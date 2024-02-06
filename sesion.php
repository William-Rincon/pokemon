<?php

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    // Si el usuario no ha iniciado sesión, redirigirlo al formulario de inicio de sesión
    header("location: index.php");
    exit();
}

// Aquí puedes mostrar el contenido de la página de inicio, como el nombre del usuario, etc.
echo "¡Bienvenido, ".$_SESSION['email']."!<br>";
echo "<a href='logout.php'>Cerrar sesión</a>";

?>
