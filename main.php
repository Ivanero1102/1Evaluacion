<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="stile.css"/>
        <title>Document</title>
    </head>
    <body>
        <div class='navigationBar'>
            <h1>PUFOSA S.L.</h1>
            <a href='index.php'>
                <button class='cell_menu'>Log out</button>
            </a>
        </div>
        <div class='bar'>
            <p>Bienvenido: ..... </p>
        </div>
        <?php
            include 'conexion.php';
            if(isset($_POST['pagina'])){
                $tabla = $_POST['pagina'];
            }else{
                $tabla = 0;
            }
            switch ($tabla) {
                case 1:
                    if(isset($_POST['borrar_trabajo_ip'])){
                        $sql = "UPDATE EMPLEADOS SET Trabajo_ID = NULL WHERE Trabajo_ID = ?;";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1,$_POST['borrar_trabajo_ip']);
                        $stmt->execute();
                        $sql = "DELETE FROM TRABAJOS WHERE Trabajo_ID = ?;";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1,$_POST['borrar_trabajo_ip']);
                        $stmt->execute();
                    }
                    $sql= "SELECT * FROM TRABAJOS";
                    echo 
                    "<div class='tabla'>
                        <h1>Clientes</h1>
                    </div>
                    <div class='menu' >
                        <form action='main.php' method='post'> 
                            <input type='hidden' name='pagina' value='0'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Clientes'></p>
                        </form>
                        <form>
                            <p><input class='active' type='button' name='botonEnviar' value='Trabajos'></p>
                        </form>
                        <form action='main.php' method='post'>
                            <input type='hidden' name='pagina' value='2'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Empleados'></p>
                        </form>
                        <form action='main.php' method='post'>
                            <input type='hidden' name='pagina' value='3'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Departamento'></p>
                        </form>
                        <form action='main.php' method='post'>
                            <input type='hidden' name='pagina' value='4'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Ubicacion'></p>
                        </form>
                    </div>
                    <div class='menu' >
                        <form action='main.php' method='post'>
                            <input type='hidden' name='pagina' value='3'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Informe'></p>
                        </form>
                        <form action='main.php' method='post'>
                            <input type='hidden' name='pagina' value='4'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Log'></p>
                        </form>
                    </div>";
                    echo "<div class='alineador'><table>";
                    echo "<tr><th>Trabajo_ID</th>
                        <th>Funcion</th>
                        <th colspan='2'><form action='' method='post'>
                        <input type='hidden' name='pagina' value='1'></input>
                        <span><input type='submit' name='ocupar' value='+' style='font-size: 40px; font-weight:25px'></span>
                        </form></th></tr>";
                    foreach ($conn->query($sql) as $row){
                    echo "<tr><td>".$row["Trabajo_ID"]."</td>
                        <td>".$row["Funcion"]."</td>
                        <td><form action='' method='post'>
                        <input type='hidden' name='pagina' value='1'></input>
                        <input type='hidden' name='borrar_trabajo_ip' value='".$row["Trabajo_ID"]."'>
                        <span><input type='submit' name='ocupar' value='🗑'></span>
                        </form></td>
                        <td><form action='' method='post'>
                        <input type='hidden' name='pagina' value='1'></input>
                        <input type='hidden' name='borrar_empleado' value=''>
                        <span><input type='submit' name='editar' value='🖉' style='font-size: 20px; font-weight:25px'></span>
                        </form></td></tr>";
                    }
                    echo "</table></div>";
                    break;
                case 2:
                    if(isset($_POST['borrar_empleado'])){
                        $sql = "UPDATE CLIENTE SET Vendedor_ID = NULL WHERE Vendedor_ID = ?;";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1,$_POST['borrar_empleado']);
                        $stmt->execute();
                        $sql = "DELETE FROM EMPLEADOS WHERE empleado_ID = ?;";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1,$_POST['borrar_empleado']);
                        $stmt->execute();
                    }
                    $sql= "SELECT * FROM EMPLEADOS";
                    echo
                    "<div class='tabla'>
                        <h1>Clientes</h1>
                    </div>
                    <div class='menu'>
                        <form action='main.php'method='post'> 
                            <input type='hidden' name='pagina' value='0'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Clientes'></p>
                        </form>
                        <form action='main.php'method='post'>
                            <input type='hidden' name='pagina' value='1'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Trabajos'></p>
                        </form>
                        <form>
                            <p><input class='active' type='button' name='botonEnviar' value='Empleados'></p>
                        </form>
                        <form action='main.php'method='post'>
                            <input type='hidden' name='pagina' value='3'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Departamento'></p>
                        </form>
                        <form action='main.php'method='post'>
                            <input type='hidden' name='pagina' value='4'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Ubicacion'></p>
                        </form>
                    </div>
                    <div class='menu' >
                        <form action='main.php' method='post'>
                            <input type='hidden' name='pagina' value='3'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Informe'></p>
                        </form>
                        <form action='main.php' method='post'>
                            <input type='hidden' name='pagina' value='4'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Log'></p>
                        </form>
                    </div>";
                    echo "<div><table class='alineador'>";
                    echo "<tr><th>empleado_ID</th>
                        <th>Apellido</th>
                        <th>Nombre</th>
                        <th>Inicial_del_segundo_apellido</th>
                        <th>Trabajo_ID</th>
                        <th>Jefe_ID</th>
                        <th>Fecha_contrato</th>
                        <th>Salario</th>
                        <th>Comision</th>
                        <th>Departamento_ID</th>
                        <th colspan='2'><form action='' method='post'>
                        <input type='hidden' name='pagina' value='2'></input>
                        <span><input type='submit' name='ocupar' value='+' style='font-size: 40px; font-weight:25px'></span>
                        </form></th></tr>";
                    foreach ($conn->query($sql) as $row){
                    echo "<tr><td>".$row["empleado_ID"]."</td>
                        <td>".$row["Apellido"]."</td>
                        <td>".$row["Nombre"]."</td>
                        <td>".$row["Inicial_del_segundo_apellido"]."</td>
                        <td>".$row["Trabajo_ID"]."</td>
                        <td>".$row["Jefe_ID"]."</td>
                        <td>".$row["Fecha_contrato"]."</td>
                        <td>".$row["Salario"]."</td>
                        <td>".$row["Comision"]."</td>
                        <td>".$row["Departamento_ID"]."</td>
                        <td><form action='' method='post'>
                        <input type='hidden' name='pagina' value='2'></input>
                        <input type='hidden' name='borrar_empleado' value='".$row["empleado_ID"]."'>
                        <span><input type='submit' name='borrar' value='🗑'></span>
                        </form></td>
                        <td><form action='' method='post'>
                        <input type='hidden' name='pagina' value='2'></input>
                        <input type='hidden' name='borrar_empleado' value=''>
                        <span><input type='submit' name='editar' value='🖉' style='font-size: 20px; font-weight:25px'></span>
                        </form></td></tr>";
                    }
                    echo "</table></div>";
                    break;
                case 3:
                    if(isset($_POST['borrar_departamento_id'])){
                        $sql = "UPDATE EMPLEADOS SET Departamento_ID = NULL WHERE Departamento_ID = ?;";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1,$_POST['borrar_departamento_id']);
                        $stmt->execute();
                        $sql = "DELETE FROM DEPARTAMENTO WHERE departamento_ID = ?;";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1,$_POST['borrar_departamento_id']);
                        $stmt->execute();
                    }
                    $sql= "SELECT * FROM DEPARTAMENTO";
                    echo
                    "<div class='tabla'>
                        <h1>Clientes</h1>
                    </div>
                    <div class='menu'>
                        <form action='main.php'method='post'> 
                            <input type='hidden' name='pagina' value='0'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Clientes'></p>
                        </form>
                        <form action='main.php'method='post'>
                            <input type='hidden' name='pagina' value='1'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Trabajos'></p>
                        </form>
                        <form action='main.php'method='post'>
                            <input type='hidden' name='pagina' value='2'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Empleados'></p>
                        </form>
                        <form>
                            <p><input class='active' type='button' name='botonEnviar' value='Departamento'></p>
                        </form>
                        <form action='main.php'method='post'>
                            <input type='hidden' name='pagina' value='4'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Ubicacion'></p>
                        </form>
                    </div>
                    <div class='menu' >
                        <form action='main.php' method='post'>
                            <input type='hidden' name='pagina' value='3'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Informe'></p>
                        </form>
                        <form action='main.php' method='post'>
                            <input type='hidden' name='pagina' value='4'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Log'></p>
                        </form>
                    </div>";
                    echo "<div><table class='alineador'>";
                    echo "<tr><th>departamento_ID</th>
                        <th>Nombre</th>
                        <th>Ubicacion_ID</th>
                        <th colspan='2'><form action='' method='post'>
                        <input type='hidden' name='pagina' value='3'></input>
                        <span><input type='submit' name='ocupar' value='+' style='font-size: 40px; font-weight:25px'></span>
                        </form></th></tr>";
                    foreach ($conn->query($sql) as $row){
                    echo "<tr><td>".$row["departamento_ID"]."</td>
                        <td>".$row["Nombre"]."</td>
                        <td>".$row["Ubicacion_ID"]."</td>
                        <td><form action='' method='post'>
                        <input type='hidden' name='pagina' value='3'></input>
                        <input type='hidden' name='borrar_departamento_id' value='".$row["departamento_ID"]."'>
                        <span><input type='submit' name='borrar' value='🗑'></span>
                        </form></td>
                        <td><form action='' method='post'>
                        <input type='hidden' name='pagina' value='3'></input>
                        <input type='hidden' name='borrar_empleado' value=''>
                        <span><input type='submit' name='editar' value='🖉' style='font-size: 20px; font-weight:25px'></span>
                        </form></td></tr>";
                    }
                    echo "</table></div>";
                    break;

