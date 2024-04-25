<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\SearchUsersRequest;
use App\Models\User;
use App\Repositories\GroupRepository;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{App, Auth, Cookie};
use Carbon\Carbon;
use Illuminate\Support\Facades\{Session};

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
        $searchParams = $request->only(['name', 'started_date_from', 'started_date_to']);

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

        $searchParams = session()->get('user.search');
        $isSearch = session()->get('user.isSearch');
        
        if(count($request->all()) >0){
            $isSearch = true;
            session()->put('user.isSearch',$isSearch);
        }
        
        // If not search ( first time visit page) show view with empty value
        if(!$isSearch){
            $users = [];
            $searchParams =[];
            return view('screens.user.list', compact('users', 'searchParams'));
        }
        
        // search data with search params
        $users = $this->userService->search($searchParams);
        $users = $this->pagination($users);

        // return view with users value and searchParams
        if(count($users) == 0){
            Session::flash('notFound','No User Found');
        }
        return view('screens.user.list', compact('users', 'searchParams'));
        
       
    }

    public function exportCSV() {
        $exportParams = session()->get('user.search');
        if($exportParams == null || count($exportParams) == 0){
            return back();
        }

        $users = $this->userService->exportCSV($exportParams);

        if ($users == null || count($users) == 0) {
            return back();
        }

        $fileName = 'list_user_'.Carbon::now('Asia/Ho_Chi_Minh')->format('YmdHis').'.csv';
        
        $filePath = storage_path('app/'.$fileName);
        $file = fopen($filePath, 'w');

        fputcsv($file, ['"ID"', '"User Name"', '"Email"', '"Group ID"', '"Group Name"', '"Started Date"', '"Position"', '"Created Date"', '"Updated Date"']);
        foreach ($users as $row) {
            fputcsv($file, $row);
        }
        fclose($file);

        $response = response()->download($filePath,  $fileName)->deleteFileAfterSend(true);
        $cookie = Cookie::make('exported', 'Ok', 1, null, null, false, false);
        $response->headers->setCookie($cookie);

        return $response;
    }

    public function clearSearch(Request $request){
        try{
            $request -> session() -> forget('user.search');
            $request -> session() -> forget('user.isSearch');
            return response()->json([
                'hasError' => false,
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'hasError' => true,
            ]);
        }
    }

    public function add() {
        if (! Auth::check() || Auth::user()->deleted_date != null) {
            return redirect()->route('login');
        }
        
        $groups = $this -> groupRepository->getListGroupForNewScreen();
        
        return view('screens.user.add-edit-delete', compact('groups'));
    }

    public function handleAdd(Request $request) {
    }

    public function edit($id) {
        $user = User::find($id);
        if($user == null){
            return redirect()->route('error');
        }

        $groups = $this -> groupRepository->getListGroupForNewScreen();

        return view('screens.user.add-edit-delete', compact('groups','user'));
    }

    public function handleEdit(Request $request) {
    }

    public function handleDelete(Request $request) {
    }
}
