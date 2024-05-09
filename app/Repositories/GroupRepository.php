<?php

namespace App\Repositories;

use App\Models\Group;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class GroupRepository extends BaseRepository
{
    public function getModel() {
        return Group::class;
    }

    public function getListGroupForNewScreen() {
        $query = Group::whereRaw('1=1');
        $query->whereNull('deleted_date');
        $query->orderBy('name', 'asc');

        return $query->get();
    }

    public function getAll() {
        $query = Group::whereRaw('1=1');
        $query->orderBy('id', 'desc');

        return $query;
    }

    public function insertMany($arrData) {
        DB::beginTransaction();
        try {
            foreach ($arrData as $data) {
                $group = new Group();
                $group->name = $data['name'];
                $group->note = $data['note'];
                $group->group_leader_id = $data['group_leader_id'];
                $group->group_floor_number = $data['group_floor_number'];
                if ($data['deleted_date'] == 'Y') {
                    $group->deleted_date = Carbon::now()->toDateString();
                }
                else{
                    $group->deleted_date = NULL;
                }
                $group->save();
            }
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
                $group = $this->findById($id, true);
                if ($group) {
                    $group->name = $data['name'];
                    $group->note = $data['note'];
                    $group->group_leader_id = $data['group_leader_id'];
                    $group->group_floor_number = $data['group_floor_number'];
                    $group->deleted_date = NULL;
                    if ($data['deleted_date'] == 'Y') {
                        $group->deleted_date = Carbon::now()->toDateString();
                    } 
                    $group->save();
                }
            }
            DB::commit();
        } catch (Exception $e) {
            $this->logError($e);
            DB::rollBack();
        }
    }
}
