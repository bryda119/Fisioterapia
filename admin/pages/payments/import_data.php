<?php
// Verifica si se ha enviado el formulario de importación de datos
if(isset($_POST['importData'])) {
    // Verifica si se ha subido un archivo
    if(isset($_FILES['importFile']['name']) && !empty($_FILES['importFile']['name'])) {
        // Ruta donde se almacenarán los archivos subidos
        $upload_folder = "uploads/";
        
        // Crea el directorio de uploads si no existe
        if(!file_exists($upload_folder)) {
            mkdir($upload_folder, 0777, true);
        }
        
        // Obtiene información sobre el archivo subido
        $file_name = $_FILES['importFile']['name'];
        $file_tmp = $_FILES['importFile']['tmp_name'];
        $file_size = $_FILES['importFile']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Define los formatos de archivo permitidos
        $allowed_ext = array("csv", "xlsx", "xls");

        // Verifica si la extensión del archivo está permitida
        if(in_array($file_ext, $allowed_ext)) {
            // Genera un nombre único para el archivo
            $unique_name = uniqid() . '.' . $file_ext;
            $target_file = $upload_folder . $unique_name;

            // Intenta mover el archivo cargado al directorio de uploads
            if(move_uploaded_file($file_tmp, $target_file)) {
                // Procesa el archivo según su extensión
                switch($file_ext) {
                    case "csv":
                        // Lógica para procesar un archivo CSV
                        // Aquí puedes utilizar las funciones de PHP para leer y procesar el archivo CSV
                        echo "El archivo CSV se ha importado correctamente.";
                        break;
                    case "xlsx":
                    case "xls":
                        // Lógica para procesar un archivo Excel (XLSX o XLS)
                        // Aquí puedes utilizar librerías como PhpSpreadsheet para leer y procesar el archivo Excel
                        echo "El archivo Excel se ha importado correctamente.";
                        break;
                }
            } else {
                echo "Error al subir el archivo.";
            }
        } else {
            echo "Solo se permiten archivos CSV, XLSX y XLS.";
        }
    } else {
        echo "Por favor, seleccione un archivo para importar.";
    }
} else {
    echo "Acceso no autorizado.";
}
?>
