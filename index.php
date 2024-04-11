<!-- Para mostrar algo por consola usaremos echo (como el console.log) -->
<h1>
    <?php echo 'App con PHP'; ?>
</h1>
<h2> <?= "Forma corta de echo!"; ?> </h2>

<!-- Definimos variables anteponiendo un $ y la podriamos usar -->
<?php
$name = "Sote";
$age = 18;
$isDev = true;
$team = 'Vikingos';
$position = 'DF';
$isOld = $age > 18;

//  otra forma de concatenar es con .= 
$output = "<br/>Primer mensaje";
$output .= ", sumando el segundo mensaje.";

var_dump($name);
echo gettype($age);
echo is_bool($isDev)
?>
<h3> <?= "Hola " . $name . " señor " . ($isDev ? 'programador' : 'normal') ?></h3>

<!-- el signo + solo hace suma, para concatenar texto se usa . -->
<?= $age + '2'; ?>
<?= $age . $name; ?>
<!-- mostrando la concatenacion con .= -->
<?= $output ?>

<!-- escapar texto (para que se vea) -->
<?= "<br/>En esta cadena muestro el nombre con comillas \"$name\" estoy escapando texto " ?> <!--sin los \ mostraria error -->

<!-- definir constantes globales-->
<?php
define('LOGO_URL', 'PHP-logo.svg.png'); //  'https://cdn.freebiesupply.com/logos/large/2x/php-1-logo-svg-vector.svg')
const apellido = 'Sotelo';
?>
<h5><?= apellido ?> como constante local!</h5>
<img src="<?= LOGO_URL ?>" alt="PHP LOGO" width="200">


<!-- uso de IF -->
<!-- el uso del if es normal como en otros lenguajes, pero el else if se puede usar junto = elseif () { ... } pero este se puede usar con una sintaxis especial de php -->

<!-- inicialmente seria asi -->
<?php
if ($age < 18) {
    echo "<h2> Congrats eres un jovencito! </h2>";
} else if ($isDev) {
    echo "<h2> Eres un junior Dev ! </h2>";
} else {
    echo "<h2>Eres viejecito</h2>";
}
?>

<!-- y si quisieramos usar fragmentos mas grandes de html podriamos usar esta sintaxis de puntos reemplazando las llaves-->
<?php if ($isOld) : ?>
    <h3>Congrats eres un jovencito! </h3>
    <p>Un texto para ver mas elementos html sin usar echo</p>
<?php elseif ($isDev) : ?>
    <h2> Eres un junior Dev ! </h2>
    <p>otro elemento p sin echo</p>
<?php else : ?>
    <h2>Eres viejecito</h2>
    <p>Un texto para ver mas elementos html sin usar echo</p>
<?php endif ?>
<!-- asi podemos agregar todo el html que quedamos pero debe ir elseif junto -->


<!-- podemos usar ternarias tambien -->
<?php $outputAge = $isOld ? 'Ternaria: Estas pasaito' : 'Ternaria: Tas joven aun' ?>
<h3><?= $outputAge ?> </h3>

<!-- MATCH -->
<!-- En vez de hacer muchos if para la edad, usaremos MATCH, que lo podemos hacer como una asignacion a una variable evaluando el parametro 
Lo que hace es, toma el valor $age y lo compara (matchea) con cada valor que hay en la lista y asigna segun coincidencia -->
<?php
$outputAgeMatch = match ($age) {
    0, 1, 2 => "$name, Eres un bebe",
    3, 4, 5, 6, 7, 8, 9, 10 => "$name, eres un niño",
    11, 12, 13 => "$name, eres un joven",
    default => "$name, eres un adulto"
}
?>
<h3><?= $outputAgeMatch ?> </h3>

