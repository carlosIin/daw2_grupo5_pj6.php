<?php
function carregar_clients() {
    $fitxer = __DIR__ . '/clients.json';
    if (!file_exists($fitxer)) return [];
    return json_decode(file_get_contents($fitxer), true);
}
?>
