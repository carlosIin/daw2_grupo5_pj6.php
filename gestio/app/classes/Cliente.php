<?php
class Cliente {
    private string $username;
    private string $password;
    private string $nombre;
    private string $apellidos;
    private string $direccion;
    private string $email;
    private string $telefono;
    private string $tarjeta;
    private string $ccv;

    public function __construct($username, $password, $nombre, $apellidos, $direccion, $email, $telefono, $tarjeta, $ccv) {
        $this->username = $username;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->direccion = $direccion;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->tarjeta = $tarjeta;
        $this->ccv = $ccv;
    }
}
