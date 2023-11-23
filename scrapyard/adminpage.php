<?php
    include 'conexion.php'; // Incluir el archivo de conexión a la base de datos
    include 'header.php'; // Incluir el archivo de cabecera

    // Consulta para obtener los usuarios desde la base de datos
    echo "<h1>Página de administacion</h1>";
    $sql = "select * from productos";
    // Ejecutamos y recogemos el resultado
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mostrar la lista de productos en una tabla
        echo "<table border='1'>";
        echo "<tr><th>nombre</th><th>descripcion</th><th>stock</th><th>imagen</th><th>precio</th><th>rareza</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            // valores que quiero mostrar
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td>" . $row['descripcion'] . "</td>";
            echo "<td>" . $row['stock'] . "</td>";
            echo "<td>" . $row['imagen'] . "</td>";
            echo "<td>" . $row['precio'] . "</td>";
            echo "<td>" . $row['rareza'] . "</td>";
            // editar/eliminar
            echo "<td><a href='editar_producto.php?id=" . $row['id'] . "'>Editar</a> | <a href='admin.php?eliminar=" . $row['id'] . "'>Eliminar</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron usuarios.";
    }


    include 'footer.php'; // Incluir el archivo de pie de página
?>