<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function getData($table, $param = [], $subStr = "get", $chkexst_id = 0)
    {
        return DB::table($table)
            ->where($param)
            ->where('id', '!=', $chkexst_id)
            ->$subStr();
    }

    public function getProducts()
    {
        return DB::table('products')
            ->leftJoin('customers', 'customers.id', '=', 'products.customer_id')
            ->select([
                'products.id',
                'products.item_code',
                'products.color',
                'products.size',
                'products.status',
                'products.miner',
                'customers.customer_name',
                'products.price',
                'products.date_of_payment'
            ])
            ->where('products.is_deleted',0)
            ->get();
    }

    public function chkduplicate($table, $param = [], $subStr = "get", $chkexst_id = 0)
    {
        return DB::table($table)
            ->where($param)
            ->where('id', '!=', $chkexst_id)
            ->$subStr();
    }

    public function insertData($table, $data)
    {
        return DB::table($table)->insertGetId($data);
    }

    public function updateData($table, $data, $param = [])
    {
        return DB::table($table)
            ->where($param)
            ->update($data);
    }

    public function getProductDetails($param = [])
    {
        return DB::table('products')
            ->leftJoin('customers', 'customers.id', '=', 'products.customer_id')
            ->select([
                'products.id',
                'products.item_code',
                'products.color',
                'products.size',
                'products.status',
                'products.miner',
                'customers.customer_name',
                'products.price',
                'products.date_of_payment'
            ])
            ->where($param)
            ->first();
    }

}
