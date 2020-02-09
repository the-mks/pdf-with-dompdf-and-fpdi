<?php
 
 
date_default_timezone_set('Asia/Jakarta');

$_stop = 'N';

if  ( $_stop == 'N' )
{
    
    // url file php or html
    $_php_file         = 'https://www.xxxxxxxx.php' ;        
    // save ke pdf dgn nama xxxxxxx.pdf
    // sebaiknya formartnya yyyymmdd_HHmmss_namafile.zip
    $_nama_file        = date('Ymd_His_') . 'bbbbbb.pdf';
    // folder nya format xxxx/
    $_nama_folder      = 'pdf/';     
    // N ; FULL ; MODIF_ONLY ; akan di buat file baru dgn tambahan _pwd.pdf
    $_di_password      = 'FULL';       
    //$_di_password      = 'MODIF_ONLY';       
    //$_di_password      = 'N';       
    // password utk file pdf
    $_password_usr     = 'abc';
    $_password_mks     = 'abcabc';
    // dalam mm
    $_kertas_lebar     = '600';     
    $_kertas_panjang   = '500';     
    // Y jika file no pass masih mau
    $_copy_file_asli   = 'N';        
    // Y jika mau send email
    $_send_email       = 'Y' ;    
    
    include('mks_pdf_generate_function.php');
    
    
    if ($_send_email == 'Y' )
    {
        $_to    = 'xxx@xxxx.com'; 
        $_cc    = '';
        $_bcc   = ''; 
        
        $_subject     = 'xxxxxxxx' . date('d-m-Y H:i:s'); 
        $_pesan_email = 'Terlampir';
        include('mks_pdf_send_email.php');
    }
     
}


?>