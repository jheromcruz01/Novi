<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Repositories\HomeRepository;

class HomeController extends Controller
{
    protected $homeRepository;

    public function __construct(HomeRepository $homeRepository)
    {
        $this->homeRepository = $homeRepository;
    }

    public function index(Request $request)
    {

        $totalSales = $this->homeRepository->totalSales(); 
        $totalExpenses = $this->homeRepository->totalExpenses(); 
        $income = $totalSales - $totalExpenses;

        // Pass the data to the view
        $data['totalSales'] = $totalSales;
        $data['totalExpenses'] = $totalExpenses;
        $data['income'] = $income;

        $auth = $this->homeRepository->getData('users', ['id' => Auth::id()], 'first');
        $data['resource'] = $auth->firstname . ' ' . $auth->lastname;
        return view('home.index', $data);
    }
}
