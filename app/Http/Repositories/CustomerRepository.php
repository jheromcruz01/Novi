<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerRepository
{
    public function getData($table, $param = [], $subStr = "get", $chkexst_id = 0)
    {
        return DB::table($table)
            ->where($param)
            ->where('id', '!=', $chkexst_id)
            ->$subStr();
    }

    public function getCustomers()
    {
        return DB::table('customers')
            ->where('customers.is_deleted', 0)
            ->orderby('customers.customer_name', 'asc')
            ->get();
    }

    public function chkduplicate($table, $param = [], $subStr = "get")
    {
        return DB::table($table)
            ->where($param)
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

    public function getCustomersDetails($param = [])
    {
        return DB::table('customers')
            ->where($param)
            ->first();
    }

}
