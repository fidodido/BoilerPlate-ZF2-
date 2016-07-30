<?php

namespace Auth\Model;

interface IdentityManagerInterface {

    public function login($identity, $credential);

    public function logout();

    public function hasIdentity();

    public function storeIdentity($identity);

    public function getAuthService();
}
