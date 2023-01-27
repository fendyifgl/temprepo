<?php
	include "../../includes/session.php";
	include "../../includes/database.php";
	include "excel_reader.php";
	
	$UPDATEDB = new Database($userid,$passwd,$DBName);
	$DB = new Database($userid,$passwd,$DBName);
	$DB1 = new Database($userid,$passwd,$DBName);
	$DB2 = new Database($userid,$passwd,$DBName);

	$errorMessage="";

	function DateSelector($inName, $useDate=0) { 
		if($useDate == 0) { 
			$useDate = Time(); 
		} 
		
		// Bulan	
  		$selected = (isset($_POST[$inName.'bln']) && $_POST[$inName.'bln']!='') ? $_POST[$inName.'bln'] : date( "n", $useDate);
		print("<select name=" . $inName .  "bln>\n"); 
		for($currentMonth = 1; $currentMonth <= 12;$currentMonth++) { 
			switch($currentMonth) {
				case '1' : $namabulan ="JANUARI"; break;
                case '2' : $namabulan ="FEBRUARI"; break;
                case '3' : $namabulan ="MARET"; break;
                case '4' : $namabulan ="APRIL"; break;
                case '5' : $namabulan ="MEI"; break;
                case '6' : $namabulan ="JUNI"; break;
                case '7' : $namabulan ="JULI"; break;
                case '8' : $namabulan ="AGUSTUS"; break;
                case '9' : $namabulan ="SEPTEMBER"; break;
                case '10' : $namabulan ="OKTOBER"; break;
                case '11' : $namabulan ="NOVEMBER"; break;
                case '12' : $namabulan ="DESEMBER"; break;
			}
			
			print("<option value=\"$currentMonth\""); 
			if($selected==$currentMonth) { 
				print(" selected"); 
			}
			
			print(">$namabulan</option>");
		} 
		print("</select>"); 
  
  		// Tahun				
  		$selected = (isset($_POST[$inName.'thn']) && $_POST[$inName.'thn']!='') ? $_POST[$inName.'thn'] : date( "Y", $useDate);			
		print("<select name=" . $inName .  "thn>\n"); 
		$startYear = date( "Y", $useDate); 
		for($currentYear = 2020; $currentYear <= $startYear+1;$currentYear++) { 
			print("<option value=\"$currentYear\""); 
			if($selected==$currentYear) { 
				print(" selected"); 
			} 
			print(">$currentYear\n"); 
		} 
		print("</select>"); 
	} 	
?>
<link href="../jws.css" rel="stylesheet" type="text/css">
<style type="text/css">
	th.verdana7blu {
		color: #000000;
		font-weight:bold;
		text-transform:capitalize;
		background-color:#43c6fa;
		text-align:center;
	}
	td.kepalacabang {
		background-color:#9DE0EE;
		font-weight:bold;
	}
	td.areamanager {
		background-color:#00CCFF;
		font-weight:bold;
	}
	td.unitmanager {
		background-color:#E1EFF7;
		font-weight:bold;
	}
	td.financialadvisor {
		background-color:#ffffff;
		font-weight:bold;
	}
	td.directsam-um {
		background-color:#89D1F8;
		font-weight:bold;
	}
	td.directsam-fa {
		background-color:#D0EDFC;
		font-weight:bold;
	}td.directam {
		background-color:#FCE3DC;
		font-weight:bold;
	}td.ade-instruktur {
		background-color:#E9967A;
		font-weight:bold;
	}td.ade-fa {
		background-color:#FFEFD5;
		font-weight:bold;
	}td.agenpk {
		background-color:#FAF5E4;
		font-weight:bold;
	}
	td {
		background-color:#e6e7e8;
		font-size:7.15pt;
		font-family:Verdana, Helvetica, sans-serif;
	}
	.warning {
		background-color:#EAFF00;
	}
	.danger {
		background-color:#FF0000;
	}

	#filterbox{ border: solid 1px #c0c0c0; padding : 5px; width:100%; margin : 0 0 10px 0; } 
	.modal {
	  display: none; /* Hidden by default */
	  position: fixed; /* Stay in place */
	  z-index: 1; /* Sit on top */
	  padding-top: 100px; /* Location of the box */
	  left: 0;
	  top: 0;
	  width: 100%; /* Full width */
	  height: 100%; /* Full height */
	  overflow: auto; /* Enable scroll if needed */
	  background-color: rgb(0,0,0); /* Fallback color */
	  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}

	/* Modal Content */
	.modal-content {
	  background-color: #fefefe;
	  margin: auto;
	  padding: 20px;
	  border: 1px solid #888;
	  width: 27%;
	}

	/* The Close Button */
	.close_setting {
	  color: #aaaaaa;
	  float: right;
	  font-size: 42px;
	  font-weight: bold;
	}

	.close_setting:hover,
	.close_setting:focus {
	  color: #000;
	  text-decoration: none;
	  cursor: pointer;
	}
	
	/* The Close Button */
	.close_informasi {
	  color: #aaaaaa;
	  float: right;
	  font-size: 42px;
	  font-weight: bold;
	}

	.close_informasi:hover,
	.close_informasi:focus {
	  color: #000;
	  text-decoration: none;
	  cursor: pointer;
	}
	
	.switch {
	  position: relative;
	  display: inline-block;
	  width: 55px;
	  height: 34px;
	}

	.switch input { 
	  opacity: 0;
	  width: 0;
	  height: 0;
	}

	.slider {
	  position: absolute;
	  cursor: pointer;
	  top: 0;
	  left: 0;
	  right: 0;
	  bottom: 0;
	  background-color: #ccc;
	  -webkit-transition: .4s;
	  transition: .4s;
	}

	.slider:before {
	  position: absolute;
	  content: "";
	  height: 26px;
	  width: 26px;
	  left: 4px;
	  bottom: 4px;
	  background-color: white;
	  -webkit-transition: .4s;
	  transition: .4s;
	}

	input:checked + .slider {
	  background-color: #2196F3;
	}

	input:focus + .slider {
	  box-shadow: 0 0 1px #2196F3;
	}

	input:checked + .slider:before {
	  -webkit-transform: translateX(26px);
	  -ms-transform: translateX(26px);
	  transform: translateX(26px);
	}

	/* Rounded sliders */
	.slider.round {
	  border-radius: 34px;
	}

	.slider.round:before {
	  border-radius: 50%;
	}
