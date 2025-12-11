<?php
require_once 'Client.php';
require_once 'Producte.php';

class Comanda {
    private string $idComanda;
    private Client $client;
    private array $productes; // array de Producte => quantitat
    private float $total;
    private string $data;

    public function __construct(Client $client, array $productes) {
        $this->client = $client;
        $this->productes = $productes;
        $this->data = date('Y-m-d H:i:s');
        $this->idComanda = md5($this->data . $client->getEmail());
        $this->calcularTotal();
    }

    private function calcularTotal() {
        $this->total = 0;
        foreach ($this->productes as $producte => $quantitat) {
            $this->total += $producte->getPreu() * $quantitat;
        }
        $this->total *= 1.21; // afegim IVA 21%
    }

    // Getters
    public function getId(): string { return $this->idComanda; }
    public function getClient(): Client { return $this->client; }
    public function getProductes(): array { return $this->productes; }
    public function getTotal(): float { return $this->total; }
    public function getData(): string { return $this->data; }
}
