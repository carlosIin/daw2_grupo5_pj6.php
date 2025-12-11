<?php
require_once 'Usuari.php';

class Client extends Usuari {
    private string $nom;
    private string $cognoms;
    private string $adreca;
    private string $email;
    private string $telefon;
    private string $numTargeta;
    private string $ccv;

    public function __construct(
        string $usuari,
        string $contrasenya,
        string $nom,
        string $cognoms,
        string $adreca,
        string $email,
        string $telefon,
        string $numTargeta,
        string $ccv
    ) {
        parent::__construct($usuari, $contrasenya, 'client');
        $this->nom = $nom;
        $this->cognoms = $cognoms;
        $this->adreca = $adreca;
        $this->email = $email;
        $this->telefon = $telefon;
        $this->numTargeta = $numTargeta;
        $this->ccv = $ccv;
    }

    // Getters
    public function getNomComplet(): string { return $this->nom . ' ' . $this->cognoms; }
    public function getAdreca(): string { return $this->adreca; }
    public function getEmail(): string { return $this->email; }
    public function getTelefon(): string { return $this->telefon; }
    public function getNumTargeta(): string { return $this->numTargeta; }
    public function getCcv(): string { return $this->ccv; }
}
