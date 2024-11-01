<div class="alumnado__titulo"><h2><?php echo $titulo; ?></h2></div>
<p class="name_alumno"><?php echo  ucwords($alumno->nombre); ?></p>
<div class="validar">
<div class="dashboard__contenedor">
<?php if(!empty($diplomas)){?>
    <div class="table-container">
    <table class="table">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">Fecha de Certificado</th>
                <th scope="col" class="table__th">Estado</th>
                <th scope="col" class="table__th">Curso</th>
                <th scope="col" class="table__th">Link de Descarga</th>
            </tr>
        </thead>
        <tbody class="table__tbody">
            <?php foreach($diplomas as $diploma):?>

                <tr class="table__tr">
                    <td class="table__td">
                        <span><?php echo $diploma->fecha_inicio; ?></span>
                        <br>
                        <span><?php echo $diploma->fecha_fin;?></span>
                    </td>

                    <td class="table__td">
                        <?php echo $diploma->status==="1" ? "Vigente" : "Anulado" ;?>
                    </td>

                    <td class="table__td">
                        <?php echo $diploma->name_curso ;?>
                    </td>
                   
                    <?php if($diploma->status==="1" ){?>
                        <td class="table__td">
                    <form method="POST" action="/mostrar-certificados">
                        <input type="hidden" name="codigo" value="<?php echo $diploma->codigo; ?>">
                        <button class="taskD" type="submit">
                        <div class="taskD__d"> <i class="fa-sharp fa-solid fa-file-arrow-down"></i>Descargar</div>
                        </button>
                    </form>
                    </td>
                    <?php }else{?>
                        <td class="table__td">
                        <button class="taskD"><div class="taskD__f"><i class="fa-sharp fa-solid fa-file-excel" disabled></i>No Disponible</div></button>
                          </td>
                        <?php };?>
                </tr>
                <?php endforeach;?>
            </>
        </tbody>
    </table>
</div>
    <?php }else{?>
        <p class="text-center">No Hay Cursus Disponibles para ti</p>
    <?php };?>
</div>
</div>
<!-- 
<div class="task" id="task">
                <span id="taskname">
                    erretrteter
                </span>
                <button class="delete">
                    <i class="fa-sharp fa-solid fa-file-arrow-down"></i>
                </button>
            </div>-->