<div class="user-details">
          <div class="input-box">
            <span class="details">Nombre del Curso</span>
            <input type="text" value="<?php echo $curso->name_curso; ?>" name="name_curso" placeholder="Nombre del curso">
          </div>
          <div class="input-box">
            <span class="details">Colaborador</span>
            <input type="text" value="<?php echo $curso->colaborador; ?>" name="colaborador" placeholder="Nombre del colaborador">
          </div>
          <div class="input-box">
            <span class="details">Fecha de Inicio</span>
            <input type="date" value="<?php echo $curso->fecha_inicio; ?>" name="fecha_inicio">
          </div>
          <div class="input-box">
            <span class="details">Fecha de Término</span>
            <input type="date" value="<?php echo $curso->fecha_fin; ?>" name="fecha_fin">
          </div>

          <div class="input-box">
            <span class="details">Duracion (En horas)</span>
            <input type="number" value="<?php echo $curso->duracion; ?>" name="duracion">
          </div>
        </div>

  