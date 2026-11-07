<?php

include("conexion.php");

$mensaje = "";
$tipo_mensaje = "";


// ==================================================
// OBTENER EL PRODUCTO
// ==================================================

if (!isset($_GET["id"])) {

    die("Producto no especificado.");

}

$id = $_GET["id"];

$sql = "SELECT * FROM productos WHERE id = ?";

$stmt = $conexion->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {

    die("El producto no existe.");

}

$producto = $resultado->fetch_assoc();

$stmt->close();


// ==================================================
// ACTUALIZAR EL PRODUCTO
// ==================================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $cantidad = $_POST["cantidad"];
    $precio = $_POST["precio"];
    $categoria = $_POST["categoria"];
    $ubicacion = $_POST["ubicacion"];


    $sql = "UPDATE productos SET
            nombre = ?,
            descripcion = ?,
            cantidad = ?,
            precio = ?,
            categoria = ?,
            ubicacion = ?
            WHERE id = ?";


    $stmt = $conexion->prepare($sql);


    $stmt->bind_param(
        "ssidssi",
        $nombre,
        $descripcion,
        $cantidad,
        $precio,
        $categoria,
        $ubicacion,
        $id
    );


    if ($stmt->execute()) {

        $mensaje = "Producto actualizado correctamente.";
        $tipo_mensaje = "exito";

        // Actualizamos los datos que se muestran en el formulario
        $producto["nombre"] = $nombre;
        $producto["descripcion"] = $descripcion;
        $producto["cantidad"] = $cantidad;
        $producto["precio"] = $precio;
        $producto["categoria"] = $categoria;
        $producto["ubicacion"] = $ubicacion;

    } else {

        $mensaje = "Error al actualizar el producto: " . $stmt->error;
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

    <title>Editar producto - RZ Inventarios</title>

    <link rel="stylesheet" href="estilos.css?v=8">

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


        <!-- TÍTULO -->

        <div class="titulo-agregar">

            <div>

                <h1>Editar producto</h1>

                <p>
                    Modifica la información del producto seleccionado.
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
                    Actualiza los datos que deseas modificar.
                </p>

            </div>



            <div class="formulario-contenido">


                <form method="POST" class="formulario-producto">


                    <!-- NOMBRE -->

                    <div class="campo">

                        <label>Nombre del producto</label>

                        <input
                            type="text"
                            name="nombre"
                            value="<?php echo htmlspecialchars($producto["nombre"]); ?>"
                            required
                        >

                    </div>



                    <!-- CATEGORÍA -->

                    <div class="campo">

                        <label>Categoría</label>

                        <input
                            type="text"
                            name="categoria"
                            value="<?php echo htmlspecialchars($producto["categoria"]); ?>"
                        >

                    </div>



                    <!-- CANTIDAD -->

                    <div class="campo">

                        <label>Cantidad</label>

                        <input
                            type="number"
                            name="cantidad"
                            min="0"
                            value="<?php echo htmlspecialchars($producto["cantidad"]); ?>"
                            required
                        >

                    </div>



                    <!-- PRECIO -->

                    <div class="campo">

                        <label>Precio</label>

                        <input
                            type="number"
                            name="precio"
                            min="0"
                            step="0.01"
                            value="<?php echo htmlspecialchars($producto["precio"]); ?>"
                            required
                        >

                    </div>



                    <!-- UBICACIÓN -->

                    <div class="campo campo-completo">

                        <label>Ubicación</label>

                        <input
                            type="text"
                            name="ubicacion"
                            value="<?php echo htmlspecialchars($producto["ubicacion"]); ?>"
                        >

                    </div>



                    <!-- DESCRIPCIÓN -->

                    <div class="campo campo-completo">

                        <label>Descripción</label>

                        <textarea
                            name="descripcion"
                        ><?php echo htmlspecialchars($producto["descripcion"]); ?></textarea>

                    </div>



                    <!-- BOTONES -->

                    <div class="acciones-formulario">

                        <a
                            href="index.php"
                            class="boton-cancelar"
                        >
                            Cancelar
                        </a>


                        <button
                            type="submit"
                            class="boton-guardar"
                        >
                            Guardar cambios
                        </button>

                    </div>


                </form>


            </div>


        </section>


    </main>


</body>

</html>