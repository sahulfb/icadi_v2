<div class="container">
    <div class="title"><?php echo $titulo;?></div>
    <div class="content">
    <div class="dashboard__formulario">
    <?php include_once __DIR__.'./../../templates/alertas.php'?>
      <form method="POST" class="formulario" enctype="multipart/form-data">
      <div class="user-details">
          <div class="input-box">
            <span class="details">Nombre</span>
            <input type="text" placeholder="Colocar nombre a plantilla" value="<?php echo $plantilla->nombre;?>" name="nombre" id="plantilla_nom">
          </div>
          <div class="img-box">
            <p class="details">Imagen (JPG)</p>
            <p>Resolución Recomendada (1056x816)</p>
            <input type="file" value="<?php echo $plantilla->plantilla;?>" name="plantilla" class="plantilla" accept="image/jpeg" >
          </div>
</div>
      <div class="button">
          <input type="submit" value="Almacenar Imagen">
        </div>
      </form>
    </div>
  </div>
  </div>