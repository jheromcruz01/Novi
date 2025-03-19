<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {

        $data['data'] = $this->userRepository->getUsers();
        if ($request->ajax()) {
            return DataTables::of($data['data'])
                ->make(true);
        }

        $auth = $this->userRepository->getData('users', ['id' => Auth::id()], 'first');
        $data['resource'] = $auth->firstname . ' ' . $auth->lastname;
        return view('users.index', $data);
    }

    public function store(Request $request)
    {
        $error = [];
        $users = [
            'is_deleted'    => 0,
            'is_admin'      => $request->roles,
            'firstname'     => $request->firstname,
            'middlename'    => $request->middlename,
            'lastname'      => $request->lastname,
        ];

        // this will check the if the record exist
        if ($request->username) {
            $chkexst = $this->userRepository->chkduplicate('users', ['username' => $request->username, 'is_deleted' =>  0], 'count', $request->id);
            if ($chkexst > 0) array_push($error, '<li>This Username is not available.</li>');
        }

        if(count($error) > 0){
            return response()->json(implode($error));
        }
        //execute saving query
        if ($request->id === NULL) {
            $users += [
                'username'      => $request->username,
                'password'      => Hash::make('password'),
                'added_by'      => Auth::user()->username,
                'created_at'    => now(),
            ];

            $this->userRepository->insertData('users', $users);
        } else {
            $this->userRepository->updateData('users', $users, ['id' => $request->id]);
        }

        //return response
        return response()->json(200);
    }

    public function show($id)
    {
        $data = $this->userRepository->getUsers(['users.id' => $id, 'users.is_deleted' => 0], 'first');
        return response()->json($data);
    }

    public function resetPassword($id)
    {
        $this->userRepository->updateData('users', [
            'password' => Hash::make('password')
        ], ['id' => $id]);

        return response()->json(200);
    }

    public function destroy($id)
    {
        $this->userRepository->updateData('users', [
            'is_deleted' => 1
        ], ['id' => $id]);

        return response()->json(200);
    }
}
