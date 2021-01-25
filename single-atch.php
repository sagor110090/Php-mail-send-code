<form id="mensajenuevo" method="post" action="mensaje-box.php" enctype="multipart/form-data">
            <input type="hidden" id="idUserMsj" name="idUserMsj" value="<?php print $_SESSION['id'];?>">
            <label>Asunto</label><br>
            <input class="input-mensajes" type="text" id="asuntoMsj" name="asuntoMsj"><br>
            <label>Mensaje</label><br>
            <textarea class="textarea-mensajes" id="mensajeMsj" name="mensajeMsj"></textarea><br>
            <label>File</label><br>
            <input type="file" class="input-mensajes" name="uploadfile"><br><br>
            <input class="btn-mensajes" type="submit" id="enviarMensaje" name="send_submit" value="ENVIAR">
          </form>


<?php


 
if (isset($_POST["send_submit"])) {

    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "image/" . $filename;
  
    if (move_uploaded_file($tempname, $folder)) {
        $msg = "Image uploaded successfully";
    } else {
        $msg = "Failed to upload image";
    }
   
  // Recipient
    $to1 = 'ventas@glama.com.mx';
    $to2 = 'productosglama@gmail.com';
    $to3 = 'fernandomagmar@gmail.com';
    $to4 = 'daniel.villena@wisewsisolutions.com';
    $to5 = 'ingrid@wisewsisolutions.com'; 
  
   
  
  // Sender
    $from = 'info@glama.com.mx';
    $fromName = 'GLAMA message system';
  
  // Email subject
    $subject = 'GLAMA message system';
  
  // Attachment file
    $file = $folder;
  
  // Email body content
    $htmlContent = '
    <h3>GLAMA message system</h3>
    <p>Affair : ' . $_POST['asuntoMsj'] . '</p>
    <p>Mensaje : ' . $_POST['mensajeMsj'] . '</p>
  ';
  
  // Header for sender info
    $headers = "From: $fromName" . " <" . $from . ">";
  
  // Boundary
    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
  
  // Headers for attachment
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
  
  // Multipart boundary
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";
  
  // Preparing attachment
    if (!empty($file) > 0) {
        if (is_file($file)) {
            $message .= "--{$mime_boundary}\n";
            $fp = @fopen($file, "rb");
            $data = @fread($fp, filesize($file));
  
            @fclose($fp);
            $data = chunk_split(base64_encode($data));
            $message .= "Content-Type: application/octet-stream; name=\"" . basename($file) . "\"\n" .
            "Content-Description: " . basename($file) . "\n" .
            "Content-Disposition: attachment;\n" . " filename=\"" . basename($file) . "\"; size=" . filesize($file) . ";\n" .
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        }
    }
    $message .= "--{$mime_boundary}--";
    $returnpath = "-f" . $from;
  
  // Send email
    $mail = @mail($to1, $subject, $message, $headers, $returnpath);
    $mail = @mail($to2, $subject, $message, $headers, $returnpath);
    $mail = @mail($to3, $subject, $message, $headers, $returnpath);
    $mail = @mail($to4, $subject, $message, $headers, $returnpath);
    $mail = @mail($to5, $subject, $message, $headers, $returnpath); 
  // Email sending status
    echo $mail ? "<h1>Email Sent Successfully!</h1>" : "<h1>Email sending failed.</h1>";
  
  }