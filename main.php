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
            session_start();

            if(isset($_POST['usuario'])){
                $_SESSION['usuario'] = $_POST['usuario'];
            }

            //Conexion
            $server = "localhost";
            $user = "root";
            $clave= "";
            $BD="pufosa";
           
            try {
                $conn = new PDO("mysql:host=$server;dbname=$BD", $user, $clave);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo "Conexion fallida". $e->getMessage();
            }

            if(isset($_POST['pagina'])){
                $tabla = $_POST['pagina'];
            }else{
                $tabla = 0;
            }

            $stmt = $conn->prepare("SELECT COUNT(*) FROM empleados WHERE empleado_ID = ?");
            $stmt->execute(array($_SESSION['usuario']));
            $existe = $stmt->fetchColumn();
            $sql ="SELECT Trabajo_ID FROM empleados WHERE empleado_ID =". $_SESSION['usuario'];
            foreach ($conn->query($sql) as $row){
                if($existe>0){
                    if($row[0]==672){
                        $usuario = 1;
                    }else{
                        if($row[0]==671){
                            $usuario = 2;
                        }else{
                            $usuario = 0;
                        }
                    }
                }else{
                    header("Location:index.php");
                }
            }
            switch ($tabla) {

/*---------------------------------------------------------------------Tabla Trabajos-----------------------------------------------------------------------------------*/

                case 1:
                    if(isset($_POST['añadir_acabado'])){
                        try {
                            $sql ="INSERT INTO 
                                trabajos (Trabajo_ID, Funcion) 
                                VALUES (? ,?)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(1,$_POST['añadir_trabajo_id']);
                            $stmt->bindParam(2,$_POST['añadir_funcion']);
                            $stmt->execute();
                            $mensaje = "Trabajo insertada correctamente";
                            $archivo = fopen("log.txt", "r+b");
                            $hora = date("d/m/Y - H:i:s");
                            $texto = "El usuario: ".$_SESSION['usuario']." Hora: ".$hora." Se añadio un trabajo";
                            fwrite($archivo, $texto);
                            fclose($archivo);
                        }catch(PDOException $e){
                            $mensaje = "Error, la trabajo id ya se utiliza";
                        }
                    }
                    if(isset($_POST['editar_acabado'])){
                        $sql ="UPDATE trabajos SET 
                            Funcion = ?
                            WHERE Trabajo_ID = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(1,$_POST['editar_funcion']);
                            $stmt->bindParam(2,$_POST['editar_trabajo_id']);
                            $stmt->execute();
                            $mensaje = "Trabajo editado correctamente";
                            $archivo = fopen("log.txt", "r+b");
                            $hora = date("d/m/Y - H:i:s");
                            $texto = "El usuario: ".$_SESSION['usuario']." Hora: ".$hora." Se editado un trabajo";
                            fwrite($archivo, $texto);
                            fclose($archivo);
                    }
                    if(isset($_POST['borrar_trabajo_ip'])){
                        $sql = "UPDATE EMPLEADOS SET Trabajo_ID = NULL WHERE Trabajo_ID = ?;";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1,$_POST['borrar_trabajo_ip']);
                        $stmt->execute();
                        $sql = "DELETE FROM TRABAJOS WHERE Trabajo_ID = ?;";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1,$_POST['borrar_trabajo_ip']);
                        $stmt->execute();
                        $archivo = fopen("log.txt", "r+b");
                            $hora = date("d/m/Y - H:i:s");
                            $texto = "El usuario: ".$_SESSION['usuario']." Hora: ".$hora." Se borro un trabajo";
                            fwrite($archivo, $texto);
                            fclose($archivo);
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
                            <input type='hidden' name='pagina' value='5'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Log'></p>
                        </form>";
                        if($usuario == 1){
                        echo "<form action='main.php' method='post'>
                            <input type='hidden' name='pagina' value='6'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Informe'></p>
                        </form>";} echo "
                    </div>";
                    if(isset($_POST['editar']) || isset($_POST['añadir'])){
                        if(isset($_POST['añadir'])){
                            echo"
                            <div class='menu'>
                            <form action='' method='post'>
                            <input type='hidden' name='pagina' value='1'></input>
                            <label for='añadir_trabajo_id' required>Trabajo id:</label>
                            <input type='number' name='añadir_trabajo_id'></br>
                            <label for='añadir_funcion'>Funcion:</label>
                            <input type='text' name='añadir_funcion'></br>
                            <span><input type='submit' name='añadir_acabado' value='Añadir Ubicacion'></span>
                            </form>
                            <form action='' method='post'>
                            <input type='hidden' name='pagina' value='1'></input>
                            <span><input type='submit' name='volver' value='Volver'></span>
                            </form>
                            </div>";
                        }else{
                            echo"
                            <div class='menu'>
                            <form action='' method='post'>
                            <input type='hidden' name='pagina' value='1'></input>
                            <label for='id'>Trabajo id:</label>
                            <input type='number' name='editar_trabajo_id' value='".$_POST['editar_trabajo_id']."' readonly></br>
                            <label for='id'>Funcion:</label>
                            <input type='text' name='editar_funcion' placeholder='".$_POST['editar_funcion']."'></br>
                            <span><input type='submit' name='editar_acabado' value='Editar cliente'></span>
                            </form>
                            <form action='' method='post'>
                            <input type='hidden' name='pagina' value='1'></input>
                            <span><input type='submit' name='volver' value='Volver'></span>
                            </form>
                            </div>";
                        }
                    }else{
                    echo "<div class='alineador'><table>";
                    echo "<tr><th>Trabajo_ID</th>
                        <th>Funcion</th>
                        <th colspan='2'><form action='' method='post'>
                        <input type='hidden' name='pagina' value='1'></input>
                        <span><input type='submit' name='añadir' value='+' style='font-size: 40px; font-weight:25px'></span>
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
                        <input type='hidden' name='editar_trabajo_id' value='". $row["Trabajo_ID"] ."'>
                        <input type='hidden' name='editar_funcion' value='". $row["Funcion"] ."'>
                        <span><input type='submit' name='editar' value='🖉' style='font-size: 20px; font-weight:25px'></span>
                        </form></td></tr>";
                    }
                    echo "</table></div>";
                }
                    break;

