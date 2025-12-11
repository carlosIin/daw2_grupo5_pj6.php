<?php
session_start();

/**
 * Redirige a login si no hay sesión de cliente activa
 */
function require_login() {
    if (!isset($_SESSION["client_user"])) {
        header("Location: /login.php");
        exit;
    }
}

/**
 * Devuelve el nombre del cliente logueado
 */
function get_current_username() {
    return $_SESSION["client_user"] ?? null;
}

/**
 * Sistema de plantillas (header, menú, footer)
 */
function render($template, $vars = []) {
    extract($vars);
    include __DIR__ . "/../templates/header.php";
    include __DIR__ . "/../templates/menu_cliente.php";
    include $template;
    include __DIR__ . "/../templates/footer.php";
}

/**
 * Ruta base donde están las carpetas de clientes
 */
function base_clients_dir() {
    return __DIR__ . "/../area_clients";
}

/**
 * Carga líneas de un fichero en array
 */
function load_lines($file) {
    if (!file_exists($file)) {
        return [];
    }
    return file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

/**
 * Carga JSON desde fichero, devolviendo array vacío si no existe
 */
function load_json($file) {
    if (!file_exists($file)) {
        return [];
    }
    return json_decode(file_get_contents($file), true);
}

/**
 * Guarda array como JSON en fichero
 */
function save_json($file, $data) {
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

/**
 * Carga los datos personales del cliente
 * (Usado solo si lo necesitas aparte)
 */
function get_client_data($user) {
    $file = base_clients_dir() . "/$user/dades";

    if (!file_exists($file)) {
        return null;
    }

    $content = file($file, FILE_IGNORE_NEW_LINES);

    return [
        "nom"      => $content[0] ?? "",
        "cognoms"  => $content[1] ?? "",
        "adreca"   => $content[2] ?? "",
        "email"    => $content[3] ?? "",
        "telefon"  => $content[4] ?? ""
    ];
}

/**
 * Guarda la cistella del client
 */
function save_basket($user, $basket) {
    $dir = base_clients_dir() . "/$user";
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }

    $file = "$dir/cistella.json";
    file_put_contents($file, json_encode($basket, JSON_PRETTY_PRINT));
}

/**
 * Carga la cistella
 */
function load_basket($user) {
    $file = base_clients_dir() . "/$user/cistella.json";

    if (!file_exists($file)) {
        return [];
    }

    return json_decode(file_get_contents($file), true);
}

/**
 * Guarda una comanda
 */
function save_order($user, $order) {
    $dir = base_clients_dir() . "/$user";
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }

    $file = "$dir/comandes.json";
    $orders = [];

    if (file_exists($file)) {
        $orders = json_decode(file_get_contents($file), true);
    }

    $orders[] = $order;

    file_put_contents($file, json_encode($orders, JSON_PRETTY_PRINT));
}

/**
 * Carga todas las comandes del client
 */
function load_orders($user) {
    $file = base_clients_dir() . "/$user/comandes.json";

    if (!file_exists($file)) {
        return [];
    }

    return json_decode(file_get_contents($file), true);
}
