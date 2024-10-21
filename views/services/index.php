<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina"></p>

<?php
    include_once __DIR__. ('/../templates/barra.php');
?>

<ul class="servicios">
    <?php foreach ($services as $service){ ?>
        <li>
            <p>Nombre: <span> <?php echo $service->servicename; ?> </span> </p>
            <p>Precio: <span>$ <?php echo $service->price; ?> </span> </p>

            <div class="acciones">
                <a class="boton" href="/services/update?id=<?php echo $service->id; ?>">Actualizar</a>

                <form action="/services/delete" method="POST">
                    <input type="hidden" name="id" value="<?php echo $service->id; ?>">
                    <input class="boton-eliminar" type="submit" value="Borrar">
                </form>
                
            </div>

        </li>
        
    <?php } ?>

        
</ul>