/*---------------------------------------------------------------------Tabla Empleado-----------------------------------------------------------------------------------*/

                case 2:
                    if(isset($_POST['añadir_acabado'])){
                        try {
                            $sql ="INSERT INTO 
                                empleados (empleado_ID, Apellido, Nombre, Inicial_del_segundo_apellido, Trabajo_ID, Jefe_ID, Fecha_contrato, Salario, Comision, Departamento_ID) 
                                VALUES (? ,? ,? ,? ,? ,? ,? ,? ,? ,?)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(1,$_POST['añadir_empeado_id']);
                            $stmt->bindParam(2,$_POST['añadir_apellido']);
                            $stmt->bindParam(3,$_POST['añadir_nombre']);
                            $stmt->bindParam(4,$_POST['añadir_inicial']);
                            $stmt->bindParam(5,$_POST['añadir_trabajo_id']);
                            $stmt->bindParam(6,$_POST['añadir_jefe_id']);
                            $stmt->bindParam(7,$_POST['añadir_fecha_contrato']);
                            $stmt->bindParam(8,$_POST['añadir_salario']);
                            $stmt->bindParam(9,$_POST['añadir_comision']);
                            $stmt->bindParam(10,$_POST['añadir_departamento_id']);
                            $stmt->execute();
                            $mensaje = "Empleado insertado correctamente";
                            $archivo = fopen("log.txt", "r+b");
                            $hora = date("d/m/Y - H:i:s");
                            $texto = "El usuario: ".$_SESSION['usuario']." Hora: ".$hora." Se añadio un empleado";
                            fwrite($archivo, $texto);
                            fclose($archivo);
                        }catch(PDOException $e){
                            $mensaje = "Error, la id empleada ya se utiliza";
                        }
                    }
                    if(isset($_POST['editar_acabado'])){
                        $sql ="UPDATE empleados SET 
                            Apellido = ?
                            , Nombre = ?
                            , Inicial_del_segundo_apellido = ?
                            , Trabajo_ID = ?
                            , Jefe_ID = ?
                            , Fecha_contrato = ?
                            , Salario = ?
                            , Comision = ?
                            , Departamento_ID = ?
                            WHERE empleado_ID = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(1,$_POST['editar_apellido']);
                            $stmt->bindParam(2,$_POST['editar_nombre']);
                            $stmt->bindParam(3,$_POST['editar_inicial']);
                            $stmt->bindParam(4,$_POST['editar_trabajo_id']);
                            $stmt->bindParam(5,$_POST['editar_jefe_id']);
                            $stmt->bindParam(6,$_POST['editar_fecha_contrato']);
                            $stmt->bindParam(7,$_POST['editar_salario']);
                            $stmt->bindParam(8,$_POST['editar_comision']);
                            $stmt->bindParam(9,$_POST['editar_departamento_id']);
                            $stmt->bindParam(10,$_POST['editar_empeado_id']);
                            $stmt->execute();
                            $mensaje = "Empleado editado correctamente";
                            $archivo = fopen("log.txt", "r+b");
                            $hora = date("d/m/Y - H:i:s");
                            $texto = "El usuario: ".$_SESSION['usuario']." Hora: ".$hora." Se edito un empleado";
                            fwrite($archivo, $texto);
                            fclose($archivo);
                    }
                    if(isset($_POST['borrar_empleado'])){
                        $sql = "UPDATE CLIENTE SET Vendedor_ID = NULL WHERE Vendedor_ID = ?;";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1,$_POST['borrar_empleado']);
                        $stmt->execute();
                        $sql = "DELETE FROM EMPLEADOS WHERE empleado_ID = ?;";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1,$_POST['borrar_empleado']);
                        $stmt->execute();
                        $archivo = fopen("log.txt", "r+b");
                            $hora = date("d/m/Y - H:i:s");
                            $texto = "El usuario: ".$_SESSION['usuario']." Hora: ".$hora." Se borro un empleado";
                            fwrite($archivo, $texto);
                            fclose($archivo);
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
                            <input type='hidden' name='pagina' value='5'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Log'></p>
                        </form>"; if($usuario == 1){
                            echo
                        "<form action='main.php' method='post'>
                            <input type='hidden' name='pagina' value='6'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Informe'></p>
                        </form>";}
                    echo  "</div>";
                    if(isset($_POST['editar']) || isset($_POST['añadir'])){
                        if(isset($_POST['añadir'])){
                            echo"
                            <div class='menu'>
                            <form action='' method='post'>
                            <input type='hidden' name='pagina' value='2' required></input>
                            <label for='id'>Id del empleado:</label>
                            <input type='number' name='añadir_empeado_id'></br>
                            <label for='id'>Apellido:</label>
                            <input type='text' name='añadir_apellido'></br>
                            <label for='id'>Nombre:</label>
                            <input type='text' name='añadir_nombre'></br>
                            <label for='id'>Letra inicial del segundo apellido:</label>
                            <input type='text' name='añadir_inicial'></br>
                            <label for='id'>Trabajo id:</label>
                            <select name='añadir_trabajo_id'>";
                            $sql= "SELECT * FROM TRABAJOS";
                            foreach ($conn->query($sql) as $row){
                                echo "<option value='". $row["Trabajo_ID"] ."'>". $row["Trabajo_ID"] ."</option>";
                            }
                            echo "
                            </select></br>
                            <label for='id'>Jefe id:</label>
                            <input type='number' name='añadir_jefe_id'></br>
                            <label for='id'>Fecha contrato:</label>
                            <input type='date' name='añadir_fecha_contrato'></br>
                            <label for='id'>Salario:</label>
                            <input type='number' name='añadir_salario'></br>
                            <label for='id'>Comision:</label>
                            <input type='number' name='añadir_comision'></br>
                            <label for='id'>departamento_id:</label>
                            <select name='añadir_departamento_id'>";
                            $sql= "SELECT * FROM DEPARTAMENTO";
                            foreach ($conn->query($sql) as $row){
                                echo "<option value='". $row["departamento_ID"] ."'>". $row["departamento_ID"] ."</option>";
                            }
                            echo "</br>
                            <span><input type='submit' name='añadir_acabado' value='Añadir cliente'></span>
                            </form>
                            <form action='' method='post'>
                            <input type='hidden' name='pagina' value='2'></input>
                            <span><input type='submit' name='volver' value='Volver'></span>
                            </form>
                            </div>";
                        }else{
                            echo"
                            <div class='menu'>
                            <form action='' method='post'>
                            <input type='hidden' name='pagina' value='2'></input>
                            <label for='id'>Id del cliente:</label>
                            <input type='number' name='editar_empeado_id' value='".$_POST['editar_empeado_id']."' readonly></br>
                            <label for='id'>Nombre:</label>
                            <input type='text' name='editar_apellido' placeholder='".$_POST['editar_apellido']."'></br>
                            <label for='id'>Direccion:</label>
                            <input type='text' name='editar_nombre' placeholder='".$_POST['editar_nombre']."'></br>
                            <label for='id'>Ciudad:</label>
                            <input type='text' name='editar_inicial' placeholder='".$_POST['editar_inicial']."'></br>
                            <label for='id'>Vendedor ID:</label>
                            <select name='editar_trabajo_id'>
                                <option value='".$_POST['editar_trabajo_id']."' selected='selected'>".$_POST['editar_trabajo_id']."</option>";
                            $sql= "SELECT * FROM TRABAJOS";
                            foreach ($conn->query($sql) as $row){
                                echo "<option value='". $row["Trabajo_ID"] ."'>". $row["Trabajo_ID"] ."</option>";
                            }
                            echo "
                            </select></br>
                            <label for='id'>Codigo postal:</label>
                            <input type='number' name='editar_jefe_id' placeholder='".$_POST['editar_jefe_id']."'></br>
                            <label for='id'>Codigo de area:</label>
                            <input type='date' name='editar_fecha_contrato' placeholder='".$_POST['editar_fecha_contrato']."'></br>
                            <label for='id'>Telefono:</label>
                            <input type='number' name='editar_salario' placeholder='".$_POST['editar_salario']."'></br>
                            <label for='id'>Limite de credito:</label>
                            <input type='number' name='editar_comision' placeholder='".$_POST['editar_comision']."'></br>
                            <label for='id'>Comentario:</label>
                            <select name='editar_departamento_id'>
                            <option value='".$_POST['editar_departamento_id']."' selected='selected'>".$_POST['editar_departamento_id']."</option>";
                            $sql= "SELECT * FROM DEPARTAMENTO";
                            foreach ($conn->query($sql) as $row){
                                echo "<option value='". $row["departamento_ID"] ."'>". $row["departamento_ID"] ."</option>";
                            }
                            echo "<span><input type='submit' name='editar_acabado' value='Editar cliente'></span>
                            </form>
                            <form action='' method='post'>
                            <input type='hidden' name='pagina' value='2'></input>
                            <span><input type='submit' name='volver' value='Volver'></span>
                            </form>
                            </div>";
                        }
                    }else{
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
                        <span><input type='submit' name='añadir' value='+' style='font-size: 40px; font-weight:25px'></span>
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
                        <input type='hidden' name='editar_empeado_id' value='". $row["empleado_ID"] ."'>
                        <input type='hidden' name='editar_apellido' value='". $row["Apellido"] ."'>
                        <input type='hidden' name='editar_nombre' value='". $row["Nombre"] ."'>
                        <input type='hidden' name='editar_inicial' value='". $row["Inicial_del_segundo_apellido"] ."'>
                        <input type='hidden' name='editar_trabajo_id' value='". $row["Trabajo_ID"] ."'>
                        <input type='hidden' name='editar_jefe_id' value='". $row["Jefe_ID"] ."'>
                        <input type='hidden' name='editar_fecha_contrato' value='". $row["Fecha_contrato"] ."'>
                        <input type='hidden' name='editar_salario' value='". $row["Salario"] ."'>
                        <input type='hidden' name='editar_comision' value='". $row["Comision"] ."'>
                        <input type='hidden' name='editar_departamento_id' value='". $row["Departamento_ID"] ."'>
                        <span><input type='submit' name='editar' value='🖉' style='font-size: 20px; font-weight:25px'></span>
                        </form></td></tr>";
                    }
                    echo "</table></div>";
                    }
                    break;

