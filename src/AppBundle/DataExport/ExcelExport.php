<?php

namespace AppBundle\DataExport;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ExcelExport {
  /**
   * Return an Excel 2007 file response.
   *
   * @param array $results
   * @param $filename
   * @return Response
   * @throws \PHPExcel_Exception
   * @throws \PHPExcel_Reader_Exception
   */
  public static function generateExcelResponse($results, $filename) {
    // Instantiate a new PHPExcel object
    $objPHPExcel = new \PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $rowCount = 1;
    $columnCount = 0;

    if (count($results) > 0) {
      $columnNames = array_keys($results[0]);

      // Set titles row with bold text.
      foreach ($columnNames as $columnName) {
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columnCount, $rowCount)->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow($columnCount, $rowCount, $columnName);
        $columnCount++;
      }
      $rowCount++;
    }

    // Set data rows
    foreach ($results as $row) {
      $columnCount = 0;
      foreach ($row as $cell) {
        // Make sure we are not trying to insert array into a cell.
        if (!is_array($cell)) {
          $objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow($columnCount, $rowCount, $cell);
        }
        else {
          $objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow($columnCount, $rowCount, "Array");
        }
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

  /**
   * Return an Excel 2007 file response.
   *
   * @param array $results
   * @param $filename
   * @return Response
   * @throws \PHPExcel_Exception
   * @throws \PHPExcel_Reader_Exception
   */
  public static function generateTwoDimensionalExcelResponse($results, $filename) {
    // Instantiate a new PHPExcel object
    $objPHPExcel = new \PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $rowCount = 1;
    $columnCount = 1;

    if (count($results) > 0) {
      $columnNames = array_keys($results);

      // Set titles row with bold text.
      foreach ($columnNames as $columnName) {
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columnCount, $rowCount)->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow($columnCount, $rowCount, $columnName);
        $columnCount++;
      }

      $columnCount = 0;
      $rowCount = 2;

      $rowNames = array_keys($results[$columnNames[0]]);

      foreach ($rowNames as $rowName) {
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columnCount, $rowCount)->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow($columnCount, $rowCount, $rowName);
        $rowCount++;
      }
    }

    $columnCount = 1;

    // Set data rows
    foreach ($results as $column) {
      $rowCount = 2;
      foreach ($column as $cell) {
        if (!is_array($cell)) {
          $objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow($columnCount, $rowCount, $cell);
        }
        else {
          $objPHPExcel->getActiveSheet()->SetCellValueByColumnAndRow($columnCount, $rowCount, "Array");
        }
        $rowCount++;
      }
      $columnCount++;
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