<?php

class Cistella {
    private array $items = [];

    public function __construct(array $data = []) {
        $this->items = $data['items'] ?? [];
    }

    public function getItems(): array {
        return $this->items;
    }

    public function clear(): void {
        $this->items = [];
    }

    public function toArray(): array {
        return ['items' => $this->items];
    }
}
