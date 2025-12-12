<?php
require_once 'config.php';
verificar_sessio();

if (!es_administrador()) {
    echo "Accés denegat";
    exit();
}

$usuari = usuari_actual();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrador</title>
</head>
<body>
    <div style="display:flex; justify-content: space-between;">
        <div><strong>Tipus d'usuari:</strong> Administrador</div>
        <div>
            <strong><?php echo $usuari; ?></strong>
            <ul>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <h1>Dashboard Administrador</h1>
    <ul>
        <li>Gestió treballadors
            <ul>
                <li><a href="treballadors/crear.php">Crear treballador</a></li>
                <li><a href="treballadors/borrar.php">Esborrar treballador</a></li>
                <li><a href="treballadors/visualitzar.php">Visualitzar treballador</a></li>
            </ul>
        </li>
        <li>Gestió clients
            <ul>
                <li><a href="clients/crear.php">Crear client</a></li>
                <li><a href="clients/borrar.php">Esborrar client</a></li>
                <li><a href="clients/visualitzar.php">Visualitzar client</a></li>
            </ul>
        </li>
        <li>Gestió productes
            <ul>
                <li><a href="productes/crear.php">Crear producte</a></li>
                <li><a href="productes/borrar.php">Esborrar producte</a></li>
                <li><a href="productes/visualitzar.php">Visualitzar producte</a></li>
            </ul>
        </li>
        <li>Gestió comandes
            <ul>
				<li><a href="comandes/no_gestionades.php">Llistar comandes no gestionades</a></li>
                <li><a href="comandes/visualitzar.php">Visualitzar comanda</a></li>
                <li><a href="comandes/procesar.php">Processar comanda</a></li>
                <li><a href="comandes/enviar_correu.php">Enviar correu comanda</a></li>
            </ul>
        </li>
    </ul>
</body>
</html>
