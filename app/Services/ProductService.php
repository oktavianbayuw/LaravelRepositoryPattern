<?php

namespace App\Services;

use App\Repositories\ProductRepositories;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class ProductService
{
    private $repository;
    public function __construct(ProductRepositories $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }
    public function show($id)
    {
        return $this->repository->findById($id);
    }
    public function store($data)
    {
        foreach ($data as $key_field => $field_validation) {
            foreach ($field_validation as $key => $field) {
                if ($field == 'unique') {
                    $data[$key_field][$key] = 'unique:' . ProductRepositories::DB_TABLE;
                }
            }
        }

        request()->validate($data);

        return $this->repository->save($data);
    }

    public function update($data, $id)
    {
        foreach ($data as $key_field => $field_validation) {
            foreach ($field_validation as $key => $field) {
                if ($field == 'unique') {
                    unset($data[$key_field][$key]);
                    $data[$key_field][] = 'unique:' . ProductRepositories::DB_TABLE . ',' . $key_field . ',' . $id;
                }
            }
        }

        // $validator = Validator::make($data, $data);

        // if ($validator->fails()) {
        //     throw new InvalidArgumentException($validator->errors()->first());
        // }
        request()->validate($data);

        return $this->repository->update($data, $id);
    }

    public function destroy($id)
    {
        return $this->repository->delete($id);
    }
}
