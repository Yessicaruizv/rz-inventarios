
<?php

include("conexion.php");

// INDICADORES GENERALES

$sql = "SELECT
        COUNT(*) AS total_productos,
        SUM(CASE WHEN cantidad > 0 THEN 1 ELSE 0 END) AS disponibles,
        SUM(CASE WHEN cantidad = 0 THEN 1 ELSE 0 END) AS agotados,
        SUM(cantidad * precio) AS valor_total
        FROM productos";

$resultado = $conexion->query($sql);
$datos = $resultado->fetch_assoc();

$total_productos = $datos["total_productos"] ?? 0;
$disponibles = $datos["disponibles"] ?? 0;
$agotados = $datos["agotados"] ?? 0;
$valor_total = $datos["valor_total"] ?? 0;

// RESUMEN POR CATEGORÍA

$sql_categorias = "SELECT
                   categoria,
                   COUNT(*) AS productos,
                   SUM(cantidad) AS unidades,
                   SUM(cantidad * precio) AS valor
                   FROM productos
                   GROUP BY categoria
                   ORDER BY valor DESC";

$categorias = $conexion->query($sql_categorias);

// LISTADO DE PRODUCTOS

$sql_productos = "SELECT *,
                  (cantidad * precio) AS valor_total
                  FROM productos
                  ORDER BY nombre ASC";

