<?php
namespace App\Repositories;

interface BaseRepository
{
    public function all();

    public function with($with=[]);

    public function create($data);
  
    public function update($id, $data);

    public function find($id);

    public function destroy($id);

    public function getLatest();

    public function latest();

    public function orderByPosition();

    public function paginate($paginate);

    public function findByField($field, $value = null, $columns = ['*']);

    public function truncate();

    public function where($field, $value);
    
    public function whereNotIn($field, $value);
}
