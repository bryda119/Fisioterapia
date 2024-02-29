<?php
include('../admin/config/dbconn.php');

// PAYPAL CONFIGURATION
$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

$sql = "SELECT * FROM payment_settings WHERE id=1";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {

    $paypal_email = $row['business_email'];
    $RETURN_URL = $row['success'];
    $CANCEL_URL = $row['cancel'];
    $NOTIFY_URL = $row['ipn'];
    $fee = $row['fee'];
}

$currency = 'PHP';
$local_certificate = FALSE;
$sandbox = TRUE;

if ($sandbox === TRUE) {
    $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
} else {
    $paypal_url = "https://www.paypal.com/cgi-bin/webscr";
}

// Simula el pago exitoso
if (isset($_GET['payment_simulated'])) {
    // Realiza las acciones necesarias para indicar que el pago ha sido realizado, por ejemplo, actualizar el estado de la transacción en la base de datos
    // ...

    echo "Pago simulado exitoso. Puedes cerrar esta ventana.";
    exit;
}
?>
