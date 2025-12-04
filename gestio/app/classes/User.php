<?php
class User {
    protected string $username;
    protected string $password;
    protected string $role;

    public function __construct($username, $password, $role) {
        $this->username = $username;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->role = $role;
    }

    public function verifyPassword($password) {
        return password_verify($password, $this->password);
    }

    public function getRole() {
        return $this->role;
    }
}
