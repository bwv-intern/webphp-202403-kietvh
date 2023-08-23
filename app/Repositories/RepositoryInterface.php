<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function getById($id);
    public function save($id = null, $attributes);
    public function saveMany($ids = null, $attributes);
    public function deleteById($id);
}
