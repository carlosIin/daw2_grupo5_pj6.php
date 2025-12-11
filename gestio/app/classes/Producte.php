<?php
class Producte {
    private string $idProducte;
    private string $nom;
    private float $preu;

    public function __construct(string $idProducte, string $nom, float $preu) {
        $this->idProducte = $idProducte;
        $this->nom = $nom;
        $this->preu = $preu;
    }

    // Getters
    public function getId(): string { return $this->idProducte; }
    public function getNom(): string { return $this->nom; }
    public function getPreu(): float { return $this->preu; }
}
