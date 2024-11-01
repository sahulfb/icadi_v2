<div class="user-details">
    <div class="input-box">
        <span class="details">Rut/Pasaporte del Alumno</span>
        <input type="text" placeholder="Ingresar pasaporte o rut" value="<?php echo $diploma->alumno_pas ?? ''; ?>" id="diploma_pas" name="alumno_pas" <?php echo $isEditRoute ? 'disabled' : ''; ?>>
    </div>
    <div class="input-box">
        <span class="details">Alumno</span>
        <input type="text" placeholder="Nombre del alumno" value="<?php echo $diploma->alumno_nombre ?? ''; ?>" name="alumno_nombre" class="alumno_id" <?php echo $isEditRoute ? 'disabled' : ''; ?>>
    </div>
    <div class="select-box">
        <span class="details">Curso Aprobado</span>
        <select name="curso_id">
            <option disabled selected>--Seleccionar--</option>
            <?php foreach($cursos as $curso): ?>
                <option value="<?php echo $curso->id; ?>" <?php echo $curso->id == ($diploma->curso_id ?? '') ? 'selected' : ''; ?>><?php echo $curso->name_curso; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="input-box">
        <span class="details">Código de Verificación</span>
        <input type="number" placeholder="Ingrese el código de verificación" value="<?php echo $diploma->codigo ?? ''; ?>" name="codigo">
    </div>
    <div class="select-box">
        <span class="details">Plantillas Disponibles</span>
        <select name="plantilla_id">
            <option disabled selected>--Seleccionar--</option>
            <?php foreach($plantillas as $plantilla): ?>
                <option value="<?php echo $plantilla->id; ?>" <?php echo $plantilla->id == ($diploma->plantilla_id ?? '') ? 'selected' : ''; ?>><?php echo $plantilla->nombre; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
