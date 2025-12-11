<?php
require_once 'funcions.php';

class Comanda {
    public $id;
    public $usuari;
    public $productes; // Array amb productes i quantitat
    public $preu_total;
    public $data;

    public function __construct($id, $usuari, $productes, $preu_total) {
        $this->id = $id;
        $this->usuari = $usuari;
        $this->productes = $productes;
        $this->preu_total = $preu_total;
        $this->data = date('Y-m-d H:i:s');
    }

    public function guardar_no_gestionada() {
        $fitxer = RUTA_COMANDES . '/' . $this->id . '.json';
        escriure_json($fitxer, [
            'usuari' => $this->usuari,
            'productes' => $this->productes,
            'preu_total' => $this->preu_total,
            'data' => $this->data
        ]);
    }
}
?>

