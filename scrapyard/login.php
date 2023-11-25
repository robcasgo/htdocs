<?php
include 'header.php'; // incluir el archivo de cabecera
?>
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

<?php
include 'footer.php'; // incluir el archivo de pie de página