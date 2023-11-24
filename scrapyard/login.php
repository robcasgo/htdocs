<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- formulario inicio de sesion -->
    <h1>INICIA SESION</h1>
    <form action="validarlogin.php" method="post">
        <input name="username" type="text" placeholder="Usuario">
        </br>
        <input name="password" type="password" placeholder="Contraseña">
        </br>
        <input type="submit" value="Iniciar sesión">
    </form>
    <a href="registro.php">No tienes usuario?</a>
    </br>
    <a href="index.php">Volver al inicio</a>

</body>

</html>
