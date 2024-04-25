<?php

namespace App\Repositories;

use App\Models\Group;

class GroupRepository extends BaseRepository
{
    public function getModel() {
        return Group::class;
    }

    public function getListGroupForNewScreen(){
        $query = Group::whereRaw('1=1');
        $query->whereNull('deleted_date');
        $query->orderBy('name', 'asc');
        return $query->get();
    }
}
