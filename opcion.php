<?php
session_start();
//error_reporting(0);
if(isset( $_SESSION['nombre'])){
    $nombre=$_SESSION['nombre'];
    $rol=$_SESSION['rol'];
    $a =  "Alumno";
    $b =  "Docente";
    $c = "Administrador";
}else{
echo 'usted no tiene autorizacion';
die();
}
require_once 'login.php';
    $conexion = new mysqli($hn, $un, $pw, $db, $port);

    if($conexion->connect_error) die("Error fatal");
if($rol==$a){
  $query = "SELECT * FROM estudiante where idusuario='$nombre'";
  $result = $conexion->query($query);
  if (!$result) die ("Falló el acceso a la base de datos");
  $rows = $result->num_rows;
  $row = $result->fetch_array(MYSQLI_NUM);
  
  $idestu = htmlspecialchars($row[0]);
}else{ if($rol==$b){
  $query = "SELECT * FROM docente where idusuario='$nombre'";
  $result = $conexion->query($query);
  if (!$result) die ("Falló el acceso a la base de datos");
  $rows = $result->num_rows;
  $row = $result->fetch_array(MYSQLI_NUM);
  
  $iddoc = htmlspecialchars($row[1]);
  }
  
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>registro de usuario</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <section class="form-login">
    <?php
    if($rol==$a){
      $query2 = "SELECT c.codigo_asignatura,c.nombre,a.codigo_estudiante,a.nombre FROM estudiante a 
    inner join matricula b on a.codigo_estudiante=b.codigo_estudiante 
    inner join asignatura c on b.codigo_asignatura=c.codigo_asignatura 
    where b.codigo_estudiante='$idestu'";
    $result = $conexion->query($query2);
    if (!$result) die ("Falló el acceso a la base de datos");
    $rows = $result->num_rows;
    for ($j = 0; $j < $rows; $j++)
    {
    $row = $result->fetch_array(MYSQLI_NUM);
    $cod = htmlspecialchars($row[0]);
    $nom = htmlspecialchars($row[1]);
    $codest = htmlspecialchars($row[2]);
    $nomest = htmlspecialchars($row[3]);
    echo "$cod";
    echo "$nom";
    //echo "
    echo <<<_END
    <br>
    <form name="asis" action="lista.php" method="POST">
    <input type='hidden' name='codigocurso' value='$cod'>
    <input type='hidden' name='nombrecurso' value='$nom'>
    <input type='hidden' name='codigoestudiante' value='$codest'>
    <input type='hidden' name='nombreestudiante' value='$nomest'>
    <input class="buttons" type="submit" name="" value="ver asistencia" >
    </form>
    <br>
    _END;
    //";
    }
    }else{
      if($rol==$b){
        $query2 = "SELECT c.codigo_asignatura,c.nombre,a.codigo_docente,a.nombre_docente FROM docente a 
        inner join docente_asignatura b on a.codigo_docente=b.codigo_docente 
        inner join asignatura c on b.codigo_asignatura=c.codigo_asignatura 
        where b.codigo_docente='$iddoc'";
        $result = $conexion->query($query2);
        if (!$result) die ("Falló el acceso a la base de datos");
        $rows = $result->num_rows;
        for ($j = 0; $j < $rows; $j++)
        {
        $row = $result->fetch_array(MYSQLI_NUM);
        $cod = htmlspecialchars($row[0]);
        $nom = htmlspecialchars($row[1]);
        $codest = htmlspecialchars($row[2]);
        $nomest = htmlspecialchars($row[3]);
        echo "$cod";
        echo "$nom";
        //echo "
        echo <<<_END
        <br>
        <form name="asis" action="lista.php" method="POST">
        <input type='hidden' name='codigocurso' value='$cod'>
        <input type='hidden' name='nombrecurso' value='$nom'>
        <input type='hidden' name='codigoestudiante' value='$codest'>
        <input type='hidden' name='nombreestudiante' value='$nomest'>
        <input class="buttons" type="submit" name="" value="llenar asistencia" >
        </form>
        <br>
        _END;
        //";
      ;
      }
      }
      else{ if($rol==$c){
         //echo "
         echo <<<_END
         <br>
         <form name="asis" action="docente_asignatura.php" method="POST">
         <input class="buttons" type="submit" name="" value="agregar cursos" >
         </form>
         <form name="asis" action="docente_asignatura.php" method="POST">
         <input class="buttons" type="submit" name="" value="designar curso" >
         </form>
         <br>
         _END;
         //";
      }

      }
      
    }    
    ?>
    </section>
  </body>
</html>