<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hundir la flota</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.css"> <!--Estilo externo -->
</head>

<body>

  
    <h2>Hundir la flota</h2>

    <form action="index.php" method="POST">

        <label for="soloLetras">Letra de la coordenada X:</label>
        <input type="text" id="coordLetras" name="coordLetras" required>
        <br><br>

        <label for="soloNumeros">Numero de la coordenada Y:</label>
        <input type="number" id="coordNumeros" name="coordNumeros"  required>
        <br><br>

        <input type="submit" value="Enviar">
    </form>
    <br>
    <br>

    <form action="index.php" method="POST">

    <input type="submit" name="reiniciar", value="reiniciar">

    </form>

    <?php print_r($tableroCompleto);?>
</body>
</html>