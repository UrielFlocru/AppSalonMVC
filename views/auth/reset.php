<h1 class="nombre-pagina" > Recuperar contraseña </h1>


<?php 
    include_once __DIR__ . "/../templates/alerts.php";
?>

<?php if ($error) return; ?>

<p class="descripcion-pagina">Coloca tu nueva contraseña a continuación</p>

<form class="formulario" method="post">
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Tu nueva contraseña">
    </div>
    <input type="submit" class="boton" value="Restablecer">

</form>

<div class="acciones">
    <div class="enlace-registrarse" >
        <p>¿Ya tienes una cuenta?</p>
        <a href="/">Inicia Sesión</a>
    </div>
    <div class="enlace-registrarse" >
        <p>¿Aún no tienes cuenta?</p>
        <a href="/register">Registrate</a>
    </div>
</div>