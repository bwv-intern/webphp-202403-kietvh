<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository
{
    public function getModel()
    {
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
    public function getUserLogin(array $params)
    {
        $query = User::query()
            ->where('email', $params['email'] ?? null)
            ->where('deleted_date', NULL);

        $user = $query->get()->first();
        if ($user && Hash::check($params['password'], $user->password)) {
            return $user;
        }
        return null;
    }

    public function checkDuplicateEmailForLogin(string $email)
    {
        try {
            $result = $this->model->where('email', $email)
                ->whereNull('deleted_date')
                ->get();
        } catch (Exception $exption) {
            Log::error($exption->getMessage());
        }
        if ($result) {
            return count($result) > 1 ;
        }
        return false;
    }
}
