<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>PHP File Upload</title>
</head>
<body>
  <?php
    if (isset($_SESSION['message']) && $_SESSION['message']) {  // Si el mensaje existe y no está vacío
      printf('<b>%s</b>', $_SESSION['message']);  // Imprime el mensaje
      unset($_SESSION['message']);  // Elimina el mensaje
    }
  ?>
  <form method="POST" action="upload.php" enctype="multipart/form-data">
    <div>
      <span>Upload a File:</span>
      <input type="file" name="uploadedFile" />
    </div>

    <input type="submit" name="uploadBtn" value="Upload" />
  </form>
</body>
</html>

