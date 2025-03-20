<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionRepository
{
    public function getData($table, $param = [], $subStr = "get", $chkexst_id = 0)
    {
        return DB::table($table)
            ->where($param)
            ->where('id', '!=', $chkexst_id)
            ->$subStr();
    }

    public function getTransactions()
    {
        // Retrieve the transactions with their related products and prices
        $transactions = DB::table('sales')
            ->join('sales_products', 'sales.id', '=', 'sales_products.sales_id') // Join sales_products
            ->join('products', 'sales_products.product_id', '=', 'products.id') // Join products table to get item details
            ->join('customers', 'sales.customer_id', '=', 'customers.id') // Join customers table to get customer details
            ->select(
                'sales.id as order_id', 
                'products.item_code', 
                'sales.transaction_date', 
                'sales.shipping_fee', 
                'sales.total_amount',
                'sales_products.price',
                'sales.id',
                'sales.order_status',
                'sales.total_sales',
                'customers.customer_name',
                'customers.shipping_address',
                'customers.contact_number',
                'customers.province',
                'customers.city',
                'customers.barangay'
            )
            ->where('sales.is_deleted', 0)
            ->get();

        // Process the result to group products by transaction ID and format the response
        $groupedTransactions = $transactions->groupBy('order_id')->map(function ($transactionGroup) {
            $firstTransaction = $transactionGroup->first();  // Get first transaction to retrieve static data (like customer_name)

            // Join item codes with their respective prices
            $items = $transactionGroup->map(function ($transaction) {
                return $transaction->item_code . ' - (₱' . number_format($transaction->price, 2) . ')';
            })->implode(', '); // Join all item codes and their prices with commas

            // Convert result to an array
            return (object)[
                'order_id' => $firstTransaction->order_id,
                'item_code' => $items, // Multiple item codes with prices
                'customer_name' => $firstTransaction->customer_name,
                'shipping_address' => $firstTransaction->shipping_address,
                'province' => $firstTransaction->province,
                'city' => $firstTransaction->city,
                'barangay' => $firstTransaction->barangay,
                'contact_number' => $firstTransaction->contact_number,
                'transaction_date' => $firstTransaction->transaction_date,
                'shipping_fee' => $firstTransaction->shipping_fee,
                'total_amount' => $firstTransaction->total_amount,
                'id' => $firstTransaction->id,
                'order_status' => $firstTransaction->order_status,
                'total_sales' => $firstTransaction->total_sales,
            ];
        });

        return $groupedTransactions; // Return grouped transactions
    }

    public function getSelectedTransaction($id)
    {
        $transaction = DB::table('sales')
            ->join('sales_products', 'sales.id', '=', 'sales_products.sales_id')
            ->join('products', 'sales_products.product_id', '=', 'products.id')
            ->join('customers', 'sales.customer_id', '=', 'customers.id')
            ->select(
                'sales.id as order_id', 
                'products.item_code', 
                'sales.transaction_date', 
                'sales.shipping_fee', 
                'sales.total_amount',
                'sales_products.price',
                'sales_products.product_id',
                'sales.id',
                'sales.order_status',
                'sales.total_sales',
                'customers.customer_name',
                'customers.shipping_address',
                'customers.contact_number',
                'customers.province',
                'customers.city',
                'customers.barangay'
            )
            ->where('sales.id', $id)
            ->where('sales.is_deleted', 0)
            ->get();

        $groupedTransaction = $transaction->groupBy('order_id')->map(function ($transactionGroup) {
            $firstTransaction = $transactionGroup->first();
            $items = $transactionGroup->map(function ($transaction) {
                return [
                    'item_code' => $transaction->item_code,
                    'price' => $transaction->price,
                    'product_id' => $transaction->product_id,
                ];
            });

            return [
                'order_id' => $firstTransaction->order_id,
                'customer_name' => $firstTransaction->customer_name,
                'shipping_address' => $firstTransaction->shipping_address,
                'province' => $firstTransaction->province,
                'city' => $firstTransaction->city,
                'barangay' => $firstTransaction->barangay,
                'contact_number' => $firstTransaction->contact_number,
                'transaction_date' => $firstTransaction->transaction_date,
                'shipping_fee' => $firstTransaction->shipping_fee,
                'total_amount' => $firstTransaction->total_amount,
                'items' => $items,
                'order_status' => $firstTransaction->order_status,
                'total_sales' => $firstTransaction->total_sales,
            ];
        })->first();

        return response()->json(['data' => $groupedTransaction]);
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
            ->where($param)
            ->first();
    }

}
