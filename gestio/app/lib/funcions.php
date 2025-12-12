<?php
session_start();

// Rutes dels directoris
define('RUTA_TREBALLADORS', __DIR__ . '/../treballadors');
define('RUTA_CLIENTS', __DIR__ . '/../clients');
define('RUTA_PRODUCTES', __DIR__ . '/../productes');
define('RUTA_COMANDES', __DIR__ . '/../comandes');
define('RUTA_COMANDES_GESTIONADES', __DIR__ . '/../comandes_gestionades');

// Funció per verificar sessió iniciada
function verificar_sessio() {
    if (!isset($_SESSION['usuari'])) {
        header("Location: ../index.php");
        exit();
    }
}

// Funcions de tipus d'usuari
function es_administrador() {
    return isset($_SESSION['tipus']) && $_SESSION['tipus'] === 'administrador';
}

function es_treballador() {
    return isset($_SESSION['tipus']) && $_SESSION['tipus'] === 'treballador';
}

function es_client() {
    return isset($_SESSION['tipus']) && $_SESSION['tipus'] === 'client';
}

// Generar hash segur per contrasenyes
function generar_hash_contrasenya($contrasenya) {
    return password_hash($contrasenya, PASSWORD_DEFAULT);
}

// Verificar contrasenya
function verificar_contrasenya($contrasenya, $hash) {
    return password_verify($contrasenya, $hash);
}

// Llegir fitxer JSON
function llegir_json($fitxer) {
    if(file_exists($fitxer)) {
        return json_decode(file_get_contents($fitxer), true);
    }
    return [];
}

// Escriure fitxer JSON
function escriure_json($fitxer, $dades) {
    return file_put_contents($fitxer, json_encode($dades, JSON_PRETTY_PRINT));
}
?>
