<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    private $whitelist = ['is_deleted' => 0];

    public function getUsers($param = [], $subStr = "get")
    {
        return DB::table('users')
            ->select('*', DB::raw('CONCAT(lastname, firstname) AS fullname'))
            ->where($this->whitelist)
            ->where($param)
            ->where('id', '!=', Auth::id())
            ->$subStr();
    }

    public function getData($table, $param = [], $subStr = "get", $chkexst_id = 0)
    {
        return DB::table($table)
            ->where($param)
            ->where('id', '!=', $chkexst_id)
            ->$subStr();
    }

    public function getAllData($table, $param = [], $subStr = "get")
    {
        return DB::table($table)
            ->where($param)
            ->$subStr();
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
    
}
