<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class ProductRepositories
{
    private $model;
    const DB_TABLE = 'products';
    public function __construct(Product $productModel)
    {
        $this->model = $productModel;
    }
    public function getAll()
    {
        $data = $this->model::orderBy('nama')->where('status', 1)->get()->map(function ($data) {
            return $this->format($data);
        });

        return $data;
    }

    public function findById($id)
    {
        try {
            $data = $this->model::findOrFail($id);
            return response()->json([
                "data"  => $this->format($data),
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function format($data)
    {
        return [
            'id'    => $data->id,
            'nama_produk'  => $data->nama,
            'harga_produk'  => $data->harga,
            'status'  => $data->status == 1 ? 'Aktif' : 'Inaktif',
            'kategori'  => $data->category->nama,
        ];
    }

    // public function create_data($dataRelation)
    // {
    //     foreach ($dataRelation as $data) {
    //         return $data::where('status', 1)->get();
    //     }
    // }

    public function save(array $field)
    {
        $data_insert = [];
        foreach ($field as $key => $data) {
            $data_insert[$key] = request()->$key;
        }
        return $this->model::create($data_insert);
    }

    public function update(array $field, $id)
    {
        $data_update = [];
        foreach ($field as $key => $data) {
            $data_update[$key] = request()->$key;
        }
        return $this->model::where('id', $id)->update($data_update);
    }

    public function delete($id)
    {
        try {
            $data = $this->model::findOrFail($id);
        } catch (\Exception $exception) {
            $errormsg = 'Data Not Found !' . $exception->getCode();
            return Response::json(['errormsg' => $errormsg]);
        }

        $result = $data->delete();
        if ($result) {
            $res['result'] = true;
            $res['message'] = "Data Successfully Deleted!";
        } else {
            $res['result'] = false;
            $res['message'] = "Data was not Deleted, Try Again!";
        }
        return json_encode($res);
    }
}
