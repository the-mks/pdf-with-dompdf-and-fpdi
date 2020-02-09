<?php

/*
    MK$ note
    create date 14-07-2019
    rev 

    note
    Dompdf use ver 0.8.3 2018-07-10
    https://github.com/dompdf/dompdf/releases
    FPDI_Protection  Version:  1.0.2  Date:  2006/11/20    
 

*/
date_default_timezone_set('Asia/Jakarta');

require_once 'dompdf/autoload.inc.php';

//$dompdf->set_option('isHtml5ParserEnabled', true);

use Dompdf\Dompdf;
$dompdf = new Dompdf();


$html = file_get_contents( $_php_file );
$dompdf->loadHtml($html);

$convert_kertas = 2.83;
$kertas_lebar_normal   = $_kertas_lebar   * $convert_kertas; 
$kertas_panjang_normal = $_kertas_panjang * $convert_kertas; 
$kertas_lebar_pwd      = $_kertas_lebar   ; 
$kertas_panjang_pwd    = $_kertas_panjang ; 

$kertas_manual_normal  = array(0 ,0 ,$kertas_lebar_normal, $kertas_panjang_normal);
$dompdf->set_paper($kertas_manual_normal);

$dompdf->render();

$_file_folder  = $_nama_folder ;  
$_file_nama    = $_nama_file ;    
$_file_mix     = $_file_folder . $_file_nama ;
file_put_contents( $_file_mix , $dompdf->output() );


function pdfEncrypt
    (   $origFile, 
        $password_usr, 
        $password_mks, 
        $kertas_lebar_pwd, 
        $kertas_panjang_pwd,
        $copy_file_asli,
        $proteksi_level
    )
{
    require_once('fpdi/FPDI_Protection.php');
    $pdf =& new FPDI_Protection();

    $pdf->FPDF( "P", "mm", array( $kertas_lebar_pwd , $kertas_panjang_pwd ) );
    
    $pagecount = $pdf->setSourceFile($origFile);

    for ($loop = 1; $loop <= $pagecount; $loop++) 
    {
        $tplidx = $pdf->importPage($loop);
        $pdf->addPage();
        $pdf->useTemplate($tplidx);
    }

    if ( $proteksi_level == 'FULL') 
    { $pdf->SetProtection(array(), $password_usr , $password_mks); }

    if ( $proteksi_level  == 'MODIF_ONLY' )   
    { $pdf->SetProtection(array(), '' , $password_mks); }

    $file_to_save_pass = str_replace('.pdf','_pwd.pdf',$origFile);
    $pdf->Output($file_to_save_pass, 'F');
    
    if ( $copy_file_asli <> 'Y' )
        { unlink($origFile); }
        
    return $file_to_save_pass;
}


$password_user  = $_password_usr;  
$password_mks   = $_password_mks;   

if ( ( $_di_password == 'FULL') || ( $_di_password == 'MODIF_ONLY')     )
{
    // now Encrypt file
    pdfEncrypt( $_file_mix, 
                $password_user, 
                $password_mks , 
                $kertas_lebar_pwd, 
                $kertas_panjang_pwd, 
                $_copy_file_asli,
                $_di_password);
}

unset($dompdf);

 
?>