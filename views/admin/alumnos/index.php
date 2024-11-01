<h2 class="dashboard__heading"><?php echo $titulo;?></h2>

<div class="search">
    <form class="search-box" id="search-bar" action="/admin/alumnos" method="GET">
        <i class="icon-search"></i>
        <input type="search" placeholder="Buscar" class="search-input" name="query" value="<?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?>">
    </form>
</div>

<div class="contenedor-table">
<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/alumnos/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir Alumno
    </a>
</div>

<div class="dashboard__contenedor">
<?php if(!empty($alumnos)){?>
<div class="table-container">
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">Pasaporte</th>
                <th scope="col" class="table__th">F. de Nacimiento</th>
                <th scope="col" class="table__th">Correo</th>
                <th scope="col" class="table__th">Nombre</th>
                <th scope="col" class="table__th">Status</th>
                <th scope="col" class="table__th"></th>
            </tr>
        </thead>
            <tbody class="table__tbody">
            <?php foreach($alumnos as $alumno):?>

                <tr class="table__tr">
                    <td class="table__td">
                        <?php echo $alumno->pasaporte; ?>
                    </td>
                    <td class="table__td">
                        <?php echo $alumno->fecha_nac;?>
                    </td>
                    <td class="table__td">
                        <?php echo $alumno->email;?>
                    </td>
                    <td class="table__td text__capit">
                        <?php echo $alumno->nombre;?>
                    </td>
                    <td class="table__td">
                        <span class="color-status <?php echo $alumno->status==="1" ? "vigente" : "anulado" ;?>" 
                            data-id="<?php echo $alumno->id; ?>" 
                            onclick="cambiarEstatus(this)">
                                <?php echo $alumno->status==="1" ? "vigente" : "anulado" ;?>
                        </span>
                    </td>
                    <td class="table__td--acciones">
                        <a class="table__accion table__accion--editar" href="/admin/alumnos/editar?id=<?php echo $alumno->id; ?>">
                        <i class="fa-solid fa-user-pen"></i>
                        Editar
                    </a>

                    <form method="POST" action="/admin/alumnos/eliminar" class="table__formulario">
                        <input type="hidden" name="id" value="<?php echo $alumno->id; ?>">
                        <button class="table__accion table__accion--eliminar" type="submit">
                            <i class="fa-solid fa-circle-xmark"></i>
                            Eliminar
                        </button>
                    </form>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </tbody>
    </table>
</div>
    <?php }else{?>
        <p class="text-center">No Hay Alumnos Aún</p>
    <?php };?>
</div>
</div>
<?php echo $paginacion;?>