<header class="header">
    <div class="header__contenedor">
        <div class="header__contenido--iqz">
            <a href="/">
                <h3 class="header__logo">INSTITUTO ICADI</h3>
            </a>
        </div>

        <div class="header__contenido--der">
            <nav class="header__navegacion">
                <?php if(is_auth()){?>
                    <a href='/admin/dashboard' class='header__enlace'>Panel</a>
                <form method="POST" action="/logout" class="header__form">
                <input type="submit" value="Cerrar Sesión" class="header__submit" id="header__submit">
                </form>
                <?php }else{?>
                <a href="/login" class="header__enlace login">Iniciar Sesión</a>
                <?php };?>
            </nav>
        </div>
    </div>
</header>