<?php

namespace App\Repositories;

use App\Enums\DelFlg;
use App\Repositories\RepositoryInterface;
use Carbon\Carbon;
use DB;
use Exception;
use Log;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    /**
     * Find model by id return true if find and false if not
     * 
     * @param int $id
     * 
     * @return mixed
     */
    public function getById($id)
    {
        try {
            $result = $this->model->find($id);
            return $result;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Insert or update record if id exist, return true if success and false if not
     * 
     * @param null|int $id
     * @param array $attributes
     * 
     * @return mixed
     */
    public function save($id = null, $attributes)
    {
        try {
            DB::beginTransaction();
            if ($id) {
                $result = $this->model->find($id);
                $result = $result->update($attributes);
            } else {
                $result = $this->model->create($attributes);
            }
            DB::commit();
            return $result;
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
            return false;
        }

    }

    /**
     * Insert or update multiple record if id exist, return true if success and false if not
     * 
     * @param null|array $ids
     * @param array $attributes
     * 
     * @return mixed
     */
    public function saveMany($ids = null, $attributes)
    {
        try {
            DB::beginTransaction();
            $models = [];

            foreach ($attributes as $index => $attribute) {
                $id = $ids[$index];

                if ($id) {
                    $model = $this->model->find($id);
                    $model = $model->update($attribute);
                }
                else {
                    $model = $model->save($attribute);
                }
                if (!$model){
                    throw new Exception('Update failed');
                }
                $models[] = $model;
            }
            DB::commit();
            return $models;
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
            return false;
        }
    }

    /**
     * Delete record by id, return true if success and false if not
     * 
     * @param int $id
     * 
     * @return mixed
     */
    public function deleteById($id)
    {
        try {
            $result = $this->model->find($id);
            $result->del_flg = 1;
            return $result->save();
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }
}
