<?php

namespace App\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\{Hash, Log};

class UserRepository extends BaseRepository
{
    public function getModel() {
        return User::class;
    }

    /**
     * Get user login
     *
     * @param array $params
     * @return mixed
     */
    /**
     * Get user login
     *
     * @param array $params
     * @return mixed
     */
    public function getUserLogin(array $params) {
        $query = User::query()
            ->where('email', $params['email'] ?? null)
            ->where('deleted_date', null);

        $user = $query->get()->first();
        if ($user && Hash::check($params['password'], $user->password)) {
            return $user;
        }

        return null;
    }

    public function checkDuplicateEmailForLogin(string $email) {
        try {
            $result = $this->model->where('email', $email)
                ->whereNull('deleted_date')
                ->get();
        } catch (Exception $exption) {
            Log::error($exption->getMessage());
        }
        if ($result) {
            return count($result) > 1;
        }

        return false;
    }


    public function search(array $params)
    {
        $query = User::whereRaw('1=1');
        $query->whereNull('deleted_date');
    
        if (isset($params['name'])) {
            $query->where('name', 'LIKE', '%' . $params['name'] . '%');
        }
    
        if (isset($params['started_date_from']) && isset($params['started_date_to'])) {
            $query->whereBetween('started_date', [$params['started_date_from'], $params['started_date_to']]);
        }
    
        $query->orderBy('name', 'asc')
        ->orderBy('started_date', 'asc')
        ->orderBy('id', 'asc');
       
        return $query;
    }

}
