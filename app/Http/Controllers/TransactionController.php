<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Repositories\TransactionRepository;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = $this->transactionRepository->getTransactions(); // Get the grouped transactions
            return DataTables::of($data)
                ->addColumn('item_code', function ($transaction) {
                    return $transaction->item_code; // Display the formatted item codes and prices
                })
                ->make(true);  // Make the proper DataTables response
        }

        $auth = $this->transactionRepository->getData('users', ['id' => Auth::id()], 'first');
        $data['resource'] = $auth->firstname . ' ' . $auth->lastname;
        return view('transaction.index', $data);
    }

    public function store(Request $request)
    {
        $error = [];
        
        $totalAmount = 0;

        // Handle product insertion (updating or adding new products)
        foreach ($request->product_id as $index => $productId) {
            // Get the selected price directly from the price_type array
            $price = $request->price_type[$index];
    
            // Add the price to the total amount
            $totalAmount += $price;
        }

        // Add the shipping fee to the total amount
        $totalAmount += $request->shipping_fee;

        // Prepare transaction data for insertion into the `transactions` table
        $transactionData = [
            'customer_id' => $request->customer_id,
            'shipping_fee' => $request->shipping_fee,
            'total_amount' => $totalAmount,
            'order_status' => 'Pending',
        ];

        // Insert the transaction record into the `transactions` table using the repository method
        $transactionId = $this->transactionRepository->insertData('sales', $transactionData);

        // Insert product-transaction relationships into `transaction_products` table
        foreach ($request->product_id as $index => $productId) {

            $price = $request->price_type[$index];
            // Prepare the relationship data
            $transactionProductData = [
                'sales_id' => $transactionId,
                'product_id' => $productId,
                'price' => $price,
            ];

            // Insert the relationship into the `transaction_products` table using the repository method
            $this->transactionRepository->insertData('sales_products', $transactionProductData);
        }

        // Return success response
        return response()->json(200);
    }

    public function updateStatus($id, Request $request)
    {
        try {

            $response  = $this->transactionRepository->getSelectedTransaction($id);

            $transaction = json_decode($response->getContent())->data;

            if (!$transaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction not found'
                ], 404);
            }    

            // Initialize the total_sales value
            $totalSales = 0;

            if ($request->order_status == 'Paid') {
                // Iterate over each item in the 'items' array
                foreach ($transaction->items as $item) {
                    // Add the price of each item to the totalSales
                    if (isset($item->price)) {
                        $totalSales += floatval($item->price);
                    }

                    // Check if product_id exists for the item
                    if (isset($item->product_id)) {
                        $productId = $item->product_id;

                        // Update the product status to 'Sold'
                        $this->transactionRepository->updateData('products', ['status' => 'Sold'], ['id' => $productId]);
                    } else {
                        // If product_id is missing for any item
                        return response()->json([
                            'success' => false,
                            'message' => 'Product ID missing in one of the items'
                        ], 400);
                    }
                }

                // Now update the sales table with the calculated total sales
                $transactionData = [
                    'order_status' => 'Paid', // Updating order status to 'Shipped'
                    'total_sales' => $totalSales, // Add the total_sales value
                ];

                // Update the sales table with the new total_sales value
                $this->transactionRepository->updateData('sales', $transactionData, ['id' => $id]);

                return response()->json([
                    'success' => true,
                    'message' => 'Order status and sales updated successfully!',
                    'data' => $transaction
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Order status is not "Shipped"'
            ], 400);

        } catch (\Exception $e) {
            // Handle any errors, such as not finding the transaction
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status. ' . $e->getMessage()
            ], 500);
        }
    }


    public function show($id)
    {
        $data = $this->transactionRepository->getSelectedTransaction($id);
        return response()->json($data);
    }


    public function destroy($id)
    {
        $this->transactionRepository->updateData('sales', [
            'is_deleted' => 1
        ], ['id' => $id]);

        return response()->json(200);
    }
}
