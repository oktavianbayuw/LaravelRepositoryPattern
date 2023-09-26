<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index()
    {
        $data = Product::orderBy('nama')->where('status', 1)->get()->map(function ($data) {
            return [
                'nama_produk'  => $data->nama,
                'harga_produk'  => $data->harga,
                'status'  => $data->status == 1 ? 'Aktif' : 'Inaktif',
                'kategori'  => $data->category->nama,
            ];
        });

        return $data;
    }
}
