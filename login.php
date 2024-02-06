<?php

session_start();

$conexion = mysqli_connect('localhost', 'root', '', 'pokemon') or die(mysqli_error($mysqli));

$email = $_POST['email'];
$clave = $_POST['clave'];

$consulta = "SELECT * FROM entrenador WHERE email='$email' AND clave='$clave'";
$resultado = mysqli_query($conexion, $consulta);

if (mysqli_num_rows($resultado) == 1) {
    // Las credenciales son válidas, iniciar sesión y redirigir al usuario
    $_SESSION['email'] = $email;
    header("location: inicio4.php");
} else {
    // Las credenciales son incorrectas, redirigir al usuario de vuelta al formulario de inicio de sesión
    header("location: index.php");
}

mysqli_close($conexion);

?>