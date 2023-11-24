<?php
include 'conexion.php'; // incluir el archivo de conexión a la base de datos
include 'header.php'; // incluir el archivo de cabecera

// Obtengo los productos desde la base de datos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mostrar los productos
    echo "<section id='productos'>";
    while ($row = $result->fetch_assoc()) {
        echo "<article>";
        echo "<h2>" . $row['nombre'] . "</h2>";
        echo "<img src='" . $row['imagen'] . "' border='0' width='100' height='100'>";
        echo "<p>Precio: $" . $row['precio'] . "</p>";
        echo "<p>Descripción: " . $row['descripcion'] . "</p>";

        // Botón para agregar al carrito
        echo "<form action='carro.php' method='post'>";
        echo "<input type='hidden' name='accion' value='agregar'>";
        echo "<input type='hidden' name='idProducto' value='" . $row['id'] . "'>"; // Puedes usar el ID del producto aquí
        echo "<input type='number' name='cantidad' value='1' min='1'>";
        echo "<input type='submit' value='Añadir al Carrito'>";
        echo "</form>";

        echo "</article>";
    }
    echo "</section>";
} else {
    echo "No se encontraron productos.";
}

include 'footer.php'; // incluir el archivo de pie de página
