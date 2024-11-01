<h2 class="dashboard__heading"><?php echo $titulo;?></h2>

<div class="search">
    <form class="search-box" id="search-bar" action="/admin/diplomas" method="GET">
        <i class="icon-search"></i>
        <input type="search" placeholder="Buscar" class="search-input" name="query" value="<?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?>">
    </form>
</div>

<div class="contenedor-table">
<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/diplomas/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir Diploma
    </a>
</div>

<div class="dashboard__contenedor">
<?php if(!empty($diplomas)){?>
    <div class="table-container">
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">Alumno</th>
                <th scope="col" class="table__th">Curso</th>
                <th scope="col" class="table__th">Codigo</th>
                <th scope="col" class="table__th">Plantilla</th>
                <th scope="col" class="table__th">Status</th>
                <th scope="col" class="table__th"></th>
            </tr>
        </thead>
        <tbody class="table__tbody">
            <?php foreach($diplomas as $diploma):?>

                <tr class="table__tr">
                    <td class="table__td text__capit">
                        <?php echo $diploma->nombreAlumno; ?>
                    </td>
                    <td class="table__td">
                        <?php echo $diploma->name_curso;?>
                    </td>
                    <td class="table__td">
                        <?php echo $diploma->codigo;?>
                    </td>
                    <td class="table__td text__capit">
                        <?php echo $diploma->nombrePlantilla;?>
                    </td>
                    <td class="table__td">
                    <span class="color-status <?php echo $diploma->status==="1" ? "vigente" : "anulado" ;?>" 
                            data-id="<?php echo $diploma->id; ?>" 
                            onclick="cambiarEstatus(this)">
                                <?php echo $diploma->status==="1" ? "vigente" : "anulado" ;?>
                        </span>
                    </td>
                    <td class="table__td--acciones">
                        <a class="table__accion table__accion--editar" href="/admin/diplomas/editar?id=<?php echo $diploma->id; ?>">
                        <i class="fa-solid fa-user-pen"></i>
                        Editar
                    </a>

                    <form method="POST" action="/admin/diplomas/eliminar" class="table__formulario">
                        <input type="hidden" name="id" value="<?php echo $diploma->id; ?>">
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
        <p class="text-center">No Hay Diplomas Aún</p>
    <?php };?>
</div>
</div>
<?php echo $paginacion;?>