$productos = $conexion->query($sql_productos);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reportes - RZ Inventarios</title>

    <link rel="stylesheet" href="estilos.css?v=12">

    <style>

        .reporte-acciones {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 25px;
        }

        .boton-imprimir {
            background: #7138b8;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .reporte-indicadores {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 25px;
        }

        .reporte-card {
            background: white;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.05);
        }

        .reporte-card span {
            color: #777;
            font-size: 13px;
        }

        .reporte-card strong {
            display: block;
            font-size: 25px;
            color: #7138b8;
            margin-top: 10px;
        }

        .reporte-panel {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.05);
        }

        .reporte-panel h2 {
            margin-top: 0;
            color: #302344;
        }

        .tabla-reporte {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-reporte th,
        .tabla-reporte td {
            padding: 13px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .tabla-reporte th {
            color: #7138b8;
            font-size: 12px;
        }

        .valor {
            font-weight: bold;
            color: #7138b8;
        }

        .estado-disponible {
            color: #16834b;
            font-weight: bold;
        }

        .estado-agotado {
            color: #d13d3d;
            font-weight: bold;
        }

        @media(max-width: 800px) {
            .reporte-indicadores {
                grid-template-columns: repeat(2, 1fr);
            }

            .tabla-contenedor {
                overflow-x: auto;
            }
        }

        @media print {
            .menu-lateral,
            .barra-superior,
            .reporte-acciones,
            .volver-inicio {
                display: none !important;
            }

            .estructura {
                display: block;
            }

            .contenido {
                width: 100%;
                padding: 10px;
            }

            .reporte-panel,
            .reporte-card {
                box-shadow: none;
                border: 1px solid #ddd;
                break-inside: avoid;
            }
        }

    </style>

</head>

<body>

<header class="barra-superior">

    <div class="logo">
        <div class="logo-icono">RZ</div>

        <div>
            <strong>RZ Inventarios</strong>
            <span>Gestión de inventarios</span>
        </div>
    </div>

    <div class="usuario">
        <div class="usuario-icono">U</div>

        <div>
            <strong>Administrador</strong>
            <span>Usuario del sistema</span>
        </div>
    </div>

</header>


<div class="estructura">

    <aside class="menu-lateral">

        <p class="titulo-menu">MENÚ PRINCIPAL</p>

        <a href="index.php" class="menu-item">
            <span class="menu-icono">⌂</span>
            <span>Inicio</span>
        </a>

        <a href="index.php" class="menu-item">
            <span class="menu-icono">▣</span>
            <span>Inventario</span>
        </a>

        <a href="agregar.php" class="menu-item">
            <span class="menu-icono">＋</span>
            <span>Agregar producto</span>
        </a>

        <p class="titulo-menu seccion">GESTIÓN</p>

        <a href="reportes.php" class="menu-item activo">
            <span class="menu-icono">▤</span>
            <span>Reportes</span>
        </a>

        <a href="#" class="menu-item">
            <span class="menu-icono">⚙</span>
            <span>Configuración</span>
        </a>

    </aside>


    <main class="contenido">

        <div class="encabezado-pagina">

            <div>
                <h1>Reportes de inventario</h1>

                <p>
                    Consulta el estado y valor de los productos registrados.
                </p>
            </div>

        </div>


        <div class="reporte-acciones">

            <button class="boton-imprimir" onclick="window.print()">
                🖨 Imprimir reporte
            </button>

        </div>


        <!-- INDICADORES -->

        <div class="reporte-indicadores">

            <div class="reporte-card">
                <span>Total de productos</span>
                <strong><?php echo $total_productos; ?></strong>
            </div>

            <div class="reporte-card">
                <span>Productos disponibles</span>
                <strong><?php echo $disponibles; ?></strong>
            </div>

            <div class="reporte-card">
                <span>Productos agotados</span>
                <strong><?php echo $agotados; ?></strong>
            </div>

            <div class="reporte-card">
                <span>Valor del inventario</span>
                <strong>
                    $<?php echo number_format($valor_total, 0, ',', '.'); ?>
                </strong>
            </div>

        </div>


        <!-- CATEGORÍAS -->

        <section class="reporte-panel">

            <h2>Resumen por categorías</h2>

            <p>Distribución de los productos registrados.</p>

            <div class="tabla-contenedor">

                <table class="tabla-reporte">

                    <thead>
                        <tr>
                            <th>CATEGORÍA</th>
                            <th>PRODUCTOS</th>
                            <th>UNIDADES</th>
                            <th>VALOR TOTAL</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if ($categorias && $categorias->num_rows > 0): ?>

                        <?php while ($cat = $categorias->fetch_assoc()): ?>

                            <tr>
                                <td>
                                    <?php echo htmlspecialchars($cat["categoria"] ?? "Sin categoría"); ?>
                                </td>

                                <td><?php echo $cat["productos"]; ?></td>

                                <td><?php echo $cat["unidades"] ?? 0; ?></td>

                                <td class="valor">
                                    $<?php echo number_format($cat["valor"] ?? 0, 0, ',', '.'); ?>
                                </td>
                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="4">No hay categorías registradas.</td>
                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </section>


        <!-- DETALLE DE PRODUCTOS -->

        <section class="reporte-panel">

            <h2>Detalle del inventario</h2>

            <p>Valor individual de los productos registrados.</p>

            <div class="tabla-contenedor">

                <table class="tabla-reporte">

                    <thead>
                        <tr>
                            <th>PRODUCTO</th>
                            <th>CATEGORÍA</th>
                            <th>CANTIDAD</th>
                            <th>PRECIO UNITARIO</th>
                            <th>VALOR TOTAL</th>
                            <th>ESTADO</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if ($productos && $productos->num_rows > 0): ?>

                        <?php while ($producto = $productos->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?php echo htmlspecialchars($producto["nombre"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($producto["categoria"] ?? ""); ?>
                                </td>

                                <td><?php echo $producto["cantidad"]; ?></td>

                                <td>
                                    $<?php echo number_format($producto["precio"], 0, ',', '.'); ?>
                                </td>

                                <td class="valor">
                                    $<?php echo number_format($producto["valor_total"], 0, ',', '.'); ?>
                                </td>

                                <td>

                                    <?php if ($producto["cantidad"] > 0): ?>

                                        <span class="estado-disponible">
                                            Disponible
                                        </span>

                                    <?php else: ?>

                                        <span class="estado-agotado">
                                            Agotado
                                        </span>

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="6">No hay productos registrados.</td>
                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </section>

        <a href="index.php" class="volver-inicio">
            ← Volver al inventario
        </a>

    </main>

</div>

</body>
</html>
