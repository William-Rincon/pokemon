<?php
session_start();
?>

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
        <!-- <a href="#" onclick="openModal('registroModal')">Registro</a> -->
        <a href="logout.php" >Cerrar Sesión</a>
        <a href="index.php">Home</a>
        <!-- Puedes agregar más enlaces para otras secciones si es necesario -->
    </div>


        <div class="pokemon-cards-container">
            <!-- Resto de tu código -->
            <?php
            $limit = 15;
            $offset = isset($_GET['page']) ? ($_GET['page'] - 1) * $limit : 0;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://pokeapi.co/api/v2/pokemon?limit={$limit}&offset={$offset}");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $pokemonListData = curl_exec($ch);
            curl_close($ch);

            $pokemonList = json_decode($pokemonListData, true)['results'];


            $totalPokemon = json_decode($pokemonListData, true)['count'];
            $totalPages = ceil($totalPokemon / $limit);

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

        <div class="pagination">
            <div class="pagination-container">
                <!-- Resto de tu código de paginación -->
                <?php
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

                for ($i = 1; $i <= $totalPages; $i++) {
                    $class = ($i == $currentPage) ? 'current' : '';
                    echo "<a href='?page={$i}' class='{$class}'>{$i}</a>";
                }
                ?>
            </div>
        </div>


    <!-- Modal de Registro -->
    <div id="registroModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('registroModal')">&times;</span>
            <!-- Agrega tu formulario de registro aquí -->
            <h2>Formulario de Registro</h2>
            <form action="conexion.php" method="post">
                <!-- Campos del formulario -->
                <input type="text" name="nombre" placeholder="Nombre">
                <input type="email" name="email" placeholder="Correo Electrónico">
                <input type="password" name="clave" placeholder="Contraseña">
                <button type="submit" name="enviar" class="button">Registrarse</button>
            </form>
        </div>
    </div>

    <!-- Modal de Inicio de Sesión -->
    <div id="inicioSesionModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('inicioSesionModal')">&times;</span>
            <!-- Agrega tu formulario de inicio de sesión aquí -->
            <h2>Formulario de Inicio de Sesión</h2>
            <form action="login.php" method="post">
                <!-- Campos del formulario -->
                <input type="email" name="email" placeholder="Correo Electrónico">
                <input type="password" name="clave" placeholder="Contraseña">
                <button type="submit" name="iniciar" class="button">Iniciar Sesión</button>
            </form>
        </div>
    </div>

    <script>
    function verDetalles(pokemonId) {
        // Aquí verificas si el usuario ha iniciado sesión
        var usuarioAutenticado = <?php echo isset($_SESSION['email']) ? 'true' : 'false'; ?>;

        if (usuarioAutenticado) {
            // Si el usuario ha iniciado sesión, redirige a la página de detalles con el ID del Pokémon
            window.location.href = 'detalle.php?id=' + pokemonId;
        } else {
            // Si el usuario no ha iniciado sesión, muestra un mensaje o abre un modal para iniciar sesión
            alert('Debes iniciar sesión para ver los detalles.');
            // O bien, abre un modal de inicio de sesión
            openModal('inicioSesionModal');
        }
    }
    </script>




        
    

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        

    </script>





   

    
</body>
</html>
