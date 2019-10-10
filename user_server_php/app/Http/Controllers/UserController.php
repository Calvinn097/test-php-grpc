<?php

namespace App\Http\Controllers;

use App\Http\Requests\getUserRequest;
use App\Repositories\UsersRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function getUser(getUserRequest $request){
        $userId = $request->user_id;
        $usersRepo = new UsersRepository();
        $data = $usersRepo->getUser($userId);

        return $data;
    }

    public function createUserGrpc(Request $request){
        $name = $request->name;
        $address = $request->address;
        $age = $request->age;

        $userRepo = new UsersRepository();

        $start = microtime(true);
        $users = $userRepo->insertUserGrpc($name, $address, $age);
        $time_elapsed_secs = microtime(true) - $start;
        $data['users'] = $users;
        $data['time_elapsed_secs'] = $time_elapsed_secs;
        return $data;

    }

    public function createUserHttp(Request $request){
        $name = $request->name;
        $address = $request->address;
        $age = $request->age;

        $userRepo = new UsersRepository();

        $start = microtime(true);
        $users = $userRepo->insertUserHttp($name, $address, $age);
        $time_elapsed_secs = microtime(true) - $start;
        $data['users'] = $users;
        $data['time_elapsed_secs'] = $time_elapsed_secs;
        return $data;
    }


    public function createUser(Request $request){
        $name = $request->name;
        $address = $request->address;
        $age = $request->age;

        $userRepo = new UsersRepository();

        $start = microtime(true);
        $users = $userRepo->insertUser($name, $address, $age);
        $time_elapsed_secs = microtime(true) - $start;
        $data['users'] = $users;
        $data['time_elapsed_secs'] = $time_elapsed_secs;
        return $data;

    }
}
