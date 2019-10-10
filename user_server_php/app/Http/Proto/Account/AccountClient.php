<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Account;

/**
 */
class AccountClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \Account\CreateUserRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateUser(\Account\CreateUserRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/account.Account/CreateUser',
        $argument,
        ['\Account\CreateUserResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Account\UpdateUserRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateUser(\Account\UpdateUserRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/account.Account/UpdateUser',
        $argument,
        ['\Account\UpdateUserResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Account\GetUserRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetUser(\Account\GetUserRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/account.Account/GetUser',
        $argument,
        ['\Account\GetUserResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Account\DeleteUserRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteUser(\Account\DeleteUserRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/account.Account/DeleteUser',
        $argument,
        ['\Account\DeleteUserResponse', 'decode'],
        $metadata, $options);
    }

}
