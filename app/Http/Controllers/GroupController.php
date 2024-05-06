<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function groupList(){
        $pageTitle = "";
        Session()->put('pageTitle', $pageTitle);
        return view('screens.group.list');
    }
}
