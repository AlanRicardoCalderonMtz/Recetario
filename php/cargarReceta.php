<?php
require "./php/conexion.php";
//echo"sin id";
$sql1="SELECT * FROM `recetas`";                               
                
$res =$con->query($sql1);
//echo"antes del primer if";
if($res->num_rows>0){
    while($row = $res->fetch_assoc()){
        $Idres = ($row["idrecetas"])+1;
    }
}else{
    $Idres = 1;
}
//echo"despues del primer if";
if(isset($_POST['nombre'])){
    $creador=$_SESSION['ID'];
    $nombre=$_POST['nombre'];
    $categoria=$_POST['categoria'];
    $region=$_POST['region'];
    $porciones=$_POST['porciones'];
    $talimentacion=$_POST['talimentacion'];
    $preparacion=$_POST['preparacion'];

    $sql="INSERT INTO `recetas` (`idrecetas`, `nombre`, `preparacion`, `tipoAlimentacion`, `porciones`, `Categoria`, `Region`, `creador`)
    VALUES($Idres, '$nombre', '$preparacion', '$talimentacion', $porciones, '$categoria', '$region', '$creador')";
    //echo $sql;
    if($con->query($sql)==true){
        $ning=$_POST['ning'];
        echo $ning;
        for($x=1;$x<=$ning;$x++){
            echo "for";
            $ingrediente=$_POST['ingrediente'.$x];
            $cantidad=$_POST['cantidad'.$x];
            $sqling="SELECT * FROM ingredientes WHERE ingrediente = '$ingrediente'";
            echo $sqling;
            $res =$con->query($sqling);
            if($res->num_rows>0){
                $sqlingrec = "INSERT INTO recetasIngredientes (recetas_idrecetas,ingredientes_ingrediente,cantidad)
                    VALUES ('$Idres','$ingrediente','$cantidad')";
                if($con->query($sqlingrec)==true){
                    header("Location:./index.php");
                }else{
                    echo "<br><p style='color: rgb(136, 1, 1);'>Error al guardar relacion</p>";
                }
            }else{
                $sqling = "INSERT INTO ingredientes (ingrediente) VALUES ('$ingrediente')";
                if($con->query($sqling)==true){
                    $sqlingrec = "INSERT INTO recetasIngredientes (recetas_idrecetas,ingredientes_ingrediente,cantidad)
                    VALUES ('$Idres','$ingrediente','$cantidad')";
                    if($con->query($sqlingrec)==true){
                        header("Location:./index.php");
                    }else{
                        echo "<br><p style='color: rgb(136, 1, 1);'>Error al guardar relacion</p>";
                    }
                }else{
                    echo "<br><p style='color: rgb(136, 1, 1);'>Error al guardar el ingrediente</p>";
                }
            }
                
        }
    }else{
        echo "<br><p style='color: rgb(136, 1, 1);'>Error al guardar receta</p>";
    }
    //echo"$IdMat $Materia $Nivel";                            
    $con->close();

}else{
    //echo"<br><p style='color: rgb(136, 1, 1);'>Vacio</p>";
}
?>