<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 5                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2004 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Original Author <author@example.com>                        |
// |          Your Name <you@example.com>                                 |
// +----------------------------------------------------------------------+
//
// $Id:$

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
if (PHP_SAPI == 'cli') die('This example should only be run from a Web Browser');
require_once 'phpexcel/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("百家威信")->setLastModifiedBy("百家威信")->setTitle("Office 2007 XLSX Test Document")->setSubject("Office 2007 XLSX Test Document")->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")->setKeywords("office 2007 openxml php")->setCategory("report file");
if ($report == 'order') {
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '号码')->setCellValue('B1','投注项')->setCellValue('C1','户口')->setCellValue('D1', '下注金额');
    $i = 2;
    foreach ($list as $k => $v) {
        foreach ($v as $key => $value) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, strval($value['number']))->setCellValue('B'.$i,strval($k))->setCellValue('C'.$i,strval($value['account']))->setCellValue('D' . $i, strval($value['order_amount']));
            $i++;
        }
    }
    $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $objPHPExcel->getActiveSheet()->setTitle('本期下注');
    $objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="下注报告.xls"');
header('Cache-Control: max-age=0');
}
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit; ?>
