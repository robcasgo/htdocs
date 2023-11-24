<?php
// Iniciar la sesión
session_start();

// Destruir todas las variables de sesión
session_unset();
session_destroy();

// Redirigir a la página de inicio o a donde desees
header("Location: index.php");
exit();
