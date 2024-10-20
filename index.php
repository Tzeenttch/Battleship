<?php
session_start();

if (isset($_POST['reiniciar'])) { //Boton de reinicio
    session_destroy();
    header("Location: index.php");
}

//Incluimos las variables globales
include_once('app/globalVars.php');
include_once('app/funcionalidad.php');
//TODO: Sustituir A por el resultado de la funcionde generar barcos


if (isset($_SESSION['posicionAtacada'])) { //Variable session para guardar las posiciones que ya han sido atacadas
    $posicionAtacada = $_SESSION['posicionAtacada'];
} else {
    $posicionAtacada = [];
}

if (!isset($_SESSION['hundirTablero'])) { //Variable session para mantener el mismo tablero 
    $flota = generateShips();
    $_SESSION['hundirTablero'] = llenarTablero($flota);
}

$tableroConFlota = $_SESSION['hundirTablero'];

if (isset($_SESSION['cantidadX'])) { //variable session para mantener el numero de veces que se acierta en un barco
    $cantidadX = $_SESSION['cantidadX'];
} else {
    $cantidadX =  0;
}
$maX = 0;



foreach ($tableroConFlota as $posicion) {
    foreach ($posicion as $fila) {
        if ($fila == "X") {
            $maX++;
        }
    }
}

if (!empty($_POST)) {
    $coordX = $_POST['coordLetras'];
    $coordY = $_POST['coordNumeros'];
    $nuevaPosicion = [$coordX, $coordY];
    if (!in_array($nuevaPosicion, $posicionAtacada)) { //Comprobacion para evitar duplicados dentro del array 
        $posicionAtacada[] = $nuevaPosicion;
        $_SESSION['posicionAtacada'] = $posicionAtacada; //Guardan los datos correctamente
        $coordenadas = $tableroConFlota[$coordX][$coordY];
        switch ($coordenadas) {
            case "X":
                echo ("Le has dado a un barco");
                $cantidadX++;
                break;

            case "":
                echo ("Agua");
                break;

            default:
                echo ("Coordenada Invalida");
                break;
        }
        $_SESSION['cantidadX'] = $cantidadX;
     } else {
        echo ("Ya has atacado aqui anteriormente");
    }
}

$tableroCompleto = pintarTablero($letrasTablero, $numerosTablero, $tableroConFlota);






if ($cantidadX >= $maX) {
    echo "¡Felicidades! Has hundido todos los barcos.";
    session_destroy();
}

include_once('templates/templateJuego.php');
