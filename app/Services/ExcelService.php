<?php
/**
 * Created by PhpStorm.
 * User: jmanihuariy
 * Date: 1/11/2019
 * Time: 16:56
 */

namespace App\Services;
require_once __DIR__."/../Utils/PHPExcel.php";
use PHPExcel;
class ExcelService
{
    public static function create($title=[],$header=null,$content=null){
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
        $startIndex=2;
        $objPHPExcel = new PHPExcel();
        if(!empty($title)){
            foreach ($title as $index => $detalle){
                if($index==0){
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("B$startIndex", $detalle);
                    $styleArray = array(
                        'font'  => array(
                            'bold'  => true,
                            'color' => array('rgb' => 'FF0000'),
                            'size'  => 14,
                            'name'  => 'Verdana'
                        ),
                        'alignment' => array(
                            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        ));

                    $objPHPExcel->setActiveSheetIndex(0)
                        ->getStyle("B$startIndex")
                       ->applyFromArray($styleArray);
                    $startIndex++;
                } else {
                    $startIndex++;
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("B$startIndex", $detalle);
                    $styleArray = array(
                        'font'  => array(
                            'bold'  => true,
                            'color' => array('rgb' => '000000'),
                            'size'  => 11,
                            'name'  => 'Verdana'
                        ),
                        'alignment' => array(
                            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        ));

                    $objPHPExcel->setActiveSheetIndex(0)
                        ->getStyle("B$startIndex")
                        ->applyFromArray($styleArray);

                }

            }
            $startIndex = $startIndex+count($title) + 1;
        }

        $objPHPExcel->setActiveSheetIndex(0)->getActiveCell();

        if($header && is_array($header)){
            foreach ($header as $index => $head){
                $cell =  self::CHARS($index).$startIndex;
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($cell, $head);


                $styleArray = array(
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => 'FF0000'),
                        'size'  => 11,
                        'name'  => 'Verdana'
                    ),
                    'alignment' => array(
                        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ));

                $objPHPExcel->setActiveSheetIndex(0)
                            ->getStyle($cell)
                            ->applyFromArray($styleArray)
                            ->getFill()
                            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('FFDBE2F1');

            }
            $startIndex++;
        }
        if($content && is_array($content)){
            foreach ($content as $index => $cont){
                $i=0;
                foreach ($cont as $value){
                    $cell =  self::CHARS($i).$startIndex;
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($cell, $value);

                    $styleArray = array(
                        'font'  => array(
                            'bold'  => false,
                            'color' => array('rgb' => '000000'),
                            'size'  => 10,
                            'name'  => 'Verdana',
                        ),
                        'alignment' => array(
                            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        ));

                    $objPHPExcel->setActiveSheetIndex(0)
                        ->getStyle($cell)
                        ->applyFromArray($styleArray);

                    $i++;
                }
                $startIndex++;
            }
        }
        $name=date("dmY");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$name.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    public static function CHARS($index) {

        $chars =['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U'];
        return $chars[$index];
    }
}
