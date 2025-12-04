<?php
require_once 'User.php';

class Administrador extends User {
    public function __construct($username, $password) {
        parent::__construct($username, $password, 'administrador');
    }
}
