<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail</title>
</head>
<body>
        <form id="mensajenuevo" method="post" action="mail.php" enctype="multipart/form-data">
            <input type="hidden" id="idUserMsj" name="idUserMsj" value="<?php print $_SESSION['id'];?>">
            <label>Asunto</label><br>
            <input class="input-mensajes" type="text" id="asuntoMsj" name="asuntoMsj"><br>
            <label>Mensaje</label><br>
            <textarea class="textarea-mensajes" id="mensajeMsj" name="mensajeMsj"></textarea><br>
            <label>File</label><br>
            <input type="file" class="input-mensajes" name="uploadfile1" multiple ><br><br>
            <input type="file" class="input-mensajes" name="uploadfile2" multiple ><br><br>
            <input type="file" class="input-mensajes" name="uploadfile3" multiple ><br><br>
            <input type="file" class="input-mensajes" name="uploadfile4" multiple ><br><br>
            <input type="file" class="input-mensajes" name="uploadfile5" multiple ><br><br>
            <input class="btn-mensajes" type="submit" id="enviarMensaje" name="submit" value="ENVIAR">
          </form>
   
</body>
</html>



<?php

function multi_attach_mail($to, $subject, $message, $senderEmail, $senderName, $files = array()){ 
 
    $from = $senderName." <".$senderEmail.">";  
    $headers = "From: $from"; 
 
    // Boundary  
    $semi_rand = md5(time());  
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
 
    // Headers for attachment  
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";  
 
    // Multipart boundary  
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . 
    "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";  
 
    // Preparing attachment 
    if(!empty($files)){ 
        for($i=0;$i<count($files);$i++){ 
            if(is_file($files[$i])){ 
                $file_name = basename($files[$i]); 
                $file_size = filesize($files[$i]); 
                 
                $message .= "--{$mime_boundary}\n"; 
                $fp =    @fopen($files[$i], "rb"); 
                $data =  @fread($fp, $file_size); 
                @fclose($fp); 
                $data = chunk_split(base64_encode($data)); 
                $message .= "Content-Type: application/octet-stream; name=\"".$file_name."\"\n" .  
                "Content-Description: ".$file_name."\n" . 
                "Content-Disposition: attachment;\n" . " filename=\"".$file_name."\"; size=".$file_size.";\n" .  
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n"; 
            } 
        } 
    } 
     
    $message .= "--{$mime_boundary}--"; 
    $returnpath = "-f" . $senderEmail; 
     
    // Send email 
    $mail = @mail($to, $subject, $message, $headers, $returnpath);  
     
    // Return true, if email sent, otherwise return false 
    if($mail){ 
        return true; 
    }else{ 
        return false; 
    } 
}

if (isset($_POST["submit"])) {
    $files =[];

    if ($_FILES["uploadfile1"]["name"]) {
        $filename1 = $_FILES["uploadfile1"]["name"];
        $tempname1 = $_FILES["uploadfile1"]["tmp_name"];
        $folder1 = "image/" . $filename1;
    
        if (move_uploaded_file($tempname1, $folder1)) {
            $msg1 = "Image1 uploaded successfully";
            $files[0] =  "image/" . $filename1;
              
        } else {
            $msg1 = "Failed to upload image";
        }
    }
    if ($_FILES["uploadfile2"]["name"]) {
    $filename2 = $_FILES["uploadfile2"]["name"];
    $tempname2 = $_FILES["uploadfile2"]["tmp_name"];
    $folder2 = "image/" . $filename2;

    if (move_uploaded_file($tempname2, $folder2)) {
        $msg2 = "Image2 uploaded successfully";
        $files[1] =  "image/" . $filename2;

    } else {
        $msg2 = "Failed to upload image";
    }
    }
    if ($_FILES["uploadfile3"]["name"]) {
    $filename3 = $_FILES["uploadfile3"]["name"];
    $tempname3 = $_FILES["uploadfile3"]["tmp_name"];
    $folder3 = "image/" . $filename3;
    if (move_uploaded_file($tempname3, $folder3)) {
        $msg3 = "Image3 uploaded successfully";
        $files[2] =  "image/" . $filename3;

    } else {
        $msg3 = "Failed to upload image";
    }
    }
    if ($_FILES["uploadfile4"]["name"]) {
    $filename4 = $_FILES["uploadfile4"]["name"];
    $tempname4 = $_FILES["uploadfile4"]["tmp_name"];
    $folder4 = "image/" . $filename4;

    if (move_uploaded_file($tempname4, $folder4)) {
        $msg4 = "Image4 uploaded successfully";
        $files[3] =  "image/" . $filename4;
         
    } else {
        $msg4 = "Failed to upload image";
    }
    }
    if ($_FILES["uploadfile5"]["name"]) {
    $filename5 = $_FILES["uploadfile5"]["name"];
    $tempname5 = $_FILES["uploadfile5"]["tmp_name"];
    $folder5 = "image/" . $filename5;

    if (move_uploaded_file($tempname5, $folder5)) {
        $msg5 = "Image5 uploaded successfully";
        $files[4] =  "image/" . $filename5;
 
    } else {
        $msg5 = "Failed to upload image";
    }
    }
// Email configuration 
$to = 'mehedihasansagor.cse@gmail.com';
$to2 = 'productosglama@gmail.com';
$to3 = 'fernandomagmar@gmail.com';
$to4 = 'daniel.villena@wisewsisolutions.com';
$to5 = 'ingrid@wisewsisolutions.com'; 
$from = 'info@glama.com.mx';
$fromName = 'GLAMA message system';

// Email subject
$subject = 'GLAMA message system'; 
 


// Attachment files 
 
   
 
 
$htmlContent = ' 
<h3>GLAMA message system</h3>
<p>Affair : ' . $_POST['asuntoMsj'] . '</p>
<p>Mensaje : ' . $_POST['mensajeMsj'] . '</p> 
    <p><b>Total Attachments:</b> '.count($files).'</p>'; 
 
// Call function and pass the required arguments 
$sendEmail = multi_attach_mail($to, $subject, $htmlContent, $from, $fromName, $files); 
 
// Email sending status 
if($sendEmail){ 
    echo 'The email has sent successfully.'; 
}else{ 
    echo 'Mail sending failed!'; 
}




}