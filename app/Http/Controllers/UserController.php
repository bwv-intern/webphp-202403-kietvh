<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function userList(){
        if(!Auth::check() || Auth::user()->deleted_date != null){
            return redirect()->route('login');
        }
        return view('screens.user.list');
    }
   
}
