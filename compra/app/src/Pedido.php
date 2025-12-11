<?php

class Pedido {

    private array $items = [];
    private string $data;

    public function __construct(array $items = [], string $data = null) {
        $this->items = $items;
        $this->data = $data ?? date("Y-m-d H:i:s");
    }

    public static function fromBasket(array $items): Pedido {
        return new Pedido($items);
    }

    public function toArray(): array {
        return [
            "data" => $this->data,
            "items" => $this->items
        ];
    }
}
