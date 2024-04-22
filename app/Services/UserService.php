<?php

namespace App\Services;

use App\Libs\{DateUtil};
use App\Repositories\UserRepository;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function search(array $params) {
        if (isset($params['started_date_from'])) {
            $params['started_date_from'] = DateUtil::formatDate($params['started_date_from'], 'Y-m-d');
        }

        if (isset($params['started_date_to'])) {
            $params['started_date_to'] = DateUtil::formatDate($params['started_date_to'], 'Y-m-d');
        }
        $users = $this->userRepository->search($params);

        return $users;
    }
}
