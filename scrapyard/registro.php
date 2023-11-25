<?php
include 'header.php'; // incluir el archivo de cabecera
?>
<!-- formulario de registro -->
<h1>REGISTRO</h1>
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
</br>
<a href="index.php">Volver al inicio</a>

<?php
include 'footer.php'; // incluir el archivo de pie de página