/*---------------------------------------------------------------------Tabla Departamento-------------------------------------------------------------------------------*/

                case 3:
                    if(isset($_POST['añadir_acabado'])){
                        try {
                            $sql ="INSERT INTO 
                                departamento (departamento_ID, Nombre, Ubicacion_ID) 
                                VALUES (? ,?, ?)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(1,$_POST['añadir_departamento_id']);
                            $stmt->bindParam(2,$_POST['añadir_nombre']);
                            $stmt->bindParam(3,$_POST['añadir_ubicacion_id']);
                            $stmt->execute();
                            $mensaje = "Departamento insertada correctamente";
                            $archivo = fopen("log.txt", "r+b");
                            $hora = date("d/m/Y - H:i:s");
                            $texto = "El usuario: ".$_SESSION['usuario']." Hora: ".$hora." Se añadio un departamento";
                            fwrite($archivo, $texto);
                            fclose($archivo);
                        }catch(PDOException $e){
                            $mensaje = "Error, el departamento id ya se utiliza";
                        }
                    }
                    if(isset($_POST['editar_acabado'])){
                        $sql ="UPDATE departamento SET 
                             Nombre = ?
                            , Ubicacion_ID = ?
                            WHERE departamento_ID = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(1,$_POST['editar_nombre']);
                            $stmt->bindParam(2,$_POST['editar_ubicacion_id']);
                            $stmt->bindParam(3,$_POST['editar_departamento_id']);
                            $stmt->execute();
                            $mensaje = "Departamento editado correctamente";
                            $archivo = fopen("log.txt", "r+b");
                            $hora = date("d/m/Y - H:i:s");
                            $texto = "El usuario: ".$_SESSION['usuario']." Hora: ".$hora." Se edito un departamento";
                            fwrite($archivo, $texto);
                            fclose($archivo);
                    }
                    if(isset($_POST['borrar_departamento_id'])){
                        $sql = "UPDATE EMPLEADOS SET Departamento_ID = NULL WHERE Departamento_ID = ?;";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1,$_POST['borrar_departamento_id']);
                        $stmt->execute();
                        $sql = "DELETE FROM DEPARTAMENTO WHERE departamento_ID = ?;";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1,$_POST['borrar_departamento_id']);
                        $stmt->execute();
                        $archivo = fopen("log.txt", "r+b");
                            $hora = date("d/m/Y - H:i:s");
                            $texto = "El usuario: ".$_SESSION['usuario']." Hora: ".$hora." Se borro un departamento";
                            fwrite($archivo, $texto);
                            fclose($archivo);
                    }
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
                            <input type='hidden' name='pagina' value='5'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Log'></p>
                        </form>"; if($usuario == 1){
                            echo
                        "<form action='main.php' method='post'>
                            <input type='hidden' name='pagina' value='6'></input>
                            <p><input class='cell_menu' type='submit' name='botonEnviar' value='Informe'></p>
                        </form>";}
                    echo "</div>";
                    if(isset($_POST['editar']) || isset($_POST['añadir'])){
                        if(isset($_POST['añadir'])){
                            echo"
                            <div class='menu'>
                            <form action='' method='post'>
                            <input type='hidden' name='pagina' value='3'></input>
                            <label for='añadir_departamento_id' required>Departamento id:</label>
                            <input type='number' name='añadir_departamento_id'></br>
                            <label for='añadir_nombre'>Nombre:</label>
                            <input type='text' name='añadir_nombre'></br>
                            <label for='id'>Ubicacion ID:</label>
                            <select name='añadir_ubicacion_id'>";
                            $sql= "SELECT * FROM UBICACION";
                            foreach ($conn->query($sql) as $row){
                                echo "<option value='". $row["Ubicacion_ID"] ."'>". $row["Ubicacion_ID"] ."</option>";
                            }
                            echo "</select></br>
                            <span><input type='submit' name='añadir_acabado' value='Añadir cliente'></span>
                            </form>
                            <form action='' method='post'>
                            <input type='hidden' name='pagina' value='3'></input>
                            <span><input type='submit' name='volver' value='Volver'></span>
                            </form>
                            </div>";
                        }else{
                            echo"
                            <div class='menu'>
                            <form action='' method='post'>
                            <input type='hidden' name='pagina' value='3'></input>
                            <label for='id'>Id del cliente:</label>
                            <input type='number' name='editar_departamento_id' value='".$_POST['editar_departamento_id']."' readonly></br>
                            <label for='id'>Nombre:</label>
                            <input type='text' name='editar_nombre' placeholder='".$_POST['editar_nombre']."'></br>
                            <label for='id'>Ubicacion ID:</label>
                            <select name='editar_ubicacion_id'>
                                <option value='".$_POST['editar_ubicacion_id']."' selected='selected'>".$_POST['editar_ubicacion_id']."</option>";
                            $sql= "SELECT * FROM UBICACION";
                            foreach ($conn->query($sql) as $row){
                                echo "<option value='". $row["Ubicacion_ID"] ."'>". $row["Ubicacion_ID"] ."</option>";
                            }
                            echo
                            "</select></br>
                            <span><input type='submit' name='editar_acabado' value='Editar cliente'></span>
                            </form>
                            <form action='' method='post'>
                            <input type='hidden' name='pagina' value='3'></input>
                            <span><input type='submit' name='volver' value='Volver'></span>
                            </form>
                            </div>";
                        }
                    }else{
                    echo "<div><table class='alineador'>";
                    echo "<tr><th>departamento_ID</th>
                        <th>Nombre</th>
                        <th>Ubicacion_ID</th>
                        <th colspan='2'><form action='' method='post'>
                        <input type='hidden' name='pagina' value='3'></input>
                        <span><input type='submit' name='añadir' value='+' style='font-size: 40px; font-weight:25px'></span>
                        </form></th></tr>";
                    $sql= "SELECT * FROM DEPARTAMENTO";
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
                        <input type='hidden' name='editar_departamento_id' value='". $row["departamento_ID"] ."'>
                        <input type='hidden' name='editar_nombre' value='". $row["Nombre"] ."'>
                        <input type='hidden' name='editar_ubicacion_id' value='". $row["Ubicacion_ID"] ."'>
                        <span><input type='submit' name='editar' value='🖉' style='font-size: 20px; font-weight:25px'></span>
                        </form></td></tr>";
                    }
                    echo "</table></div>";
                }
                    break;

