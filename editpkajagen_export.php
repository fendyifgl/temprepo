<?php

  include "../../includes/database.php"; 
  include "../../includes/session.php"; 
  include "../../includes/common.php";
  $DB = new database($userid, $passwd, $DBName);
  $DB2 = new database($DBUser, $DBPass, $DBName);
  $DB3 = new database($DBUser, $DBPass, $DBName);
  $conn = ocilogon($DBUser, $DBPass, $DBName);
  $conn1 = ocilogon($DBUser, $DBPass, $DBName);
  $conn2 = ocilogon($DBUser, $DBPass, $DBName);

  require('../libs/fpdf17/fpdf.php');
  $pdf=new FPDF('P','mm','A4');

  $nomer = $_GET['no'];

	// DOCUMENT CREATED
	$created = "SELECT *
	FROM ( select a.*, TO_CHAR(DATETIME, 'YYYY-MM-DD HH24:mi') AS DATEFORMAT, max(DATETIME) over () as max_created
			 from $DBUser.HISTORY_LOG_PKAJ a WHERE DOCUMENT_NO = '$nomer' AND LOWER(ACTIVITY) LIKE '%created%'
				  )
   	WHERE DATETIME = max_created";

	$documentCreated = ociparse($conn, $created);
	ociexecute($documentCreated);
	// END DOCUMENT CREATED

	// DOCUMENT VIEWED
	$viewed = "SELECT *
	FROM ( select a.*, TO_CHAR(DATETIME, 'YYYY-MM-DD HH24:mi') AS DATEFORMAT, max(DATETIME) over () as max_created
			 from $DBUser.HISTORY_LOG_PKAJ a WHERE DOCUMENT_NO = '$nomer' AND LOWER(ACTIVITY) LIKE '%viewed%'
				  )
   	WHERE DATETIME = max_created";

	$documentViewed = ociparse($conn, $viewed);
	ociexecute($documentViewed);
	// END DOCUMENT VIEWED

	// DOCUMENT OTP
	$otp = "SELECT *
	FROM ( select a.*, TO_CHAR(DATETIME, 'YYYY-MM-DD HH24:mi') AS DATEFORMAT, max(DATETIME) over () as max_created
			 from $DBUser.HISTORY_LOG_PKAJ a WHERE DOCUMENT_NO = '$nomer' AND LOWER(ACTIVITY) LIKE '%otp%'
				  )
   	WHERE DATETIME = max_created";

	$documentOTP = ociparse($conn, $otp);
	ociexecute($documentOTP);
	// END DOCUMENT OTP

	// DOCUMENT SIGNED
	$signed = "SELECT *
	FROM ( select a.*, TO_CHAR(DATETIME, 'YYYY-MM-DD HH24:mi') AS DATEFORMAT, max(DATETIME) over () as max_created
			 from $DBUser.HISTORY_LOG_PKAJ a WHERE DOCUMENT_NO = '$nomer' AND LOWER(ACTIVITY) LIKE '%signed%'
				  ) ORDER BY DATETIME ASC";

	$documentSigned = ociparse($conn, $signed);
	ociexecute($documentSigned);
	// END DOCUMENT SIGNED

	// DOCUMENT AGREEMENT
	$agreement = "SELECT *
	FROM ( select a.*, TO_CHAR(DATETIME, 'YYYY-MM-DD HH24:mi') AS DATEFORMAT, max(DATETIME) over () as max_created
			 from $DBUser.HISTORY_LOG_PKAJ a WHERE DOCUMENT_NO = '$nomer' AND LOWER(ACTIVITY) LIKE '%agreement%'
				  )";

	$documentAgreement = ociparse($conn, $agreement);
	ociexecute($documentAgreement);
	// END DOCUMENT SIGNED

  $pdf->AddPage();
  $pdf->SetFont('Arial', '', 12);
  while (oci_fetch($documentCreated)) {
    $pdf->Cell(200,10,'Created Date : ' . oci_result($documentCreated, 'DATEFORMAT') ,0,0);
    $pdf->Ln(7);
    $pdf->Cell(200,10,'Created By : ' . oci_result($documentCreated, 'ID_USER') . " - " . oci_result($documentCreated, 'USR') ,0,0);
    $pdf->Ln(7);
    $pdf->Cell(200,10,'Status : ' . oci_result($documentCreated, 'STATUS') ,0,0);
    $pdf->Ln(7);
    $pdf->Cell(200,10,'Document No : ' . oci_result($documentCreated, 'DOCUMENT_NO'),0,0);
    $pdf->Ln(20);

  // DOCUMENT CREATED
  
    $pdf->Image('icon/pdf.png',5,51,4);
    $pdf->Cell(55, 5, oci_result($documentCreated, 'ACTIVITY') . " by " . oci_result($documentCreated, 'ID_USER') . " - " . oci_result($documentCreated, 'USR'), 0, 0);
    $pdf->Ln(7);
    $pdf->Cell(25, 5, oci_result($documentCreated, 'DATEFORMAT'), 0, 1);
    
    $pdf->Line(10, 65, 130, 65);
    $pdf->Ln(10);
  }
  // END DOCUMENT CREATED

  // DOCUMENT VIEWED
  while (oci_fetch($documentViewed)) {
    $pdf->Image('icon/eye-solid.png',5,74,4);
    $pdf->Cell(55, 5, oci_result($documentViewed, 'ACTIVITY') . " by " . oci_result($documentViewed, 'ID_USER') . " - " . oci_result($documentViewed, 'USR'), 0, 0);
    $pdf->Ln(7);
    $pdf->Cell(25, 5, oci_result($documentViewed, 'DATEFORMAT'), 0, 1);
    
    $pdf->Line(10, 87, 130, 87);
    $pdf->Ln(10);
  }
  // END DOCUMENT VIEWED

  // DOCUMENT OTP
  while (oci_fetch($documentOTP)) {
    $pdf->Image('icon/envelope-open-text-solid.png',5,95,4);
    $pdf->Cell(55, 5, oci_result($documentOTP, 'ACTIVITY') . " code sent to " . oci_result($documentOTP, 'ID_USER') . " - " . oci_result($documentOTP, 'USR') . " via SMS", 0, 0);
    $pdf->Ln(7);
    $pdf->Cell(25, 5, oci_result($documentOTP, 'DATEFORMAT'), 0, 1);
    
    $pdf->Line(10, 110, 130, 110);
    $pdf->Ln(10);
  }
  // END DOCUMENT OTP

  // DOCUMENT SIGNED
  $i=1;
  while (($row = oci_fetch_array($documentSigned, OCI_BOTH)) != false) { 

    if ($i == 3) {
      break;
    }
    
    $pdf->Cell(55, 5, oci_result($documentSigned, 'ACTIVITY') . " by " . oci_result($documentSigned, 'ID_USER') . " - " . oci_result($documentSigned, 'USR'), 0, 0);
    $pdf->Ln(7);
    $pdf->Cell(25, 5, oci_result($documentSigned, 'DATEFORMAT'), 0, 1);
    
    if ($i == 1) {
      $pdf->Image('icon/pen-solid.png',5,117,4);
      $pdf->Line(10, 132, 130, 132);
    } else {
      $pdf->Image('icon/pen-solid.png',5,139,4);
      $pdf->Line(10, 153, 130, 153);
    }
    
    $pdf->Ln(10);
    
    $i++;
  }
  // END DOCUMENT SIGNED

  // DOCUMENT AGREEMENT
  while (oci_fetch($documentAgreement)) {
    $pdf->Image('icon/circle-check-solid.png',5,161,4);
    $pdf->Cell(55, 5, oci_result($documentAgreement, 'ACTIVITY'), 0, 0);
    $pdf->Ln(7);
    $pdf->Cell(25, 5, oci_result($documentAgreement, 'DATEFORMAT'), 0, 1);
    
    $pdf->Line(10, 174, 130, 174);
    $pdf->Ln(10);
  }
  // END DOCUMENT AGREEMENT

$pdf->Output();
?>