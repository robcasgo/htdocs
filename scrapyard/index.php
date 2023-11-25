<?php
include 'conexion.php'; // incluir el archivo de conexión a la base de datos
include 'header.php'; // incluir el archivo de cabecera

?>
<section id='productos' class='card-container'>
    <?php
// Obtengo los productos desde la base de datos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<article class='card'>";
        echo "<h2>" . $row['nombre'] . "</h2>";
        echo "<img src='" . $row['imagen'] . "' alt='" . $row['nombre'] . "' width='100' height='100'>";
        echo "<p class='precio'>Precio: $" . $row['precio'] . "</p>";
        echo "<p class='descripcion'>Descripción: " . $row['descripcion'] . "</p>";

        // Botón para agregar al carrito
        echo "<form action='carro.php' method='post'>";
        echo "<input type='hidden' name='accion' value='agregar'>";
        echo "<input type='hidden' name='idProducto' value='" . $row['id'] . "'>";
        echo "<input type='number' name='cantidad' value='1' min='1'>";
        echo "<input type='submit' value='Añadir al Carrito'>";
        echo "</form>";

        echo "</article>";
    }
} else {
    echo "<p class='no-productos'>No se encontraron productos.</p>";
}
?>
</section>
<?

include 'footer.php'; // incluir el archivo de pie de página