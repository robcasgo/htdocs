<?php
    include 'conexion.php'; // incluir el archivo de conexión a la base de datos
    include 'header.php'; // incluir el archivo de cabecera

    // obtengo los productos desde la base de datos
    $sql = "SELECT * FROM productos";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mostrar los productos
        echo "<section id='productos'>";
        while ($row = $result->fetch_assoc()) {
            echo "<article>";
            echo "<h2>" . $row['nombre'] . "</h2>";
            echo "<p>Precio: $" . $row['precio'] . "</p>";
            echo "<p>Descripción: $" . $row['descripcion'] . "</p>";
            echo "</article>";
        }
        echo "</section>";
    } else {
        echo "No se encontraron productos.";
    }

    include 'footer.php'; // Incluir el archivo de pie de página
?>