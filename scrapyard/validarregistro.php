<?php
include("conexion.php");

// Recojo los parámetros enviados  
$username = $_POST["username"];
$password = $_POST["password"];
$password2 = $_POST["password2"];

//comprobamos que sean iguales las contraseñas
if ($password !== $password2) {
// Construyo la consulta
$sql = "insert into users (username, password) values ('$username', '$password')";
// ejecuto la consulta
$conn->query($sql);

header("Location: registro.php");
} else {
    //alerta nuevo usuario creado
     echo "<script>
                alert('Nuevo usuario creado');
                window.location= 'login.php'
            </script>";

}


// Construyo la consulta
$sql = "insert into users (username, password) values ('$username', '$password')";

// ejecuto la consulta
$conn->query($sql);

//cierro la conexión
$conn->close();
?>