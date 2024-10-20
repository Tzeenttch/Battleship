<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Revisar serialize
function generateShips()
{
    $casillaInicioSmith = rand(0, 9); //Destructor
    $direccionSmith = rand(1, 2); // 1 Vertical, 2 Horizontal
    if ($direccionSmith == 1) {
        $destroyerSmith = [$casillaInicioSmith, rand(0, 9), 2, 1]; // Vertical
    } else {
        $destroyerSmith = [rand(0, 9), $casillaInicioSmith, 2, 2]; // Horizontal
    }

    $casillaInicioBalao = rand(0, 7);  //Submarino 1
    $direccionBalao = rand(1, 2);
    if ($direccionBalao == 1) {
        $submarineBalao = [$casillaInicioBalao, rand(0, 9), 3, 1];
    } else {
        $submarineBalao = [rand(0, 9), $casillaInicioBalao, 3, 2];
    }

    $casillaInicioU190 = rand(0, 7); // Submarino 2
    $direccionU190 = rand(1, 2);
    if ($direccionU190 == 1) {
        $submarineU190 = [$casillaInicioU190, rand(0, 9), 3, 1];
    } else {
        $submarineU190 = [rand(0, 9), $casillaInicioU190, 3, 2];
    }

    $casillaInicioBismark = rand(0, 6); // Acorazado
    $direccionBismark = rand(1, 2);
    if ($direccionBismark == 1) {
        $battleshipBismark = [$casillaInicioBismark, rand(0, 9), 4, 1];
    } else {
        $battleshipBismark = [rand(0, 9), $casillaInicioBismark, 4, 2];
    }

    $casillaInicioMidway = rand(0, 5); // Portaaviones
    $direccionMidway = rand(1, 2);
    if ($direccionMidway == 1) {
        $aircraftMidway = [$casillaInicioMidway, rand(0, 9), 5, 1];
    } else {
        $aircraftMidway = [rand(0, 9), $casillaInicioMidway, 5, 2];
    }

    $barcosParametros = [$destroyerSmith, $submarineBalao, $submarineU190, $battleshipBismark, $aircraftMidway];

    return $barcosParametros;
}

function llenarTablero($flota)
{
    $tableroConFlota = [];
    for ($i = 0; $i < 10; $i++) {
        $tableroConFlota[$i] = array_fill(0, 10, null);
    }

    foreach ($flota as $barco) {
        $ejeX = $barco[0];
        $ejeY = $barco[1];
        $tamanyo = $barco[2];
        $direccion = $barco[3];

        for ($i = 0; $i < $tamanyo; $i++) {
            if ($direccion == 1) {
                if ($ejeX + $i < 10) { //Manejo del eje X
                    if ($tableroConFlota[$ejeX + $i][$ejeY] === null) {
                        $tableroConFlota[$ejeX + $i][$ejeY] = "X";
                    } else {
                    }
                }
            } else {  //Manejo del eje Y
                if ($ejeY + $i < 10) {
                    if ($tableroConFlota[$ejeX][$ejeY + $i] === null) {
                        $tableroConFlota[$ejeX][$ejeY + $i] = "X";
                    } else {
                    }
                }
            }
        }
    }

    //Editar cabeceras
    $nuevasKeysLetras = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
    $nuevasKeysNumeros = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
    $tableroLetras = [];
    foreach ($tableroConFlota as $index => $newKeys) {
        $tableroLetras[$nuevasKeysLetras[$index]] = $newKeys;
    }
    foreach ($tableroLetras as $letras => $index) {
        $tableroNumeros = [];
        foreach ($index as $value => $newIndex) {
            $tableroNumeros[$nuevasKeysNumeros[$value]] = $newIndex;
        }
        $tableroLetras[$letras] = $tableroNumeros;
    }

    //dump($tableroLetras);
    return $tableroLetras;
}

function coordenadaAtacada($letras, $numeros1, $posicionesAtacadas)
{
    foreach ($posicionesAtacadas as $posicion) {
        if ($posicion[0] === $letras && $posicion[1] == $numeros1) {
            return true;
        }
    }
    return false;
}

//TODO: Ajustar la forma en laque pinta para que no se pierdan posiciones por el camino
function pintarTablero($letrasCoord, $numerosCoord, $ubicaciones)
{
    $posicionesAtacadas = [];
    $output = '<table border="1">';
    $output .= '<tr><th></th>';
    //Header eje X
    foreach ($letrasCoord as $keyLetras => $header) {
        $output .= "<th>" . $header . "</th>";
    }
    $output .= '</tr>';
    //Header eje Y

    foreach ($numerosCoord as $numeros1) {
        $output .= '<tr>';
        $output .= '<td>' . $numeros1 . '</td>';
        //Contenido
        foreach ($letrasCoord as $letras) {

            $buque = $ubicaciones[$letras][$numeros1];
            
            $posicionesAtacadas =  $_SESSION['posicionAtacada'];

            if (coordenadaAtacada($letras, $numeros1, $posicionesAtacadas)) { 
                if (is_null($buque)) {

                    $output .= '<td>' . "*" . '</td>'; //display:none para ocultar los datos, el 0 es donde van los datos a guardar(barcos y agua); "style="display:none;"
                } else {
                    $output .= '<td>' . $buque . '</td>'; //display:none para ocultar los datos, el 0 es donde van los datos a guardar(barcos y agua); "style="display:none;"
                }
            } else {
                $output .= '<td style="visibility:hidden;">' . "*" . '</td>'; // visibility:hidden para mostrar en oculto los datos
            }
        }
        $output .= '</tr>';
    }
    $output .= '</table>';
    return $output;
}

function dump($var)
{
    echo '<pre>' . print_r($var, true) . '</pre>';
}
