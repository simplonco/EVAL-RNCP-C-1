<?php
require_once("dbcontroller.php");
$db_handle = new DBController();

if (empty($_GET['id'])) {
    $user->redirect('myrequest.php');
}

if (isset($_GET['id'])) {
    $uid = $_GET['id'];

    $result = $db_handle->runQuery("SELECT tbl_request.date AS date, tbl_request.message FROM tbl_request right JOIN tbl_users ON tbl_request.userid = $uid WHERE tbl_users.userId = $uid ");

    require('fpdf.php');
    class PDF extends FPDF
    {
      // Page header
      function Header()
      {
          // Logo
          $this->Image('./images/Magic-Lamp.png',10,6,30);
          // Arial bold 15
          $this->SetFont('Arial','I',10);
          // Move to the right
          $this->Cell(57);
      		$tDate = date("F j, Y, G:i");
          // Date
          $this->Cell(0, 10, utf8_decode('Magique rapport toutes les souhaits: ').$tDate, 0, false, 'C', 0, '', 0, false, 'T', 'M');
          // Line break
          $this->Ln(10);
      }
      // Page footer
      function Footer()
      {
          // Position at 1.5 cm from bottom
          $this->SetY(-15);
          // Arial italic 8
          $this->SetFont('Arial','I',8);
          // Page number
          $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
      }
    }

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    foreach($result as $row) {
    	if (!empty($row['date'])){
    		$pdf->SetFont('Arial','',12);
    		$pdf->Ln();
    		foreach($row as $column)
    			$pdf->MultiCell(190,12,utf8_decode($column),0,1);
    	}
    }
  }
  $pdf->Output();
?>
