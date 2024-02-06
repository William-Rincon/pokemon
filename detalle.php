<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    // Si el usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
    header("Location: inicio.php");
    exit; // Detener la ejecución del script después de redirigir
}

// Ahora que sabemos que el usuario ha iniciado sesión, podemos continuar mostrando los detalles del Pokémon
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Pokémon</title>
    <link rel="stylesheet" href="estilos.css">

    <link rel="icon" href="../img/Pokelogo.ico">

    <style>
        body {
            background-image: url('..img/poke.jpg');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        .container {
            text-align: center;
            margin: 30px auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            max-width: 250px;
        }

        .back-button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>

</head>
<body>

<div style="text-align: right; padding: 10px;">
    <a href="registro.php" style="color: #fff; margin-right: 10px;">Registro</a>
    <a href="inicio.php" style="color: #fff;">Home</a>
</div>

<div class="container">
<?php
    if (isset($_GET['id'])) {
        $pokemonId = $_GET['id'];
        $pokemonData = file_get_contents("https://pokeapi.co/api/v2/pokemon/{$pokemonId}");
        $pokemonDetails = json_decode($pokemonData, true);

        $pokemonImage = $pokemonDetails['sprites']['front_default'];
        $pokemonName = ucfirst($pokemonDetails['name']);
        $pokemonType = ucfirst($pokemonDetails['types'][0]['type']['name']); // Tomando solo el primer tipo por simplicidad

        echo "<h2>{$pokemonName}</h2>";
        echo "<img src='{$pokemonImage}' alt='{$pokemonName}' style='width: 50%;'>";


        echo "<h2>Tipo</h2> {$pokemonType}";

        echo "<h2>Habilidades</h2>";


        foreach ($pokemonDetails['abilities'] as $ability) {
            $abilityName = ucfirst($ability['ability']['name']);
            echo "<li>{$abilityName}</li>";
        }
   
   

        // Botón para ir al inicio
       // echo '<a href="inicio.php" class="back-button">Inicio </a>';
       echo "<input type='button' value='Atras' onClick='history.go(-1);' class='back-button'>";

        //echo "<input type='button' value='Atras' onClick='history.go(-1);'>"  class="back-button";
    } else {
        echo "<p>No se ha seleccionado ningún Pokémon.</p>";
    }
?>
</div>

</body>
</html>
