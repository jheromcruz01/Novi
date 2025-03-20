<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Repositories\CustomerRepository;
use App\Services\GoogleSheetService;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    protected $customerRepository;
    protected $signature = 'import:google-sheet';
    protected $description = 'Import data from Google Sheets to the database';

    public function __construct(CustomerRepository $customerRepository, GoogleSheetService $googleSheetService)
    {
        $this->customerRepository = $customerRepository;
        $this->googleSheetService = $googleSheetService;
    }

    public function index(Request $request)
    {
        $googleData = $this->googleSheetService->getSheetData();

        if (empty($googleData)) {
            $this->info('No data found.');
            return;
        }

        foreach ($googleData as $sheetCustomer) {

            $customers = [
                'submitted_date' => $sheetCustomer[0],
                'ig_username' => $sheetCustomer[1],
                'customer_name' => $sheetCustomer[2],
                'contact_number' => $sheetCustomer[3],
                'shipping_address' => $sheetCustomer[4],
                'province' => $sheetCustomer[5],
                'city' => $sheetCustomer[6],
                'barangay' => $sheetCustomer[7],
                'payment_method' => $sheetCustomer[8],
            ];
    
            $chkexst = $this->customerRepository->chkduplicate('customers', ['ig_username' => $sheetCustomer[1], 'is_deleted' =>  0], 'count');

            if ($chkexst > 0) {
                $this->customerRepository->updateData('customers', $customers, ['ig_username' => $sheetCustomer[1]]);
            } 
            else {
                $this->customerRepository->insertData('customers', $customers);
            }

        }

        $data['data'] = $this->customerRepository->getCustomers();
        if ($request->ajax()) {
            return DataTables::of($data['data'])
                ->make(true);
        }

        $auth = $this->customerRepository->getData('users', ['id' => Auth::id()], 'first');
        $data['resource'] = $auth->firstname . ' ' . $auth->lastname;
        return view('customers.index', $data);
    }
}
