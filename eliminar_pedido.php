<?php
$numero_pedido = $_GET['numero_pedido'];
$pedidos = file('pedidos.txt', FILE_IGNORE_NEW_LINES);
$filtrado = [];

foreach ($pedidos as $pedido) {
    if (strpos($pedido, $numero_pedido) === false) {
        $filtrado[] = $pedido;
    }
}

// Guardar pedidos filtrados
file_put_contents('pedidos.txt', implode("\n", $filtrado));

header("Location: listar_pedidos.php");
exit();
?>