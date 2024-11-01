<h2 class="dashboard__heading"><?php echo $titulo;?></h2>

<div class="search">
    <form class="search-box" id="search-bar" action="/admin/plantillas" method="GET">
        <i class="icon-search"></i>
        <input type="search" placeholder="Buscar" class="search-input" name="query" value="<?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?>">
    </form>
</div>

<div class="contenedor-table">
<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/plantillas/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir Plantilla
    </a>
</div>

<div class="dashboard__contenedor">
<?php if(!empty($plantillas)){?>
    <div class="table-container">
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="imagen">Imagen</th>
                <th scope="col" class="nombre">Nombre</th>
                <th scope="col" class="accion">Acción</th>
            </tr>
        </thead>
        <tbody class="table__tbody custom-table">
    <?php foreach($plantillas as $plantilla): ?>
        <tr class="table__tr">
            <td class="table__td table-img">
                <img src="/plantillas/<?php echo $plantilla->plantilla.".jpg";?>" alt="plantilla" class="img-plantilla">
            </td>
            <td class="table__td text__capit plant-nom">
                <?php echo $plantilla->nombre; ?>
            </td>
            <td class="table__td table__td--acciones table_plantilla_eliminar">
                <form method="POST" action="/admin/plantillas/eliminar" class="table__formulario">
                    <input type="hidden" name="id" value="<?php echo $plantilla->id; ?>">
                    <button class="table__accion table__accion--eliminar" type="submit">
                        <i class="fa-solid fa-circle-xmark"></i>
                        Eliminar
                    </button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>


        </tbody>
    </table>
</div>
    <?php }else{?>
        <p class="text-center">No Hay Plantillas Aún</p>
    <?php };?>
</div>
</div>
<?php echo $paginacion;?>