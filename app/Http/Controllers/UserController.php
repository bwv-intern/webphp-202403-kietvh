<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\SearchUsersRequest;
use App\Http\Requests\{AddUserRequest, EditUserRequest};
use App\Libs\ConfigUtil;
use App\Models\User;
use App\Repositories\{GroupRepository, UserRepository};
use App\Services\UserService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Cookie, Validator};

class UserController extends Controller
{
    protected UserRepository $userRepository;

    protected GroupRepository $groupRepository;

    protected UserService $userService;

    public function __construct(UserRepository $userRepository, UserService $userService, GroupRepository $groupRepository) {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
        $this->groupRepository = $groupRepository;
    }

    public function userList(SearchUsersRequest $request) {
        // check user logged
        if (! Auth::check() || Auth::user()->deleted_date != null) {
            return redirect()->route('login');
        }

        // get params search
        $searchParams = $request->only(['name', 'started_date_from', 'started_date_to', 'page']);

        if (count(array_filter($searchParams)) === 0) {
            $searchParams = [
                'name' => null,
                'started_date_from' => null,
                'started_date_to' => null,
            ];
        }

        session()->forget('user.search');
        session()->put('user.search', $searchParams);

        // handle search
        return $this->handlesearch($request);
    }

    public function handlesearch(SearchUsersRequest $request) {
        $pageTitle = 'User List';
        $request->session()->put('pageTitle', $pageTitle);
        $searchParams = session()->get('user.search');
        $isSearch = session()->get('user.isSearch');
        $messageNotFound = '';
        if (count($request->all()) > 0) {
            $isSearch = true;
            session()->put('user.isSearch', $isSearch);
        }

        // If not search ( first time visit page) show view with empty value
        if (! $isSearch) {
            $users = [];
            $searchParams = [];

            return view('screens.user.list', compact('users', 'searchParams', 'messageNotFound'));
        }

        // search data with search params
        $users = $this->userService->search($searchParams);
        $users = $this->pagination($users);

        // return view with users value and searchParams
        if (count($users) == 0) {
            $messageNotFound = 'No User Found';
        }

        return view('screens.user.list', compact('users', 'searchParams', 'messageNotFound'));
    }

    public function exportCSV() {
        $exportParams = session()->get('user.search');
        if ($exportParams == null || count($exportParams) == 0) {
            return back();
        }

        $users = $this->userService->exportCSV($exportParams);

        if ($users == null || count($users) == 0) {
            return back();
        }

        $fileName = 'list_user_' . Carbon::now('Asia/Ho_Chi_Minh')->format('YmdHis') . '.csv';

        $filePath = storage_path('app/' . $fileName);
        $file = fopen($filePath, 'w');

        fputcsv($file, ['"ID"', '"User Name"', '"Email"', '"Group ID"', '"Group Name"', '"Started Date"', '"Position"', '"Created Date"', '"Updated Date"']);
        foreach ($users as $row) {
            fputcsv($file, $row);
        }
        fclose($file);

        $fileContents = file_get_contents($filePath);
        $fileContents = str_replace('""', '', $fileContents);
        file_put_contents($filePath, $fileContents);
        $response = response()->download($filePath, $fileName)->deleteFileAfterSend(true);
        $cookie = Cookie::make('exported', 'Ok', 1, null, null, false, false);
        $response->headers->setCookie($cookie);

        return $response;
    }

    public function clearSearch(Request $request) {
        try {
            $request->session()->forget('user.search');
            $request->session()->forget('user.isSearch');

            return response()->json([
                'hasError' => false,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'hasError' => true,
            ]);
        }
    }

    public function add() {

        if (! Auth::check() || Auth::user()->deleted_date != null) {
            return redirect()->route('login');
        }

        $pageTitle = 'UserAddEditDelete';
        session()->put('pageTitle', $pageTitle);
        if (! Auth::check() || Auth::user()->deleted_date != null) {
            return redirect()->route('login');
        }

        $groups = $this->groupRepository->getListGroupForNewScreen();

        return view('screens.user.add-edit-delete', compact('groups'));
    }

    public function handleAdd(Request $request) {
        $addUserRequest = new AddUserRequest();

        $validator = Validator::make($request->all(), $addUserRequest->rules(), $addUserRequest->messages(), $addUserRequest->attributes());
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
       
        $result = $this->userService->create($request);
        if ($result) {
            $searchParams = session()->get('user.search');
            $url = route('admin.userList', $searchParams); // Build the URL with search parameters

            return redirect($url)->with('success', ConfigUtil::getMessage('EBT096'));
        }

        return redirect()->back()->withInput()->with('error', ConfigUtil::getMessage('EBT093'));
    }

    public function edit($id) {
        
        if (! Auth::check() || Auth::user()->deleted_date != null) {
            return redirect()->route('login');
        }

        $pageTitle = '';
        session()->put('pageTitle', $pageTitle);
        $user = $this->userRepository->findById($id);
        if ($user == null) {
            return redirect()->route('error');
        }

        $groups = $this->groupRepository->getListGroupForNewScreen();

        return view('screens.user.edit-delele', compact('groups', 'user'));
    }

    public function handleEdit(EditUserRequest $request) 
    {
        $editUserRequest = new EditUserRequest();

        $validator = Validator::make($request->all(), $editUserRequest->rules(), $editUserRequest->messages(), $editUserRequest->attributes());
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $result = $this->userService->edit($request);
        if ($result) {
            $searchParams = session()->get('user.search');
            $url = route('admin.userList', $searchParams); // Build the URL with search parameters

            return redirect($url)->with('success', ConfigUtil::getMessage('EBT096'));
        }

        return redirect()->back()->withInput()->with('error', ConfigUtil::getMessage('EBT093'));
    }

    public function handleDelete($id) {
        if ($id) {
            if ($id == Auth::user()->id) {
                return redirect()->route('admin.userList')
                    ->with('error', ConfigUtil::getMessage('EBT086'));
            }
            $userFound = $this->userRepository->findById($id);
            if ($userFound == null) {
                return redirect()->route('error');
            }
            $userFound['deleted_date'] = Carbon::now()->toDateString();
            if ($userFound->save()) {
                $searchParams = session()->get('user.search');
                $url = route('admin.userList', $searchParams); // Build the URL with search parameters

                return redirect($url)->with('success', ConfigUtil::getMessage('EBT096'));
            }

            return redirect()->route('admin.userList')->with('error', ConfigUtil::getMessage('EBT093'));
        }

        return redirect()->route('admin.userList')->with('error', ConfigUtil::getMessage('EBT093'));
    }

    public function checkExistEmail(Request $request) {
        if (isset($request->id)) {
            $user = $this->userRepository->getByEmail($request->email, $request->id);
        } else {
            $user = $this->userRepository->getByEmail($request->email);
        }

        if ($user->count()) {
            return response()->json([
                'duplicate' => true,
            ]);
        }

        return response()->json([
            'duplicate' => false,
        ]);
    }

    public function cancle() {
        $searchParams = session()->get('user.search');
        $url = route('admin.userList', $searchParams);

        return redirect($url);
    }
}
