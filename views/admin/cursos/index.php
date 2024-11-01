<h2 class="dashboard__heading"><?php echo $titulo;?></h2>

<div class="search">
    <form class="search-box" id="search-bar" action="/admin/cursos" method="GET">
        <i class="icon-search"></i>
        <input type="search" placeholder="Buscar" class="search-input" name="query" value="<?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?>">
    </form>
</div>

<div class="contenedor-table">
<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/cursos/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir Curso
    </a>
</div>

<div class="dashboard__contenedor">
<?php if(!empty($cursos)){?>
    <div class="table-container">
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">N. Curso</th>
                <th scope="col" class="table__th">F. Inicio</th>
                <th scope="col" class="table__th">F. Final</th>
                <th scope="col" class="table__th">Colaborador</th>
                <th scope="col" class="table__th">Status</th>
                <th scope="col" class="table__th"></th>
            </tr>
        </thead>
        <tbody class="table__tbody">
            <?php foreach($cursos as $curso):?>

                <tr class="table__tr">
                    <td class="table__td text__capit">
                        <?php echo $curso->name_curso; ?>
                    </td>
                    <td class="table__td">
                        <?php echo $curso->fecha_inicio;?>
                    </td>
                    <td class="table__td">
                        <?php echo $curso->fecha_fin;?>
                    </td>
                    <td class="table__td text__capit">
                        <?php echo $curso->colaborador;?>
                    </td>
                    <td class="table__td">
                    <span class="color-status <?php echo $curso->status==="1" ? "vigente" : "anulado" ;?>" 
                            data-id="<?php echo $curso->id; ?>" 
                            onclick="cambiarEstatus(this)">
                                <?php echo $curso->status==="1" ? "vigente" : "anulado" ;?>
                        </span>
                    </td>
                    <td class="table__td--acciones">
                        <a class="table__accion table__accion--editar" href="/admin/cursos/editar?id=<?php echo $curso->id; ?>">
                        <i class="fa-solid fa-user-pen"></i>
                        Editar
                    </a>

                    <form method="POST" action="/admin/cursos/eliminar" class="table__formulario">
                        <input type="hidden" name="id" value="<?php echo $curso->id; ?>">
                        <button class="table__accion table__accion--eliminar" type="submit">
                            <i class="fa-solid fa-circle-xmark"></i>
                            Eliminar
                        </button>
                    </form>
                    </td>
                </tr>
                <?php endforeach;?>
            </>
        </tbody>
    </table>   
</div>
    <?php }else{?>
        <p class="text-center">No Hay Cursos Aún</p>
    <?php };?>
</div>
</div>
<?php echo $paginacion;?>