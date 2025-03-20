<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Repositories\ProductRepository;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {

        $data['data'] = $this->productRepository->getProducts();
        if ($request->ajax()) {
            return DataTables::of($data['data'])
                ->make(true);
        }

        $auth = $this->productRepository->getData('users', ['id' => Auth::id()], 'first');
        $data['resource'] = $auth->firstname . ' ' . $auth->lastname;
        return view('products.index', $data);
    }

    public function store(Request $request)
    {
        $error = [];
        $products = [
            'is_deleted'=> 0,
            'item_code' => $request->item_code,
            'color'     => $request->color,
            'size'      => $request->size,
            'status'    => $request->status,
            'miner'     => $request->miner,
            'mine_price'     => $request->mine_price,
            'lock_price'     => $request->lock_price,
        ];

        // this will check the if the record exist
        if ($request->item_code) {
            $chkexst = $this->productRepository->chkduplicate('products', ['item_code' => $request->item_code, 'is_deleted' =>  0], 'count', $request->id);
            if ($chkexst > 0) array_push($error, '<li>This item code is not available.</li>');
        }

        if(count($error) > 0){
            return response()->json(implode($error));
        }

        // Handle image upload if a file is provided
        if ($request->hasFile('image')) {
            // Validate the image
            $request->validate([
                'image' => 'image|mimes:jpg,jpeg,png,gif|max:2048', // 2MB Max
            ]);

            // Store the image and get the file path
            $imagePath = $request->file('image')->store('products', 'public');
            $products['image'] = $imagePath;  // Add image path to the data
        }

        //execute saving query
        if ($request->id === NULL) {
            $this->productRepository->insertData('products', $products);
        } 
        else {
            $this->productRepository->updateData('products', $products, ['id' => $request->id]);
        }

        //return response
        return response()->json(200);
    }

    public function show($id)
    {
        $data = $this->productRepository->getProductDetails(['products.id' => $id, 'products.is_deleted' => 0]);
        return response()->json($data);
    }

    public function destroy($id)
    {
        $this->productRepository->updateData('products', [
            'is_deleted' => 1
        ], ['id' => $id]);

        return response()->json(200);
    }
}
