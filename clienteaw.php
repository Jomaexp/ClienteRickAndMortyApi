<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rick y Morty: La enciclopedia</title>
    <style>
        @import url("style.css");
    </style>
</head>
 <body>
    <header>
        <img src="banner.png"></img>
    </header>
 <br>
 <!-- A partir de aquí comienza el contenido dinámico en php-->
<?php
// Si se recibe "get_datos_capitulo" con su id, se mostraran los datos del capitulo con ese id.
if (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_datos_capitulo"){
    $app_info = file_get_contents('http://rickandmortyapi.com/api/episode/' . $_GET["id"]);
    $app_info = json_decode($app_info);
    /* Creamos un div que va a contener un título y una tabla.
    La tabla va a mostrar los datos del capitulo devueltos por la api. */
    echo "<div id='izq'><h3>Datos del capítulo</h3>";
    echo("<table>
    <tr>
    <th>Id</th>	
    <th>Nombre</th>
    <th>Fecha emisión</th>
    <th>Número y Temporada</th>
    </tr>") ;
    echo "<tr>";
    // Accedemos a los datos del capitulo para mostrar sus campos.
    echo "<td>" . $app_info->id . "</td>"
    . "<td>" . $app_info->name . "</td>"
    . "<td>" . $app_info->air_date . "</td>"
    . "<td>" . $app_info->episode. "</td>";				
    echo "</tr></table></div>";
    /* Creamos un div que va a contener un título y una tabla.
    La tabla va a mostrar los personajes del capitulo devueltos por la api. */
    echo "<div id='dcha'><h3>Personajes del capítulo</h3>";
    echo"<table>";
    ?>    
    <?php
      /* Recorremos $app_info->characters para mostrar un enlace hacia cada uno,
      mostrando como texto el nombre del personaje. */
      foreach($app_info->characters as $character): ?>
      <?php $personaje = file_get_contents($character);
        // Se decodifica el fichero JSON y se convierte a array
        $personaje = json_decode($personaje);
        ?>
        <tr><td>
        <a href="<?php echo "http://jomaexp.byethost7.com/DWES/TAREA9/clienteaw.php?action=get_datos_personaje&id=" . $personaje->id  ?>">
        <?php echo $personaje->name;?>
        </a>
    </td></tr>
    <?php endforeach; ?>
    <?php
    /* Tras cerrar la tabla se muestra un mensaje de ayuda al usuario 
    sobre los enlaces de la tabla.*/
    echo ("</table>
    <br><h3>Pulse sobre un personaje para obtener<br> más información</h3></div>");
    ?>
    <br>
    <br>
    <!-- Enlace para volver a la lista de capitulos -->
    <div class="volver">
        <a  href="http://jomaexp.byethost7.com/DWES/TAREA9/clienteaw.php" alt="volver a inicio">Volver a la lista de capítulos</a>
    </div>
    <br>
    <?php
/* Si no, si se recibe por get la acción get_datos_personaje junto a un id,
entonces se va a mostrar los detalles del personaje con ese id junto a los capítulos
 donde aparece.*/
}else if (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_datos_personaje"){
    $app_info = file_get_contents('http://rickandmortyapi.com/api/character/' . $_GET["id"]);
    $app_info = json_decode($app_info);
    /* Creamos un div que va a contener un título y una tabla.
    La tabla va a mostrar los datos del personaje devueltos por la api. */
    echo "<div id='izq'><h3>Datos del personaje</h3>";
    echo "<img src=$app_info->image></img>";
    echo("<table>
    <tr>
    <th>Nombre</th>
    <th>Especie</th>
    <th>Género</th>	
    <th>Origen</th>
    </tr>") ;
    echo "<tr>";
    // Accedemos a los datos del personaje para mostrar sus campos.
    echo "<td>" . $app_info->name . "</td>"
    . "<td>" . $app_info->species . "</td>"
    . "<td>" . $app_info->gender . "</td>"
    . "<td>" . $app_info->origin->name. "</td>";				
    echo "</tr></table></div>";
    /* Creamos un div que va a contener un título y una tabla.
    La tabla va a mostrar los capitulos donde aparece el personaje
     devueltos por la api. */
    echo "<div id='dcha'><h3>Capítulos donde aparece</h3>";
    echo"<table>";
    ?>    
    <?php
      /* Recorremos $app_info->episode para mostrar un enlace hacia cada uno,
      mostrando como texto el título del capitulo. */
      foreach($app_info->episode as $episod): ?>
      <?php $episodio = file_get_contents($episod);
        // Se decodifica el fichero JSON y se convierte a array
        $episodio = json_decode($episodio);
        ?>
        <tr><td>
        <a href="<?php echo "http://jomaexp.byethost7.com/DWES/TAREA9/clienteaw.php?action=get_datos_capitulo&id=" . $episodio->id  ?>">
        <?php echo $episodio->name;?>
        </a>
    </td></tr>
    <?php endforeach; ?>
    <?php
    /* Tras cerrar la tabla se muestra un mensaje de ayuda al usuario 
    sobre los enlaces de la tabla.*/
    echo ("</table>
    <br><h3>Pulse sobre un capítulo para obtener<br> más información</h3></div>");
    ?>
    <br>
    <br>
    <!-- Enlace para volver a la lista de capitulos -->
    <div class="volver">
        <a  href="http://jomaexp.byethost7.com/DWES/TAREA9/clienteaw.php" alt="volver a inicio">Volver a la lista de capítulos</a>
    </div>
    <br>
    <?php
/* Si no ocurre nada de lo anterior se mostrará la página por defecto que es el listado de capítulos*/
}else{
    //Se realiza la peticion a la api que nos devuelve el JSON con la información de todos los capítulos
    // Se decodifica el fichero JSON y se convierte a array
    // como hay varias páginas de episodios metemos en variables distintas cada página de la api
    $app_info = file_get_contents('https://rickandmortyapi.com/api/episode');  
    $app_info = json_decode($app_info);
    $app_info2 = file_get_contents('https://rickandmortyapi.com/api/episode?page=2');
    $app_info2 = json_decode($app_info2);
    $app_info3 = file_get_contents('https://rickandmortyapi.com/api/episode?page=3');
    $app_info3 = json_decode($app_info3);  
?>
<?php 
    /* Creamos un div que va a contener un título y una tabla.
    La tabla va a mostrar el listado de capitulos devuelto por la api. */
    echo "<div ><h3>Listado de capítulos</h3>";
    echo("<table>
    <tr>
    <th>capítulo</th>	
    </tr>") ;?>
    <?php foreach($app_info->results as $result): ?>
        <tr><td>
        <a href="<?php echo "http://jomaexp.byethost7.com/DWES/TAREA9/clienteaw.php?action=get_datos_capitulo&id=" . $result->id ?>">
            <?php echo $result->name  ?>
        </a>
        </td></tr>
     <?php endforeach; ?>
     <?php foreach($app_info2->results as $result): ?>
        <tr><td>
        <a href="<?php echo "http://jomaexp.byethost7.com/DWES/TAREA9/clienteaw.php?action=get_datos_capitulo&id=" . $result->id ?>">
            <?php echo $result->name  ?>
        </a>
        </td></tr>
     <?php endforeach; ?>
     <?php foreach($app_info3->results as $result): ?>
        <tr><td>
        <a href="<?php echo "http://jomaexp.byethost7.com/DWES/TAREA9/clienteaw.php?action=get_datos_capitulo&id=" . $result->id ?>">
            <?php echo $result->name  ?>
        </a>
        </td></tr>
     <?php endforeach; ?>
    <?php
    echo ("</table>
    <br><h3>Pulse sobre un título para obtener<br> más información</h3></div>");
    ?>
    <br>
    <br>
    <!-- Enlace para volver a la lista de capitulos -->
    <div class="volver">
        <a  href="http://jomaexp.byethost7.com/DWES/TAREA9/clienteaw.php" alt="volver a inicio">Volver a la lista de capítulos</a>
    </div>
    <br>
<?php
} ?>
 <!-- Fin del contenido dinámico php y comienzo de nuevo contenido estático html -->
 <br>
 <br>
 <div class="volver">
 <footer>José María Expósito Reyes 75160119Y</footer>
 </div>
 </body>
</html>