/*---------------------------------------------------------------------Tabla Ubicacion----------------------------------------------------------------------------------*/

                case 4:
                    if(isset($_POST['borrar_ubicacion'])){
                        $sql = "UPDATE DEPARTAMENTO SET Ubicacion_ID = NULL WHERE Ubicacion_ID = ?;";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1,$_POST['borrar_ubicacion']);
                        $stmt->execute();
                        $sql = "DELETE FROM UBICACION WHERE Ubicacion_ID = ?;";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1,$_POST['borrar_ubicacion']);
                        $stmt->execute();
                    }
                    $sql= "SELECT * FROM UBICACION";
                    echo
                    "<div class='tabla'>
                        <h1>Clientes</h1>
                    </div>
                    <div class='menu'>
                        <form action='main.php' method='post'> 
                            <input type='hidden' name='pagina' value='0'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Clientes'></p>
                        </form>
                        <form action='main.php' method='post'>
                            <input type='hidden' name='pagina' value='1'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Trabajos'></p>
                        </form>
                        <form action='main.php' method='post'>
                            <input type='hidden' name='pagina' value='2'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Empleados'></p>
                        </form>
                        <form action='main.php' method='post'>
                            <input type='hidden' name='pagina' value='3'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Departamento'></p>
                        </form>
                        <form>
                            <p><input class='active' type='button' name='botonEnviar' value='Ubicacion'></p>
                        </form>
                    </div>
                    <div class='menu' >
                        <form action='main.php' method='post'>
                            <input type='hidden' name='pagina' value='3'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Informe'></p>
                        </form>
                        <form action='main.php' method='post'>
                            <input type='hidden' name='pagina' value='4'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Log'></p>
                        </form>
                    </div>";
                    echo "<div><table class='alineador'>";
                    echo "<tr><th>Ubicacion_ID</th>
                        <th>GrupoRegional</th>
                        <th colspan='2'><form action='' method='post'>
                        <input type='hidden' name='pagina' value='4'></input>
                        <span><input type='submit' name='ocupar' value='+' style='font-size: 40px; font-weight:25px'></span>
                        </form></th></tr>";
                    foreach ($conn->query($sql) as $row){
                    echo "<tr><td>".$row["Ubicacion_ID"]."</td>
                        <td>".$row["GrupoRegional"]."</td>
                        <td><form action='' method='post'>
                        <input type='hidden' name='pagina' value='4'></input>
                        <input type='hidden' name='borrar_ubicacion' value='".$row["Ubicacion_ID"]."'>
                        <span><input type='submit' name='borrar' value='🗑'></span>
                        </form></td>
                        <td><form action='' method='post'>
                        <input type='hidden' name='pagina' value='4'></input>
                        <input type='hidden' name='borrar_empleado' value=''>
                        <span><input type='submit' name='editar' value='🖉' style='font-size: 20px; font-weight:25px'></span>
                        </form></td></tr>";
                    }
                    echo "</table></div>";
                    break;

