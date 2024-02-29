<?php
// Incluir el archivo de conexión a la base de datos
include('../../config/dbconn.php');

// Consulta SQL para obtener los montos de los pagos
$sql = "SELECT amount FROM payments";

$result = mysqli_query($conn, $sql);

// Verificar si hay errores en la consulta
if (!$result) {
    die('Error en la consulta: ' . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Pagos</title>
    <!-- Agregar DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>

<?php
// Verificar si hay resultados
if (mysqli_num_rows($result) > 0) {
    // Iniciar la tabla
    echo '<table id="payment-table">';
    echo '<thead><tr><th>Monto</th></tr></thead>';
    echo '<tbody>';

    // Iterar sobre los resultados y mostrarlos en la tabla
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['amount'] . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    // Cerrar la tabla
    echo '</table>';
} else {
    // No se encontraron resultados
    echo 'No hay montos de pagos disponibles';
}

// Liberar el resultado y cerrar la conexión
mysqli_free_result($result);
mysqli_close($conn);
?>

<!-- Agregar jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Agregar DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#payment-table').DataTable();
    });
</script>
</body>
</html>
