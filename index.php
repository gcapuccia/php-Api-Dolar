<?php

const API_URL = 'https://dolarapi.com/v1/dolares';

$iniciarCURL = curl_init(API_URL);
curl_setopt($iniciarCURL, CURLOPT_RETURNTRANSFER, true);
$resultado = curl_exec($iniciarCURL);
$data = json_decode($resultado, true);


//una alternativa para obtener solo el GET 
// $resultado = file_get_contents(API_URL);
// $data = json_decode($resultado, true);
//$usd = $data['USD']['value'];


//validar consulta
if (curl_errno($iniciarCURL)) {
    echo 'Error en la solicitud: ' . curl_error($iniciarCURL);
    exit;
}

//error en pantalla si existe un error en el json
if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'Error decoding JSON: ' . json_last_error_msg();
    exit;
}

//error en pantalla si existe un error en Data
if (isset($data['error'])) {
    echo 'Error: ' . $data['error'];
    exit;
}

//cerrar la conexión CURL
curl_close($iniciarCURL);

?>



<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link  rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.slate.min.css">
    <title>Api Dolar</title>
</head>
<body>

<!-- centrar todo el contenido de la pagina -->
<div class="container" style="text-align: center; margin-top: 50px;">
    <h1>API Dolar PHP</h1>
    <p>Consulta el valor del dolar hoy.</p>

<!-- una tabla con los valores de las monedas -->
<table class="table" style="margin: 0 auto; width: 80%; text-align: center;">
    <thead>
        <tr>
            <th>Compra</th>
            <th>Venta</th>
            <!-- <th>Variacion</th> -->
            <th>Casa</th>
            <th>Fecha de Actualizacion</th>
        </tr>
    </thead>
    <tbody>
     
            <!-- //recorrer el array de data y mostrar los valores en la tabla con un foreach -->
            <?php foreach ($data as $key => $value): 
                //formatea la fecha de actualizacion a d-m-Y H
                $value["fechaActualizacion"] = date("d-m-Y H:i", strtotime($value["fechaActualizacion"]));
                ?>

                <tr>
                    <td>$<?= $value["compra"] ?></td>
                    <td>$<?= $value["venta"] ?></td>
                    <!-- <td><? /* $value["casa"]  */?></td> -->
                    <td><?= $value["nombre"] ?></td>
                    <td><?= $value["fechaActualizacion"] ?>hs</td>
                </tr>
            <?php endforeach; ?>
    </tbody>
</table>
<br>

  <fieldset class="grid">
    <input type="number" id="ingreso"  placeholder="Dolares A Convertir" />
    <input type="text" id="resultado"  placeholder="Pesos Convertidos" readonly/>
    <!-- <input type="submit" id="conver" value="Convertir" /> -->
  </fieldset>


</div>
<footer style="text-align: center; margin-top: 50px;">
    <p>Desarrollado por <a href="https://github.com/gcapuccia" target="_blank">Guido Capucciati</a> - 2025</p>
    <p>API Dolar - <a href="https://dolarapi.com/" target="_blank">dolarapi.com</a></p>
</footer>

<script>
    //evento Click
    /*     var conver = document.getElementById("conver");
    conver.addEventListener("clic", function(event) {
        event.preventDefault(); // Evita el envío del formulario
        var monto = document.getElementById("ingreso").value;
        var respuesta = monto * <?= $data[0]['venta'] ?>; // Cambia el índice según la moneda que desees usar
        document.getElementById("resultado").value = respuesta.toFixed(2); // Muestra el resultado con 2 decimales
    }); */

    /*     //misma funcion pero con el evento sin clic, solo con el evento de cambio
        var ingreso = document.getElementById("ingreso");
        ingreso.addEventListener("change", function(event) {
            var monto = document.getElementById("ingreso").value;
            var respuesta = monto * <?= $data[0]['venta'] ?>; // Cambia el índice según la moneda que desees usar
            document.getElementById("resultado").value = respuesta.toFixed(2); // Muestra el resultado con 2 decimales
        }); */
    //otra forma de hacerlo con el evento input, que se ejecuta cada vez que se cambia el valor del input
    var ingreso = document.getElementById("ingreso");
    ingreso.addEventListener("input", function(event) {
        var monto = document.getElementById("ingreso").value;
        var respuesta = monto * <?= $data[0]['venta'] ?>; // Cambia el índice según la moneda que desees usar
        document.getElementById("resultado").value = respuesta.toFixed(2); // Muestra el resultado con 2 decimales
    });

</script>

</body>
</html>