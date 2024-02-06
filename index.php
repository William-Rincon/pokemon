<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POKEMON</title>
    <link rel="icon" href="../img/Pokelogo.ico">
    <link rel="stylesheet" href="estilos1.css">

</head>
<body>
   
    <div class="navbar">
        <a href="#" onclick="openModal('registroModal')">Registro</a>
        <a href="#" onclick="openModal('inicioSesionModal')">Inicio Sesión</a>
        <!-- <a href="index.php">Home</a> -->
        <!-- Puedes agregar más enlaces para otras secciones si es necesario -->
    </div>

    <div class="pokemon-cards-container">
        <?php
            $limit = 9; // Limitamos a solo 9 Pokémon

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://pokeapi.co/api/v2/pokemon?limit={$limit}");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $pokemonListData = curl_exec($ch);
            curl_close($ch);

            $pokemonList = json_decode($pokemonListData, true)['results'];

            foreach ($pokemonList as $pokemon) {
                $pokemonName = ucfirst($pokemon['name']);
                $pokemonId = explode('/', rtrim($pokemon['url'], '/'))[count(explode('/', rtrim($pokemon['url'], '/')))-1];

                $chDetails = curl_init();
                curl_setopt($chDetails, CURLOPT_URL, "https://pokeapi.co/api/v2/pokemon/{$pokemonId}");
                curl_setopt($chDetails, CURLOPT_RETURNTRANSFER, 1);
                $pokemonDetailsData = curl_exec($chDetails);
                curl_close($chDetails);

                $pokemonDetails = json_decode($pokemonDetailsData, true);
                $pokemonImage = $pokemonDetails['sprites']['front_default'];

                echo "<div class='pokemon-card'>";
                echo "<img src='{$pokemonImage}' alt='{$pokemonDetails['name']}' class='pokemon-image'>";
                echo "<div class='pokemon-info'>";
                echo "<h3>{$pokemonName}</h3>";
                // Agrega un identificador único a cada botón usando el ID del Pokémon
                echo "<button type='button' class='pokemon-button' onclick='verDetalles(\"{$pokemonId}\")'>Ver Detalles</button>";
                echo "</div>";
                echo "</div>";
            }
        ?>

   

    </div>

    <script>
        function verDetalles(pokemonId) {
            // Aquí puedes implementar la lógica para mostrar detalles del Pokémon
            console.log("Ver detalles del Pokémon #" + pokemonId);
        }

        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }
    </script>

    <!-- Modal de Registro -->
    <div id="registroModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('registroModal')">&times;</span>
            <h2>Formulario de Registro</h2>
            <form action="conexion.php" method="post">
                <!-- Campos del formulario -->
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="email" name="email" placeholder="Correo Electrónico" required>
                <input type="password" name="clave" placeholder="Contraseña" required>
                <button type="submit" name="enviar" class="button">Registrarse</button>
            </form>
        </div>
    </div>

    <!-- Modal de Inicio de Sesión -->
    <div id="inicioSesionModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('inicioSesionModal')">&times;</span>
            <h2>Formulario de Inicio de Sesión</h2>
            <form action="login.php" method="post">
                <!-- Campos del formulario -->
                <input type="email" name="email" placeholder="Correo Electrónico" required>
                <input type="password" name="clave" placeholder="Contraseña" required>
                <button type="submit" name="iniciar" class="button">Iniciar Sesión</button>
            </form>
        </div>
    </div>


    <script>
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        

    </script>
    <script>
    function verDetalles(pokemonId) {
        // Redirigir al modal de inicio de sesión
        openModal('inicioSesionModal');
    }

    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }
</script>
</body>
</html>
