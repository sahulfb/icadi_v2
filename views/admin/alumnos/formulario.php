        <div class="user-details">
          <div class="input-box">
            <span class="details">Rut/Pasaporte</span>
            <input type="number" placeholder="Ingrese pasaporte o rut" value="<?php echo trim($alumno->pasaporte); ?>" name="pasaporte">
          </div>
          <div class="input-box">
            <span class="details">Fecha de Nacimiento</span>
            <input type="date" value="<?php echo $alumno->fecha_nac; ?>" name="fecha_nac" max=<?php echo date("Y-m-d");?>>
          </div>
          <div class="input-box">
            <span class="details">Nombre Completo</span>
            <input type="text" placeholder="Ingrese su nombre y apellido" value="<?php echo $alumno->nombre; ?>" name="nombre">
          </div>
          <div class="input-box">
            <span class="details">Correo</span>
            <input type="email" placeholder="Ingrese su correo" value="<?php echo $alumno->email; ?>" name="email">
          </div>
        </div>