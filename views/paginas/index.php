<div class="validar">
<div class="validar__contenedor">
    <div class="validar__img">
        <img src="/build/img/validar.jpg" alt="imagen validar diplomas">
    </div>
    <div class="validar__form form__validar">
        <form action="/validar" method="POST" class="form__diplomas" id="form__diplomas">
            <div class="form__header">
                <div class="form__titulo"><h2><?php echo $titulo; ?></h2></div>
            </div>
            
            <?php include_once __DIR__.'../../templates/alertas.php';?>

            <div class="form__campo">
                <label for="pasaporte" class="form__label">Rut/Pasaporte</label>
                <input type="text"
                id="pasaporte"
                class="form__input"
                name="pasaporte"
                placeholder="pasaporte o rut"
                value="">
            </div>

            <div class="form__campo tipo-validacion">
                <div class="tipo-dato">
                    <label for="codigo" class="form__label tipo-dato__label activo">Código de Verificación</label>
                    <label for="fecha" class="form__label tipo-dato__label">Fecha de Nacimiento</label>
                </div>
                <input type="number"
                id="codigo"
                class="form__input"
                name="codigo"
                placeholder="codigo de verificación"
                value="">

                <input type="date"
                id="fecha"
                class="form__input hidden"
                name="fecha"
                max=<?php echo date("Y-m-d");?>
                value="">
            </div>

            <button class="form__campo--btn" id="btnSubmit">
            <div><i class="fa-solid fa-magnifying-glass"></i>
            <input type="submit" value="Buscar"></div>
            </button>
        </form>
    </div>
</div>
</div>

