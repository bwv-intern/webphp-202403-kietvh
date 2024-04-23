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

    public function checkDuplicateEmailForLogin(string $email,string $password)
    {
        try {
            $result = $this->model->where('email', $email)
                ->whereNull('deleted_date')
                ->get();
        } catch (\Exception $exption) {
            
        }
        if ($result) {
            $duplicate = [];
            foreach($result as $user){
                if(Hash::check($password, $user->password)){
                    $duplicate[] = $user;
                }
            }
            return count($duplicate) > 1;
        }
        return false;
    }
}
