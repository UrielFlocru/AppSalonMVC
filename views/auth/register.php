<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario</p>

<?php 
    include_once __DIR__ . "/../templates/alerts.php";
?>

<form action="/register" method="post" class="formulario">
    <div class="campo">
        <label for="name">Nombre</label>
        <input type="text" id="name" name="name" placeholder="Tu nombre" value="<?php echo s($user->name); ?>">
    </div>
    <div class="campo">
        <label for="lastname">Apellido</label>
        <input type="text" id="lastname" name="lastname" placeholder="Tu apellido" value="<?php echo s($user->lastname); ?>">
    </div>
    <div class="campo">
        <label for="phone">Telefono</label>
        <input type="tel" id="phone" name="phone" placeholder="Tu número telefónico" value="<?php echo s($user->phone); ?>">
    </div>
    <div class="campo">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" placeholder="Tu correo electrónico" value="<?php echo s($user->email); ?>">
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Tu contraseña">
    </div>

    <input type="submit" value="Crear Cuenta" class="boton">

</form>

<div class="acciones">
    <div class="enlace-registrarse" >
        <p>¿Ya tienes una cuenta?</p>
        <a href="/">Iniciar Sesión</a>
    </div>
    <a href="/forgot">¿Olvidaste tu contraseña?</a>
</div>