<?php

include("conexion.php");

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $sql = "DELETE FROM productos WHERE id = ?";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        header("Location: index.php");
        exit;

    } else {

        echo "Error al eliminar el producto: " . $stmt->error;

    }

    $stmt->close();
}

?>