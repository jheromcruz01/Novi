<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpensesRepository
{
    public function getData($table, $param = [], $subStr = "get", $chkexst_id = 0)
    {
        return DB::table($table)
            ->where($param)
            ->where('id', '!=', $chkexst_id)
            ->$subStr();
    }

    public function getExpenses()
    {
        return DB::table('expenses')
            ->where('expenses.is_deleted',0)
            ->get();
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

    public function getExpensesDetails($param = [])
    {
        return DB::table('expenses')
            ->where($param)
            ->first();
    }

}
