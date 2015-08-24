<?php namespace Project\Providers;

use Illuminate\Auth\UserProviderInterface;
use Illuminate\Auth\GenericUser;

class AuthUserProvider implements UserProviderInterface {

    /**
    * Retrieves a user by id
    *
    * @param int $identifier
    * @return mixed null|array

    */
    public function retrieveByID($identifier)
    {
        $this->user = is_null($this->user) ? $this->webservice->find($identifier) : $this->user;
        return $this->user;
    }