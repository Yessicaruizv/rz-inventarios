<?php

include("conexion.php");

$resultado = $conexion->query("SELECT * FROM productos");

$sql_total = "SELECT SUM(cantidad * precio) AS total_inventario FROM productos";
$resultado_total = $conexion->query($sql_total);

$fila_total = $resultado_total->fetch_assoc();

$total_inventario = $fila_total["total_inventario"] ?? 0;

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RZ Inventarios</title>

    <link rel="stylesheet" href="estilos.css?v=11">

</head>


<body>


<!-- BARRA SUPERIOR -->

<header class="barra-superior">

    <div class="logo">

        <div class="logo-icono">
            RZ
        </div>

        <div>
            <strong>RZ Inventarios</strong>
            <span>Gestión de inventarios</span>
        </div>

    </div>


    <div class="usuario">

        <div class="usuario-icono">
            U
        </div>

        <div>
            <strong>Administrador</strong>
            <span>Usuario del sistema</span>
        </div>

    </div>

</header>



<!-- ESTRUCTURA PRINCIPAL -->

<div class="estructura">


    <!-- MENÚ LATERAL -->

    <aside class="menu-lateral">

        <p class="titulo-menu">
            MENÚ PRINCIPAL
        </p>


        <a href="index.php" class="menu-item activo">

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


        <p class="titulo-menu seccion">

            GESTIÓN

        </p>


        <a href="reportes.php" class="menu-item">

            <span class="menu-icono">▤</span>

            <span>Reportes</span>

        </a>


        <a href="#" class="menu-item">

            <span class="menu-icono">⚙</span>

            <span>Configuración</span>

        </a>

    </aside>



    <!-- CONTENIDO -->

    <main class="contenido">


        <div class="encabezado-pagina">

            <div>

                <h1>Inventario</h1>

                <p>
                    Consulta y administra los productos registrados en el sistema.
                </p>

            </div>


            <a href="agregar.php" class="boton-principal">

                <span>＋</span>

                Agregar producto

            </a>

        </div>



        <!-- INDICADORES -->

        <div class="indicadores">


            <div class="indicador">

                <div class="indicador-icono">
                    📦
                </div>

                <div>

                    <span class="indicador-titulo">
                        Productos registrados
                    </span>

                    <strong>
                        <?php echo $resultado->num_rows; ?>
                    </strong>

                </div>

            </div>


            <div class="indicador">

                <div class="indicador-icono">
                    ✓
                </div>

                <div>

                    <span class="indicador-titulo">
                        Inventario activo
                    </span>

                    <strong>
                        <?php echo $resultado->num_rows; ?>
                    </strong>

                </div>

            </div>


            <div class="indicador">

    <div class="indicador-icono">
        $
    </div>

    <div>

        <span class="indicador-titulo">
            Valor del inventario
        </span>

        <strong class="texto-activo">
            $<?php echo number_format($total_inventario, 0, ',', '.'); ?>
        </strong>

    </div>

</div>


</div>


        <!-- TABLA -->

        <section class="panel">


            <div class="panel-encabezado">

                <div>

                    <h2>Productos registrados</h2>

                    <p>
                        Listado de productos disponibles en el inventario.
                    </p>

                </div>


            </div>



            <?php if ($resultado->num_rows > 0): ?>


                <div class="tabla-contenedor">

                    <table>


                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>PRODUCTO</th>

                                <th>DESCRIPCIÓN</th>

                                <th>CANTIDAD</th>

                                <th>PRECIO</th>

                                <th>CATEGORÍA</th>

                                <th>UBICACIÓN</th>

                                <th>ACCIONES</th>

                            </tr>

                        </thead>


                        <tbody>


                            <?php while ($producto = $resultado->fetch_assoc()): ?>


                                <tr>


                                    <td class="id-producto">

                                        <?php echo $producto["id"]; ?>

                                    </td>


                                    <td>

                                        <strong class="nombre-producto">

                                            <?php echo $producto["nombre"]; ?>

                                        </strong>

                                    </td>


                                    <td class="descripcion">

                                        <?php echo $producto["descripcion"]; ?>

                                    </td>


                                    <td>

                                        <span class="cantidad">

                                            <?php echo $producto["cantidad"]; ?>

                                        </span>

                                    </td>


                                    <td class="precio">

                                        $<?php echo number_format(
                                            $producto["precio"],
                                            0,
                                            ",",
                                            "."
                                        ); ?>

                                    </td>


                                    <td>

                                        <span class="categoria">

                                            <?php echo $producto["categoria"]; ?>

                                        </span>

                                    </td>


                                    <td>

    <?php echo $producto["ubicacion"]; ?>

</td>

<td class="acciones">

    <a
        href="editar.php?id=<?php echo $producto["id"]; ?>"
        class="boton-editar"
    >
        ✏️ Editar
    </a>

    <a
        href="eliminar.php?id=<?php echo $producto["id"]; ?>"
        class="boton-eliminar"
        onclick="return confirm('¿Está seguro de eliminar este producto?');"
    >
        🗑️ Eliminar
    </a>

</td>
                                    


                                </tr>


                            <?php endwhile; ?>


                        </tbody>


                    </table>

                </div>


            <?php else: ?>


                <div class="inventario-vacio">

                    <div class="vacio-icono">
                        📦
                    </div>

                    <h3>No hay productos registrados</h3>

                    <p>
                        Comienza agregando el primer producto al inventario.
                    </p>

                    <a href="agregar.php" class="boton-principal">
                        ＋ Agregar producto
                    </a>

                </div>


            <?php endif; ?>


        </section>


    </main>


</div>


</body>

</html>