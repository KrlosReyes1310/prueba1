<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Pedidos</title>
</head>
<body>
    <center><h1>Lista de Pedidos</h1></center>
    <center><h3><a href="index.php">Regresar al Menu</a></h3></center>
    <center><h3><a href="crear_pedido.php">Solicitar Pedido</a></h3></center>
    <!-- Formulario para Filtrar -->
    <form method="GET">
        <label for="cedula_cliente">Filtrar por Cédula:</label>
        <input type="text" id="cedula_cliente" name="cedula_cliente" placeholder="Ingrese cédula">
        
        <label for="valor_final">Filtrar por Valor Final:</label>
        <input type="number" id="valor_final" name="valor_final" placeholder="Ingrese valor final">
        
        <label for="ordenar">Ordenar por Valor Final:</label>
        <select id="ordenar" name="ordenar">
            <option value="asc">Menor a Mayor</option>
            <option value="desc">Mayor a Menor</option>
        </select>
        
        <input type="submit" value="Filtrar">
    </form>

    <table border="1">
        <tr><center>
            <th>Número de Pedido</th>
            <th>Cédula del Cliente</th>
            <th>Cantidad Tacos</th>
            <th>Cantidad Agua</th>
            <th>Total</th>
            <th>Foto</th>
            <th>Acciones</th>
            </center>
        </tr>
        <?php
        $pedidos = file('pedidos.txt', FILE_IGNORE_NEW_LINES);
        $filtros = [];

        // Recoger filtros
        if (isset($_GET['cedula_cliente']) && $_GET['cedula_cliente'] !== '') {
            $filtros['cedula_cliente'] = $_GET['cedula_cliente'];
        }
        if (isset($_GET['valor_final']) && $_GET['valor_final'] !== '') {
            $filtros['valor_final'] = floatval($_GET['valor_final']);
        }
        $ordenar = isset($_GET['ordenar']) ? $_GET['ordenar'] : 'asc';

        // Filtrar pedidos
        $resultados = [];
        foreach ($pedidos as $pedido) {
            list($numero_pedido, $cedula_cliente, $cantidad_tacos, $cantidad_agua, $total, $foto_cliente) = explode('|', $pedido);
            $total = floatval($total);

            if (isset($filtros['cedula_cliente']) && $cedula_cliente !== $filtros['cedula_cliente']) {
                continue;
            }
            if (isset($filtros['valor_final']) && $total != $filtros['valor_final']) {
                continue;
            }
            $resultados[] = [$numero_pedido, $cedula_cliente, $cantidad_tacos, $cantidad_agua, $total, $foto_cliente];
        }

        // Ordenar resultados
        usort($resultados, function($a, $b) use ($ordenar) {
            return $ordenar === 'asc' ? $a[4] <=> $b[4] : $b[4] <=> $a[4];
        });

        // Mostrar resultados
        foreach ($resultados as $pedido) {
            echo "<tr>
                    <td>{$pedido[0]}</td>
                    <td>{$pedido[1]}</td>
                    <td>{$pedido[2]}</td>
                    <td>{$pedido[3]}</td>
                    <td>{$pedido[4]}</td>   
                    <td><img src='imagenes/{$pedido[5]}' width='100' /></td>
                    <td><a href='eliminar_pedido.php?numero_pedido={$pedido[0]}'>Eliminar</a></td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>