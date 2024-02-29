<?php
include('dbclass.php');
require_once('config.php');

define("IPN_LOG_FILE", "ipn.log");
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
    $keyval = explode('=', $keyval);
    if (count($keyval) == 2)
        $myPost[$keyval[0]] = urldecode($keyval[1]);
}

// Construye el cuerpo de la solicitud de verificación POST, agregando el comando _notify-validate.
$req = 'cmd=_notify-validate';
if (function_exists('get_magic_quotes_gpc')) {
    $get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
    if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
        $value = urlencode(stripslashes($value));
    } else {
        $value = urlencode($value);
    }
    $req .= "&$key=$value";
}

/*
Envía los datos de IPN de vuelta a PayPal utilizando curl para validar que los datos de IPN sean genuinos
Sin este paso, cualquiera puede falsificar los datos de IPN
*/
$ch = curl_init($paypal_url);
if ($ch == FALSE) {
    return FALSE;
}
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSLVERSION, 6);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

/*
Esto a menudo es necesario si el servidor no tiene un paquete de certificación global o está utilizando uno desactualizado.
Por favor, descargue el último 'cacert.pem' de http://curl.haxx.se/docs/caextract.html
*/
if ($local_certificate == TRUE) {
    curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . "/cert/cacert.pem");
}

// Establece el tiempo de espera de TCP en 30 segundos
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Connection: Close',
    'User-Agent: PHP-IPN-Verification-Script'
));

$res = curl_exec($ch);

// error de cURL
if (curl_errno($ch) != 0) {
    curl_close($ch);
    exit;
} else {
    curl_close($ch);
}

/* 
 * Inspecciona el resultado de la validación de IPN y actúa en consecuencia 
 * Divide las cabeceras de respuesta y la carga útil, una mejor manera de strcmp 
 */
$tokens = explode("\r\n\r\n", trim($res));
$res = trim(end($tokens));
if (strcmp($res, "VERIFIED") == 0 || strcasecmp($res, "VERIFIED") == 0) {
    // asigna las variables publicadas a variables locales
    // $item_number = $_POST['item_number'];
    // $item_name = $_POST['item_name'];
    $payer_id = $_POST['payer_id'];
    $item_number = $_POST['item_number'];
    $payment_status = $_POST['payment_status'];
    $amount = $_POST['mc_gross'];
    $currency = $_POST['mc_currency'];
    $txn_id = $_POST['txn_id'];
    $receiver_email = $_POST['receiver_email'];
    $payer_email = $_POST['payer_email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $payment_date = $_POST['payment_date'];
    $custom = $_POST['custom'];
    // comprueba que receiver_email sea tu correo electrónico comercial de PayPal
    if (strtolower($receiver_email) != strtolower($payer_email)) {
        error_log(date('[Y-m-d H:i e] ') . "Correo electrónico comercial no válido: $req" . PHP_EOL, 3, IPN_LOG_FILE);
        exit();
    }

    // comprueba que la moneda del pago sea correcta
    if (strtolower($currency) != strtolower($currency)) {
        error_log(date('[Y-m-d H:i e] ') . "Moneda no válida: $req" . PHP_EOL, 3, IPN_LOG_FILE);
        exit();
    }

    //Comprueba la identificación única de la transacción
    $db = new DB;
    $db->query("SELECT * FROM 'payment_info' WHERE txn_id=:txn_id");
    $db->bind(':txn_id', $txn_id);
    $db->execute();
    $unique_txn_id = $db->rowCount();

    if (!empty($unique_txn_id)) {
        error_log(date('[Y-m-d H:i e] ') . "ID de transacción no válida: $req" . PHP_EOL, 3, IPN_LOG_FILE);
        $db->close();
        exit();
    } else {
        $db->query("INSERT INTO `payments` (`payer_id`,`ref_id`,`payment_status`,`amount`,`currency`,`txn_id`,`payer_email`,`first_name`,`last_name`,`created_at`) 
        VALUES (:payer_id, :ref_id, :payment_status, :amount, :currency, :txn_id, :payer_email, :first_name, :last_name,:payment_date)");
        $db->bind(":payer_id", $payer_id);
        $db->bind(":ref_id", $ref_id);
        $db->bind(":payment_status", $payment_status);
        $db->bind(":amount", $amount);
        $db->bind(":currency", $currency);
        $db->bind(":txn_id", $txn_id);
        $db->bind(":payer_email", $payer_email);
        $db->bind(":first_name", $first_name);
        $db->bind(":last_name", $last_name);
        $db->bind(":payment_date", $payment_date);
        $db->execute();
    }
    $db->close();
} else if (strcmp($res, "INVALID") == 0) {
    error_log(date('[Y-m-d H:i e] ') . "IPN no válido: $req" . PHP_EOL, 3, IPN_LOG_FILE);
}
?>
