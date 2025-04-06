<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Pedido</title>
</head>
<body>
    <center><h1>SOLICITAR NUEVO PEDIDO</h1><h3><a href="index.php">Regresar al menu</a></h3><h3><a href="listar_pedidos.php">Listar Pedidos</a></h3></CENter>
    <form method="post" enctype="multipart/form-data">
        <label for="cedula_cliente">Cédula del Cliente:</label>
        <input type="text" name="cedula_cliente" required><br>

        <label for="cantidad_tacos">Cantidad de Tacos al Pastor:</label>

        <input type="number" name="cantidad_tacos" min="0" required><br>


        <label for="cantidad_agua">Cantidad de Agua de Jamaica:</label>

        <input type="number" name="cantidad_agua" min="0" required><br>


        <label for="foto_cliente">Foto del Cliente:</label>
        <input type="file" name="foto_cliente" accept="image/*" required><br>


        <input type="submit" value="Crear Pedido">

    </form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_pedido = uniqid();
    $cedula_cliente = $_POST['cedula_cliente'];
    $cantidad_tacos = $_POST['cantidad_tacos'];
    $cantidad_agua = $_POST['cantidad_agua'];
    $foto_cliente = $_FILES['foto_cliente']['name'];

    // Calcular precio total
    $precio_tacos = 2000 * $cantidad_tacos;
    $precio_agua = 6000 * $cantidad_agua;
    $total = $precio_tacos + $precio_agua;

    // Guardar la imagen
    move_uploaded_file($_FILES['foto_cliente']['tmp_name'], 'imagenes/' . $foto_cliente);

    // Guardar pedido en un archivo
    $pedido = "$numero_pedido|$cedula_cliente|$cantidad_tacos|$cantidad_agua|$total|$foto_cliente
";
    file_put_contents('pedidos.txt', $pedido, FILE_APPEND);

    echo "Pedido creado con éxito. Número de pedido: $numero_pedido";
}
?>