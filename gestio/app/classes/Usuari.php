<?php
class Usuari {
    protected string $usuari;
    protected string $contrasenya;
    protected string $tipus;

    public function __construct(string $usuari, string $contrasenya, string $tipus) {
        $this->usuari = $usuari;
        $this->contrasenya = password_hash($contrasenya, PASSWORD_DEFAULT);
        $this->tipus = $tipus;
    }

    // Getters
    public function getUsuari(): string {
        return $this->usuari;
    }

    public function getTipus(): string {
        return $this->tipus;
    }

    public function verificarContrasenya(string $contrasenya): bool {
        return password_verify($contrasenya, $this->contrasenya);
    }
}
