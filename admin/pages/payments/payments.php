<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
</head>
<body>
    <h1>Payments Page</h1>
    <?php
// Verificar si hay mensajes de error o éxito en la URL
if (isset($_GET['error'])) {
    $error_message = '';
    switch ($_GET['error']) {
        case 'patient_not_found':
            $error_message = 'El paciente no fue encontrado.';
            break;
        case 'payment_not_registered':
            $error_message = 'No se pudo registrar el pago.';
            break;
        default:
            $error_message = 'Hubo un error al procesar el pago.';
            break;
    }
    echo '<p style="color: red;">' . $error_message . '</p>';
} elseif (isset($_GET['success'])) {
    echo '<p style="color: green;">El pago se procesó exitosamente.</p>';
}

// Redireccionar a la página de pagos
header('Refresh: 0.1; URL=/fisioterapia/admin/pages/payments/');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
</head>
<body>
    <h1>Payments Page</h1>
    <!-- Agregar aquí contenido adicional según sea necesario -->
</body>
</html>

</body>
</html>