</style>
<?php
$upload = $_GET['upload'];
if($upload == 1){
    $mimes = array('application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet');
    if(in_array($_FILES["file"]["type"],$mimes)){
    //upload file ke server
    $target = basename($_FILES['file']['name']) ;
    $name = str_replace(' ','_',$target);
    $path = 'filelifesaver/';
    $fileupload = $path.$name;
    move_uploaded_file($_FILES['file']['tmp_name'],$fileupload);
    
    // mengambil isi file xls
    $data = new Spreadsheet_Excel_Reader($fileupload,false);


    // menghitung jumlah baris data yang ada
    $jumlah_baris = $data->rowcount($sheet_index=0);
    $namauser = $_SESSION["userid"];
    // jumlah default data yang berhasil di import
    $berhasil = 0;
    for ($i=2; $i<=$jumlah_baris; $i++){
       
        // menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
        $noPolis     = $data->val($i, 1);
        $kondisiUpdate  = $data->val($i, 2);
        $mulas  = $data->val($i, 3);
        $noagen  = $data->val($i, 4);
        $tglbooked  = $data->val($i, 5);
		
		$kondisiUpdateUpper = strtoupper($kondisiUpdate);

		$checkKondisiUpdate = "STATUS.MIGRASI.POLIS." . $data->val($i, 2);

		if($noPolis != "" && $kondisiUpdate != "" && $userid != ""){
			if ($kondisiUpdateUpper == "RED" || $kondisiUpdateUpper == "GREEN" || $kondisiUpdateUpper == "AMBER") {
				$queryCheck = "SELECT kondisi_update FROM temporary_import WHERE NO_POLIS = '$noPolis' AND STATUS != '8'";
				$DB1->parse($queryCheck);
	
				if(!$DB1->execute()) {
					echo "<script>alert('Gagal Melakukan Import Data, Karena query db1 gagal')</script>";
					echo "<script> window.location.href = 'update_status_pht.php';</script>";
				} 

				$errorTemporary = false;

				while ($row = $DB1->nextrow()) {
					$temporary = $row['KONDISI_UPDATE'];
					if ($temporary != $kondisiUpdate) {
						$errorTemporary = false;
						$queryUpdateTemporary = "UPDATE $DBUser.temporary_import set status = '8', updated_by = 'SYSTEM', tanggal_penerimaan = SYSDATE
						where no_polis = '$noPolis'";

						$UPDATEDB->parse($queryUpdateTemporary);

						if(!$UPDATEDB->execute()) {
							echo "<script>alert('Gagal Melakukan Approve!!')</script>";
							echo "<script> window.location.href = 'update_status_pht.php';</script>";
						}
					} else if ($temporary == $kondisiUpdate) {
						$errorTemporary = true;
					}
				}

				if (!$errorTemporary) {
					$queryCheckNoPol = "SELECT COUNT(PREFIXPERTANGGUNGAN) AS jumlah_prefix, keterangan
					FROM rpt_prefix_noper_restru 
					WHERE prefixpertanggungan = 
					(SELECT prefixpertanggungan
					FROM tabel_200_pertanggungan
					WHERE nopol = '$noPolis') AND nopertanggungan = 
					(SELECT nopertanggungan
					FROM tabel_200_pertanggungan
					WHERE nopol = '$noPolis')
					GROUP BY keterangan";
	
					$DB2->parse($queryCheckNoPol);
					
					if(!$DB2->execute()) {
						echo "<script>alert('Gagal Melakukan Import Data, Karena query db2 gagal')</script>";
						echo "<script> window.location.href = 'update_status_pht.php';</script>";
					} 
					$rowCheck = $DB2->nextrow();

					$error = false;
					$errorKeterangan = false;

					if(!$error) {
						if ($rowCheck['JUMLAH_PREFIX'] == 0) {
							$errorMessage .= $noPolis . ", ";
							$error = true;
						} else if ($rowCheck['KETERANGAN'] == "STATUS.MIGRASI.POLIS.GREEN") {
							$errorMessage .= $noPolis . ", ";
							$errorKeterangan = true;
							break;
						} else {
							$query = "INSERT INTO temporary_import(NO_POLIS,KONDISI_UPDATE,STATUS,TANGGAL_PENGAJUAN,CREATED_BY) 
							VALUES('$noPolis','$kondisiUpdate',0,SYSDATE,'$userid')";
						}
					}
	
					$DB->parse($query);
					if(!$DB->execute()) {
						echo "<script>alert('Gagal Melakukan Import Data, Karena Karena query db gagal')</script>";
						echo "<script> window.location.href = 'update_status_pht.php';</script>";
					} 
				} else {
					$errorMessage .= $noPolis . " dan kondisi update " . $kondisiUpdate . ", ";
					$errorTemporary = true;
				}
			} else {
				echo "<script>alert('Gagal Melakukan Import Data, Karena Kondisi update hanya boleh RED, AMBER, dan GREEN')</script>";
        		echo "<script> window.location.href = 'update_status_pht.php';</script>";
			}
		}  
    }
    } else {
        echo "<script>alert('Gagal Melakukan Upload File, Silahkan Rubah Type File Tersebut Menjadi .xls !!!')</script>";
		echo "<script> window.location.href = 'update_status_pht.php';</script>";
    }
// hapus kembali file .xls yang di upload tadi
unlink($fileupload);
	if ($error) {
		echo "<script>alert('Gagal Melakukan Import Data, Karena No Polis tidak ada $errorMessage')</script>";
        echo "<script> window.location.href = 'update_status_pht.php';</script>";
	} else if ($errorTemporary) {
		echo "<script>alert('Gagal Melakukan Import Data, Karena No Polis $errorMessage sudah ada di table temporary')</script>";
        echo "<script> window.location.href = 'update_status_pht.php';</script>";
	} else if ($errorKeterangan) {
		echo "<script>alert('Gagal Melakukan Import Data, Karena No Polis $errorMessage ini statusnya sudah GREEN')</script>";
        echo "<script> window.location.href = 'update_status_pht.php';</script>";
	} else {
		echo "<script>alert('Berhasil Melakukan Upload File!!!')</script>";
		echo "<script> window.location.href = 'update_status_pht.php';</script>";
	}
}
?>


