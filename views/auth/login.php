<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>

    <?php require_once __DIR__.'/../templates/alertas.php';?>

    <form method="POST" action="/login" class="formulario">
        <div class="formulario__campo">
            <label class="formulario__label">Usuario</label>
            <input for="usuario" type="text"
            class="formulario__input"
            placeholder="Tu usuario"
            id="usuario"
            name="usuario"
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

        <input type="submit" class="formulario__submit" value="Iniciar Sesión">
    </form>

</main>