/*---------------------------------------------------------------------Tabla Cliente------------------------------------------------------------------------------------*/

                default:
                if(isset($_POST['añadir_acabado'])){
                    try {
                        $sql ="INSERT INTO 
                            cliente (CLIENTE_ID, nombre, Direccion, Ciudad, Estado, CodigoPostal, CodigoDeArea, Telefono, Vendedor_ID, Limite_De_Credito, Comentarios) 
                            VALUES (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1,$_POST['añadir_cliente_id']);
                        $stmt->bindParam(2,$_POST['añadir_cliente_nombre']);
                        $stmt->bindParam(3,$_POST['añadir_cliente_direccion']);
                        $stmt->bindParam(4,$_POST['añadir_cliente_ciudad']);
                        $stmt->bindParam(5,$_POST['añadir_cliente_estado']);
                        $stmt->bindParam(6,$_POST['añadir_cliente_codigo_postal']);
                        $stmt->bindParam(7,$_POST['añadir_cliente_codigo_area']);
                        $stmt->bindParam(8,$_POST['añadir_cliente_telefono']);
                        $stmt->bindParam(9,$_POST['añadir_cliente_vendedor_id']);
                        $stmt->bindParam(10,$_POST['añadir_cliente_credito']);
                        $stmt->bindParam(11,$_POST['añadir_cliente_comentario']);
                        $stmt->execute();
                        $mensaje = "Cliente insertado correctamente";
                    }catch(PDOException $e){
                        $mensaje = "Error, la id empleada ya se utiliza";
                    }
                }
                if(isset($_POST['editar_acabado'])){
                    $sql ="UPDATE cliente SET 
                        nombre = ?
                        , Direccion = ?
                        , Ciudad = ?
                        , Estado = ?
                        , CodigoPostal = ?
                        , CodigoDeArea = ?
                        , Telefono = ?
                        , Vendedor_ID = ?
                        , Limite_De_Credito = ?
                        , Comentarios = ?
                        WHERE CLIENTE_ID = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1,$_POST['editar_cliente_nombre']);
                        $stmt->bindParam(2,$_POST['editar_cliente_direccion']);
                        $stmt->bindParam(3,$_POST['editar_cliente_ciudad']);
                        $stmt->bindParam(4,$_POST['editar_cliente_estado']);
                        $stmt->bindParam(5,$_POST['editar_cliente_codigo_postal']);
                        $stmt->bindParam(6,$_POST['editar_cliente_codigo_area']);
                        $stmt->bindParam(7,$_POST['editar_cliente_telefono']);
                        $stmt->bindParam(8,$_POST['editar_cliente_vendedor_id']);
                        $stmt->bindParam(9,$_POST['editar_cliente_credito']);
                        $stmt->bindParam(10,$_POST['editar_cliente_comentario']);
                        $stmt->bindParam(11,$_POST['editar_cliente_id']);
                        $stmt->execute();
                        $mensaje = "Cliente editado correctamente";
                }
                if(isset($_POST['borrar_cliente_id'])){
                    $sql = "DELETE FROM cliente WHERE CLIENTE_ID = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(1,$_POST['borrar_cliente_id']);
                    $stmt->execute();
                    $mensaje = "Cliente borrado correctamente";
                }
                echo
                    "<div class='tabla'>
                        <h1>Clientes</h1>
                    </div>
                    <div class='menu'>
                        <form> 
                            <p><input class='active' type='button' name='botonEnviar' value='Clientes'></p>
                        </form>
                        <form action='main.php'method='post'>
                            <input type='hidden' name='pagina' value='1'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Trabajos'></p>
                        </form>
                        <form action='main.php'method='post'>
                            <input type='hidden' name='pagina' value='2'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Empleados'></p>
                        </form>
                        <form action='main.php'method='post'>
                            <input type='hidden' name='pagina' value='3'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Departamento'></p>
                        </form>
                        <form action='main.php'method='post'>
                            <input type='hidden' name='pagina' value='4'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Ubicacion'></p>
                        </form>
                    </div>
                    <div class='menu' >
                        <form action='main.php' method='post'>
                            <input type='hidden' name='pagina' value='3'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Informe'></p>
                        </form>
                        <form action='main.php' method='post'>
                            <input type='hidden' name='pagina' value='4'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Log'></p>
                        </form>
                    </div>";
                if(isset($_POST['editar']) || isset($_POST['añadir'])){
                    if(isset($_POST['añadir'])){
                        echo"
                        <form action='' method='post'>
                        <input type='hidden' name='pagina' value='0'></input>
                        <label for='añadir_cliente_id'>Id del cliente:</label>
                        <input type='number' name='añadir_cliente_id'></br>
                        <label for='añadir_cliente_nombre'>Nombre:</label>
                        <input type='text' name='añadir_cliente_nombre'></br>
                        <label for='añadir_cliente_direccion'>Direccion:</label>
                        <input type='text' name='añadir_cliente_direccion'></br>
                        <label for='añadir_cliente_ciudad'>Ciudad:</label>
                        <input type='text' name='añadir_cliente_ciudad'></br>
                        <label for='añadir_cliente_estado'>Estado:</label>
                        <input type='text' name='añadir_cliente_estado'></br>
                        <label for='añadir_cliente_codigo_postal'>Codigo postal:</label>
                        <input type='number' name='añadir_cliente_codigo_postal'></br>
                        <label for='añadir_cliente_codigo_area'>Codigo de area:</label>
                        <input type='number' name='añadir_cliente_codigo_area'></br>
                        <label for='añadir_cliente_telefono'>Telefono:</label>
                        <input type='number' name='añadir_cliente_telefono'></br>
                        <label for='id'>Vendedor ID:</label>
                        <select name='añadir_cliente_vendedor_id'>";
                        $sql= "SELECT * FROM EMPLEADOS";
                        foreach ($conn->query($sql) as $row){
                            echo "<option value='". $row["empleado_ID"] ."'>". $row["empleado_ID"] ."</option>";
                        }
                        echo "</select></br>
                        <label for='añadir_cliente_credito'>Limite de credito:</label>
                        <input type='number' name='añadir_cliente_credito'></br>
                        <label for='añadir_cliente_comentario'>Comentario:</label>
                        <input type='text' name='añadir_cliente_comentario'></br>
                        <span><input type='submit' name='añadir_acabado' value='Añadir cliente'></span>
                        </form>
                        <form action='' method='post'>
                        <input type='hidden' name='pagina' value='0'></input>
                        <span><input type='submit' name='volver' value='Volver'></span>
                        </form>";
                    }else{
                        echo"
                        <form action='' method='post'>
                        <input type='hidden' name='pagina' value='0'></input>
                        <input type='hidden' name='pagina' value='0'></input>
                        <label for='id'>Id del cliente:</label>
                        <input type='number' name='editar_cliente_id' value='".$_POST['editar_cliente_id']."' readonly></br>
                        <label for='id'>Nombre:</label>
                        <input type='text' name='editar_cliente_nombre' placeholder='".$_POST['editar_cliente_nombre']."'></br>
                        <label for='id'>Direccion:</label>
                        <input type='text' name='editar_cliente_direccion' placeholder='".$_POST['editar_cliente_direccion']."'></br>
                        <label for='id'>Ciudad:</label>
                        <input type='text' name='editar_cliente_ciudad' placeholder='".$_POST['editar_cliente_ciudad']."'></br>
                        <label for='id'>Estado:</label>
                        <input type='text' name='editar_cliente_estado' placeholder='".$_POST['editar_cliente_estado']."'></br>
                        <label for='id'>Codigo postal:</label>
                        <input type='number' name='editar_cliente_codigo_postal' placeholder='".$_POST['editar_cliente_codigo_postal']."'></br>
                        <label for='id'>Codigo de area:</label>
                        <input type='number' name='editar_cliente_codigo_area' placeholder='".$_POST['editar_cliente_codigo_area']."'></br>
                        <label for='id'>Telefono:</label>
                        <input type='number' name='editar_cliente_telefono' placeholder='".$_POST['editar_cliente_telefono']."'></br>
                        <label for='id'>Vendedor ID:</label>
                        <select name='editar_cliente_vendedor_id'>
                            <option value='".$_POST['editar_cliente_vendedor_id']."' selected='selected'>".$_POST['editar_cliente_vendedor_id']."</option>";
                        $sql= "SELECT * FROM EMPLEADOS";
                        foreach ($conn->query($sql) as $row){
                            echo "<option value='". $row["empleado_ID"] ."'>". $row["empleado_ID"] ."</option>";
                        }
                        echo
                        "</select></br>
                        <label for='id'>Limite de credito:</label>
                        <input type='number' name='editar_cliente_credito' placeholder='".$_POST['editar_cliente_credito']."'></br>
                        <label for='id'>Comentario:</label>
                        <input type='text' name='editar_cliente_comentario' placeholder='".$_POST['editar_cliente_comentario']."'></br>
                        <span><input type='submit' name='editar_acabado' value='Editar cliente'></span>
                        </form>
                        <form action='' method='post'>
                        <input type='hidden' name='pagina' value='0'></input>
                        <span><input type='submit' name='volver' value='Volver'></span>
                        </form>";
                    }
                }else{
                    echo "<div><table class='alineador'>";
                    echo "<tr><th>CLIENTE_ID</th>
                        <th>nombre</th>
                        <th>Direccion</th>
                        <th>Ciudad</th>
                        <th>Estado</th>
                        <th>CodigoPostal</th>
                        <th>CodigoDeArea</th>
                        <th>Telefono</th>
                        <th>Vendedor_ID</th>
                        <th>Limite_De_Credito</th>
                        <th>Comentarios</th>
                        <th colspan='2'><form action='' method='post'>
                        <input type='hidden' name='pagina' value='0'></input>
                        <span><input type='submit' name='añadir' value='+' style='font-size: 40px; font-weight:25px'></span>
                        </form></th></tr>";
                    if(isset($mensaje)){
                        echo $mensaje;
                    }
                    $sql= "SELECT * FROM CLIENTE";
                    foreach ($conn->query($sql) as $row){
                    echo "<tr><td>".$row["CLIENTE_ID"]."</td>
                        <td>".$row["nombre"]."</td>
                        <td>".$row["Direccion"]."</td>
                        <td>".$row["Ciudad"]."</td>
                        <td>".$row["Estado"]."</td>
                        <td>".$row["CodigoPostal"]."</td>
                        <td>".$row["CodigoDeArea"]."</td>
                        <td>".$row["Telefono"]."</td>
                        <td>".$row["Vendedor_ID"]."</td>
                        <td>".$row["Limite_De_Credito"]."</td>
                        <td>".$row["Comentarios"]."</td>
                        <td><form action='' method='post'>
                        <input type='hidden' name='pagina' value='0'></input>
                        <input type='hidden' name='borrar_cliente_id' value='". $row["CLIENTE_ID"] ."'>
                        <span><input type='submit' name='ocupar' value='🗑'></span>
                        </form></td>
                        <td><form action='' method='post'>
                        <input type='hidden' name='pagina' value='0'></input>
                        <input type='hidden' name='editar_cliente_id' value='". $row["CLIENTE_ID"] ."'>
                        <input type='hidden' name='editar_cliente_nombre' value='". $row["nombre"] ."'>
                        <input type='hidden' name='editar_cliente_direccion' value='". $row["Direccion"] ."'>
                        <input type='hidden' name='editar_cliente_ciudad' value='". $row["Ciudad"] ."'>
                        <input type='hidden' name='editar_cliente_estado' value='". $row["Estado"] ."'>
                        <input type='hidden' name='editar_cliente_codigo_postal' value='". $row["CodigoPostal"] ."'>
                        <input type='hidden' name='editar_cliente_codigo_area' value='". $row["CodigoDeArea"] ."'>
                        <input type='hidden' name='editar_cliente_telefono' value='". $row["Telefono"] ."'>
                        <input type='hidden' name='editar_cliente_vendedor_id' value='". $row["Vendedor_ID"] ."'>
                        <input type='hidden' name='editar_cliente_credito' value='". $row["Limite_De_Credito"] ."'>
                        <input type='hidden' name='editar_cliente_comentario' value='". $row["Comentarios"] ."'>
                        <span><input type='submit' name='editar' value='🖉' style='font-size: 20px; font-weight:25px'></span>
                        </form></td></tr>";
                    }
                    echo "</table></div>";
                }
                break;
            }
        ?>
    </body>
</html>