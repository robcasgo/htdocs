<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Función para añadir un producto al carrito
function agregarAlCarrito($idProducto, $cantidad)
{
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }

    // Verificar si el producto ya está en el carrito
    if (isset($_SESSION['carrito'][$idProducto])) {
        $_SESSION['carrito'][$idProducto] += $cantidad; // Incrementar la cantidad si el producto ya está en el carrito
    } else {
        // Añadir el producto al carrito con verificación de stock
        include "conexion.php";

        $sqlStock = "SELECT stock FROM productos WHERE idProducto = $idProducto";
        $resultStock = mysqli_query($conn, $sqlStock);

        if ($resultStock && mysqli_num_rows($resultStock) > 0) {
            $rowStock = mysqli_fetch_assoc($resultStock);
            $stockDisponible = $rowStock['stock'];

            // Verificar el stock antes de agregar al carrito
            if ($cantidad <= $stockDisponible) {
                $_SESSION['carrito'][$idProducto] = $cantidad;
                echo "Producto agregado al carrito.";
            } else {
                echo "No hay suficiente stock disponible.";
            }
        } else {
            echo "No se pudo obtener la información de stock.";
        }

        // Cerrar la conexión a la base de datos
        mysqli_close($conn);
    }
}

// Función para visualizar el carrito
function visualizarCarrito()
{
    if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
        echo "El carrito está vacío.";
        return;
    }

    echo "<h2>Carrito de Compras</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID Producto</th><th>Cantidad</th></tr>";

    foreach ($_SESSION['carrito'] as $idproducto => $cantidad) {
        echo "<tr>";
        echo "<td>$idproducto</td>";
        echo "<td>$cantidad</td>";
        echo "</tr>";
    }

    echo "</table>";
}

// Función para realizar la compra y guardar como un pedido en la base de datos
function realizarCompra($nombreUsuario, $contrasena)
{
    // Verificar las credenciales del usuario en la base de datos
    // Aquí debes agregar la lógica para verificar el usuario en tu tabla de usuarios

    // Si las credenciales son válidas, proceder con la compra
    // ...

    // Vaciar el carrito después de la compra
    $_SESSION['carrito'] = array();

    echo "Compra realizada con éxito.";
}

// Función para vaciar el carrito
function vaciarCarrito()
{
    $_SESSION['carrito'] = array();
    echo "Carrito vaciado correctamente.";
}

// Manejar acciones según la solicitud
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accion'])) {
        switch ($_POST['accion']) {
            case 'agregar':
                if (isset($_POST['idproducto']) && isset($_POST['cantidad'])) {
                    agregarAlCarrito($_POST['idproducto'], $_POST['cantidad']);
                }
                // Redirigir de nuevo a index.php después de agregar al carrito
                header("Location: index.php");
                exit(); // Asegurar que el script se detenga después de la redirección
                break;
            case 'visualizar':
                visualizarCarrito();
                break;
            case 'comprar':
                if (isset($_POST['nombreUsuario']) && isset($_POST['contrasena'])) {
                    realizarCompra($_POST['nombreUsuario'], $_POST['contrasena']);
                }
                break;
            case 'vaciar':
                vaciarCarrito();
                break;
            default:
                echo "Acción no reconocida.";
        }
    }
}
