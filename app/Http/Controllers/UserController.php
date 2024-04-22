<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\SearchUsersRequest;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected UserRepository $userRepository;

    protected UserService $userService;

    public function __construct(UserRepository $userRepository, UserService $userService) {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function userList() {
        if (! Auth::check()) {
            return redirect()->route('login');
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

        return $this->search($request);
    }

    public function search(SearchUsersRequest $request) {
        $paramSession = session()->get('user.search');
        // main search
        if (! isset($paramSession['btnExport'])) {
            $users = $this->userService->search($paramSession);
            $users = $this->pagination($users);

            return view('screens.user.list', compact('users', 'paramSession'));
        }

        return $this->exportCSV($request);
    }


    public function add(){
        return view('screens.user.add-edit-delete');
    }

    public function handleAdd(Request $request){
    
    }

    public function edit(){
        return view('screens.user.add-edit-delete');
    }

    public function handleEdit(Request $request){
    
    }

    public function handleDelete(Request $request){
    
    }

}
