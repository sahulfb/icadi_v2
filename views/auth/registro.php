<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Registrate en Icadi</p>

    <?php require_once __DIR__.'/../templates/alertas.php';?>

    <form method="POST" action="/registro" class="formulario">
    <div class="formulario__campo">
            <label class="formulario__label">Nombre</label>
            <input for="nombre" type="text"
            class="formulario__input"
            placeholder="Tu Nombre"
            id="nombre"
            name="nombre"
            value="<?php echo $usuario->nombre;?>"
            >
        </div>

        <div class="formulario__campo">
            <label class="formulario__label">Apellido</label>
            <input for="apellido" type="text"
            class="formulario__input"
            placeholder="Tu Apellido"
            id="apellido"
            name="apellido"
            value="<?php echo $usuario->apellido;?>"
            >
        </div>

        <div class="formulario__campo">
            <label class="formulario__label">Email</label>
            <input for="email" type="email"
            class="formulario__input"
            placeholder="Tu Email"
            id="email"
            name="email"
            value="<?php echo $usuario->email;?>"
            >
        </div>

        <div class="formulario__campo">
            <label class="formulario__label">Usuario</label>
            <input for="usuario" type="text"
            class="formulario__input"
            placeholder="Tu Usuario"
            id="usuario"
            name="usuario"
            value="<?php echo $usuario->usuario;?>"
            >
        </div>

        <div class="formulario__campo">
            <label class="formulario__label">Password</label>
            <input for="password" type="password"
            class="formulario__input"
            placeholder="Tu Password"
            id="password"
            name="password"
            >
        </div>

        <div class="formulario__campo">
            <label class="formulario__label">Repetir Password</label>
            <input for="password2" type="password"
            class="formulario__input"
            placeholder="Repite tu Password"
            id="password2"
            name="password2"
            >
        </div>
        <input type="submit" class="formulario__submit" value="Crear Cuenta">
    </form>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tienes cuenta? Iniciar Sesión</a>
        <a href="/olvide" class="acciones__enlace">¿Olvidaste tu password?</a>
    </div>
</main>