<?php

if($_POST['check']){
	$box=$_POST['box1'];
	$username = $_SESSION["userid"];
	$box_count=count($box);
	if (($box_count)<1) {
		echo "<script>alert('Tidak ada data yang dipilih!!')</script>";
		echo "<script> window.location.href = 'update_status_pht.php';</script>";
		   
	} else { 
		foreach ($box as $dear) {
			$value = explode(',',$dear);
			$username = $_SESSION["userid"];
			$query = "UPDATE $DBUser.temporary_import set status = '2', tanggal_penerimaan = SYSDATE, updated_by = '$username'
			where no_polis = '$value[0]' AND kondisi_update = '$value[1]' AND status = '$value[2]'";
			//echo $query;die;
			$DB->parse($query);

			if(!$DB->execute()) {
				echo "<script>alert('Gagal Melakukan Approve!!')</script>";
				echo "<script> window.location.href = 'update_status_pht.php';</script>";
			}

			$statusUpdate = "STATUS.MIGRASI.POLIS." . $value[1];

			$queryUpdate = "UPDATE $DBUser.rpt_prefix_noper_restru SET keterangan = '$statusUpdate'
			WHERE prefixpertanggungan = 
			(SELECT prefixpertanggungan
			FROM $DBUser.tabel_200_pertanggungan
			WHERE nopol = '$value[0]') AND nopertanggungan =
			(SELECT nopertanggungan
			FROM $DBUser.tabel_200_pertanggungan
			WHERE nopol = '$value[0]')";
			$DB1->parse($queryUpdate);

			if(!$DB1->execute()) {
				echo "<script>alert('Gagal Melakukan Update Status Migrasi!!')</script>";
				echo "<script> window.location.href = 'update_status_pht.php';</script>";
			}
		}
		echo "<script>alert('Berhasil Melakukan Approve dan Update Status Migrasi!!')</script>";
		echo "<script> window.location.href = 'update_status_pht.php';</script>";
	}
}

