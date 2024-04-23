<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\SearchUsersRequest;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Cookie};

class UserController extends Controller
{
    protected UserRepository $userRepository;

    protected UserService $userService;

    public function __construct(UserRepository $userRepository, UserService $userService) {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function userList(SearchUsersRequest $request) {
        if (! Auth::check() || Auth::user()->deleted_date != null) {
            return redirect()->route('login');
        }
        if ($request->query->has('page')) {
            return $this->handlesearch($request);
        }
        if (count($request->all()) > 0) {
            return $this->searchUserList($request);
        }
       
        return view('screens.user.list');
    }

    public function searchUserList(SearchUsersRequest $request) {
        $params = $request->only(
            ['name',
                'started_date_from',
                'started_date_to',
            ],
        );

        session()->forget('user.search');
        session()->put('user.search', $params);

        return $this->handlesearch($request);
    }

    public function handlesearch(SearchUsersRequest $request) {
        $searchParams = session()->get('user.search');

        // Main search

        if ($searchParams == null) {
            return redirect()->route('admin.userList');
        }
        $users = $this->userService->search($searchParams);
        $users = $this->pagination($users);

        return view('screens.user.list', compact('users', 'searchParams'));
    }

    public function exportCSV() {
        $exportParams = session()->get('user.search');
        
        $users = $this->userService->exportCSV($exportParams);

        if ($users == null || count($users) == 0) {
            return back();
        }

        $filePath = storage_path('app/users.csv');
        $file = fopen($filePath, 'w');

        fputcsv($file, ['User Name', 'User Name', 'Email', 'Group ID', 'Group Name', 'Started Date', 'Position', 'Created Date', 'Updated Date']);
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

    public function add() {
        return view('screens.user.add-edit-delete');
    }

    public function handleAdd(Request $request) {
    }

    public function edit($id) {
        return 'Đây là màn hình edit của user ID :' . $id;
    }

    public function handleEdit(Request $request) {
    }

    public function handleDelete(Request $request) {
    }
}
