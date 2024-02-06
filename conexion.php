<?php

$conexion = mysqli_connect('localhost', 'root', '', 'pokemon') 
    or die(mysqli_error($mysqli));

insertar($conexion);

function insertar($conexion){
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $clave = $_POST['clave'];

    // Encriptar la contraseña
    $hashedPassword = password_hash($clave, PASSWORD_DEFAULT);

    $consulta = "INSERT INTO entrenador(nombre,email,clave)
    VALUES ('$nombre', '$email', '$hashedPassword' )"; // Insertar el hash en lugar de la contraseña en texto plano
    mysqli_query($conexion, $consulta);
    mysqli_close($conexion);
    header("location: index.php");
}

?>
