<?php
/**
 * Created by PhpStorm.
 * User: wilson
 * Date: 03/01/2019
 * Time: 13:45
 */

namespace App\Repositories;


use Account\AccountClient;
use Account\CreateUserRequest;
use Account\GetUserRequest;
use App\Models\UsersModel;
use App\User;

class Http_client_helper  {

    protected $curl;
    public function __construct(){
        $this->curl = curl_init();
        curl_setopt_array($this->curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:66.0) Gecko/20100101 Firefox/66.0'
        ]);
    }

    public function __destruct(){
        curl_close($this->curl);
    }

    public function get($url, $httpHeaders){
//        dd($url);
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $httpHeaders);
//            curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
        $resp = curl_exec($this->curl); //2.5detik
        if($resp==false){
//                dump(curl_errno($this->curl));
//                dd(curl_error($this->curl));
            throw new \Exception(curl_error($this->curl));
//                return curl_error($this->curl);
//                curl_errno($this->curl);
        }
        return $resp;

    }

    public function getWithStatusCode($url, $httpHeaders){
//        dd($url);
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $httpHeaders);
//            curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
        $resp = curl_exec($this->curl); //2.5detik
        if($resp==false){
//                dump(curl_errno($this->curl));
//                dd(curl_error($this->curl));
            throw new \Exception(curl_error($this->curl));
//                return curl_error($this->curl);
//                curl_errno($this->curl);
        }
        $statusCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        return ['resp'=>$resp, 'status_code'=> $statusCode];

    }

    public function post($url, $param, $httpHeaders){
        curl_setopt($this->curl, CURLOPT_URL,$url);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $httpHeaders);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($this->curl);
        return $result;
    }




}

class UsersRepository
{
    protected $host = "10.0.0.79:50051";
    function getUser($userId){
//        $data['user'] =  UsersModel::where('id', $userId)
//            ->get();

//        if(count($data['user']??[]) != 0){
        $accountClient = new AccountClient($this->host, [
            'credentials' => \Grpc\ChannelCredentials::createInsecure()
        ]);
        $getUserRequest = new GetUserRequest();
        $getUserRequest->setId($userId);
        list($getUserResponse, $status) = $accountClient->GetUser($getUserRequest)->wait();
//            dump($status);
        if($status->code != 0){
            throw new \Exception($status->details." {$status->code}, metadata: ".json_encode($status->metadata));
        }
        $user['id'] = $getUserResponse->GetId();
        $user['name'] = $getUserResponse->GetName();
        $user['address'] = $getUserResponse->GetAddress();
        $user['age'] = $getUserResponse->GetAge();
//            dump($user);
//            dump($status);
//            dd($getUserResponse);
//        }


        return $user ;
    }

    function insertUserGrpc($name, $address, $age){
        $accountCline = new Accountclient($this->host, [
            'credentials' => \Grpc\ChannelCredentials::createInsecure()
        ]);
        $createUserRequest = new CreateUserRequest();
        $createUserRequest->setName($name);
        $createUserRequest->setAddress($address);
        $createUserRequest->setAge($age);
        for($i=0;$i<1;$i++){
            list($createUserResponse, $status) = $accountCline->CreateUser($createUserRequest)->wait();
//        dd($status);
//        dump($createUserResponse, $status);
            if($status->code != 0){
                throw new \Exception($status->details." {$status->code}, metadata: ".json_encode($status->metadata));
            }
            $user['id'] = $createUserResponse->GetId();
            $user['name'] = $createUserResponse->GetName();
            $user['address'] = $createUserResponse->GetAddress();
            $user['age'] = $createUserResponse->GetAge();
            $users[] = $user;
        }

        return $users;
    }

    function insertUserHttp($name, $address, $age){

        $httpClient = new Http_client_helper();
        for($i=0;$i<1;$i++){
            $data = $httpClient->post('localhost/api/user', ['name'=>'testhttp', 'address'=>'wew', 'age'=>11], ['accept'=>'application/json']);
            $data = json_decode($data, true);
            $users[] = $data['users'];
        }

        return $users;
    }

    function insertUser($name, $address, $age){
        $data = [
            'name'=>$name,
            'address'=>$address,
            'age'=>$age
        ];
        $data['id'] = UsersModel::insertGetId($data);
        return $data;
    }


}