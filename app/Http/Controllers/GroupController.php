<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportCsvRequest;
use App\Libs\CSVUtil;
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

        return view('screens.group.list', compact('groups', 'messageNotFound'));
    }

    public function import(ImportCsvRequest $request) {
        if ($request->hasFile('csvFile')) {
            $csvFile = $request->file('csvFile');

            $tempPath = $csvFile->getRealPath();
            $result = $this->groupService->importCsv($tempPath);
            switch ($result['message']) {
                case 'WRONG_HEADER':
                    return redirect()->back()->withErrors('EBT095')->withInput();
                case 'ERROR':
                    return redirect()->back()->withErrors($result['data'])->withInput();
                case 'SUCCESS':
                    return redirect()->back();
                default:
                    return redirect()->back();
            }
        }
    }
}
