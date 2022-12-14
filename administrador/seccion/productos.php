<?php include("../template/cabecera.php");?>
<?php
    $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
    $txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
    $txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
    $accion=(isset($_POST['accion']))?$_POST['accion']:"";

    include("../config/bd.php");

    switch($accion)
    {
        case "agregar":

            //INSERT INTO `libros` (`id`, `nombre`, `imagen`) VALUES (NULL, 'Libro de php', 'imagen.jpg');
            $sentenciaSQL=$conexion->prepare("INSERT INTO libros (nombre, imagen) VALUES (:nombre,:imagen);");
            $sentenciaSQL->bindParam(':nombre',$txtNombre);
            $sentenciaSQL->bindParam(':imagen',$txtImagen);
            $sentenciaSQL->execute();
            break;

        case "modificar":
            echo "Presionado boton modificar";
            break;

        case "cancelar":
            echo "Presionado boton cancelar";
            break;
        case "Seleccionar":
            $sentenciaSQL=$conexion->prepare("SELECT * FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            $txtNombre=$libro['nombre'];
            $txtImagen=$libro['imagen'];
            //echo "Presionado boton seleccionar";
            break;
        case "Borrar":
            $sentenciaSQL=$conexion->prepare("DELETE FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            //echo "Presionado boton borrar";
            break;
    }
    $sentenciaSQL=$conexion->prepare("SELECT * FROM libros");
    $sentenciaSQL->execute();
    $listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>

<div class="col-md-5">

    <div class="card">
        <div class="card-header">
            Datos de Libro
        </div>
        <div class="card-body">
        <form method="POST" enctype="multipart/form-data">

            <div class = "form-group">
            <label for="txtID">ID:</label>
            <input type="text" class="form-control" value="<?php echo $txtID;?>" name="txtID" id="txtID" placeholder="ID">
            </div>

            <div class = "form-group">
            <label for="txtNombre">Nombre:</label>
            <input type="text" class="form-control" value="<?php echo $txtNombre;?>" name="txtNombre" id="txtNombre" placeholder="nombre del libro">
            </div>

            <div class = "form-group">
            <label for="txtNombre">Nombre:</label>

            <?php echo $txtImagen;?>

            <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="nombre del libro">
            </div>

            <div class="btn-group" role="group" aria-label="">
                <button type="submit" name="accion" value="agregar" class="btn btn-success">Agregar</button>
                <button type="submit" name="accion" value="modificar" class="btn btn-warning">Modificar</button>
                <button type="submit" name="accion" value="cancelar" class="btn btn-info">Cancelar</button>
            </div>

        </form>
    </div>

</div>

    
    
    

</div>

<div class="col-md-7">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($listaLibros as $libro){?>
            <tr>
                <td><?php echo $libro['id'];?></td>
                <td><?php echo $libro['nombre'];?></td>
                <td><?php echo $libro['imagen'];?></td>
                
                <td>
                <form method="post">

                    <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id'];?>">
                    <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                </form>
                
                
                </td>
            
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>

<?php include("../template/pie.php")?>