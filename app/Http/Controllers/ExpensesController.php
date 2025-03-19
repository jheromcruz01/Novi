<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Repositories\ExpensesRepository;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class ExpensesController extends Controller
{
    protected $expensesRepository;

    public function __construct(ExpensesRepository $expensesRepository)
    {
        $this->expensesRepository = $expensesRepository;
    }

    public function index(Request $request)
    {

        $data['data'] = $this->expensesRepository->getExpenses();
        if ($request->ajax()) {
            return DataTables::of($data['data'])
                ->make(true);
        }

        $auth = $this->expensesRepository->getData('users', ['id' => Auth::id()], 'first');
        $data['resource'] = $auth->firstname . ' ' . $auth->lastname;
        return view('expenses.index', $data);
    }

    public function store(Request $request)
    {
        $error = [];
        $expenses = [
            'is_deleted'=> 0,
            'item'      => $request->item,
            'qty'       => $request->qty,
            'price'     => $request->price,
        ];

        if(count($error) > 0){
            return response()->json(implode($error));
        }
        //execute saving query
        if ($request->id === NULL) {
            $this->expensesRepository->insertData('expenses', $expenses);
        } else {
            $this->expensesRepository->updateData('expenses', $expenses, ['id' => $request->id]);
        }

        //return response
        return response()->json(200);
    }

    public function show($id)
    {
        $data = $this->expensesRepository->getExpensesDetails(['expenses.id' => $id, 'expenses.is_deleted' => 0]);
        return response()->json($data);
    }

    public function destroy($id)
    {
        $this->expensesRepository->updateData('expenses', [
            'is_deleted' => 1
        ], ['id' => $id]);

        return response()->json(200);
    }
}
