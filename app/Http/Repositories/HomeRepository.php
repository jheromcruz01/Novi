<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeRepository
{
    private $whitelist = ['is_deleted' => 0];

    public function getData($table, $param = [], $subStr = "get", $chkexst_id = 0)
    {
        return DB::table($table)
            ->where($param)
            ->where('id', '!=', $chkexst_id)
            ->$subStr();
    }

    public function totalSales()
    {
        return DB::table('sales')
            ->where($this->whitelist)
            ->sum('total_sales');
    }

    public function totalExpenses()
    {
        return DB::table('expenses')
            ->where($this->whitelist)
            ->sum('price');
    }
    
}
