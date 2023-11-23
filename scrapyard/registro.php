<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!--
    https://code.tutsplus.com/es/create-a-php-login-form--cms-33261t
    https://parzibyte.me/blog/2019/01/22/ejemplo-simple-login-php/
    -->
    <h1>INICIA SESION</h1>
    <form action="validarregistro.php" method="post">
        <input name="username" type="text" placeholder="Usuario">
        </br>
        <input name="password" type="password" placeholder="Contraseña">
        </br>
        <input name="password2" type="password" placeholder="Confirmar contraseña">
        </br>
        <input type="submit" value="Registrarme">
    </form>
    <a href="login.php">Ya tienes usuario?</a>
</body>

</html>
