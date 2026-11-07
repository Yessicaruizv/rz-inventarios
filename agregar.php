<?php

include("conexion.php");

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $cantidad = $_POST["cantidad"];
    $precio = $_POST["precio"];
    $categoria = $_POST["categoria"];
    $ubicacion = $_POST["ubicacion"];

    $sql = "INSERT INTO productos 
            (nombre, descripcion, cantidad, precio, categoria, ubicacion, fecha_registro)
            VALUES (?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param(
        "ssidss",
        $nombre,
        $descripcion,
        $cantidad,
        $precio,
        $categoria,
        $ubicacion
    );
    
    echo "Llegué a ejecutar el guardado";

    if ($stmt->execute()) {

        $mensaje = "Producto agregado correctamente.";
        $tipo_mensaje = "exito";

    } else {

        $mensaje = "Error al agregar el producto: " . $stmt->error;
        $tipo_mensaje = "error";

    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Agregar producto - RZ Inventarios</title>

    <link rel="stylesheet" href="estilos.css?v=7">

</head>


<body class="pagina-agregar">


    <!-- ENCABEZADO -->

    <header class="header-agregar">

        <div class="logo-agregar">

            <div class="logo-icono-agregar">
                RZ
            </div>

            <div>
                <strong>RZ Inventarios</strong>
                <span>Gestión de inventarios</span>
            </div>

        </div>


        <a href="index.php" class="volver-superior">
            ← Volver al inventario
        </a>

    </header>



    <!-- CONTENIDO -->

    <main class="contenido-agregar">


        <div class="titulo-agregar">

            <div>

                <h1>Agregar producto</h1>

                <p>
                    Registra un nuevo producto en el inventario.
                </p>

            </div>

        </div>



        <!-- MENSAJE -->

        <?php if ($mensaje != ""): ?>

            <div class="mensaje-agregar <?php echo $tipo_mensaje; ?>">

                <?php echo $mensaje; ?>

            </div>

        <?php endif; ?>



        <!-- FORMULARIO -->

        <section class="panel-agregar">


            <div class="panel-agregar-encabezado">

                <h2>Información del producto</h2>

                <p>
                    Completa los datos del producto que deseas registrar.
                </p>

            </div>



            <div class="formulario-contenido">


                <form method="POST" class="formulario-producto">


                    <!-- FILA 1 -->

                    <div class="campo">

                        <label>Nombre del producto</label>

                        <input
                            type="text"
                            name="nombre"
                            placeholder="Ej. Taladro eléctrico"
                            required
                        >

                    </div>


                    <div class="campo">

                        <label>Categoría</label>

                        <input
                            type="text"
                            name="categoria"
                            placeholder="Ej. Herramientas"
                        >

                    </div>



                    <!-- FILA 2 -->

                    <div class="campo">

                        <label>Cantidad</label>

                        <input
                            type="number"
                            name="cantidad"
                            min="0"
                            placeholder="Ej. 5"
                            required
                        >

                    </div>


                    <div class="campo">

                        <label>Precio</label>

                        <input
                            type="number"
                            name="precio"
                            min="0"
                            step="0.01"
                            placeholder="Ej. 25000"
                            required
                        >

                    </div>



                    <!-- UBICACIÓN -->

                    <div class="campo campo-completo">

                        <label>Ubicación</label>

                        <input
                            type="text"
                            name="ubicacion"
                            placeholder="Ej. Bodega principal"
                        >

                    </div>



                    <!-- DESCRIPCIÓN -->

                    <div class="campo campo-completo">

                        <label>Descripción</label>

                        <textarea
                            name="descripcion"
                            placeholder="Describe brevemente el producto..."
                        ></textarea>

                    </div>



                    <!-- ACCIONES -->

                    <div class="acciones-formulario">

                        <a href="index.php" class="boton-cancelar">
                            Cancelar
                        </a>

                        <button type="submit" class="boton-guardar">
                            Guardar producto
                        </button>

                    </div>


                </form>


            </div>


        </section>


    </main>


</body>

</html>