/*---------------------------------------------------------------------Tabla Ubicacion----------------------------------------------------------------------------------*/

                case 4:
                    if(isset($_POST['añadir_acabado'])){
                        try {
                            $sql ="INSERT INTO 
                                ubicacion (Ubicacion_ID, GrupoRegional) 
                                VALUES (? ,?)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(1,$_POST['añadir_ubicacion_id']);
                            $stmt->bindParam(2,$_POST['añadir_grupo_regional']);
                            $stmt->execute();
                            $mensaje = "Ubicacion insertada correctamente";
                            $archivo = fopen("log.txt", "r+b");
                            $hora = date("d/m/Y - H:i:s");
                            $texto = "El usuario: ".$_SESSION['usuario']." Hora: ".$hora." Se añadio una ubicacion";
                            fwrite($archivo, $texto);
                            fclose($archivo);
                        }catch(PDOException $e){
                            $mensaje = "Error, la ubicacion id ya se utiliza";
                        }
                    }
                    if(isset($_POST['editar_acabado'])){
                        $sql ="UPDATE ubicacion SET 
                            GrupoRegional = ?
                            WHERE Ubicacion_ID = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(1,$_POST['editar_grupo_regional']);
                            $stmt->bindParam(2,$_POST['editar_ubicacion_id']);
                            $stmt->execute();
                            $mensaje = "Ubicacion editado correctamente";
                            $archivo = fopen("log.txt", "r+b");
                            $hora = date("d/m/Y - H:i:s");
                            $texto = "El usuario: ".$_SESSION['usuario']." Hora: ".$hora." Se edito una ubicacion";
                            fwrite($archivo, $texto);
                            fclose($archivo);
                    }
                    if(isset($_POST['borrar_ubicacion'])){
                        $sql = "UPDATE DEPARTAMENTO SET Ubicacion_ID = NULL WHERE Ubicacion_ID = ?;";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1,$_POST['borrar_ubicacion']);
                        $stmt->execute();
                        $sql = "DELETE FROM UBICACION WHERE Ubicacion_ID = ?;";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1,$_POST['borrar_ubicacion']);
                        $stmt->execute();
                        $archivo = fopen("log.txt", "r+b");
                            $hora = date("d/m/Y - H:i:s");
                            $texto = "El usuario: ".$_SESSION['usuario']." Hora: ".$hora." Se borro una ubicacion";
                            fwrite($archivo, $texto);
                            fclose($archivo);
                    }
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
                                <input type='hidden' name='pagina' value='5'></input>
                                <p><input class='cell_menu' type='submit' name='botonEnviar' value='Log'></p>
                            </form>"; if($usuario == 1){
                                echo
                            "<form action='main.php' method='post'>
                                <input type='hidden' name='pagina' value='6'></input>
                                <p><input class='cell_menu' type='submit' name='botonEnviar' value='Informe'></p>
                            </form>";};
                        echo "</div>";
                    if(isset($_POST['editar']) || isset($_POST['añadir'])){
                        if(isset($_POST['añadir'])){
                            echo"
                            <div class='menu'>
                            <form action='' method='post'>
                            <input type='hidden' name='pagina' value='4'></input>
                            <label for='añadir_ubicacion_id' required>Id de ubicacion:</label>
                            <input type='number' name='añadir_ubicacion_id'></br>
                            <label for='añadir_grupo_regional'>Grupo regional:</label>
                            <input type='text' name='añadir_grupo_regional'></br>
                            <span><input type='submit' name='añadir_acabado' value='Añadir Ubicacion'></span>
                            </form>
                            <form action='' method='post'>
                            <input type='hidden' name='pagina' value='4'></input>
                            <span><input type='submit' name='volver' value='Volver'></span>
                            </form>
                            </div>";
                        }else{
                            echo"
                            <div class='menu'>
                            <form action='' method='post'>
                            <input type='hidden' name='pagina' value='4'></input>
                            <label for='id'>Id del cliente:</label>
                            <input type='number' name='editar_ubicacion_id' value='".$_POST['editar_ubicacion_id']."' readonly></br>
                            <label for='id'>Nombre:</label>
                            <input type='text' name='editar_grupo_regional' placeholder='".$_POST['editar_grupo_regional']."'></br>
                            <span><input type='submit' name='editar_acabado' value='Editar cliente'></span>
                            </form>
                            <form action='' method='post'>
                            <input type='hidden' name='pagina' value='4'></input>
                            <span><input type='submit' name='volver' value='Volver'></span>
                            </form>
                            </div>";
                        }
                    }else{
                        echo "<div><table class='alineador'>";
                        echo "<tr><th>Ubicacion_ID</th>
                            <th>GrupoRegional</th>
                            <th colspan='2'><form action='' method='post'>
                            <input type='hidden' name='pagina' value='4'></input>
                            <span><input type='submit' name='añadir' value='+' style='font-size: 40px; font-weight:25px'></span>
                            </form></th></tr>";
                        if(isset($mensaje)){
                            echo $mensaje;
                        }
                        $sql= "SELECT * FROM UBICACION";
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
                            <input type='hidden' name='editar_ubicacion_id' value='". $row["Ubicacion_ID"] ."'>
                            <input type='hidden' name='editar_grupo_regional' value='". $row["GrupoRegional"] ."'>
                            <span><input type='submit' name='editar' value='🖉' style='font-size: 20px; font-weight:25px'></span>
                            </form></td></tr>";
                        }
                        echo "</table></div>";
                    }
                    break;
