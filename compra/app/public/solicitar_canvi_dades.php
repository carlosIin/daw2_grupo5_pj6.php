<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

// Comprovació de sessió
if (!isset($_SESSION["client_user"]) || $_SESSION["role"] !== "client") {
    header("Location: login.php");
    exit;
}

$usuari = $_SESSION["client_user"];
$missatge = "";

// Quan s'envia el formulari
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $dada = $_POST["dada"] ?? "";
    $valor = $_POST["valor"] ?? "";

    if ($dada === "" || $valor === "") {
        $missatge = "Cal omplir tots els camps.";
    } else {

        // ---------------------------
        //     ENVIAMENT DEL CORREU
        // ---------------------------
        $mail = new PHPMailer(true);

        try {
            // Configuració SMTP REAL (Gmail)
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;

            // ✔️ EL TEU CORREU I CONTRASENYA D’APLICACIÓ
            $mail->Username   = 'nilgrasam@gmail.com';
            $mail->Password   = 'owfs zxbq vnzo mtoz';

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Configuració del correu
            $mail->setFrom('nilgrasam@gmail.com', 'Botiga Muebles');
            $mail->addAddress('nilgrasam@gmail.com'); // Enviar-te’l a tu mateix

            $mail->Subject = "Sol·licitud de canvi de dades de l'usuari $usuari";
            $mail->Body    = "L'usuari $usuari sol·licita modificar la dada '$dada' amb el valor: $valor";

            // Enviar correu
            $mail->send();
            $missatge = "Correu enviat correctament.";

        } catch (Exception $e) {
            $missatge = "Error en enviar el correu: " . $mail->ErrorInfo;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sol·licitar canvi de dades</title>

<style>
body { font-family: Arial; margin: 20px; }
.top-bar { 
    display: flex; 
    justify-content: space-between; 
    background: #eee; 
    padding: 10px; 
    border-bottom: 1px solid #ccc; 
}
.right { cursor: pointer; position: relative; }
.dropdown {
    display: none;
    position: absolute;
    right: 0;
    top: 25px;
    background: white;
    border: 1px solid #ccc;
    padding: 5px;
}
.right:hover .dropdown { display: block; }
</style>

</head>
<body>

<div class="top-bar">
    <div class="left">Client</div>
    <div class="right">
        <?= htmlspecialchars($usuari) ?>
        <div class="dropdown">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</div>

<h1>Sol·licitar canvi de dades</h1>

<?php if ($missatge): ?>
<p><strong><?= htmlspecialchars($missatge) ?></strong></p>
<?php endif; ?>

<form method="POST">

    <label>Dada a modificar:</label>
    <select name="dada">
        <option value="">-- Tria una dada --</option>
        <option value="nom">Nom i Cognoms</option>
        <option value="adreca">Adreça física</option>
        <option value="email">Adreça de correu electrònic</option>
        <option value="telefon">Telèfon</option>
        <option value="tarjeta">Número de la targeta de crèdit</option>
        <option value="ccv">CCV de la targeta de crèdit</option>
    </select>

    <br><br>

    <label>Nou valor:</label>
    <input type="text" name="valor">

    <br><br>

    <button type="submit">Enviar sol·licitud</button>
</form>

<br>
<a href="dashboard_cliente.php">Tornar</a>

</body>
</html>
