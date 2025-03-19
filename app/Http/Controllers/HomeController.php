<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Repositories\UserRepository;
use App\Services\GoogleSheetService;

class HomeController extends Controller
{
    protected $userRepository;
    protected $signature = 'import:google-sheet';
    protected $description = 'Import data from Google Sheets to the database';

    public function __construct(UserRepository $userRepository, GoogleSheetService $googleSheetService)
    {
        $this->userRepository = $userRepository;
        $this->googleSheetService = $googleSheetService;
    }

    public function index(Request $request)
    {
        $data = $this->googleSheetService->getSheetData();

        if (empty($data)) {
            $this->info('No data found.');
            return;
        }

        dd($data);

        // $auth = $this->userRepository->getData('users', ['id' => Auth::id()], 'first');
        // $data['resource'] = $auth->firstname . ' ' . $auth->lastname;
        // return view('home.index', $data);
    }
}
