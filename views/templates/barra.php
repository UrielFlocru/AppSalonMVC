<div class="barra">
    <p>Hola <span> <?php echo $name; ?></span></p>
    <a class="boton" href="/logout"> Cerrar Sesión</a>
</div>

<?php 
    if(isset($_SESSION['admin'])){ ?>
        <div class="barra-servicios">
            <a class="boton" href="/admin">Ver citas</a>
            <a class="boton" href="/services">Ver Servicios</a>
            <a class="boton" href="/services/create">Nuevo Servicio</a>
        </div>

    
<?php }?>