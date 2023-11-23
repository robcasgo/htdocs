<?php
include 'conexion.php'; // Incluir el archivo de conexión a la base de datos
include 'header.php'; // Incluir el archivo de cabecera

// Verificar si se proporciona un ID válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_producto = $_GET['id'];

    // Consultar la base de datos para obtener la información del producto
    $sql = "SELECT * FROM productos WHERE id = $id_producto";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Obtener los datos del producto
        $row = $result->fetch_assoc();
        $nombre = $row['nombre'];
        $descripcion = $row['descripcion'];
        $stock = $row['stock'];
        $imagen = $row['imagen'];
        $precio = $row['precio'];
        $rareza = $row['rareza'];

        // Mostrar un formulario con la información actual del producto
        echo "<h2>Editar Producto</h2>";
        echo "<form method='post' action='actualizarproducto.php'>";
        echo "<input type='hidden' name='id' value='$id_producto'>";
        echo "<label for='nombre'>Nombre:</label>";
        echo "<input type='text' name='nombre' value='$nombre' required><br>";
        echo "<label for='descripcion'>Descripción:</label>";
        echo "<input type='text' name='descripcion' value='$descripcion' required><br>";
        echo "<label for='stock'>Stock:</label>";
        echo "<input type='number' name='stock' value='$stock' required><br>";
        echo "<label for='imagen'>Imagen:</label>";
        echo "<input type='text' name='imagen' value='$imagen' required><br>";
        echo "<label for='precio'>Precio:</label>";
        echo "<input type='number' name='precio' value='$precio' required><br>";
        echo "<label for='rareza'>Rareza:</label>";
        echo "<input type='text' name='rareza' value='$rareza' required><br>";
        echo "<input type='submit' value='Actualizar'>";
        echo "</form>";
    } else {
        echo "No se encontró el producto.";
    }
} else {
    echo "ID de producto no válido.";
}

include 'footer.php'; // Incluir el archivo de pie de página
?>