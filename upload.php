<?php
session_start();

$message = '';
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload') { // Si se ha pulsado el botón de subir
  if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) { // Si el archivo existe y no hay errores
    // get details of the uploaded file
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name']; // Ruta temporal del archivo
    $fileName = $_FILES['uploadedFile']['name'];  // Nombre del archivo
    $fileSize = $_FILES['uploadedFile']['size'];  // Tamaño del archivo
    $fileType = $_FILES['uploadedFile']['type'];  // Tipo del archivo
    $fileNameCmps = explode(".", $fileName);  // Separa el nombre del archivo en un array
    $fileExtension = strtolower(end($fileNameCmps));  // Obtiene la extensión del archivo

    // sanitize file-name
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;  // Crea un nuevo nombre para el archivo. md5 es una función de hash que devuelve un string de 32 caracteres con el hash del string que le pasamos como parámetro.

    // check if file has one of the following extensions
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');  // Extensiones permitidas

    if (in_array($fileExtension, $allowedfileExtensions)) { // Si la extensión del archivo está en el array de extensiones permitidas
      // directory in which the uploaded file will be moved
      $uploadFileDir = './uploaded_files/'; // Directorio donde se subirá el archivo
      $dest_path = $uploadFileDir . $newFileName; // Ruta del archivo

      if (move_uploaded_file($fileTmpPath, $dest_path)) { // Si se ha podido mover el archivo a la ruta de destino
        $message = 'File is successfully uploaded.';  // Mensaje de éxito
      } else {
        $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';  // Mensaje de error
      }
    } else {
      $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);  // Mensaje de error. implode devuelve las extensiones de los archivos permitidos separadas por comas.
    }
  } else {
    $message = 'There is some error in the file upload. Please check the following error.<br>'; // Mensaje de error
    $message .= 'Error:' . $_FILES['uploadedFile']['error'];  // Mensaje de error
  }
}
$_SESSION['message'] = $message;  // Guarda el mensaje en la sesión
header("Location: index.php");  // Redirige a index.php
