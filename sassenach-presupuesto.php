<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    // Obtener la información de la imagen
    $imagen_nombre = $_FILES['imagen']['name'];
    $imagen_tipo = $_FILES['imagen']['type'];
    $imagen_tamano = $_FILES['imagen']['size'];
    $imagen_temp = $_FILES['imagen']['tmp_name'];

    // Crear una cadena con los datos del formulario y la información de la imagen
    $contenido = "Nombre: $nombre\nEmail: $email\nMensaje: $mensaje\n";

    // Ruta donde se guardará la imagen
    $ruta_imagen = "datos/" . $imagen_nombre;

    // Mover la imagen de la ubicación temporal al directorio deseado
    if (move_uploaded_file($imagen_temp, $ruta_imagen)) {
        $contenido .= "Imagen: $ruta_imagen";
    } else {
        $contenido .= "Imagen: (no se pudo subir la imagen)";
    }

    // Crea el archivo .txt
    $archivo = fopen("datos/$email.txt", "w");
    fwrite($archivo, $contenido);
    fclose($archivo);

    // Establece parámetros para el correo electrónico
    $to = $email; // Usamos el correo proporcionado en el formulario
    $subject = 'Presupuesto de Sassenach Cosplays'; // Asunto del correo
    $message = $contenido; // Utilizamos la variable $contenido que ya contiene los datos del formulario

    $headers = 'From: antonelagreco@gmail.com' . "\r\n" .
        'Reply-To: contacto@sassenach.cosplays.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    // Envía el correo electrónico
    if (mail($to, $subject, $message, $headers)) {
        // Redireccionar a una página de agradecimiento si el correo se envió correctamente
        header("Location: gracias.html");
        exit;
    } else {
        // Redireccionar a una página de error si hubo algún problema al enviar el correo
        header("Location: error.html");
        exit;
    }
}
?>
