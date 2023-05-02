<?php

namespace App\Repositories;

class BaseRepositoryEloquent implements BaseRepository
{
    protected $model;

    public function with($with=[])
    {
        return $this->model->with($with);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create($data)
    {
        $data['created_by'] = auth()->id();
        return $this->model->create($data);
    }
    
    public function update($id, $data)
    {
        $record = $this->model->findOrFail($id);
        $data['updated_by'] = auth()->id();
        $record->fill($data)->save();
        return $record;
    }
    
    public function find($id)
    {   
        return $this->model->findOrFail($id);
    }

    public function destroy($id)
    {
        return $this->model->findOrFail($id)->delete();
    }
    
    public function getLatest()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }

    public function latest()
    {
        return $this->model->latest();
    }

    public function orderByPosition()
    {
        return $this->model->orderBy('order_position', 'asc')->get();
    }

    public function paginate($paginate) {
        return $this->model->paginate($paginate);
    }

    public function findByField($field, $value = null, $columns = ['*'])
    {
        return $this->model->where($field, '=', $value)->first($columns);
    }

    public function truncate()
    {
        return $this->model->truncate();
    }

    public function where($field, $value) {
        return $this->model->where($field, $value);
    }

    public function whereNotIn($field, $value) {
        return $this->model->whereNotIn($field, $value);
    }
}
