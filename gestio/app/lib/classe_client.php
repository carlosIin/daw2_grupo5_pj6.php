<?php
require_once 'funcions.php';

class Client {
    public $id;
    public $nom_usuari;
    public $contrasenya;
    public $nom;
    public $cognoms;
    public $adreca;
    public $email;
    public $telefon;
    public $targeta;
    public $ccv;

    public function __construct($id, $nom_usuari, $contrasenya, $nom, $cognoms, $adreca, $email, $telefon, $targeta, $ccv) {
        $this->id = $id;
        $this->nom_usuari = $nom_usuari;
        $this->contrasenya = generar_hash_contrasenya($contrasenya);
        $this->nom = $nom;
        $this->cognoms = $cognoms;
        $this->adreca = $adreca;
        $this->email = $email;
        $this->telefon = $telefon;
        $this->targeta = $targeta;
        $this->ccv = $ccv;
    }

    public function guardar() {
        $fitxer = RUTA_CLIENTS . '/clients.json';
        $dades = llegir_json($fitxer);
        $dades[$this->id] = [
            'nom_usuari' => $this->nom_usuari,
            'contrasenya' => $this->contrasenya,
            'nom' => $this->nom,
            'cognoms' => $this->cognoms,
            'adreca' => $this->adreca,
            'email' => $this->email,
            'telefon' => $this->telefon,
            'targeta' => $this->targeta,
            'ccv' => $this->ccv
        ];
        escriure_json($fitxer, $dades);

        // Crear directori personal
        $carpeta = RUTA_CLIENTS . '/../area_clients/' . $this->nom_usuari;
        if(!is_dir($carpeta)) mkdir($carpeta, 0755, true);
        file_put_contents($carpeta.'/dades.json', json_encode($dades[$this->id], JSON_PRETTY_PRINT));
    }
}
?>
