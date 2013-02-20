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


if(count($headers)>0)
    echo join(';', $headers)."\n";

foreach ($csvData as $data) {

  echo join(';', $data)."\n";
}