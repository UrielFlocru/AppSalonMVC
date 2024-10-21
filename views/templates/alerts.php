<?php
    foreach ($alerts as $key => $messages){
        foreach ($messages as $message){
?>
    <div class="alerta <?php echo $key; ?>">
        <?php echo $message; ?>
    </div>
<?php
        }
    }