<?php

namespace App\Services;

use App\Libs\{DateUtil};
use App\Repositories\GroupRepository;

class GroupService
{
    protected GroupRepository $groupRepository;

    public function __construct(GroupRepository $groupRepository) {
        $this->groupRepository = $groupRepository;
    }

    public function getAll() {
        return $this->groupRepository->getAll();
    }
    
}
