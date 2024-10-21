<h1 class="nombre-pagna">Olvide mi contraseña</h1>
<p class="descripcion-pagina"> Restablece tu contraseña escribiendo tu correo a continuacion </p>

<?php 
    include_once __DIR__ . "/../templates/alerts.php";
?>

<form class="formulario" action="/forgot" method="post" >
    <div class="campo" >
        <label for="email">Email</label>
        <input type="email" id="email"  name="email" placeholder="Tu correo electronico">
    </div>
    <input type="submit" class="boton" value="Enviar">
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