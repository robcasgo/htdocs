<?php
include 'conexion.php';
include 'header.php';

echo "<h1>Página de administración</h1>";

// Verificar si hay un usuario autenticado en la sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Redirigir a la página de inicio de sesión si no hay usuario autenticado
    exit();
}

// Mostrar la lista de productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Imprimir la tabla con la lista de productos
    echo "<table border='1'>";
    echo "<tr><th>nombre</th><th>descripcion</th><th>stock</th><th>imagen</th><th>precio</th><th>rareza</th><th>Acciones</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['nombre'] . "</td>";
        echo "<td>" . $row['descripcion'] . "</td>";
        echo "<td>" . $row['stock'] . "</td>";
        echo "<td>" . $row['imagen'] . "</td>";
        echo "<td>" . $row['precio'] . "</td>";
        echo "<td>" . $row['rareza'] . "</td>";
        echo "<td><a href='adminpage.php?editar=" . $row['id'] . "'>Editar</a> | <a href='adminpage.php?eliminar=" . $row['id'] . "'>Eliminar</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No se encontraron productos.";
}

echo "<h2>Añadir/Editar Producto</h2>";

$nombre = $descripcion = $stock = $imagen = $precio = $rareza = "";

// Procesar formulario de edición o adición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $stock = (int) $_POST['stock'];
    $imagen = $_POST['imagen'];
    $precio = (float) $_POST['precio'];
    $rareza = $_POST['rareza'];

    if (isset($_GET['editar'])) {
        // Si se está editando un producto
        $id_editar = (int) $_GET['editar'];

        $sql_actualizar = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', stock=$stock, imagen='$imagen', precio=$precio, rareza='$rareza' WHERE id=$id_editar";

        $resultado_actualizar = $conn->query($sql_actualizar);

        if (!$resultado_actualizar) {
            echo "Error al actualizar el producto: " . $conn->error;
        } else {
            // Redirigir a la página de administración después de la actualización
            header("Location: adminpage.php");
            exit();
        }
    } else {
        // Si se está añadiendo un nuevo producto
        $sql_insertar = "INSERT INTO productos (nombre, descripcion, stock, imagen, precio, rareza) VALUES ('$nombre', '$descripcion', $stock, '$imagen', $precio, '$rareza')";

        $resultado_insertar = $conn->query($sql_insertar);

        if (!$resultado_insertar) {
            echo "Error al insertar el nuevo producto: " . $conn->error;
        } else {
            // Redirigir a la página de administración después de la inserción
            header("Location: adminpage.php");
            exit();
        }
    }
}

// Formulario para añadir o editar productos
echo "<form method='post' action='adminpage.php'>";
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

if (isset($_GET['editar'])) {
    // Si se está editando, agregar un campo oculto con el ID del producto
    echo "<input type='hidden' name='id_editar' value='" . $_GET['editar'] . "'>";
    echo "<input type='submit' value='Actualizar'>";
} else {
    echo "<input type='submit' value='Añadir'>";
}

echo "</form>";

if (isset($_GET['eliminar'])) {
    // Si se solicita eliminar un producto
    $id_eliminar = (int) $_GET['eliminar'];
    $sql_eliminar = "DELETE FROM productos WHERE id=$id_eliminar";
    $resultado_eliminar = $conn->query($sql_eliminar);

    if (!$resultado_eliminar) {
        echo "Error al eliminar el producto: " . $conn->error;
    } else {
        // Redirigir a la página de administración después de la eliminación
        header("Location: adminpage.php");
        exit();
    }
}

include 'footer.php';
