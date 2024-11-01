<aside class="dashboard__sidebar">
    <div class="dashboard__logo">
        <span class="dashboard__logo-titulo"><?php echo is_admin() ? 'Administrador' : 'Colaborador' ;?></span>
    </div>
    <nav class="dashboard__menu">
        <div class="dashboard__enlace dashboard__home <?php echo pagina_actual('/dashboard') ? 'dashboard__enlace--actual' : '' ;?>">
        <a href="/admin/dashboard">
            <i class="fa-solid fa-house dashboard__icono"></i>
            <span class="dashboard__menu-texto">Inicio</span>
        </a>
        </div>

        <div class="dashboard__enlace <?php echo pagina_actual('/alumnos') ? 'dashboard__enlace--actual' : '' ;?>">
        <div class="dashboard__enlace--menu">
        <div><i class="fa-solid fa-users-line dashboard__icono"></i>
            <span class="dashboard__menu-texto">Alumnos</span></div>
            <i class="fa-solid fa-chevron-down dashboard__down"></i>
        </div>

        <div class="dashboard__submenu">
            <div class="dashboard__submenu--contenido">
                <a href="/admin/alumnos/crear" class="nav__dropdown-item">Registrar Alumno</a>
                <a href="/admin/alumnos" class="nav__dropdown-item">Lista Alumnos</a>
            </div>
        </div>
        </div>

        <div class="dashboard__enlace <?php echo pagina_actual('/cursos') ? 'dashboard__enlace--actual' : '' ;?>">
        <div class="dashboard__enlace--menu">
           <div><i class="fa-solid fa-graduation-cap dashboard__icono"></i>
            <span class="dashboard__menu-texto">Cursos</span></div>
            <i class="fa-solid fa-chevron-down dashboard__down"></i>
        </div>

        <div class="dashboard__submenu">
            <div class="dashboard__submenu--contenido">
                <a href="/admin/cursos/crear" class="nav__dropdown-item">Registrar Curso</a>
                <a href="/admin/cursos" class="nav__dropdown-item">Lista de Cursos</a>
            </div>
        </div>
        </div>

        <div class="dashboard__enlace <?php echo pagina_actual('/diplomas') ? 'dashboard__enlace--actual' : '' ;?>">
        <div class="dashboard__enlace--menu">
           <div><i class="fa-solid fa-id-card dashboard__icono"></i>
            <span class="dashboard__menu-texto">Diplomas</span></div>
            <i class="fa-solid fa-chevron-down dashboard__down"></i>
        </div>

        <div class="dashboard__submenu">
            <div class="dashboard__submenu--contenido">
                <a href="/admin/diplomas/crear" class="nav__dropdown-item">Registrar Diploma</a>
                <a href="/admin/diplomas" class="nav__dropdown-item">Lista de Diplomas</a>
                <a href="/admin/plantillas" class="nav__dropdown-item">Platillas</a>
            </div>
        </div>
        </div>
    </nav>
</aside>