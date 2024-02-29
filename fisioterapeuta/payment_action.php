<?php
include('../admin/config/dbconn.php');
date_default_timezone_set("America/Guayaquil");

function validarEstadoPago($payment_status) {
    // Verifica si el estado de pago es válido
    if ($payment_status == "Pending" || $payment_status == "Paid" || $payment_status == "Failed") {
        return $payment_status;
    } else {
        // Si el estado de pago no es válido, se establece como "Pending" por defecto
        return "Pending";
    }
}

function subirCSV() {
    $nombreArchivo = $_FILES['file']['name'];
    $archivoTemp = $_FILES['file']['tmp_name'];
    $directorioTemp = sys_get_temp_dir(); // Obtener el directorio temporal del sistema
    $rutaDestino = $directorioTemp . '/' . $nombreArchivo;

    // Intentar mover el archivo temporal al directorio de destino (temporal)
    if (move_uploaded_file($archivoTemp, $rutaDestino)) {
        return $rutaDestino; // Devuelve la ruta del archivo
    } else {
        // Si falla la carga, devuelve false
        return false;
    }
}

if (isset($_POST['insertpayment'])) {
    // Recopilamos los datos del formulario
    $patient_id = $_POST['patient_id'];
    $app_id = $_POST['app_id'] ?? null;
    $payer_id = $_POST['payer_id'] ?? null;
    $ref_id = $_POST['ref_id'] ?? null;
    $payment_status = validarEstadoPago($_POST['payment_status']);
    $amount = $_POST['amount'];
    $currency = $_POST['currency'] ?? null;
    $txn_id = $_POST['transaction_id'] ?? null;
    $payer_email = $_POST['payer_email'] ?? null;
    $first_name = $_POST['first_name'] ?? null;
    $last_name = $_POST['last_name'] ?? null;
    $method = $_POST['payment_method'];
    $created_at = date('Y-m-d H:i:s');

    // Verificamos si el patient_id es válido en la tabla tblappointment
    $check_stmt = $conn->prepare("SELECT id FROM tblappointment WHERE id = ?");
    $check_stmt->bind_param("i", $patient_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Preparamos la consulta SQL para insertar el pago
        $sql = "INSERT INTO payments (patient_id, app_id, payer_id, ref_id, payment_status, amount, currency, txn_id, payer_email, first_name, last_name, method, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("iiisdsdssssss", $patient_id, $app_id, $payer_id, $ref_id, $payment_status, $amount, $currency, $txn_id, $payer_email, $first_name, $last_name, $method, $created_at);
            
            if ($stmt->execute()) {
                $_SESSION['success'] = "El pago se registró correctamente";
                header('Location: payments.php?success=1');
                exit();
            } else {
                $_SESSION['error'] = "Error al registrar el pago: " . $conn->error;
            }
            $stmt->close();
        } else {
            $_SESSION['error'] = "Error en la preparación de la consulta: " . $conn->error;
        }
    } else {
        $_SESSION['error'] = "ID de paciente no válido";
    }

    header('Location: payments.php?error=1');
}

if (isset($_POST['importSubmit'])) {
    // Intentar subir el archivo CSV
    $rutaArchivo = subirCSV();

    if ($rutaArchivo) {
        // Archivo subido exitosamente, ahora procesa el CSV
        $csvFile = fopen($rutaArchivo, 'r');

        if (!$csvFile) {
            $_SESSION['error'] = "No se pudo abrir el archivo CSV.";
            header("Location: payments.php?error=1");
            exit();
        }

        // Resto del código para procesar el CSV ...
    } else {
        $_SESSION['error'] = "Se produjo un problema al subir el archivo, por favor inténtelo de nuevo.";
        header('Location: payments.php?error=1');
    }
}

// Cerramos la conexión a la base de datos
$conn->close();
?>
