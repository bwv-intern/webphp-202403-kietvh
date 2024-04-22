<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\SearchUsersRequest;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    protected UserRepository $userRepository;

    protected UserService $userService;

    public function __construct(UserRepository $userRepository, UserService $userService) {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function showUserListPage(SearchUsersRequest $request) {
        if (! Auth::check()) {
            return redirect()->route('login');
        }
       
        if ($request->query->has('page')) {
            return $this->handlesearch($request);
        }
        if(count($request->all()) > 0){
            return $this->searchUserList($request);
        }

        return view('screens.user.list');
    }

    public function searchUserList(SearchUsersRequest $request) {
        $params = $request->only(
            [   'name',
                'started_date_from',
                'started_date_to',
            ],
        );
        if ($request->has('btnExport')) {
            $params['btnExport'] = 'btnExport';
        }

        session()->forget('user.search');
        session()->put('user.search', $params);
        return $this->handlesearch($request);
    }

    public function handlesearch(SearchUsersRequest $request)
    {
        $searchParams = session()->get('user.search');
        
        // Main search
        if (!$request->has('btnExport')) {
            if($searchParams == null){
                return redirect()->route('admin.userList');
            }
            $users = $this->userService->search($searchParams);
            $users = $this->pagination($users);
            return view('screens.user.list', compact('users', 'searchParams'));
        }
    
        $exportParams = $request->only([
            'name',
            'started_date_from',
            'started_date_to',
        ]);
    
        return $this->exportCSV($exportParams);
    }


    public function exportCSV($exportParams) {
        $users = $this->userService->exportCSV($exportParams);

        if($users == null || count($users) == 0){

            return back();
        }

        $filePath = storage_path('app/users.csv');
        $file = fopen($filePath, 'w');

        // encoding CSV UTF-8
        fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($file, ['ID', 'User Name', 'Email', 'Group ID', 'Group Name', 'Started Date', 'Position', 'Created Date', 'Updated Date']);
        foreach ($users as $row) {
            fputcsv($file, $row);
        }
        fclose($file);

        session()->forget('user.search.btnExport');

        $response = response()->download($filePath, 'users.csv')->deleteFileAfterSend(true);
        $cookie = Cookie::make('exported', 'Ok', 1, null, null, false, false);
        $response->headers->setCookie($cookie);

        return $response;
    }


    public function add(){
        return view('screens.user.add-edit-delete');
    }

    public function handleAdd(Request $request){
    
    }

    public function edit($id){
        return "Đây là màn hình edit của user ID :".$id;
    }

    public function handleEdit(Request $request){
    
    }

    public function handleDelete(Request $request){
    
    }

}
