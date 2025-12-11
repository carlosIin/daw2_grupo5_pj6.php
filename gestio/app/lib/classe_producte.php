<?php
require_once 'funcions.php';

class Producte {
    public $id;
    public $nom;
    public $preu;

    public function __construct($id, $nom, $preu) {
        $this->id = $id;
        $this->nom = $nom;
        $this->preu = $preu;
    }

    public function guardar() {
        $fitxer = RUTA_PRODUCTES . '/productes.json';
        $dades = llegir_json($fitxer);
        $dades[$this->id] = [
            'nom' => $this->nom,
            'preu' => $this->preu
        ];
        escriure_json($fitxer, $dades);

        // Actualitzar còpia per a clients
        $fitxer_copia = __DIR__ . '/../productes_copia/productes.json';
        escriure_json($fitxer_copia, $dades);
    }
}
?>
