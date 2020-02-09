<?php
date_default_timezone_set('Asia/Jakarta');

if ( ( $_di_password == 'FULL') || ( $_di_password == 'MODIF_ONLY')     )
{
    $file_to_save_pass = $_nama_folder . $_nama_file ;
    $file_to_save_pass = str_replace('.pdf','_pwd.pdf',$file_to_save_pass);
    $filename_di_email = str_replace('.pdf','_pwd.pdf',$_nama_file);
}

if  ( $_di_password == 'N')  
{
    $file_to_save_pass = $_nama_folder . $_nama_file ;
    $filename_di_email = $_nama_file;
}

$to          = $_to;
$cc          = $_cc;
$bcc         = $_bcc;

$fileatt     = $file_to_save_pass;  
$subject     = $_subject;
$mainMessage = $_pesan_email;
$fileatttype = "application/pdf";
$fileattname = $filename_di_email;  
$headers     = 'From: noreply@xxxxxx.com' . "\r\n" .
               "CC: " .$cc. "\r\n" .
               "BCC : " .$bcc;


// File
$file = fopen($fileatt, 'rb');
$data = fread($file, filesize($fileatt));
fclose($file);

// This attaches the file
$semi_rand     = md5(time());
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

$headers      .= "\nMIME-Version: 1.0\n" .
                "Content-Type: multipart/mixed;\n" .
                " boundary=\"{$mime_boundary}\"";

$message       = "This is a multi-part message in MIME format.\n\n" .
                "--{$mime_boundary}\n" .
                "Content-Type: text/plain; charset=\"iso-8859-1\n" .
                "Content-Transfer-Encoding: 7bit\n\n" .
                $mainMessage  . "\n\n";

$data          = chunk_split(base64_encode($data));
$message      .= "--{$mime_boundary}\n" .
                 "Content-Type: {$fileatttype};\n" .
                 " name=\"{$fileattname}\"\n" .
                 "Content-Disposition: attachment;\n" .
                 " filename=\"{$fileattname}\"\n" .
                 "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n" .
                 "--{$mime_boundary}--\n";

// Send the email
mail($to, $subject, $message, $headers) 


?>