<!-- pero es una lata tener que agregar todas las alternativas, por eso le pasaremos un bool para que evalue, y en luego hacemos la comparativa logica -->
<?php
$outputAgeMatchBool = match (true) {
    $age < 2 => "$name, Eres un bebe (match con true)",
    $age < 12 => "$name, eres un niño (match con true)",
    $age < 18 => "$name, eres un joven (match con true)",
    $age === 18 => "$name, eres adulto pero aun no puedes beber chelita (match con true)",
    default => "$name, eres un adulto puedes beber chelita (match con true)"
}
?>
<!-- y como va de arriba abajo al primero que entra, hace la asignacion -->
<h3><?= $outputAgeMatchBool ?> </h3>


<!-- ARRAY -->
<!-- podemos mezclar elementos en un array: string, bool, numeros, etc -->
<?php
$bestLanguages = ['PHP', 'Javascript', "java", true, 15];
// podemos agregar elementos al array sin metodos
$bestLanguages[] = "Pyhton";
// podemos reasignar un valor indicando el indice
$bestLanguages[2] = "Typescript";
?>
<!-- para iterar los arreglos en php podemos usar foreach, y lo podriamos usar con la sintaxis de puntos tambien-->
<ul>
    <?php foreach ($bestLanguages as $languages) { ?>
        <li><?= $languages ?> </li>
    <?php } ?>
</ul>

<ul>
    <p>Con sintaxis de puntos</p>
    <!-- para sacar el indice usamos un arrow que lo que hace es que de $$languages obtiene el indice y lo asigna a $key -->
    <?php foreach ($bestLanguages as $key => $languages) : ?>
        <li><?= $languages, " - id: ", $key ?> </li>
    <?php endforeach ?>
</ul>

<!-- podemos usar un ARRAY ASOCIATIVO (objeto) para tener una suerte de objeto, asignando una key de string a un elemento del arreglo, esto con la => arrow -->
<?php
$person = [
    "name" => "Andres", // con => hacemos la asociacion
    "lastName" => "Sotelo",
    "age" => 33,
    "dev" => true,
    "languages" => ["Javascript", "Typescript", "Rust"]
];
//podriamos reasignar los valores
$person['name'] = 'Andresin';
?>
<h4><?= "usando array Asociativo ", $person['name'] ?></h4>

<!-- API -->
<!-- Hacer llamado a api desde php, forma basica (sin dependencias), usando curl esto lo hacemos desde la terminal -->
<!-- para esto hay que inicializarlo y tambien definir la api (constante) -->
<?php
const API_URL = "https://whenisthenextmcufilm.com/api";
// con esto creamos una sesion de curl; cURL handle
$ch = curl_init(API_URL);
#indicar que no queremos mostrar el resultado en pantalla
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# ejecutamos y guardamos el resultado en una variable
$result = curl_exec($ch);
# transformar el resultado, donde la segunda opcion es para que sea un array asociativo (objeto)
$data = json_decode($result, true);

# Alternativa si solo queremos hacer un GET de una api seria usar file_get_contents(API_URL) y asignarlo a una variable

# cerramos la conexion de curl
curl_close($ch);

?>

<head>
    <title>Proxima peli de marvel</title>
    <meta name="description" content="La proxima pelicula de marvel"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" />
</head>
<main>
    <!-- podemos visualizar la informacion en pantalla dando un formato al pre -->
    <pre style="font-size: 14px; overflow:scroll; height: 250px;">
        <?php var_dump($data); ?>
    </pre>
    <section>
        <!-- desde la data obtenida con el curl usamos el parametro poster que trae la imagen de la peli -->
        <img src="<?= $data['poster_url'] ?>" width="300" alt="Poster de <?= $data['title'] ?>" style="border-radius:15px;"/>
    </section>
    <hgroup>
        <h3><?= $data['title']?> se estrena en  <?= $data['days_until'] ?> días! </h3>
        <p>Fecha de estreno es: <?= $data['release_date'] ?></p>
        <p>La siguiente pelicula es: <strong><?= $data['following_production']['title'] ?></strong></p>
        <p>Resumen: <?= $data['following_production']['overview']?></p>
    </hgroup>
</main>









<!-- podemos definir estilos para html y asi envolver el echo en un h1-->
<style>
    :root {
        color-scheme: light dark;
    }

    body {
        display: grid;
        place-content: center;
    }
</style>