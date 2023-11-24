<?php
include 'conexion.php'; // Incluir el archivo de conexión a la base de datos
include 'header.php'; // Incluir el archivo de cabecera

echo "<h1>Página de usuario</h1>";

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Función para visualizar el carrito en userpage.php
function visualizarCarrito()
{
    if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
        echo "El carrito está vacío.";
        return;
    }

    echo "<h2>Carrito de Compras</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID Producto</th><th>Cantidad</th><th>Acciones</th></tr>";

    foreach ($_SESSION['carrito'] as $idproducto => $cantidad) {
        echo "<tr>";
        echo "<td>$idproducto</td>";
        echo "<td>$cantidad</td>";
        echo "<td><a href='userpage.php?accion=eliminar&idproducto=$idproducto'>Eliminar</a></td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "<br>";
    echo "<form method='post' action='userpage.php'>";
    echo "<input type='hidden' name='accion' value='comprar'>";
    echo "<label for='nombreUsuario'>Nombre de Usuario:</label>";
    echo "<input type='text' name='nombreUsuario' required><br>";
    echo "<label for='contrasena'>Contraseña:</label>";
    echo "<input type='password' name='contrasena' required><br>";
    echo "<input type='submit' value='Realizar Compra'>";
    echo "</form>";
}

// Función para eliminar un producto del carrito
function eliminarDelCarrito($idproducto)
{
    if (isset($_SESSION['carrito'][$idproducto])) {
        unset($_SESSION['carrito'][$idproducto]);
        echo "Producto eliminado del carrito.";
    } else {
        echo "El producto no está en el carrito.";
    }
}

// Función para realizar la compra y guardar como un pedido en la base de datos
function realizarCompra($nombreUsuario, $contrasena)
{
    $sql = "SELECT idusuario FROM usuarios WHERE username = '$nombreUsuario' AND password = '$contrasena'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Las credenciales son válidas, proceder con la compra y guardar en la base de datos
        $row = mysqli_fetch_assoc($result);
        $idusuario = $row['idusuario'];

        // Ejemplo: Guardar en la tabla de pedidos
        $carrito = $_SESSION['carrito'];

        foreach ($carrito as $idproducto => $cantidad) {
            $sqlInsert = "INSERT INTO pedidos (idusuario, idproducto, cantidad) VALUES ($idusuario, $idproducto, $cantidad)";
            mysqli_query($conn, $sqlInsert);
        }

        // Vaciar el carrito después de la compra
        $_SESSION['carrito'] = array();

        echo "Compra realizada con éxito y registrada en la base de datos.";
    } else {
        echo "Credenciales inválidas. No se pudo realizar la compra.";
    }

    echo "Compra realizada con éxito y registrada en la base de datos.";
}

// Manejar acciones según la solicitud
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accion'])) {
        switch ($_POST['accion']) {
            case 'comprar':
                if (isset($_POST['nombreUsuario']) && isset($_POST['contrasena'])) {
                    realizarCompra($_POST['nombreUsuario'], $_POST['contrasena']);
                }
                break;
            default:
                echo "Acción no reconocida.";
        }
    }
}

// Manejar acciones según los parámetros de la URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['accion'])) {
        switch ($_GET['accion']) {
            case 'eliminar':
                if (isset($_GET['idproducto'])) {
                    eliminarDelCarrito($_GET['idproducto']);
                }
                break;
            default:
                echo "Acción no reconocida.";
        }
    }
}

// Mostrar el carrito
visualizarCarrito();

include 'footer.php'; // Incluir el archivo de pie de página
