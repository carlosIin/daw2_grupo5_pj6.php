<?php
require_once 'Usuari.php';

class Treballador extends Usuari {
    private string $nom;
    private string $cognoms;
    private string $adreca;
    private string $email;
    private string $telefon;

    public function __construct(
        string $usuari, 
        string $contrasenya, 
        string $tipus, 
        string $nom, 
        string $cognoms, 
        string $adreca, 
        string $email, 
        string $telefon
    ) {
        parent::__construct($usuari, $contrasenya, $tipus);
        $this->nom = $nom;
        $this->cognoms = $cognoms;
        $this->adreca = $adreca;
        $this->email = $email;
        $this->telefon = $telefon;
    }

    // Getters
    public function getNomComplet(): string {
        return $this->nom . ' ' . $this->cognoms;
    }

    public function getAdreca(): string { return $this->adreca; }
    public function getEmail(): string { return $this->email; }
    public function getTelefon(): string { return $this->telefon; }
}
