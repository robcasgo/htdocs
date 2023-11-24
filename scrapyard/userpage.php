<?php
include 'conexion.php'; // Incluir el archivo de conexión a la base de datos
include 'header.php'; // Incluir el archivo de cabecera

session_start();

echo "<h1>Página de usuario</h1>";

// Verificar si hay un usuario autenticado en la sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Redirigir a la página de inicio de sesión si no hay usuario autenticado
    exit();
}

// Verificar si se ha enviado una acción desde el formulario del carrito
if (isset($_POST['accion'])) {
    if ($_POST['accion'] == 'realizar_pedido') {
        // Lógica para realizar el pedido y guardar en la tabla de pedidos
        // ...

        // Vaciar el carrito después de realizar el pedido
        $_SESSION['carro'] = array();
        echo "<p>¡Pedido realizado con éxito!</p>";
    }
}

// Mostrar el carrito
if (isset($_SESSION['carro']) && count($_SESSION['carro']) > 0) {
    echo "<h2>Carrito de Compras</h2>";
    echo "<ul>";
    foreach ($_SESSION['carro'] as $idProducto => $cantidad) {
        // Consultar la información del producto según el ID
        $sqlProducto = "SELECT * FROM productos WHERE id = $idProducto";
        $resultProducto = $conn->query($sqlProducto);
        $rowProducto = $resultProducto->fetch_assoc();
        echo "<li>" . $rowProducto['nombre'] . " - Cantidad: " . $cantidad . "</li>";
    }
    echo "</ul>";

    // Formulario para realizar el pedido
    echo "<form action='userpage.php' method='post'>";
    echo "<input type='hidden' name='accion' value='realizar_pedido'>";
    echo "<input type='submit' value='Realizar Pedido'>";
    echo "</form>";
} else {
    echo "<p>El carrito está vacío.</p>";
}

include 'footer.php'; // Incluir el archivo de pie de página
