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
    <div class="navigationBar">
        <h1>PUFOSA S.L.</h1>
    </div>
    <form action="main.php" method="post">
        <label for="id">Id:</label>
        <input type="text" name="id" required></input>
        <label for="password">Contraseña:</label>
        <input type="text" name="password" required></input>
        <p><input type="submit" name="botonEnviar" value="Ingersar"></p>
    </form>
</body>
</html>