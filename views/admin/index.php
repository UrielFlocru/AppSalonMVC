<h1 class="nombre-pagina" >Panel de Administración</h1>

<?php
    include_once __DIR__. '/../templates/barra.php';
?>




<div class="busqueda">
    <h2>Buscar citas</h2>
    <form action="" class="formulario">
        <div class="campo">
            <label for="date">Fecha</label>
            <input type="date" id="date" name="date" value="<?php echo $date; ?>">
        </div>
    </form>

</div>

<?php
    if (count($appointments) ===0){
        echo '<h2>No hay citas para esta fecha</h2>';
    }

?>

<div id="citas-admin">
    <ul class="citas" >
        <?php
            $idAppo = 0;
            foreach ($appointments as $key => $appo) {
                if ($idAppo !== $appo->id){
                    $total=0;
        ?>
            <li>
                <h3>Cita:</h3>
                <p>ID: <span> <?php echo $appo->id; ?> </span> </p>
                <p>Hora: <span> <?php echo $appo->hour; ?> </span> </p>
                <p>Cliente: <span> <?php echo $appo->client; ?> </span> </p>
                <p>Email: <span> <?php echo $appo->email; ?> </span> </p>
                <p>Telefono: <span> <?php echo $appo->phone; ?> </span> </p>
            </li>
            <li>
                <h3>Servicios</h3>
            
        <?php  
                    $idAppo=$appo->id;
                    $total=0;
                }
        ?>
                <p class="servicio"><?php  echo $appo->service . " " . $appo->price;  ?></p>
                
        <?php   
                //Agregar Precio al final de los servicios
                $total += $appo->price;
                if ($appo->id != $appointments[$key+1]->id || $appointments[$key+1]->id === null){
                    ?>
                        <p>Total: <span>$<?php echo $total; ?></span></p>

                        <form action="/api/delete" method="POST">
                            <input type="hidden" name="id" value="<?php echo $appo->id;?>">
                            <input type="submit" class="boton-eliminar" value="Eliminar">
                        </form>
                    <?php
                }
            }
        ?>
            </li>
    </ul>

</div>

<?php
    $script = "<script src='build/js/buscador.js'></script>";
?>