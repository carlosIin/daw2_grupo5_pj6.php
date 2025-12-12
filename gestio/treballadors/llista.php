<?php
function carregar_treballadors() {
    $fitxer = __DIR__ . '/treballadors.json';
    if (!file_exists($fitxer)) return [];
    return json_decode(file_get_contents($fitxer), true);
}
?>
