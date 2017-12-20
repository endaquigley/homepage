<?php

  require_once 'Classes/PHPExcel.php';
  require_once 'Classes/PHPExcel/Writer/Excel2007.php';

  if (isset($_POST['export-excel-data']) === false) {
    die('Sensor data was not provided...');
  }

  $sensorData = json_decode($_POST['export-excel-data']);
  createExcelDocument($sensorData);


  function createWorksheet($objPHPExcel, $index, $title, $device, $sensorID, $description) {

    $objPHPExcel->setActiveSheetIndex($index);
    $worksheet = $objPHPExcel->getActiveSheet();

    $worksheet->setTitle($title);

    $worksheet->getColumnDimension('A')->setWidth(20);
    $worksheet->getColumnDimension('B')->setWidth(15);
    $worksheet->getColumnDimension('C')->setWidth(12);
    $worksheet->getColumnDimension('D')->setWidth(12);

    $worksheet->getStyle('A1:A1')->getFont()->setBold(true);
    $worksheet->getStyle('A5:D5')->getFont()->setBold(true);

    $worksheet->SetCellValue('A1', $device);
    $worksheet->SetCellValue('A2', $sensorID);
    $worksheet->SetCellValue('A3', $description);

    $worksheet->SetCellValue('A5', 'Date');
    $worksheet->SetCellValue('B5', 'Time');
    $worksheet->SetCellValue('C5', 'Value');
    $worksheet->SetCellValue('D5', 'Unit');

    return $worksheet;

  }

  function createExcelDocument($sensorData) {

    $objPHPExcel = new PHPExcel();
    $properties = $objPHPExcel->getProperties();

    $objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(
      PHPExcel_Style_Alignment::HORIZONTAL_LEFT
    );

    $properties->setCreator('Zoo Digital');
    $properties->setLastModifiedBy('Zoo Digital');

    $properties->setTitle('Intel DCC Report');
    $properties->setSubject('Intel DCC Report');
    $properties->setDescription('Intel DCC Report');

    for ($i = 1; $i < count($sensorData); $i++) {
      $objPHPExcel->createSheet();
    }

    foreach ($sensorData as $key => $sensor) {

      $row = 7;
      $title = substr($sensor->device, 0, 30);

      $worksheet = createWorksheet($objPHPExcel, $key, $title, $sensor->device, $sensor->sensorID, $sensor->description);

      foreach ($sensor->data as $data) {

        $worksheet->SetCellValue('A'.$row, gmdate('d/m/Y', $data->date));
        $worksheet->SetCellValue('B'.$row, gmdate('H:i', $data->date));
        $worksheet->SetCellValue('C'.$row, $data->value);
        $worksheet->SetCellValue('D'.$row, $sensor->unit);

        $row = $row + 1;

      }

      $base64 = $sensor->chartDataURL;
      $exploded = explode(',', $base64, 2);
      $decoded = base64_decode($exploded[1]);
      $image = imagecreatefromstring($decoded);
      imagesavealpha($image, true);

      $row = $row + 2;

      $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
      $objDrawing->setImageResource($image);
      $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
      $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
      $objDrawing->setResizeProportional(true);
      $objDrawing->setWidth(600);
      $objDrawing->setCoordinates('A'.$row);
      $objDrawing->setWorksheet($worksheet);

    }

    $objPHPExcel->setActiveSheetIndex(0);

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="intel-dcc-report.xlsx"');

    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $objWriter->save('php://output');

  }

?>
