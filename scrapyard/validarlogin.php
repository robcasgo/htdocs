<?php
session_start();

include("conexion.php");

$username = $_POST['username'];
$password = $_POST['password'];

//se valida si se ha enviado información, con la función isset()
if (!isset($username, $password)) {

    // si no hay datos muestra error y re direccionar
    header('Location: login.php');
}

$sql = "select * from users where username = '" . $username . "'";
//ejecutamos y recogemos el resultado
$result = $conn->query($sql);
//recorro el array
$row = mysqli_fetch_assoc($result);

if ($row["role"] = "admin") {
    //comprobamos que sean iguales las contraseñas
    if ($row["password"] != $password) {
        header("Location: login.php");
    } else {
        header("Location: adminpage.php");
    }
} else {
    header("Location: adminpage.php");
}

//cierro la conexions
$conn->close();
?>