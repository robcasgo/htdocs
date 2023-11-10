<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>
</head>

<body>

    <?php
    include("conexion.php");

    echo "<h1>Página de administacion</h1>";
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