<h1 class="nombre-pagina">Nuevo Servicio</h1>
<p class="descripcion-pagina"> Llena todos los campos para agregar un nuevo servicio</p>

<?php
    //include_once __DIR__. ('/../templates/barra.php');
    include_once __DIR__. ('/../templates/alerts.php');
?>

<form action="/services/create" method="POST" class="formulario">
    <?php
        include_once __DIR__ . '/form.php';
    ?>

</form>