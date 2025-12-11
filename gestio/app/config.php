<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Rutes dels fitxers
define('RUTA_TREBALLADORS', __DIR__ . '/../treballadors');
define('RUTA_CLIENTS', __DIR__ . '/../clients');
define('RUTA_PRODUCTES', __DIR__ . '/../productes');
define('RUTA_COMANDES', __DIR__ . '/../comandes_gestionades');

// Funció per verificar si l'usuari està autenticat
function verificar_sessio() {
    if (!isset($_SESSION['usuari'])) {
        header('Location: login.php');
        exit();
    }
}

// Funcions per comprovar tipus d'usuari
function es_administrador() {
    return isset($_SESSION['tipus']) && $_SESSION['tipus'] === 'administrador';
}

function es_treballador() {
    return isset($_SESSION['tipus']) && $_SESSION['tipus'] === 'treballador';
}

function es_client() {
    return isset($_SESSION['tipus']) && $_SESSION['tipus'] === 'client';
}

// Funció per obtenir l'usuari actual
function usuari_actual() {
    return $_SESSION['usuari'] ?? '';
}

// Configuració PHPMailer (opcional, per enviar correus)
define('EMAIL_REMITENT', 'empresa@example.com');
define('EMAIL_PASSWORD', 'contrassenya_email');
define('EMAIL_HOST', 'smtp.example.com');
define('EMAIL_PORT', 587);
define('EMAIL_SECURE', 'tls');
