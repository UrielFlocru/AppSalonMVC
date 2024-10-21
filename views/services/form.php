<div class="campo">
    <label for="servicename">Nombre</label>
    <input type="text" id="servicename" name="servicename" placeholder="Nombre del Servicio" value="<?php echo $service->servicename; ?>">
</div>
<div class="campo">
    <label for="price">Precio</label>
    <input type="number" id="price" name="price" placeholder="Precio del Servicio" value="<?php echo $service->price; ?>">
</div>

<input type="submit" class="boton" value="Guardar">

