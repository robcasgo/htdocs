<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user page</title>
</head>

<body>

    <?php
    include 'conexion.php'; // Incluir el archivo de conexión a la base de datos
    include 'header.php'; // Incluir el archivo de cabecera

    echo "<h1>Página de usuario</h1>";
    $sql = "select * from users";
    // Ejecutamos y recogemos el resultado
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        echo $row['username'];
        echo $row['password'];
        echo $row['role'];
    }

    ?>


</body>

</html>