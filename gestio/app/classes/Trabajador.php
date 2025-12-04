<?php
require_once 'User.php';

class Trabajador extends User {
    private string $nombre;
    private string $apellidos;
    private string $direccion;
    private string $email;
    private string $telefono;

    public function __construct($username, $password, $nombre, $apellidos, $direccion, $email, $telefono) {
        parent::__construct($username, $password, 'trabajador');
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->direccion = $direccion;
        $this->email = $email;
        $this->telefono = $telefono;
    }
}
