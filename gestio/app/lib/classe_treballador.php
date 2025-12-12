<?php
require_once 'funcions.php';

class Treballador {
    public $id;
    public $nom_usuari;
    public $contrasenya;
    public $tipus;
    public $nom;
    public $cognoms;
    public $adreca;
    public $email;
    public $telefon;

    public function __construct($id, $nom_usuari, $contrasenya, $tipus, $nom, $cognoms, $adreca, $email, $telefon) {
        $this->id = $id;
        $this->nom_usuari = $nom_usuari;
        $this->contrasenya = generar_hash_contrasenya($contrasenya);
        $this->tipus = $tipus;
        $this->nom = $nom;
        $this->cognoms = $cognoms;
        $this->adreca = $adreca;
        $this->email = $email;
        $this->telefon = $telefon;
    }

    public function guardar() {
        $fitxer = RUTA_TREBALLADORS . '/treballadors.json';
        $dades = llegir_json($fitxer);
        $dades[$this->id] = [
            'nom_usuari' => $this->nom_usuari,
            'contrasenya' => $this->contrasenya,
            'tipus' => $this->tipus,
            'nom' => $this->nom,
            'cognoms' => $this->cognoms,
            'adreca' => $this->adreca,
            'email' => $this->email,
            'telefon' => $this->telefon
        ];
        return escriure_json($fitxer, $dades);
    }
}
?>
