<div class="container">
    <div class="title"><?php echo $titulo;?></div>
    <div class="content">
    <div class="dashboard__formulario">
    <?php include_once __DIR__.'./../../templates/alertas.php'?>
      <form method="POST" class="formulario">
      <?php include_once __DIR__.'/formulario.php'?>
      <div class="button">
          <input type="submit" value="Guardar Cambios">
        </div>
      </form>
    </div>
  </div>  
</div>