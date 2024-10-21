<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<?php 
    include __DIR__ . '/../templates/alerts.php';
?>

<form class="form" method="POST" action="/">
    <div class="campo" >
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu correo electrónico" name="email">
    </div>
    <div class="campo" >
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu contraseña" name="password">
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">
</form>

<div class="acciones">
    <div class="enlace-registrarse" >
        <p>¿Aún no tienes cuenta?</p>
        <a href="/register">Registrate</a>
    </div>
    <a href="/forgot">¿Olvidaste tu contraseña?</a>
</div>