/*---------------------------------------------------------------------Log----------------------------------------------------------------------------------------------*/
                case 5:
                    echo "<div class='tabla'>
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
                                <input type='hidden' name='pagina' value='4'></input>
                                <p><input class='cell_menu' type='submit' name='botonEnviar' value='Ubicacion'></p>
                            </form>
                        </div>
                        <div class='menu' >
                            <form action='main.php' method='post'>
                                <p><input class='active' type='button' name='botonEnviar' value='Log'></p>
                            </form>"; if($usuario == 1){
                                echo
                            "<form action='main.php' method='post'>
                                <input type='hidden' name='pagina' value='6'></input>
                                <p><input class='cell_menu' type='submit' name='botonEnviar' value='Informe'></p>
                            </form>";}
                        echo "</div>";
                        $fp = fopen("log.txt", "r");
                        while (!feof($fp)){
                                $linea = fgets($fp);
                                echo $linea;
                        }
                        fclose($fp);
                break;
/*---------------------------------------------------------------------Informe------------------------------------------------------------------------------------------*/
                case 6:
                    echo "<div class='tabla'>
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
                                <input type='hidden' name='pagina' value='4'></input>
                                <p><input class='cell_menu' type='submit' name='botonEnviar' value='Ubicacion'></p>
                            </form>
                        </div>
                        <div class='menu' >
                            <form action='main.php' method='post'>
                                <input type='hidden' name='pagina' value='5'></input>
                                <p><input class='cell_menu' type='submit' name='botonEnviar' value='Log'></p>
                            </form>
                            <form>
                                <p><input class='active' type='button' name='botonEnviar' value='Informe'></p>
                            </form>
                        </div>";
                 echo "<div><table class='alineador'>";
                 echo "<tr><th>Numnero de empleados</th>
                     <th>Departamento</th>
                     <th>Ubicacion</th>
                     <th>Salario maximo</th>
                     <th>Salario minimo</th>
                     <th>Media de los salarios</th></tr>";
                 if(isset($mensaje)){
                     echo $mensaje;
                 }
                 $sql = "SELECT COUNT(empleados.empleado_ID)
                        , departamento.Nombre
                        , ubicacion.GrupoRegional
                        , MAX(empleados.Salario) 
                        ,MIN(empleados.Salario) 
                        ,AVG(empleados.Salario) 
                        FROM empleados, departamento, ubicacion 
                        WHERE departamento.departamento_ID = empleados.Departamento_ID AND ubicacion.Ubicacion_ID = departamento.Ubicacion_ID 
                        GROUP BY departamento.Nombre";   
                 foreach ($conn->query($sql) as $row){
                 echo "<tr><td>".$row["0"]."</td>
                     <td>".$row["1"]."</td>
                     <td>".$row["2"]."</td>
                     <td>".$row["3"]."</td>
                     <td>".$row["4"]."</td>
                     <td>".$row["5"]."</td></tr>";
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
                            $archivo = fopen("log.txt", "r+b");
                            $hora = date("d/m/Y - H:i:s");
                            $texto = "El usuario: ".$_SESSION['usuario']." Hora: ".$hora." Se añadio un cliente";
                            fwrite($archivo, $texto);
                            fclose($archivo);
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
                            $archivo = fopen("log.txt", "r+b");
                            $hora = date("d/m/Y - H:i:s");
                            $texto = "El usuario: ".$_SESSION['usuario']." Hora: ".$hora." Se edito un cliente";
                            fwrite($archivo, $texto);
                            fclose($archivo);
                    }
                    if(isset($_POST['borrar_cliente_id'])){
                        $sql = "DELETE FROM cliente WHERE CLIENTE_ID = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1,$_POST['borrar_cliente_id']);
                        $stmt->execute();
                        $mensaje = "Cliente borrado correctamente";
                        $archivo = fopen("log.txt", "r+b");
                            $hora = date("d/m/Y - H:i:s");
                            $texto = "El usuario: ".$_SESSION['usuario']." Hora: ".$hora." Se borro un cliente";
                            fwrite($archivo, $texto);
                            fclose($archivo);
                    }
                    echo
                        "<div class='tabla'>
                            <h1>Clientes</h1>
                        </div>
                        <div class='menu'>
                            <form> 
                                <p><input class='active' type='button' name='botonEnviar' value='Clientes'></p>
                            </form>";
                            if($usuario == 1 || $usuario == 2){
                                echo "
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
                                <input type='hidden' name='pagina' value='5'></input>
                                <p><input class='cell_menu' type='submit' name='botonEnviar' value='Log'></p>
                            </form>";
                            if($usuario == 1){
                            echo "<form action='main.php' method='post'>
                                <input type='hidden' name='pagina' value='6'></input>
                                <p><input class='cell_menu' type='submit' name='botonEnviar' value='Informe'></p>
                            </form>";}}
                        echo "</div>";
                    if(isset($_POST['editar']) || isset($_POST['añadir'])){
                        if(isset($_POST['añadir'])){
                            echo"
                            <form action='' method='post'>
                            <input type='hidden' name='pagina' value='0' ></input>
                            <label for='añadir_cliente_id' required>Id del cliente:</label>
                            <input type='number' name='añadir_cliente_id' max='6'></br>
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
                            <input type='number' name='añadir_cliente_codigo_area' max='3'></br>
                            <label for='añadir_cliente_telefono' max='7'>Telefono:</label>
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