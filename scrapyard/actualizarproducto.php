<?php
include 'conexion.php'; // incluyo el archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // recibo los datos del formulario
    $id_producto = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $stock = $_POST['stock'];
    $imagen = $_POST['imagen'];
    $precio = $_POST['precio'];
    $rareza = $_POST['rareza'];

    // actualizo el producto en la base de datos
    $sql_actualizar = "update productos SET nombre='$nombre', descripcion='$descripcion', stock=$stock, imagen='$imagen', precio=$precio, rareza='$rareza' where id=$id_producto";

    // ejecuto la consulta
    if ($conn->query($sql_actualizar) === TRUE) {
        echo "<script>
        alert('producto actualizado correctamente');
        window.location= 'adminpage.php'
         </script>";
    } else {
        echo "<script>
        alert('error al actualizar el producto');
        window.location= 'adminpage.php'
         </script>";
    }
}

include 'footer.php'; // incluyo el archivo de pie de página
?>