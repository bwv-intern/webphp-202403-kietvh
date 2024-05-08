<?php

namespace App\Http\Controllers;

use App\Services\GroupService;

class GroupController extends Controller
{
    protected GroupService $groupService;

    public function __construct(GroupService $groupService) {
        $this->groupService = $groupService;
    }

    public function groupList() {
        $pageTitle = '';
        session()->put('pageTitle', $pageTitle);

        $groups = $this->groupService->getAll();
        $groups = $this->pagination($groups);

        $messageNotFound = '';

        return view('screens.group.list',compact('groups','messageNotFound'));
    }
}
