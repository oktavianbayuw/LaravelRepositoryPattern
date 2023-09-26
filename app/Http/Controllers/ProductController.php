<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Services\ProductService;
use Exception;

class ProductController extends Controller
{
    protected $service;
    protected $folder = 'product';
    protected $field = [
        'nama'  => ['required', 'unique'],
        'harga' => ['required'],
        'stok'  => ['required'],
        'id_kategori'   => ['required']
    ];

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }


    public function index()
    {
        return $this->service->getAll();
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function create()
    {
        $data['data'] = CategoryProduct::where('status', 0)->get();
        return view($this->folder . '.form');
    }

    public function store()
    {
        $results['status'] = 200;
        try {
            $results['data'] = $this->service->store($this->field);
        } catch (Exception $e) {
            $results = [
                'status'    => 500,
                'error'     => $e->getMessage()
            ];
        }

        return response()->json($results, $results['status']);
    }

    public function edit($id)
    {
        $data['data'] =  $this->service->show($id);
        return view($this->folder . '.edit', $data);
    }

    public function update($id)
    {
        return $this->service->update($this->field, $id);
    }

    public function delete($id)
    {
        return $this->service->destroy($id);
    }
}
