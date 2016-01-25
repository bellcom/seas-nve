<?php

namespace AppBundle\DataExport;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ExcelExport {
  /**
   * Return a file response.
   *
   * @param array $results
   * @param $columnNames
   * @param $filename
   * @return Response
   * @throws \PHPExcel_Exception
   * @throws \PHPExcel_Reader_Exception
   */
  public static function generateExcelResponse($results, $columnNames, $filename) {
    $accessor = PropertyAccess::createPropertyAccessor();

    // Instantiate a new PHPExcel object
    $objPHPExcel = new \PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $rowCount = 1;
    $columnCount = 0;

    // Set titles row with bold text.
    foreach ($columnNames as $columnName) {
      $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columnCount, $rowCount)->getFont()->setBold(TRUE);
      $objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow($columnCount, $rowCount, $columnName);
      $columnCount++;
    }
    $rowCount++;

    // Set data rows
    foreach ($results as $row) {
      $columnCount = 0;
      foreach ($columnNames as $columnName) {
        $objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow($columnCount, $rowCount, $accessor->getValue($row, $columnName));
        $columnCount++;
      }
      $rowCount++;
    }

    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

    ob_start();
    $objWriter->save('php://output');

    return new Response(
      ob_get_clean(),  // read from output buffer
      200,
      array(
        'Content-Type' => 'application/vnd.ms-excel',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        'Cache-Control' => 'max-age=0',
      )
    );
  }
}