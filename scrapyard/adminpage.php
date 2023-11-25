<?php
include 'conexion.php';
include 'header.php';

echo "<h1>Página de administración</h1>";

// Verificar si hay un usuario autenticado en la sesión
if (!isset($_SESSION['rol'])) {
    header("Location: login.php"); // Redirigir a la página de login si no está identificado
    exit();
} elseif ($_SESSION['rol'] != 'admin') {
    header("Location: userpage.php"); // Redirigir a la página de usuario si no es administrador
    exit();
}

// Función para obtener el nombre de usuario
function obtenerNombreUsuario($idUsuario)
{
    global $conn;
    $sql = "SELECT username FROM users WHERE id = $idUsuario";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['username'];
    } else {
        return 'Usuario no encontrado';
    }
}

// Mostrar la lista de productos
$sqlProductos = "SELECT * FROM productos";
$resultProductos = $conn->query($sqlProductos);

if ($resultProductos->num_rows > 0) {
    // Imprimir la tabla con la lista de productos
    echo "<table border='1'>";
    echo "<tr><th colspan='7'>TABLA PRODUCTOS</th></tr>";
    echo "<tr><th>nombre</th><th>descripcion</th><th>stock</th><th>imagen</th><th>precio</th><th>rareza</th><th>Acciones</th></tr>";

    while ($row = $resultProductos->fetch_assoc()) {
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

// Mostrar la lista de pedidos
$sqlPedidos = "SELECT * FROM pedidos";
$resultPedidos = $conn->query($sqlPedidos);

if ($resultPedidos->num_rows > 0) {
    // Imprimir la tabla con la lista de pedidos
    echo "<table border='1'>";
    echo "<tr><th colspan='5'>TABLA PEDIDOS</th></tr>";
    echo "<tr><th>ID Pedido</th><th>Usuario</th><th>Fecha</th><th>Estado</th><th>Total</th></tr>";

    while ($rowPedido = $resultPedidos->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $rowPedido['id'] . "</td>";
        echo "<td>" . obtenerNombreUsuario($rowPedido['idusuario']) . "</td>";
        echo "<td>" . $rowPedido['fecha'] . "</td>";
        echo "<td>" . $rowPedido['estado'] . "</td>";
        echo "<td>" . $rowPedido['total'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No se encontraron pedidos.";
}

// Mostrar la lista de detalles de pedidos
$sqlDetallesPedido = "SELECT * FROM detalles_pedido";
$resultDetallesPedido = $conn->query($sqlDetallesPedido);

if ($resultDetallesPedido->num_rows > 0) {
    // Imprimir la tabla con la lista de detalles de pedidos
    echo "<table border='1'>";
    echo "<tr><th colspan='5'>TABLA DETALLE PEDIDOS</th></tr>";
    echo "<tr><th>ID Detalle</th><th>ID Pedido</th><th>ID Producto</th><th>Cantidad</th><th>Precio Unitario</th></tr>";

    while ($rowDetallePedido = $resultDetallesPedido->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $rowDetallePedido['id'] . "</td>";
        echo "<td>" . $rowDetallePedido['idpedido'] . "</td>";
        echo "<td>" . $rowDetallePedido['idproducto'] . "</td>";
        echo "<td>" . $rowDetallePedido['cantidad'] . "</td>";
        echo "<td>" . $rowDetallePedido['precioUnitario'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No se encontraron detalles de pedidos.";
}

echo "<h2>Añadir/Editar Producto</h2>";

$nombre = $descripcion = $stock = $imagen = $precio = $rareza = "";

// Me llega un id y quiero precargar el formulario para editar
if (isset($_GET['editar'])) {
    $idProducto = $_GET['editar'];

    // Buscar en la base de datos la información del producto
    $stmt = $conn->prepare("select nombre, descripcion, stock, imagen, precio, rareza from productos where id = ?");
    $stmt->bind_param("i", $idProducto);
    $stmt->execute();
    $stmt->bind_result($nombre, $descripcion, $stock, $imagen, $precio, $rareza);

    // Cargar los valores en las variables
    if ($stmt->fetch()) {
        // Los valores se cargan automáticamente desde la base de datos
    } else {
        // Manejar el caso en el que no se encuentra el producto con el ID dado
        echo "No se encontró el producto con el ID especificado.";
        exit();
    }

    // Cerrar la declaración
    $stmt->close();

// Ya he cargado el formulario con los datos a editar y me lo vuelven a enviar
} elseif (isset($_POST['editarDatos'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $stock = (int) $_POST['stock'];
    $imagen = $_POST['imagen'];
    $precio = (float) $_POST['precio'];
    $rareza = $_POST['rareza'];

    // Si se está editando un producto
    $id_editar = (int) $_POST['editarDatos'];

    $sql_actualizar = "update productos set nombre='$nombre', descripcion='$descripcion', stock=$stock, imagen='$imagen', precio=$precio, rareza='$rareza' where id=$id_editar";

    $resultado_actualizar = $conn->query($sql_actualizar);

    if (!$resultado_actualizar) {
        echo "Error al actualizar el producto: " . $conn->error;
    } else {
        // Redirigir a la página de administración después de la actualización
        header("Location: adminpage.php");
        exit();
    }

// Me envian un producto para añadir
} elseif (isset($_REQUEST['addDatos'])) {

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $stock = (int) $_POST['stock'];
    $imagen = $_POST['imagen'];
    $precio = (float) $_POST['precio'];
    $rareza = $_POST['rareza'];

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
    echo "<input type='hidden' name='editarDatos' value='" . $_GET['editar'] . "'>";
    echo "<input type='submit' value='Actualizar'>";
} else {
    echo "<input type='hidden' name='addDatos' value='1'>";
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
