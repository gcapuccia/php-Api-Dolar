<?php

const API_URL = 'https://dolarapi.com/v1/dolares';

$ch = curl_init(API_URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$resultado = curl_exec($ch);

$data = json_decode($resultado, true);




if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'Error decoding JSON: ' . json_last_error_msg();
    exit;
}

if (isset($data['error'])) {
    echo 'Error: ' . $data['error'];
    exit;
}

//una alternativa para obtener solo el GET 
// $resultado = file_get_contents(API_URL);
// $data = json_decode($resultado, true);


//$usd = $data['USD']['value'];


curl_close($ch);

?>



<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link  rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.slate.min.css">
    <title>Document</title>
</head>
<body>

<pre>
<?= $data[1]["nombre"]; ?>
</pre>


<button>Button</button>
</body>
</html>