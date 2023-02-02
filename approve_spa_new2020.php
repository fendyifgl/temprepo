<?php 
include "../../includes/session.php";
include "../../includes/database.php";
$DB = new Database($userid,$passwd,$DBName);
$DB1 = new Database($userid,$passwd,$DBName);
//$conn = ocilogon("nadm", "ifg#dbs#nadm#2020", "STAGING");
$conn = ocilogon($userid,$passwd,$DBName);

?>
<style type="text/css">
	<!-- 
	body { font-family: tahoma,verdana,geneva,sans-serif; font-size: 13px; } 
	td { font-family: tahoma,verdana,geneva,sans-serif; font-size: 12px; } 
	input {font-family:tahoma,verdana,geneva,sans-serif; font-size: 12px; padding:1px; } 
	select {font-family:tahoma,verdana,geneva,sans-serif; font-size: 12px; border-style: groove; border-width: .2em; } 
	textarea {font-family:tahoma,verdana,geneva,sans-serif; font-size: 12px; border-style: groove; border-width: .2em; } 
	a { color:#259dc5; text-decoration:none; } 
	a:hover { color:#cc6600; } 
	#filterbox{ border: solid 1px #c0c0c0; padding : 5px; width:100%; margin : 0 0 10px 0; } 
	.tombolSubmit{ font-family: tahoma,verdana,geneva,sans-serif; font-size: 18px; }
	.div2 {
	  width: 100px;
	  height: 35px;  
	  padding: 2px;
	  border: 1px solid red;
	  box-sizing: border-box;
	  background: #FF9900;
	}
	input[type=button], input[type=submit], input[type=reset] {
	  background-color: #4CAF50;
	  border: 2px solid blue;
	  border-radius: 15px;
	  color: white;
	  padding: 5px 20px;
	  text-decoration: none;
	  margin: 4px 2px;
	  cursor: pointer;
	}
	form{ margin : 0; padding : 0; } 
	--> 
</style> 
<?
if ($_POST['approve']) {
	/*jika approve promosi PBE -> BE
		1. get mutasi sqlGetMutasi
		2. jika mutasi == promosi
		3. (jalankan query sqlcheck = sqlupdatehistori) update histori jabatan no spa, kode approval, 
		   tgl penetapan masuk kolom tgljabatan, berlaku mulai masuk tgl
		4. update tabel_400_agen set kode jabatan,  atasan, kode kantor (to be)
	*/
	
	$daftarspa=$_POST['listapprove'];
	//var_dump($daftarspa); die;
	$index = 0;
	$box_count=count($daftarspa);
	foreach ($daftarspa as $dear) {
	/*$newAtasan = substr($dear,-10);
		if(substr($dear,-10) == '0000000000'){
			$newAtasan = '';
		} */
		$sqlCheck="UPDATE $DBUser.TABEL_417_HISTORI_JABATAN SET 
						STATUS_APPROVAL='2',
						KETERANGAN = '".$no_spa."', 
						TGL_APPROVAL = SYSDATE, 
						TGLJABATAN = TO_DATE('".$tgljabatan."','DD/MM/YYYY'),
						TGLPENETAPAN = to_date('".$tglberlaku."','MM-YYYY'),
						PERIHAL = '".$_SESSION["namusr"]."'
					WHERE STATUS_APPROVAL = '1'
				  		AND NOAGEN = '".substr($dear,0,10)."'
				  		AND (to_char(TGLJABATAN,'DD/MM/YYYY')='".substr($dear,10,10)."') 
				  		AND KDJABATANAGEN='".substr($dear,20,2)."'";	
		$sqlGetMutasi="SELECT * FROM $DBUser.TABEL_417_HISTORI_JABATAN 
					    WHERE STATUS_APPROVAL = '1'
					  		AND NOAGEN = '".substr($dear,0,10)."'
					  		AND (to_char(TGLJABATAN,'DD/MM/YYYY')='".substr($dear,10,10)."') 
					  		AND KDJABATANAGEN='".substr($dear,20,2)."'
				  	   ";			   
		$getMutasi=ociparse($conn, $sqlGetMutasi);
		ociexecute($getMutasi);
		ocifetch($getMutasi);
		if(ociresult($getMutasi,"URAIAN")== "PROMOSI" || ociresult($getMutasi,"URAIAN")== "DEGRADASI") {
			$updHistori=ociparse($conn, $sqlCheck);
			if(ociexecute($updHistori)){
				$sql="UPDATE $DBUser.TABEL_400_AGEN SET 
							   ATASAN_LAMA = ATASAN,
							   KDJABATANAGEN = '".substr($dear,20,2)."',
							   KDKANTOR='".substr($dear,22,2)."',
							   ATASAN ='".substr($dear,-10)."'
				  	  	  	  WHERE 
							  NOAGEN = '".substr($dear,0,10)."'
								AND KDKANTOR = (SELECT A.KDKANTOR FROM $DBUser.TABEL_400_AGEN A WHERE A.NOAGEN = '".substr($dear,0,10)."')
			  	 	 ";
			
			$update = ociparse($conn, $sql);
			if(ociexecute($update)) {
				$index++;
			}
				
		}
		
	} else if(ociresult($getMutasi,"URAIAN") == "TETAP") {
		$updHistori=ociparse($conn, $sqlCheck);
		if(ociexecute($updHistori)){
				$sql="UPDATE $DBUser.TABEL_400_AGEN SET 
							   ATASAN_LAMA = ATASAN,
							   KDJABATANAGEN = '".substr($dear,20,2)."',
							   KDKANTOR='".substr($dear,22,2)."',
							   ATASAN ='".substr($dear,-10)."'
				  	  	  	  WHERE 
							  NOAGEN = '".substr($dear,0,10)."'
								AND KDKANTOR = (SELECT A.KDKANTOR FROM $DBUser.TABEL_400_AGEN A WHERE A.NOAGEN = '".substr($dear,0,10)."')
			  	 	 ";
			
			$update = ociparse($conn, $sql);
			if(ociexecute($update)) {
				$index++;
			}
				
		}
	} else if(ociresult($getMutasi,"URAIAN") == "PEMBERHENTIAN KARENA VALIDASI" || ociresult($getMutasi,"URAIAN") == "PEMUTUSAN PKAJ" || ociresult($getMutasi,"URAIAN") == "PEMBERHENTIAN KARNA EVALUASI") {
		$updHistori=ociparse($conn, $sqlCheck);
		if(ociexecute($updHistori)){
		$sql="UPDATE $DBUser.TABEL_400_AGEN SET 
							  KDSTATUSAGEN = '02'
				  	  	  	  WHERE 
							  NOAGEN = '".substr($dear,0,10)."'
								AND KDKANTOR = (SELECT A.KDKANTOR FROM $DBUser.TABEL_400_AGEN A WHERE A.NOAGEN = '".substr($dear,0,10)."')
			  	 	 ";
			
			$update = ociparse($conn, $sql);
			if(ociexecute($update)) {
				$index++;
			}
		}
	}
	else if(ociresult($getMutasi,"URAIAN")== "PEMBERHENTIAN" || ociresult($getMutasi,"URAIAN")== "MENGUNDURKAN DIRI" || ociresult($getMutasi,"URAIAN")== "MENINGGAL DUNIA")
	{
		$updHistori=ociparse($conn, $sqlCheck);
		if(ociexecute($updHistori))
		{
			$sql="UPDATE $DBUser.TABEL_400_AGEN SET 
						KDJABATANAGEN='".substr($dear,20,2)."',
						KDSTATUSAGEN = '02'
		  	  	  WHERE NOAGEN = '".substr($dear,0,10)."'
		  	 	 ";

			$updStatus=ociparse($conn, $sql);
			if(ociexecute($updStatus)){
				$sql="UPDATE $DBUser.TABEL_400_AGEN SET 
						   ATASAN_LAMA = ATASAN,
						   ATASAN =''
			  	  	  WHERE ATASAN  = '".substr($dear,0,10)."'
			  	  	  		AND KDKANTOR = (SELECT A.KDKANTOR FROM $DBUser.TABEL_400_AGEN A WHERE A.NOAGEN = '".substr($dear,0,10)."')
			  	 	 "; 
				$updateatasan = ociparse($conn, $sql);
				if(ociexecute($updateatasan)) 				
				{				
					$index++;
				}
			}	
		}
	}
	//$index++;
}
if($index == $box_count){
		echo "<br><div style=\"background-color:lightblue;width: 100%;\"><br><font face=\"Verdana\" size=\"2\">Approval telah berhasil dilakukan dengan nomor SPA: <b>".$no_spa."</b></font><br><br></div><br><br>";
	}else{
		echo "<br><div style=\"background-color:red;width: 100%;\"><br><font face=\"Verdana\" size=\"2\">Approval hanya berhasil dilakukan dengan beberapa agen dengan nomor SPA: <b>".$no_spa."</b></font><br><br></div><br><br>";
	}
}
	
	
	/*$daftarspa=$_POST['listapprove'];
	$cekStatus = 0;
	$box_count=count($daftarspa);
	foreach ($daftarspa as $dear) {
		$newAtasan = substr($dear,-10);
		if(substr($dear,-10) == '0000000000'){
			$newAtasan = '';
		}
		$sqlCheck="UPDATE $DBUser.TABEL_417_HISTORI_JABATAN SET 
						STATUS_APPROVAL='2',
						KETERANGAN = '".$no_spa."', 
						TGL_APPROVAL = SYSDATE, 
						TGLJABATAN = TO_DATE('".$tgljabatan."','DD/MM/YYYY'),
						TGLPENETAPAN = to_date('".$tglberlaku."','MM-YYYY'),
						PERIHAL = '".$_SESSION["namusr"]."'
				   WHERE STATUS_APPROVAL = '1'
				  		AND NOAGEN = '".substr($dear,0,10)."'
				  		AND (to_char(TGLJABATAN,'DD/MM/YYYY')='".substr($dear,10,10)."') 
				  		AND KDJABATANAGEN='".substr($dear,20,2)."'
				  ";
		$sqlGetMutasi="SELECT * FROM $DBUser.TABEL_417_HISTORI_JABATAN 
					    WHERE STATUS_APPROVAL = '1'
					  		AND NOAGEN = '".substr($dear,0,10)."'
					  		AND (to_char(TGLJABATAN,'DD/MM/YYYY')='".substr($dear,10,10)."') 
					  		AND KDJABATANAGEN='".substr($dear,20,2)."'
				  	   ";
		$getMutasi=ociparse($conn, $sqlGetMutasi);
		ociexecute($getMutasi);
		ocifetch($getMutasi);
		if(ociresult($getMutasi,"URAIAN")== "PEMBERHENTIAN" || ociresult($getMutasi,"URAIAN")== "MENGUNDURKAN DIRI" || ociresult($getMutasi,"URAIAN")== "MENINGGAL DUNIA")
		{
			$updHistori=ociparse($conn, $sqlCheck);
			if(ociexecute($updHistori)){
				$sql="UPDATE $DBUser.TABEL_400_AGEN SET 
							KDJABATANAGEN='".substr($dear,20,2)."',
							KDSTATUSAGEN = '02'
			  	  	  WHERE NOAGEN = '".substr($dear,0,10)."'
			  	 	 ";

				$updStatus=ociparse($conn, $sql);
				if(ociexecute($updStatus)){
					$sql="UPDATE $DBUser.TABEL_400_AGEN SET 
							   ATASAN_LAMA = ATASAN,
							   ATASAN =''
				  	  	  WHERE ATASAN  = '".substr($dear,0,10)."'
				  	  	  		AND KDKANTOR = (SELECT A.KDKANTOR FROM $DBUser.TABEL_400_AGEN A WHERE A.NOAGEN = '".substr($dear,0,10)."')
				  	 	 ";
				  	$updAtasan=ociparse($conn, $sql);
				  	if(substr($dear,20,2) == '19'){
					  	if(ociexecute($updAtasan)){
					  		$sql="UPDATE $DBUser.TABEL_400_SAM_KANTOR_MERGE SET 
									NO_SAM =''
						  	  	  WHERE KODE_KANTOR = (SELECT A.KDKANTOR FROM $DBUser.TABEL_400_AGEN A WHERE A.NOAGEN = '".substr($dear,0,10)."')
				  	 	 		  ";
				  	 	 	$updMergeSAM=ociparse($conn, $sql);
				  	 	 	if(ociexecute($updMergeSAM)){
				  	 	 		$cekStatus++;
				  	 	 	}
					  	}
					}else{
						if(ociexecute($updAtasan)){
							$cekStatus++;
						}
					}
				}else{
					echo "<br><div style=\"background-color:red;width: 100%;\"><br><font face=\"Verdana\" size=\"2\">Approval Gagal dilakukan dengan nomor Agen: <b>".substr($dear,0,10).". Gagal Update Status Non-Aktif.</b></font><br><br></div><br><br>";
				}
			}else{
				echo "<br><div style=\"background-color:red;width: 100%;\"><br><font face=\"Verdana\" size=\"2\">Approval Gagal dilakukan dengan nomor Agen: <b>".substr($dear,0,10).". Gagal Update Histori Jabatan.</b></font><br><br></div><br><br>";
			}
		}else{
			$updHistori=ociparse($conn, $sqlCheck);
			if(ociexecute($updHistori)){
				$sql="UPDATE $DBUser.TABEL_400_AGEN SET 
							KDKANTOR='".substr($dear,22,2)."'
			  	  	  WHERE ATASAN = '".substr($dear,0,10)."'
			  	  	  		AND KDKANTOR = (SELECT KDKANTOR FROM $DBUser.TABEL_400_AGEN A WHERE A.NOAGEN = '".substr($dear,0,10)."')
			  	 	 ";
				$updKantorBawahan=ociparse($conn, $sql);
				if(ociexecute($updKantorBawahan)){
					$sql="UPDATE $DBUser.TABEL_400_AGEN SET 
							KDJABATANAGEN='".substr($dear,20,2)."',
							KDKANTOR='".substr($dear,22,2)."',
							ATASAN = '".$newAtasan."',
							ATASAN_LAMA = (SELECT A.ATASAN FROM $DBUser.TABEL_400_AGEN A WHERE A.NOAGEN = '".substr($dear,0,10)."')
			  	  	  WHERE NOAGEN = '".substr($dear,0,10)."'
			  	 	 ";
			  	 	$updJabatan=ociparse($conn, $sql);
			  	 	ociexecute($updJabatan);
			  	 	
					if(substr($dear,20,2) == '19' && ociresult($getMutasi,"URAIAN") == "PROMOSI"){
						$sql="UPDATE $DBUser.TABEL_400_AGEN SET 
							   ATASAN_LAMA = ATASAN,
							   KDKANTOR='".substr($dear,22,2)."',
							   ATASAN ='".substr($dear,0,10)."'
				  	  	  	  WHERE (ATASAN IS NULL 
				  	  	  	  		 OR KDJABATANAGEN = '02' 
				  	  	  	  		 OR ATASAN = (SELECT NO_SAM FROM $DBUser.TABEL_400_SAM_KANTOR_MERGE WHERE KODE_KANTOR = (SELECT A.KDKANTOR FROM $DBUser.TABEL_400_AGEN A WHERE A.NOAGEN = '".substr($dear,0,10)."'))
				  	  	  	  		)
				  	  	  			AND KDKANTOR = (SELECT A.KDKANTOR FROM $DBUser.TABEL_400_AGEN A WHERE A.NOAGEN = '".substr($dear,0,10)."')
				  	 	 ";
				  	 	 $updAtasan=ociparse($conn, $sql);
				  	 	 if(ociexecute($updAtasan)){
				  	 	 	$sql="UPDATE $DBUser.TABEL_400_SAM_KANTOR_MERGE SET 
									   NO_SAM ='".substr($dear,0,10)."'
						  	  	  WHERE NO_SAM = (SELECT ATASAN_LAMA FROM $DBUser.TABEL_400_AGEN A WHERE A.NOAGEN = '".substr($dear,0,10)."')
				  	 	 		";
				  	 	 	$updMergeSAM=ociparse($conn, $sql);
				  	 	 	ociexecute($updMergeSAM);
				  	 	 }
				  	}else if(substr($dear,20,2) == '02' && ociresult($getMutasi,"URAIAN") == "DEGRADASI"){
				  		$sql="UPDATE $DBUser.TABEL_400_AGEN SET 
							   ATASAN_LAMA = ATASAN,
							   ATASAN = '".$newAtasan."'
				  	  	  	  WHERE KDJABATANAGEN = '02' 
				  	  	  			AND KDKANTOR = (SELECT A.KDKANTOR FROM $DBUser.TABEL_400_AGEN A WHERE A.NOAGEN = '".substr($dear,0,10)."')
				  	 	 ";
				  	 	 $updAtasan=ociparse($conn, $sql);
				  	 	 if(ociexecute($updAtasan)){
				  	 	 	$sql="UPDATE $DBUser.TABEL_400_SAM_KANTOR_MERGE SET 
									   NO_SAM = ''
						  	  	  WHERE NO_SAM = '".substr($dear,0,10)."'
				  	 	 		";
				  	 	 	$updMergeSAM=ociparse($conn, $sql);
				  	 	 	ociexecute($updMergeSAM);
				  	 	 }
				  	}
				  	$cekStatus++;
				}else{
					echo "<br><div style=\"background-color:red;width: 100%;\"><br><font face=\"Verdana\" size=\"2\">Approval Gagal dilakukan dengan nomor Agen: <b>".substr($dear,0,10).". Gagal Update Kantor Bawahan.</b></font><br><br></div><br><br>";
				}
			}else{
				echo "<br><div style=\"background-color:red;width: 100%;\"><br><font face=\"Verdana\" size=\"2\">Approval Gagal dilakukan dengan nomor Agen: <b>".substr($dear,0,10).". Gagal Update Histori Jabatan.</b></font><br><br></div><br><br>";
			}
		}	
	}
	if($cekStatus == $box_count){
		echo "<br><div style=\"background-color:lightblue;width: 100%;\"><br><font face=\"Verdana\" size=\"2\">Approval telah berhasil dilakukan dengan nomor SPA: <b>".$no_spa."</b></font><br><br></div><br><br>";
	}else{
		echo "<br><div style=\"background-color:red;width: 100%;\"><br><font face=\"Verdana\" size=\"2\">Approval hanya berhasil dilakukan dengan beberapa agen dengan nomor SPA: <b>".$no_spa."</b></font><br><br></div><br><br>";
	}
	
}
*/

if ($_POST['unapprove']) {
	$daftarspa_decline=$_POST['listunapprove'];
	$cekStatus = 0;
	$box_count=count($daftarspa_decline);
	foreach ($daftarspa_decline as $daftar) {
		$sqlUnCheck="UPDATE $DBUser.TABEL_417_HISTORI_JABATAN SET 
						STATUS_APPROVAL='3',
						ALASAN_PENOLAKAN_SPA = '".$ket_ditolak."',
						TGL_APPROVAL = SYSDATE, 
						PERIHAL = '".$_SESSION["namusr"]."'
				   WHERE STATUS_APPROVAL = '1'
				  		AND NOAGEN = '".substr($daftar,0,10)."'
				  		AND (to_char(TGLJABATAN,'DD/MM/YYYY')='".substr($daftar,10,10)."') 
				  		AND KDJABATANAGEN='".substr($daftar,20,2)."'
				  ";
		$setDecline=ociparse($conn, $sqlUnCheck);
		if(ociexecute($setDecline)){
			$cekStatus++;
		}
	}
	if($cekStatus == $box_count){
		echo "<br><div style=\"background-color:lightblue;width: 100%;\"><br><font face=\"Verdana\" size=\"2\">Penolakan SPA telah berhasil dilakukan.</b></font><br><br></div><br><br>";
	}else{
		echo "<br><div style=\"background-color:red;width: 100%;\"><br><font face=\"Verdana\" size=\"2\">Penolakan SPA hanya berhasil dilakukan dengan beberapa agen.</b></font><br><br></div><br><br>";
	}
}

if ($_POST['check']) {
	$box=$_POST['box1'];
	$box_count=count($box);
	if (($box_count)<1) {
		echo "No Data Updated !";
	} else {

	$sql0 = "SELECT nadm.NO_SPA_AGEN.NEXTVAL as VALUE FROM DUAL ";
	// echo $sql0;
 //  	$nextvalspa=ociparse($conn, $sql0);
	// ociexecute($nextvalspa);
	// ocifetch($nextvalspa);
	//echo $sql0;
	$DB->parse($sql0);
	$DB->execute();
	$arr = $DB->nextrow();
	$nospagaen = $arr["VALUE"];
	//echo "test";
	//print_r($arr);
	
	//kode automatis 3 digit
	if (strlen($nospagaen) == 1 ) {
		$kode = '0'.'0'.$nospagaen;
	} else if (strlen($nospagaen) == 2 ) {
	$kode = '0'.$nospagaen; 
	} else {
	$kode = $nospagaen;
	}
	//echo date('m').substr(date('Y'), -2);die;
	$nospa=$kode.'.SPA.AGN.'.date('m').substr(date('Y'),-2);
	//$nospa='1234'.'.SPA.AGN.'.date('m').substr(date('Y'),0,2);

?>
	<form name="approveSpa" id="approveSpa" action="<?=$PHP_SELF;?>" method="post">
	<table border="0" cellpadding="2" cellspacing="1" style="border-collapse: collapse" bordercolor="#CCCCCC" id="AutoNumber1">
		<tr>
			<td bgcolor="#89acd8" align="center">No.</td>
			<td bgcolor="#89acd8" align="center">No Agen</td>
			<td bgcolor="#89acd8" align="center">Nama Agen</td>
			<td bgcolor="#89acd8" align="center">Kode Kantor</td>
			<td bgcolor="#89acd8" align="center">Jenis Mutasi</td>
			<td bgcolor="#89acd8" align="center">Jabatan Sekarang</td>
			<td bgcolor="#89acd8" align="center">Jabatan Baru</td>
			<td bgcolor="#89acd8" align="center">Nomor <br/>PKAJ</td>
			<td bgcolor="#89acd8" align="center">Atasan <br/>Baru</td>
		</tr>
<?
		$i = 1;
		$box=$_POST['box1'];
		foreach ($box as $dear) {
			$sql = "
					SELECT A.NOAGEN,
						   A.KDJABATANAGEN,
						   TO_CHAR(A.TGLJABATAN,'DD/MM/YYYY') AS TGLJABATAN,
						   A.ATASAN_BARU,
						   (SELECT NAMAKLIEN1 FROM $DBUser.tabel_100_klien where noklien = A.noagen ) AS NAMAAGEN,
						   A.KDKANTOR,
						   A.URAIAN,
						   (SELECT NAMAJABATANAGEN FROM $DBUser.TABEL_413_JABATAN_AGEN WHERE KDJABATANAGEN = B.KDJABATANAGEN) AS JABATAN_LAMA,
						   (SELECT NAMAJABATANAGEN FROM $DBUser.TABEL_413_JABATAN_AGEN WHERE KDJABATANAGEN = A.KDJABATANAGEN) AS JABATAN_BARU,
						   A.NOPKAJAGEN,
						   A.TGLPENETAPAN,
						   A.ATASAN_BARU
					FROM $DBUser.TABEL_417_HISTORI_JABATAN A, $DBUser.TABEL_400_AGEN B
					WHERE A.NOAGEN = B.NOAGEN
						  AND STATUS_APPROVAL = '1'
						  AND A.NOAGEN = '".substr($dear,0,10)."'
						  AND (to_char(A.TGLJABATAN,'DD/MM/YYYY')='".substr($dear,10,10)."')
						  AND A.KDJABATANAGEN='".substr($dear,20,2)."'
					";
			//echo $sql;
			$detailList=ociparse($conn, $sql);
			ociexecute($detailList);
			while (($arr = oci_fetch_array($detailList, OCI_BOTH)) != false) {
?>
				<tr bgcolor=#d5e7fd>
					<td style="border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA" align="center"><?=$i;?></td>
					<td style="border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA" align="center"><?=$arr["NOAGEN"];?></td>
					<td style="border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA" align="center"><?=$arr["NAMAAGEN"];?></td>
					<td style="border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA" align="center"><?=$arr["KDKANTOR"];?></td>
					<td style="border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA" align="center"><?=$arr["URAIAN"];?></td>
					<td style="border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA" align="center"><?=$arr["JABATAN_LAMA"];?></td>
					<td style="border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA" align="center"><?=$arr["JABATAN_BARU"];?></td>
					<td style="border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA" align="center"><?=$arr["NOPKAJAGEN"];?></td>
					<td style="border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA" align="center"><?=$arr["ATASAN_BARU"];?></td>
				</tr>	
<?
			}
?>
			<input type="hidden" name="listapprove[]" value='<?php print_r($dear); ?>'/>
<?
			$i++;
		}
?>
	</table>
	<br/>
	<table>
		<tr>
		  	<td class="verdana9blu">Nomor SPA</td>
			<td class="verdana9blu">: 
				<input type="hidden" size="35 " name="no_spa" size="10" value="<?=$nospa;?>">
				<input type="text" size="35 " name="no_spa1" size="10" value="<?=$nospa;?>" disabled></td>
			</td>
		</tr>
		<tr>
		  	<td class="verdana9blu">Berlaku Mulai</td>
			<td class="verdana9blu">: <input type="text" size="25" name="tglberlaku" maxlength="10" size="10" value="<? echo date("m-Y"); ?>"></td>
			</td>
		</tr>
		<tr>
		  <td class="verdana9blu">Tanggal Penetapan</td>
			<td class="verdana9blu">:      
			  <input type="text" size="25" name="tgljabatan" maxlength="10" size="10" value="<? echo date("d/m/Y"); ?>">
			</td>
		</tr>
		<tr>
		  <td class="verdana9blu">Tanggal Approval</td>
			<td class="verdana9blu">:      
			  <input type="text" size="25" name="tglApproval" maxlength="10" size="10" value="<? echo date("d/m/Y"); ?>" disabled>
			</td>
		</tr>
	</table>
	<hr/><br/>
	<div align="center">
		<input align="center" class="tombolSubmit" type='submit' name='approve' value='Submit'>
	</div>
	</form>
<?
	}
}

if ($_POST['uncheck']) {
	$box=$_POST['box1']; //as a normal var
	$box_count=count($box); // count how many values in array
	if (($box_count)<1) {
		//echo "No Data Updated !";
	}else{?>
		<form name="approveSpa" id="approveSpa" action="<?=$PHP_SELF;?>" method="post">
		<table border="0" cellpadding="2" cellspacing="1" style="border-collapse: collapse" bordercolor="#CCCCCC" id="AutoNumber1">
			<tr>
				<td bgcolor="#89acd8" align="center">No.</td>
				<td bgcolor="#89acd8" align="center">No Agen</td>
				<td bgcolor="#89acd8" align="center">Nama Agen</td>
				<td bgcolor="#89acd8" align="center">Kode Kantor</td>
				<td bgcolor="#89acd8" align="center">Jenis Mutasi</td>
				<td bgcolor="#89acd8" align="center">Jabatan Sekarang</td>
				<td bgcolor="#89acd8" align="center">Jabatan Baru</td>
				<td bgcolor="#89acd8" align="center">Nomor <br/>PKAJ</td>
				<td bgcolor="#89acd8" align="center">Atasan <br/>Baru</td>
			</tr>
		<?
			$i = 1;
			$box=$_POST['box1'];
			foreach ($box as $dear) {
				$sql = "
						SELECT A.NOAGEN,
							   A.KDJABATANAGEN,
							   TO_CHAR(A.TGLJABATAN,'DD/MM/YYYY') AS TGLJABATAN,
							   A.ATASAN_BARU,
							   (SELECT NAMAKLIEN1 FROM $DBUser.tabel_100_klien where noklien = A.noagen ) AS NAMAAGEN,
							   A.KDKANTOR,
							   A.URAIAN,
							   (SELECT NAMAJABATANAGEN FROM $DBUser.TABEL_413_JABATAN_AGEN WHERE KDJABATANAGEN = B.KDJABATANAGEN) AS JABATAN_LAMA,
							   (SELECT NAMAJABATANAGEN FROM $DBUser.TABEL_413_JABATAN_AGEN WHERE KDJABATANAGEN = A.KDJABATANAGEN) AS JABATAN_BARU,
							   A.NOPKAJAGEN,
							   A.TGLPENETAPAN,
							   A.ATASAN_BARU
						FROM $DBUser.TABEL_417_HISTORI_JABATAN A, $DBUser.TABEL_400_AGEN B
						WHERE A.NOAGEN = B.NOAGEN
							  AND STATUS_APPROVAL = '1'
							  AND A.NOAGEN = '".substr($dear,0,10)."'
							  AND (to_char(A.TGLJABATAN,'DD/MM/YYYY')='".substr($dear,10,10)."')
							  AND A.KDJABATANAGEN='".substr($dear,20,2)."'
						";
				//echo $sql;
				$detailList2=ociparse($conn, $sql);
				ociexecute($detailList2);
				while (($arr = oci_fetch_array($detailList2, OCI_BOTH)) != false) {
		?>
					<tr bgcolor=#d5e7fd>
						<td style="border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA" align="center"><?=$i;?></td>
						<td style="border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA" align="center"><?=$arr["NOAGEN"];?></td>
						<td style="border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA" align="center"><?=$arr["NAMAAGEN"];?></td>
						<td style="border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA" align="center"><?=$arr["KDKANTOR"];?></td>
						<td style="border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA" align="center"><?=$arr["URAIAN"];?></td>
						<td style="border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA" align="center"><?=$arr["JABATAN_LAMA"];?></td>
						<td style="border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA" align="center"><?=$arr["JABATAN_BARU"];?></td>
						<td style="border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA" align="center"><?=$arr["NOPKAJAGEN"];?></td>
						<td style="border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA" align="center"><?=$arr["ATASAN_BARU"];?></td>
					</tr>	
		<?
				}
		?>
				<input type="hidden" name="listunapprove[]" value='<?php print_r($dear); ?>'/>
		<?
				$i++;
			}
		?>
		</table>
		<br/>
		<br/>
		<table>
			<tr>
			  <td class="verdana9blu">Alasan Penolakan</td>
				<td class="verdana9blu">:</td>
				<td>
				  <textarea rows="4" cols="50" name="ket_ditolak" id="ket_ditolak"></textarea>
				</td>
			</tr>
		</table>
		<hr/><br/>
		<div align="center">
			<input align="center" class="tombolSubmit" type='submit' name='unapprove' value='Decline'>
		</div>
		</form>
<?	
	}
}

?>