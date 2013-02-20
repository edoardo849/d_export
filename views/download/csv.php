<?php
/**
 * @author edoardo849 <edoardo.s@daviom.com>
 * @copyright Copyright &copy; Daviom 2011-2013
 * Date: 2/19/13 - 4:56 PM
 */


header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename={$fileName}.csv" );
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Pragma: public");


ob_start();
$df = fopen("php://output", 'w');

if(count($headers)>0)
    fputcsv($df, $headers, ';');

foreach ($csvData as $data)
    fputcsv($df, $data,';');

fclose($df);
echo ob_get_clean();