<?php

namespace App\Repositories;

use App\Models\Group;
use Exception;
use Illuminate\Support\Facades\DB;

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

    public function getAll(){
        $query = Group::whereRaw('1=1');
        $query->orderBy('id', 'desc');
        return $query;
    }


    public function insertMany($arrData) {
        DB::beginTransaction();
        try {
            $this->model->insert($arrData);
            DB::commit();
        } catch (Exception $e) {
            $this->logError($e);
            DB::rollBack();
        }
    }

    public function editMany($arrData) {
        DB::beginTransaction();
        try {
            foreach ($arrData as $data) {
                $id = $data['id'];
                $this -> save($id,$data,true);
            }
        } catch (Exception $e) {
            $this->logError($e);
            DB::rollBack();
        }
    }
}
