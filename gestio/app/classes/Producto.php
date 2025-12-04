<?php
class Producto {
    private string $id;
    private string $nombre;
    private float $precio;

    public function __construct($id, $nombre, $precio) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
    }
}