if($_POST['uncheck']){
	$box=$_POST['box1'];
	$username = $_SESSION["userid"];
	$box_count=count($box);
	if (($box_count)<1) {
		echo "<script>alert('Tidak ada data yang dipilih!!')</script>";
		echo "<script> window.location.href = 'update_status_pht.php';</script>";
		   
	} else { 
		foreach ($box as $dear) {
			
			$value = explode(',',$dear);
			$username = $_SESSION["userid"];
			$query = "UPDATE $DBUser.temporary_import set status = '1', tanggal_penerimaan = SYSDATE, updated_by = '$username'
			where no_polis = '$value[0]'";
			//echo $query;die;
			$DB->parse($query);
			if(!$DB->execute()) {
				echo "<script>alert('Gagal Melakukan Approve!!')</script>";
				echo "<script> window.location.href = 'update_status_pht.php';</script>";
		   	}

			// $queryUpdate = "UPDATE $DBUser.rpt_prefix_noper_restru SET keterangan = 'STATUS.MIGRASI.POLIS.RED'
			// WHERE prefixpertanggungan = 
			// (SELECT prefixpertanggungan
			// FROM $DBUser.tabel_200_pertanggungan
			// WHERE nopol = '$value[0]') AND nopertanggungan =
			// (SELECT nopertanggungan
			// FROM $DBUser.tabel_200_pertanggungan
			// WHERE nopol = '$value[0]')";
			// $DB1->parse($queryUpdate);
		}
		echo "<script>alert('Berhasil Melakukan Approve dan Update Status Migrasi!!')</script>";
		echo "<script> window.location.href = 'update_status_pht.php';</script>";
	}
}

if($dbln == null || $dbln == ''){
	$bulan = date('m');
} else {
	if($dbln > 0 && $dbln < 10){
		$bulan = '0'.$dbln;
	} else {
		$bulan = $dbln;
	}
	
}

if($dthn == null || $dthn == ''){
	$tahun = date('Y');
} else {
	$tahun = $dthn;
}
//var_dump($bulan.$tahun);die;
$tanggalConcat = $bulan.$tahun;
$tanggalPengajuan = "where to_char(tanggal_pengajuan,'mmyyyy') = " . "'$tanggalConcat'";

?>
<style type="text/css">
	body{
		font-family: sans-serif;
	}
 
	p{
		color: green;
	}
</style>
<script language="JavaScript" type="text/javascript" src="../includes/window.js"></script>
<script language="JavaScript"> 
	function Cekbok(doc) { 
		console.log(doc);
		if (doc == true) {
			checkedAll('getpremi', true);
			console.log("test true")
		} else {
			checkedAll('getpremi', false);
			console.log("test false")
		}
	} 
	function checkedAll (id, checked) {
		console.log(id);
		console.log(checked);
		var el = document.getElementById(id);
		console.log(el);
		for (var i = 0; i < el.elements.length; i++) {
			el.elements[i].checked = checked;
		}
	}
</script>
<span style="color:red">*File yang diupload Type Excel.xls</span>
 <a href="./template/template.xls" style="text-decoration:none;"> (Contoh Template Excel) </a>

<form method="post" enctype="multipart/form-data" action="update_status_pht.php?upload=1">
<br/>
	Pilih File: 
	<input name="file" type="file" required="required"> 
	<input name="upload" type="submit" value="Import">
</form>
<hr size = '1'>

