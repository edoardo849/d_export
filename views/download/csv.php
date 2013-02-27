<?php
/**
 * @author edoardo849 <edoardo.s@daviom.com>
 * @copyright Copyright &copy; Daviom 2011-2013
 * Date: 2/19/13 - 4:56 PM
 */
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename={$fileName}.csv" );
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Pragma: public");
$df = fopen("php://output", 'w');

//ob_start();

/*
if(count($headers)>0)
    fputcsv($df, $headers, ';');


foreach ($csvData as $data)
    fputcsv($df, $data, ';');
*/
fputcsv($df, array('ciao'), ',', '"');
//fputcsv(array('headers'=>count($headers)), $data, ';');
fclose($df);

//print str_replace(array("\r\n", "\r"), "\n",  ob_get_clean());
//ob_get_clean();