<div id="filterbox">
	<table>
		<tr>
		<form action="<?=$PHP_SELF;?>" method="post">
			<td>Bulan Pengajuan <?=DateSelector("d"); ?></td>
			<td colspan="2"><input type="submit" name="submit" value="Cari"></td>
		</form>
		<form action="<?=$PHP_SELF;?>" method="post">
			<td>Status</td>
			<td>
				<select name="status">
					<option value="99">Semua</option>
					<option value="0">Menunggu Approval</option>
					<option value="1">Decline</option>
					<option value="2">Approve</option>
				</select>
			</td>
			<td colspan="2"><input type="submit" name="submit" value="Cari"></td>
		</form>
		<form action="<?=$PHP_SELF;?>" method="post">
			<td>No Polis</td>
			<td>
				<input type="text" name="no_polis">
			</td>
			<td colspan="2"><input type="submit" name="submit" value="Cari"></td>
		</form>
		</tr>
	</table>
</div>

<?php 
$statusQuery = "";
if (isset($_POST['status'])) {
	$status=trim($_POST['status']);
	if($status != 99) {
		$statusQuery = "and status = " . "'$status'";
	}
}

$noPolisQuery = "";
if (!empty($_POST['no_polis'])) {
	$no_polis = $_POST['no_polis'];
	$noPolisQuery = "and no_polis = " . "'$no_polis'";
}
?>


<form name="getpremi" id="getpremi" action="<?=$PHP_SELF;?>" method="post">
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:separate;border-color:#f7f7f5;" width="100%" id="AutoNumber1">
<thead>
		<tr>
		  <th class="verdana7blu">No <?= $namusr ?></th>
          <th class="verdana7blu">No Polis</th>
          <th class="verdana7blu">Kondisi Update</th>
          <th class="verdana7blu">Tanggal Pengajuan</th>
		  <th class="verdana7blu">Status</th>
		  <?php if ($namusr == "YAN YAN MULYANA") { ?>
		  <th class="verdana7blu"><input type="checkbox" name="xx" onClick="Cekbok(this.form.xx.checked);" /></th>
		  <?php } ?>
		</tr>
</thead>
<?php 
    $no = 1;
    $sql = "select no_polis as polis, 
	kondisi_update,
	to_char(tanggal_pengajuan,'dd/mm/yyyy') as tanggal_pengajuan, 
	created_by,
	updated_by,
	to_char(tanggal_penerimaan,'dd/mm/yyyy') as tanggal_penerimaan,
	status
	from $DBUser.temporary_import
	$tanggalPengajuan $statusQuery $noPolisQuery ORDER BY id DESC";
    $DB->parse($sql);
	$DB->execute();
?>
<tbody>
	<?php while ($row = $DB->nextrow()) {  ?>
    <tr>
    <td align="center"><?= $no++;?></td>
    <td align="center"><?= $row['POLIS'];?></td>
    <td align="center"><?= $row['KONDISI_UPDATE'];?></td>
    <td align="center"><?= $row['TANGGAL_PENGAJUAN'];?></td>
	<?php if($row['STATUS'] == 0){ ?>
		<td align="center"><span style="color:blue">Menunggu Approval</span></td>
	<?php }else if ($row['STATUS'] == 1) { ?>
		<td align="center"><span style="color:red">Data Telah Direject oleh <?= $row['UPDATED_BY']." pada tanggal " .$row['TANGGAL_PENERIMAAN'];?></span></td>
	<?php } else if ($row['STATUS'] == 2) { ?>
		<td align="center"><span style="color:green">Data Telah Diapprove oleh <?= $row['UPDATED_BY']." pada tanggal " .$row['TANGGAL_PENERIMAAN'];?></span></td>
	<?php } else if ($row['STATUS'] == 8) { ?>
		<td align="center"><span style="color:gray">Data Telah Ditimpa oleh <?= $row['UPDATED_BY']." pada tanggal " .$row['TANGGAL_PENERIMAAN'];?></span></td>
	<?php } ?>
	<?php if ($namusr == "YAN YAN MULYANA") { ?>
		<?php if ($row['STATUS'] == 2) { ?>
			<td align='center' style='border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA'></td>
		<?php } else if ($row['STATUS'] == 8) { ?>
			<td align='center' style='border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA'></td>
		<?php } else { ?>
			<td align='center' style='border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA'><input type='checkbox' name='box1[]' value="<?= $row['POLIS'].','.$row['KONDISI_UPDATE'].','.$row['STATUS'];?>"></td>
		<?php } ?>
	<?php } ?>
<?php } ?>
<?php if ($namusr == "YAN YAN MULYANA") { ?>
<tr>
	<td colspan ='5'></td>
	<td align="center">
		<? echo "<input type='submit' name='check' value='Approve'>";?>
		<? echo "<input type='submit' name='uncheck' value='Decline'>";?>
	</td>
</tr>
<?php } ?>
</tbody>

</table>
</form>
