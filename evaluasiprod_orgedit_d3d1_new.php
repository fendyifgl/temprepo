<? 
	// Modified by Fendy 12/12/2018
	include "../../includes/session.php";
	include "../../includes/database.php";
	
	$conn = ocilogon("nadm", "ifg#dbs#nadm#2020", "IFGDB");
	$DB = new Database($userid,$passwd,$DBName);
	$DB1=new Database($userid,$passwd,$DBName);

	$directLevel2 = array("00","09","05");
	$directLevel3 = array("00","09");
	$filterkantor = $kdkantor ? $kdkantor : $kantor;
	// Program fast track 2017
	// Pencapaian KPI 20 Kantor Cabang lewat entry agen baru dari data agen lama
	/*$boleh = array('DION_KP', 'REDI_KP', 'AGEN_KP', 'VERA_KS', 'PRIYA_KP', 'FERY_KP', 'TIMMY_BC', 'WAYAN_MC');
	if (in_array($userid, $boleh)) {
		header('Location: evaluasiprod_orgedit_temp.php');
	}*/
 ?>

<link href="../jws.css" rel="stylesheet" type="text/css">
<style type="text/css">
	th.verdana7blu {
		color: #ffffff;
		font-weight:bold;
		text-transform:uppercase;
		background-color:#0066FF;
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
		font-size:7.15pt;
		font-family:Verdana, Helvetica, sans-serif;
	}
	.warning {
		background-color:#EAFF00;
	}
	.danger {
		background-color:#FF0000;
	}
</style>
<?php 
$sqlagency = "select * from $DBUser.tabel_001_kantor a, $DBUser.TABEL_001_AGENCY_KANTOR b where a.kdkantor = b.kdkantor and (SELECT NAMA_AGENCY FROM $DBUser.TABEL_001_AGENCY_KANTOR where kdkantor = '$filterkantor') = b.nama_agency  and a.kdkantor<>'XA' order by a.kdkantor asc ";
//echo $sqlagency;
//$DB->parse($sqlagency);
//$DB->execute();
//while ($arr=$DB->nextrow()) {
	
	//$kdkantoratasan=ociparse($conn, $sqlagency);
			//ociexecute($kdkantoratasan);
			//ocifetch($kdkantoratasan);
 
?>

<!--a class="verdana10blk"><b>(new) DAFTAR PENETAPAN AGEN AGENCY <?= ociresult($kdkantoratasan,"NAMA_AGENCY"); ?> </b></a-->
<? if($kantor=="KP") { ?>
<table cellpadding="1" cellspacing="2">
	<form action="<? $PHP_SELF; ?>" method="post" name="memreg">
	<tr>
		<td style="font-size:12">Pilih Kantor</td>
		<td class="agenpk">:</td>
		<td>
			<select name="kdkantor" size="1">
				<option value="all" class="agenpk">-- Silahkan Pilih --</option>
				<? $conn=ocilogon($DBUser, $DBPass, $DBName); 
				$sqlktr1="SELECT kdkantor,namakantor FROM tabel_001_kantor WHERE status = '1' order by kdkantor ASC";
				$sqlktr=ociparse($conn,$sqlktr1);
				ociexecute($sqlktr);
				while(ocifetch($sqlktr)) {
					$selected = ociresult($sqlktr,"KDKANTOR")==$kdkantor ? 'selected' : '';
					echo "<option value=".ociresult($sqlktr,"KDKANTOR")." class='agenpk' $selected>".ociresult($sqlktr,"KDKANTOR")." - ".ociresult($sqlktr,"NAMAKANTOR")."</option>";
				} ?>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2"></td>
		<td align="left"><input name="cari" value="Cari" type="submit"></td>
	</tr>
	</form>
</table>
<? } ?>

<hr size="1">
<H4> AGENCY </H4>

<script language="JavaScript" type="text/javascript" src="../includes/window.js"></script>

<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse;border-color:#006699;" width="800" id="AutoNumber1">
	<tr>
		<th class="verdana7blu" rowspan="3">No</th>
		<th class="verdana7blu" rowspan="3">Nomor Agen</th>
		<th class="verdana7blu" colspan="3">Lisensi Agen</th>
		<th class="verdana7blu" rowspan="3">Nama Agen</th>
		<th class="verdana7blu" rowspan="3">Kantor/Unit Kerja</th>
		<th class="verdana7blu" colspan="4">Penetapan Predikat Baru</th>
		<th class="verdana7blu" rowspan="3">Jenis Mutasi</th>
		<th class="verdana7blu" rowspan="2" colspan="2">PKAJ</th>
		<th class="verdana7blu" rowspan="3">SPA</th>
		<th class="verdana7blu" rowspan="3">Usia</th>
		<th class="verdana7blu" rowspan="3">Keterangan</th>
	</tr>
	<tr>
		<th class="verdana7blu" rowspan="2">Nomor Lisensi</th>
		<th class="verdana7blu" rowspan="2">Tgl Berlaku</th>
		<th class="verdana7blu" rowspan="2">Tgl Berakhir</th>
		<th class="verdana7blu" rowspan="2">Jabatan</th>
		<th class="verdana7blu" rowspan="2">PER TGL</th>
		<th class="verdana7blu" colspan="2">NO SPA/SK</th>
	</tr>
	<tr>
		<th class="verdana7blu">Nomor</th>
		<th class="verdana7blu">Tanggal</th>
		<th class="verdana7blu">Tanggal</th>
		<th class="verdana7blu">Sisa Berlaku</th>
	</tr>
  
	<?php 
	$sql = "SELECT MAX(KDJABATANAGEN) AS STARTFROM 
			FROM $DBUser.TABEL_400_AGEN A 
			INNER JOIN $DBUser.TABEL_001_AGENCY_KANTOR B ON a.kdkantor = b.kdkantor
			WHERE b.nama_agency IN (SELECT NAMA_AGENCY FROM $DBUser.TABEL_001_AGENCY_KANTOR where kdkantor = '$filterkantor')
				AND KDJABATANAGEN IN ('24','25','26')";
	
	
	/*==================== new hirarki 2021 ===================*/

	$query = "SELECT MAX(KDJABATANAGEN) AS STARTFROM FROM $DBUser.TABEL_400_AGEN A, $DBUser.TABEL_001_AGENCY_KANTOR B WHERE a.kdkantor = b.kdkantor and (SELECT NAMA_AGENCY FROM $DBUser.TABEL_001_AGENCY_KANTOR where kdkantor = '$filterkantor') = b.nama_agency AND KDJABATANAGEN IN ('24','25','26')";
		
		$sql1= ociparse($conn, $query);
		ociexecute($sql1);
		ocifetch($sql1);
	
		$query2 = "SELECT MAX(LEVEL) as LEVELMAX from $DBUser.TABEL_400_AGEN A, $DBUser.TABEL_001_AGENCY_KANTOR B WHERE a.kdkantor = b.kdkantor and (SELECT NAMA_AGENCY FROM $DBUser.TABEL_001_AGENCY_KANTOR where kdkantor = '$filterkantor') = b.nama_agency
					AND KDJABATANAGEN IN ('24','25','26','27')	
					START WITH KDJABATANAGEN =  '".ociresult($sql1,"STARTFROM")."'				
					CONNECT BY PRIOR noagen = atasan";
		$sql12= ociparse($conn, $query2);
		ociexecute($sql12);
		ocifetch($sql12);
	
		$sql = "SELECT * FROM 
					(
						(SELECT a.kdkantor prefixagen, a.noagen,A.ATASAN,A.noagenrekr, d.namaklien1 AS namaagen,a.kdkantor,namajabatanagen, TO_CHAR(a.tglpenetapan, 'dd/mm/yyyy') tglpenetapan, kdunitproduksi,
						(select KETERANGAN FROM TABEL_417_HISTORI_JABATAN i WHERE i.NOAGEN = a.Noagen and TGLJABATAN = (SELECT MAX(TGLJABATAN) FROM TABEL_417_HISTORI_JABATAN j WHERE j.NOAGEN = a.Noagen AND STATUS_APPROVAL = 2) AND STATUS_APPROVAL = 2) as NO_SK, (SELECT MAX(TGLJABATAN) FROM TABEL_417_HISTORI_JABATAN k WHERE k.NOAGEN = a.Noagen) AS TGL_SK,
						a.noskagen, TO_CHAR(a.tglskagen, 'dd/mm/yyyy') tglskagen, FLOOR(MONTHS_BETWEEN(sysdate, d.tgllahir)/12) usia, a.kdjabatanagen,
						a.namabank, a.norekening, a.nodplk, a.nolisensiagen, to_char(tglmulailisensi,'dd/mm/yyyy') tglmulailisensi, 
						to_char(tglakhirlisensi,'dd/mm/yyyy')tglakhirlisensi, 
						(SELECT namakantor FROM $DBUser.tabel_001_kantor c, $DBUser.TABEL_001_AGENCY_KANTOR d  WHERE c.kdkantor = d.kdkantor AND c.kdkantor = a.kdkantor and (SELECT NAMA_AGENCY FROM $DBUser.TABEL_001_AGENCY_KANTOR where kdkantor = '$filterkantor') = d.nama_agency) namabo, TO_CHAR(tglpkajagen, 'dd/mm/yyyy') tglpkaj, 
						floor(months_between(sysdate, tglpkajagen) /12) yearexppkaj, FLOOR(months_between(tglakhirlisensi,SYSDATE) /12) yearexpls,
						NVL((SELECT COUNT(*) FROM $DBUser.tabel_400_pkaj_agen WHERE noagen = a.noagen), 0) jmlpkaj,
						CASE WHEN FLOOR(ADD_MONTHS(tglpkajagen, 24) - sysdate) > 0 THEN FLOOR(ADD_MONTHS(tglpkajagen, 24) - sysdate) ELSE 0 END sisapkaj,
						(SELECT y.kdjabatanagen FROM $DBUser.tabel_400_agen y where a.atasan = y.noagen) as jabatanatasan,
						(SELECT n.kdjabatanagen FROM $DBUser.tabel_400_agen n where n.noagen = (select atasan from $DBUser.tabel_400_agen s where s.noagen = a.atasan)) as jabatanatasan2,
						level as levelhirarki,
						CASE
							WHEN  a.NOLISENSIAGEN IS NOT NULL AND (ADD_MONTHS (SYSDATE,-3)) < a.TGLAKHIRLISENSI THEN 1 ELSE 0 END AS CEKLISENSI
						FROM $DBUser.tabel_400_agen a
						INNER JOIN $DBUser.tabel_406_kode_pangkat_agen b ON a.kdpangkat = b.kdpangkat
						INNER JOIN $DBUser.tabel_413_jabatan_agen c ON a.kdjabatanagen = c.kdjabatanagen
						INNER JOIN $DBUser.tabel_100_klien d ON a.noagen = d.noklien
						INNER JOIN $DBUser.tabel_001_agency_kantor g on g.kdkantor = a.kdkantor
						LEFT OUTER JOIN (
							SELECT noagen, MAX(tglpkajagen) tglpkajagen
							FROM $DBUser.tabel_400_pkaj_agen
							GROUP BY noagen
						) e ON a.noagen = e.noagen
						WHERE a.kdstatusagen NOT IN ('02', '04', '03')
							AND (SELECT NAMA_AGENCY FROM $DBUser.TABEL_001_AGENCY_KANTOR where kdkantor = '$filterkantor') = g.nama_agency
							AND a.KDJABATANAGEN IN ('24','25','26','27')
						START WITH a.KDJABATANAGEN = '".ociresult($sql1,"STARTFROM")."'
						CONNECT BY nocycle PRIOR a.noagen = a.atasan)
						UNION ALL
						(SELECT a.kdkantor prefixagen, a.noagen,A.ATASAN,A.noagenrekr, d.namaklien1 AS namaagen,a.kdkantor,namajabatanagen, TO_CHAR(a.tglpenetapan, 'dd/mm/yyyy') tglpenetapan, kdunitproduksi,
						(select KETERANGAN FROM TABEL_417_HISTORI_JABATAN i WHERE i.NOAGEN = a.Noagen and TGLJABATAN = (SELECT MAX(TGLJABATAN) FROM TABEL_417_HISTORI_JABATAN j WHERE j.NOAGEN = a.Noagen AND STATUS_APPROVAL = 2) AND STATUS_APPROVAL = 2) as NO_SK, (SELECT MAX(TGLJABATAN) FROM TABEL_417_HISTORI_JABATAN k WHERE k.NOAGEN = a.Noagen AND STATUS_APPROVAL = 2) AS TGL_SK,
						a.noskagen, TO_CHAR(a.tglskagen, 'dd/mm/yyyy') tglskagen, FLOOR(MONTHS_BETWEEN(sysdate, d.tgllahir)/12) usia, a.kdjabatanagen,
						a.namabank, a.norekening, a.nodplk, a.nolisensiagen, to_char(tglmulailisensi,'dd/mm/yyyy') tglmulailisensi, 
						to_char(tglakhirlisensi,'dd/mm/yyyy')tglakhirlisensi, 
						(SELECT namakantor FROM $DBUser.tabel_001_kantor c, $DBUser.TABEL_001_AGENCY_KANTOR d WHERE c.kdkantor = d.kdkantor AND c.kdkantor = a.kdkantor and (SELECT NAMA_AGENCY FROM $DBUser.TABEL_001_AGENCY_KANTOR where kdkantor = '$filterkantor') = d.nama_agency) namabo, TO_CHAR(tglpkajagen, 'dd/mm/yyyy') tglpkaj, 
						floor(months_between(sysdate, tglpkajagen) /12) yearexppkaj, FLOOR(months_between(tglakhirlisensi,SYSDATE) /12) yearexpls,
						NVL((SELECT COUNT(*) FROM $DBUser.tabel_400_pkaj_agen WHERE noagen = a.noagen), 0) jmlpkaj,
						CASE WHEN FLOOR(ADD_MONTHS(tglpkajagen, 24) - sysdate) > 0 THEN FLOOR(ADD_MONTHS(tglpkajagen, 24) - sysdate) ELSE 0 END sisapkaj,
						(SELECT y.kdjabatanagen FROM $DBUser.tabel_400_agen y where a.atasan = y.noagen) as jabatanatasan,
						(SELECT n.kdjabatanagen FROM $DBUser.tabel_400_agen n where n.noagen = (select atasan from $DBUser.tabel_400_agen s where s.noagen = a.atasan)) as jabatanatasan2,
						0 as levelhirarki,
						CASE
							WHEN  a.NOLISENSIAGEN IS NOT NULL AND (ADD_MONTHS (SYSDATE,-3)) < a.TGLAKHIRLISENSI THEN 1 ELSE 0 END AS CEKLISENSI
						FROM $DBUser.tabel_400_agen a
						INNER JOIN $DBUser.tabel_406_kode_pangkat_agen b ON a.kdpangkat = b.kdpangkat
						INNER JOIN $DBUser.tabel_413_jabatan_agen c ON a.kdjabatanagen = c.kdjabatanagen
						INNER JOIN $DBUser.tabel_100_klien d ON a.noagen = d.noklien
						INNER JOIN $DBUser.TABEL_001_AGENCY_KANTOR g on a.kdkantor = g.kdkantor
						LEFT OUTER JOIN (
							SELECT noagen, MAX(tglpkajagen) tglpkajagen
							FROM $DBUser.tabel_400_pkaj_agen
							GROUP BY noagen
						) e ON a.noagen = e.noagen
						WHERE a.kdstatusagen NOT IN ('02', '03', '04')
							AND (SELECT NAMA_AGENCY FROM $DBUser.TABEL_001_AGENCY_KANTOR where kdkantor = '$filterkantor') = g.nama_agency
							AND a.KDJABATANAGEN IN ('24','25','26','27')
							AND (
									a.ATASAN IS NULL 
									OR (a.atasan IN (SELECT NOAGEN FROM $DBUser.TABEL_400_AGEN y WHERE y.atasan is null and (y.kdkantor = '$filterkantor' or y.kdkantor = (select kdkantor from $DBUser.tabel_400_agen where noagen = y.noagen)) AND y.kdstatusagen = '01'))
								)
							AND a.NOAGEN NOT IN (
				                    SELECT NOAGEN FROM TABEL_400_AGEN
				                    WHERE   kdstatusagen NOT IN ('02', '04', '03')
				                            AND kdkantor = '$filterkantor'
				                            AND KDJABATANAGEN IN ('24', '25', '26', '27')
				                    START WITH KDJABATANAGEN = '".ociresult($sql1,"STARTFROM")."'
				                    CONNECT BY NOCYCLE PRIOR noagen = atasan
				                )
							AND a.KDJABATANAGEN !=  '".ociresult($sql1,"STARTFROM")."'
						)

					)km
				
	";


		// echo $sql; 
	/*$sql = "SELECT * FROM 
					(
						(SELECT a.kdkantor prefixagen, a.noagen,A.ATASAN,A.noagenrekr, d.namaklien1 AS namaagen,a.kdkantor,namajabatanagen, TO_CHAR(a.tglpenetapan, 'dd/mm/yyyy') tglpenetapan, kdunitproduksi,
						a.noskagen, TO_CHAR(a.tglskagen, 'dd/mm/yyyy') tglskagen, FLOOR(MONTHS_BETWEEN(sysdate, d.tgllahir)/12) usia, a.kdjabatanagen,
						a.namabank, a.norekening, a.nodplk, a.nolisensiagen, to_char(tglmulailisensi,'dd/mm/yyyy') tglmulailisensi, 
						to_char(tglakhirlisensi,'dd/mm/yyyy')tglakhirlisensi, 
						(SELECT namakantor FROM $DBUser.tabel_001_kantor c, $DBUser.TABEL_001_AGENCY_KANTOR d  WHERE c.kdkantor = d.kdkantor AND c.kdkantor = a.kdkantor and (SELECT NAMA_AGENCY FROM $DBUser.TABEL_001_AGENCY_KANTOR where kdkantor = '$filterkantor') = d.nama_agency) namabo, TO_CHAR(tglpkajagen, 'dd/mm/yyyy') tglpkaj, 
						floor(months_between(sysdate, tglpkajagen) /12) yearexppkaj, FLOOR(months_between(tglakhirlisensi,SYSDATE) /12) yearexpls,
						NVL((SELECT COUNT(*) FROM $DBUser.tabel_400_pkaj_agen WHERE noagen = a.noagen), 0) jmlpkaj,
						CASE WHEN FLOOR(ADD_MONTHS(tglpkajagen, 24) - sysdate) > 0 THEN FLOOR(ADD_MONTHS(tglpkajagen, 24) - sysdate) ELSE 0 END sisapkaj,
						(SELECT y.kdjabatanagen FROM $DBUser.tabel_400_agen y where a.atasan = y.noagen) as jabatanatasan,
						(SELECT n.kdjabatanagen FROM $DBUser.tabel_400_agen n where n.noagen = (select atasan from $DBUser.tabel_400_agen s where s.noagen = a.atasan)) as jabatanatasan2,
						level as levelhirarki,
						CASE
							WHEN  a.NOLISENSIAGEN IS NOT NULL AND (ADD_MONTHS (SYSDATE,-3)) < a.TGLAKHIRLISENSI THEN 1 ELSE 0 END AS CEKLISENSI
						FROM $DBUser.tabel_400_agen a
						INNER JOIN $DBUser.tabel_406_kode_pangkat_agen b ON a.kdpangkat = b.kdpangkat
						INNER JOIN $DBUser.tabel_413_jabatan_agen c ON a.kdjabatanagen = c.kdjabatanagen
						INNER JOIN $DBUser.tabel_100_klien d ON a.noagen = d.noklien
						INNER JOIN $DBUser.tabel_001_agency_kantor g on g.kdkantor = a.kdkantor
						LEFT OUTER JOIN (
							SELECT noagen, MAX(tglpkajagen) tglpkajagen
							FROM $DBUser.tabel_400_pkaj_agen
							GROUP BY noagen
						) e ON a.noagen = e.noagen
						WHERE a.kdstatusagen NOT IN ('02', '04', '03')
							AND (SELECT NAMA_AGENCY FROM $DBUser.TABEL_001_AGENCY_KANTOR where kdkantor = '$filterkantor') = g.nama_agency
							AND a.KDJABATANAGEN IN ('24','25','26','27')
						CONNECT BY PRIOR a.noagen = a.atasan)
						UNION ALL
						(SELECT a.kdkantor prefixagen, a.noagen,A.ATASAN,A.noagenrekr, d.namaklien1 AS namaagen,a.kdkantor,namajabatanagen, TO_CHAR(a.tglpenetapan, 'dd/mm/yyyy') tglpenetapan, kdunitproduksi,
						a.noskagen, TO_CHAR(a.tglskagen, 'dd/mm/yyyy') tglskagen, FLOOR(MONTHS_BETWEEN(sysdate, d.tgllahir)/12) usia, a.kdjabatanagen,
						a.namabank, a.norekening, a.nodplk, a.nolisensiagen, to_char(tglmulailisensi,'dd/mm/yyyy') tglmulailisensi, 
						to_char(tglakhirlisensi,'dd/mm/yyyy')tglakhirlisensi, 
						(SELECT namakantor FROM $DBUser.tabel_001_kantor c, $DBUser.TABEL_001_AGENCY_KANTOR d WHERE c.kdkantor = d.kdkantor AND c.kdkantor = a.kdkantor and (SELECT NAMA_AGENCY FROM $DBUser.TABEL_001_AGENCY_KANTOR where kdkantor = '$filterkantor') = d.nama_agency) namabo, TO_CHAR(tglpkajagen, 'dd/mm/yyyy') tglpkaj, 
						floor(months_between(sysdate, tglpkajagen) /12) yearexppkaj, FLOOR(months_between(tglakhirlisensi,SYSDATE) /12) yearexpls,
						NVL((SELECT COUNT(*) FROM $DBUser.tabel_400_pkaj_agen WHERE noagen = a.noagen), 0) jmlpkaj,
						CASE WHEN FLOOR(ADD_MONTHS(tglpkajagen, 24) - sysdate) > 0 THEN FLOOR(ADD_MONTHS(tglpkajagen, 24) - sysdate) ELSE 0 END sisapkaj,
						(SELECT y.kdjabatanagen FROM $DBUser.tabel_400_agen y where a.atasan = y.noagen) as jabatanatasan,
						(SELECT n.kdjabatanagen FROM $DBUser.tabel_400_agen n where n.noagen = (select atasan from $DBUser.tabel_400_agen s where s.noagen = a.atasan)) as jabatanatasan2,
						0 as levelhirarki,
						CASE
							WHEN  a.NOLISENSIAGEN IS NOT NULL AND (ADD_MONTHS (SYSDATE,-3)) < a.TGLAKHIRLISENSI THEN 1 ELSE 0 END AS CEKLISENSI
						FROM $DBUser.tabel_400_agen a
						INNER JOIN $DBUser.tabel_406_kode_pangkat_agen b ON a.kdpangkat = b.kdpangkat
						INNER JOIN $DBUser.tabel_413_jabatan_agen c ON a.kdjabatanagen = c.kdjabatanagen
						INNER JOIN $DBUser.tabel_100_klien d ON a.noagen = d.noklien
						INNER JOIN $DBUser.TABEL_001_AGENCY_KANTOR g on a.kdkantor = g.kdkantor
						LEFT OUTER JOIN (
							SELECT noagen, MAX(tglpkajagen) tglpkajagen
							FROM $DBUser.tabel_400_pkaj_agen
							GROUP BY noagen
						) e ON a.noagen = e.noagen
						WHERE a.kdstatusagen NOT IN ('02', '03', '04')
							AND (SELECT NAMA_AGENCY FROM $DBUser.TABEL_001_AGENCY_KANTOR where kdkantor = '$filterkantor') = g.nama_agency
							AND a.KDJABATANAGEN IN ('24','25','26','27')
							AND (
									a.ATASAN IS NULL 
									OR (a.atasan IN (SELECT NOAGEN FROM $DBUser.TABEL_400_AGEN y WHERE y.atasan is null and y.kdkantor = '$filterkantor' AND y.kdstatusagen = '01'))
								)
							AND a.NOAGEN NOT IN (
				                    SELECT NOAGEN FROM TABEL_400_AGEN
				                    WHERE   kdstatusagen NOT IN ('02', '04', '03')
				                            AND kdkantor = '$filterkantor'
				                            AND KDJABATANAGEN IN ('24', '25', '26', '27')
				                    CONNECT BY PRIOR noagen = atasan
				                )
							AND a.KDJABATANAGEN !=  '".ociresult($sql1,"STARTFROM")."'
						)

					)km
				
	";*/
	//Testing *Mario 25 January 2021*
	$list = ociparse($conn, $sql);
	ociexecute($list);;//var_dump($DB0->parse($sql));
	//$DB0->execute();//var_dump($DB0->execute());
	//----------- INITIATE ARRAY ------------------------
	$size_of_the_array = ociresult($sql12,"LEVELMAX") == '' ? 1 : ociresult($sql12,"LEVELMAX"); //cari maksimum level 
	$level = array_fill(0, $size_of_the_array, 0);

	//--------------------penomoran baru IFG Life Nov 2021-----------------------------------------------------------------
	$leveling = array (
		    "BP"  => 0,
		    "BM" => 0,
		    "BE"   => 0,
		    "BE"   => 0,
		    "BE_DIBAWAH_BE"   => 0,
		    "BE_DIRECT_BP"   => 96,
		    "BM_TIDAKADA_ATASAN_BP"   => 0,
		    "BE_DIBAWAH_BM_TIDAKADA_ATASAN_BP"   => 0,
		    "BE_TIDAKADA_ATASAN_BM"   => 0,
		    "BE_DIBAWAH_BE_TIDAKADA_ATASAN_BM"   => 0
		);

	while (($arr0 = oci_fetch_array($list, OCI_BOTH)) != false) {
		//print_r($arr0=$DB0->nextrow());
		$directFlag = 0;
		$bgcolor = $arr0['SISAPKAJ'] < 30 && !empty($arr0['TGLPKAJ']) ? $danger : ($arr0['SISAPKAJ'] < 60 && !empty($arr0['TGLPKAJ']) ? $warning : '');
		$usia = $arr0['USIA'] >= 65 ? $danger : 'null'; //echo $usia;
		$ytemp = y; 
		$temp_nomor = array();
		for($idx=0; $idx < $arr0['LEVELHIRARKI']; $idx++) 
		{
			if($idx == $arr0['LEVELHIRARKI']-1)
			{
				$level[$idx] = $level[$idx]+1;
				for($resetidx=$idx+1; $resetidx<$size_of_the_array;$resetidx++)
				{
					$level[$resetidx] = 0;
				}
			}
			//var_dump(array_push($temp_nomor,$level[$idx]));
			array_push($temp_nomor,$level[$idx]);
		}
		//--------------------penomoran baru IFG Life Nov 2021-----------------------------------------------------------------

		if($arr0['KDJABATANAGEN'] == '26' && ($arr0['ATASAN'] == '' OR empty($arr0['ATASAN']))){
			$leveling["BP"] = $leveling["BP"] + 1;
			//RESET PENOMORAN BM dan BE_DIRECT_BP
			$leveling["BM"] = 0;
			$leveling["BE_DIRECT_BP"] = 96;
			$newnomor = $leveling["BP"];
		}
		else if($arr0['KDJABATANAGEN'] == '25' && $arr0['JABATANATASAN'] == '26'){
			$leveling["BM"] = $leveling["BM"] + 1;
			//RESET PENOMORAN BE
			$leveling["BE"] = 0;
			$newnomor = $leveling["BP"].".".$leveling["BM"];
		}
		else if(($arr0['KDJABATANAGEN'] == '24' || $arr0['KDJABATANAGEN'] == '27') && $arr0['JABATANATASAN'] == '25' && $arr0['JABATANATASAN2'] == '26'){
			$leveling["BE"] = $leveling["BE"] + 1;
			//RESET PENOMORAN BE_DIBAWAH_BE
			$leveling["BE_DIBAWAH_BE"] = 0;
			$newnomor = $leveling["BP"].".".$leveling["BM"].".".$leveling["BE"];
		}
		else if(($arr0['KDJABATANAGEN'] == '24' || $arr0['KDJABATANAGEN'] == '27') && $arr0['JABATANATASAN'] == '24' && $arr0['JABATANATASAN2'] == '25'){
			$leveling["BE_DIBAWAH_BE"] = $leveling["BE_DIBAWAH_BE"] + 1;
			$newnomor = $leveling["BP"].".".$leveling["BM"].".".$leveling["BE"].".".$leveling["BE_DIBAWAH_BE"];
		}
		else if(($arr0['KDJABATANAGEN'] == '24' || $arr0['KDJABATANAGEN'] == '27') && $arr0['JABATANATASAN'] == '26'){
			$leveling["BE_DIRECT_BP"] = $leveling["BE_DIRECT_BP"]+1;
			$newnomor = $leveling["BP"].".".chr($leveling["BE_DIRECT_BP"]);
		}
		else if($arr0['KDJABATANAGEN'] == '25' && $arr0['JABATANATASAN'] != '26'){
			$leveling["BM_TIDAKADA_ATASAN_BP"] = $leveling["BM_TIDAKADA_ATASAN_BP"]+1;
			//RESET PENOMORAN BE_DIBAWAH_BM_TIDAKADA_ATASAN_BP
			$leveling["BE_DIBAWAH_BM_TIDAKADA_ATASAN_BP"] = 0;
			$newnomor = "X.".$leveling["BM_TIDAKADA_ATASAN_BP"];
		}
		else if(($arr0['KDJABATANAGEN'] == '24' || $arr0['KDJABATANAGEN'] == '27') && $arr0['JABATANATASAN'] == '25' && $arr0['JABATANATASAN2'] != '26'){
			$leveling["BE_DIBAWAH_BM_TIDAKADA_ATASAN_BP"] = $leveling["BE_DIBAWAH_BM_TIDAKADA_ATASAN_BP"]+1;
			$newnomor = "X.".$leveling["BM_TIDAKADA_ATASAN_BP"].".".$leveling["BE_DIBAWAH_BM_TIDAKADA_ATASAN_BP"];
		}
		else if(($arr0['KDJABATANAGEN'] == '24' || $arr0['KDJABATANAGEN'] == '27') && $arr0['JABATANATASAN'] != '25' && $arr0['JABATANATASAN'] != '26' && $arr0['JABATANATASAN'] != '24'){
			$leveling["BE_TIDAKADA_ATASAN_BM"] = $leveling["BE_TIDAKADA_ATASAN_BM"]+1;
			//RESET PENOMORAN BE_DIBAWAH_BM_TIDAKADA_ATASAN_BP
			$leveling["BE_DIBAWAH_BE_TIDAKADA_ATASAN_BM"] = 0;
			$newnomor = "X.X.".$leveling["BE_TIDAKADA_ATASAN_BM"];
		}
		else if(($arr0['KDJABATANAGEN'] == '24' || $arr0['KDJABATANAGEN'] == '27') && $arr0['JABATANATASAN'] == '24' && $arr0['JABATANATASAN2'] != '25' && $arr0['JABATANATASAN2'] != '26'){
			$leveling["BE_DIBAWAH_BE_TIDAKADA_ATASAN_BM"] = $leveling["BE_DIBAWAH_BE_TIDAKADA_ATASAN_BM"]+1;
			$newnomor = "X.X.".$leveling["BE_TIDAKADA_ATASAN_BM"].".".$leveling["BE_DIBAWAH_BE_TIDAKADA_ATASAN_BM"];
		}else{
			$newnomor = '-';
		}
	//Tutup Testing *Mario 25 January 2021*
		$nomor = implode(".",$temp_nomor);
		echo "<tr>";
			echo "<td class='$nameClass'>$newnomor</td>"; 
			echo "<td class='$nameClass' align='center' nowrap>$arr0[KDKANTOR]-$arr0[NOAGEN]</td>";
			// echo "<td class='$nameClass' align='center' nowrap>$arr0[NOAGENREKR]</td>";
			if ($arr0['CEKLISENSI'] == 0){  
				echo "<td class='$nameClass' style='background-color:#FF0000;' align='center' nowrap>$arr0[NOLISENSIAGEN]</td>";
			}else{
				echo "<td class='$nameClass' nowrap>$arr0[NOLISENSIAGEN]</td>";
			} 
			echo "<td class='$nameClass' nowrap>$arr0[TGLMULAILISENSI]</td>"; 
			echo "<td class='$nameClass' nowrap>$arr0[TGLAKHIRLISENSI]</td>";
			echo "<td class='$nameClass' nowrap>$arr0[NAMAAGEN]</td>";
			echo "<td class='$nameClass' nowrap>$arr0[NAMABO]</td>";
			echo "<td class='$nameClass' nowrap>$arr0[NAMAJABATANAGEN]</td>";	  
			echo "<td class='$nameClass' nowrap>$arr0[TGLPENETAPAN]</td>";	  
			if ($arr0['KDJABATANAGEN'] == '27'){
				echo "<td class='$nameClass' nowrap>$arr0[NOSKAGEN]</td>";	  
				echo "<td class='$nameClass' nowrap>$arr0[TGLSKAGEN]</td>";
			}else{
				echo "<td class='$nameClass' nowrap>$arr0[NO_SK]</td>";	  
				echo "<td class='$nameClass' nowrap>$arr0[TGL_SK]</td>";
			}	  
			echo "<td class='$nameClass' nowrap></td>";
			echo "<td class='$nameClass' style='background-color:$bgcolor;' nowrap>$arr0[TGLPKAJ]</td>";
			echo "<td class='$nameClass' style='background-color:$bgcolor;' nowrap>".(!empty($arr0['TGLPKAJ']) ? "$arr0[SISAPKAJ] hari" : null)."</td>";
			echo "<td class='$nameClass' align='center' nowrap>";
			echo "<a href='javascript:void(0);' onclick=\"NewWindow('updspa_new2020.php?&noagen=$arr0[NOAGEN]&preagen=$arr0[PREFIXAGEN]&kdjabatanagen=$arr0[KDJABATANAGEN]','updspa',500,400,1);\">SPA</a>";
			// if ($arr0['JMLPKAJ'] == 0)
			// 	echo "N/A";
			// else
			// 	echo "<a href='javascript:void(0);' onclick=\"NewWindow('updspa_new2020.php?&noagen=$arr0[NOAGEN]&preagen=$arr0[PREFIXAGEN]&kdjabatanagen=$arr0[KDJABATANAGEN]','updspa',500,400,1);\">SPA</a>";
			echo "</td>";
			echo "<td class='$nameClass' style='background-color:$usia;' align='center' nowrap>$arr0[USIA]</td>";
			/* if($directFlag == 1){
				echo "<td class='$nameClass' style='background-color:$usia;' align='center' nowrap>$directDesc</td>";
			} */
			//var_dump($arr0['ATASAN']);
			if($arr0['NOAGENREKR'] == NULL || $arr0['ATASAN'] == NULL || $arr0['NOAGENREKR'] == $arr0['ATASAN'] )
			{		
				echo "<td class='$nameClass' nowrap></td>";	
			}
			else if ($arr0['NOAGENREKR'] != $arr0['ATASAN'])
			{
				echo "<td class='$nameClass' nowrap>Enroller</td>";
			}
		echo "</tr>";
	}
	/*==================== AKHIR HIRARKI AGEN PP ====================*/
	?>
	
</table>

<!--<hr size="1">
<H4> ADE - INSTRUKTUR </H4>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse;border-color:#006699;" width="800" id="AutoNumber1">
	<tr>
		<th class="verdana7blu" rowspan="3">No</th>
		<th class="verdana7blu" rowspan="3">Nomor Agen</th>
		<th class="verdana7blu" colspan="3">Lisensi Agen</th>
		<th class="verdana7blu" rowspan="3">Nama Agen</th>
		<th class="verdana7blu" rowspan="3">Kantor/Unit Kerja</th>
		<th class="verdana7blu" colspan="4">Penetapan Predikat Baru</th>
		<th class="verdana7blu" rowspan="3">Jenis Mutasi</th>
		<th class="verdana7blu" rowspan="2" colspan="2">PKAJ</th>
		<th class="verdana7blu" rowspan="3">SPA</th>
		<th class="verdana7blu" rowspan="3">Usia</th>
	</tr>
	<tr>
		<th class="verdana7blu" rowspan="2">Nomor Lisensi</th>
		<th class="verdana7blu" rowspan="2">Tgl Berlaku</th>
		<th class="verdana7blu" rowspan="2">Tgl Berakhir</th>
		<th class="verdana7blu" rowspan="2">Jabatan</th>
		<th class="verdana7blu" rowspan="2">PER TGL</th>
		<th class="verdana7blu" colspan="2">NO SPA/SK</th>
	</tr>
	<tr>
		<th class="verdana7blu">Nomor</th>
		<th class="verdana7blu">Tanggal</th>
		<th class="verdana7blu">Tanggal</th>
		<th class="verdana7blu">Sisa Berlaku</th>
	</tr> -->
<?
/*==================== HIRARKI ADE, INSTRUKTUR ====================*/

/*$sql3 = "SELECT * FROM 
		(
			(SELECT a.prefixagen, a.noagen, d.namaklien1 AS namaagen,a.kdkantor,namajabatanagen, TO_CHAR(a.tglpenetapan, 'dd/mm/yyyy') tglpenetapan, kdunitproduksi,
			a.noskagen, TO_CHAR(a.tglskagen, 'dd/mm/yyyy') tglskagen, FLOOR(MONTHS_BETWEEN(sysdate, d.tgllahir)/12) usia, a.kdjabatanagen,
			a.namabank, a.norekening, a.nodplk, a.nolisensiagen, to_char(tglmulailisensi,'dd/mm/yyyy') tglmulailisensi, 
			to_char(tglakhirlisensi,'dd/mm/yyyy')tglakhirlisensi, 
			(SELECT namakantor FROM $DBUser.tabel_001_kantor c, $DBUser.TABEL_001_AGENCY_KANTOR d WHERE c.kdkantor = d.kdkantor AND c.kdkantor = a.kdkantor and (SELECT NAMA_AGENCY FROM $DBUser.TABEL_001_AGENCY_KANTOR where kdkantor = '$filterkantor') = d.nama_agency) namabo, TO_CHAR(tglpkajagen, 'dd/mm/yyyy') tglpkaj, 
			floor(months_between(sysdate, tglpkajagen) /12) yearexppkaj, FLOOR(months_between(tglakhirlisensi,SYSDATE) /12) yearexpls,
			NVL((SELECT COUNT(*) FROM $DBUser.tabel_400_pkaj_agen WHERE noagen = a.noagen), 0) jmlpkaj,
			CASE WHEN FLOOR(ADD_MONTHS(tglpkajagen, 24) - sysdate) > 0 THEN FLOOR(ADD_MONTHS(tglpkajagen, 24) - sysdate) ELSE 0 END sisapkaj,
			(SELECT y.kdjabatanagen FROM $DBUser.tabel_400_agen y where a.atasan = y.noagen) as jabatanatasan,
			level as levelhirarki,
			CASE
				WHEN  a.NOLISENSIAGEN IS NOT NULL AND (ADD_MONTHS (SYSDATE,-3)) < a.TGLAKHIRLISENSI THEN 1 ELSE 0 END AS CEKLISENSI
			FROM $DBUser.tabel_400_agen a
			INNER JOIN $DBUser.tabel_406_kode_pangkat_agen b ON a.kdpangkat = b.kdpangkat
			INNER JOIN $DBUser.tabel_413_jabatan_agen c ON a.kdjabatanagen = c.kdjabatanagen
			INNER JOIN $DBUser.tabel_100_klien d ON a.noagen = d.noklien
			INNER JOIN $DBUser.tabel_001_agency_kantor  g on g.kdkantor =	a.kdkantor
			LEFT OUTER JOIN (
				SELECT noagen, MAX(tglpkajagen) tglpkajagen
				FROM $DBUser.tabel_400_pkaj_agen
				GROUP BY noagen
			) e ON a.noagen = e.noagen
			WHERE a.kdstatusagen NOT IN ('02', '04', '03')
			AND (SELECT NAMA_AGENCY FROM $DBUser.TABEL_001_AGENCY_KANTOR where kdkantor = '$filterkantor') = g.nama_agency
				AND a.KDJABATANAGEN IN ('00','09','23')
	      	START WITH a.KDJABATANAGEN = '23'
	      	CONNECT BY nocycle PRIOR a.noagen = a.atasan)
	      	UNION ALL
		    (SELECT a.prefixagen, a.noagen, d.namaklien1 AS namaagen,a.kdkantor,namajabatanagen, TO_CHAR(a.tglpenetapan, 'dd/mm/yyyy') tglpenetapan, kdunitproduksi,
				a.noskagen, TO_CHAR(a.tglskagen, 'dd/mm/yyyy') tglskagen, FLOOR(MONTHS_BETWEEN(sysdate, d.tgllahir)/12) usia, a.kdjabatanagen,
				a.namabank, a.norekening, a.nodplk, a.nolisensiagen, to_char(tglmulailisensi,'dd/mm/yyyy') tglmulailisensi, 
				to_char(tglakhirlisensi,'dd/mm/yyyy')tglakhirlisensi, 
				(SELECT namakantor FROM $DBUser.tabel_001_kantor c, $DBUser.TABEL_001_AGENCY_KANTOR d WHERE c.kdkantor = d.kdkantor AND c.kdkantor = a.kdkantor and (SELECT NAMA_AGENCY FROM $DBUser.TABEL_001_AGENCY_KANTOR where kdkantor = '$filterkantor') = d.nama_agency) namabo, TO_CHAR(tglpkajagen, 'dd/mm/yyyy') tglpkaj, 
				floor(months_between(sysdate, tglpkajagen) /12) yearexppkaj, FLOOR(months_between(tglakhirlisensi,SYSDATE) /12) yearexpls,
				NVL((SELECT COUNT(*) FROM $DBUser.tabel_400_pkaj_agen WHERE noagen = a.noagen), 0) jmlpkaj,
				CASE WHEN FLOOR(ADD_MONTHS(tglpkajagen, 24) - sysdate) > 0 THEN FLOOR(ADD_MONTHS(tglpkajagen, 24) - sysdate) ELSE 0 END sisapkaj,
				(SELECT y.kdjabatanagen FROM $DBUser.tabel_400_agen y where a.atasan = y.noagen) as jabatanatasan,
				level as levelhirarki,
				CASE
					WHEN  a.NOLISENSIAGEN IS NOT NULL AND (ADD_MONTHS (SYSDATE,-3)) < a.TGLAKHIRLISENSI THEN 1 ELSE 0 END AS CEKLISENSI
				FROM $DBUser.tabel_400_agen a
				INNER JOIN $DBUser.tabel_406_kode_pangkat_agen b ON a.kdpangkat = b.kdpangkat
				INNER JOIN $DBUser.tabel_413_jabatan_agen c ON a.kdjabatanagen = c.kdjabatanagen
				INNER JOIN $DBUser.tabel_100_klien d ON a.noagen = d.noklien
				inner join $DBUser.tabel_001_agency_kantor g on g.kdkantor = a.kdkantor
				LEFT OUTER JOIN (
					SELECT noagen, MAX(tglpkajagen) tglpkajagen
					FROM $DBUser.tabel_400_pkaj_agen
					GROUP BY noagen
				) e ON a.noagen = e.noagen
			WHERE a.kdstatusagen NOT IN ('02', '04', '03')
			AND (SELECT NAMA_AGENCY FROM $DBUser.TABEL_001_AGENCY_KANTOR where kdkantor = '$filterkantor') = g.nama_agency
				AND a.KDJABATANAGEN IN ('00','09','08')
	      	START WITH a.KDJABATANAGEN = '08'
	      	CONNECT BY nocycle PRIOR a.noagen = a.atasan)
    	)km
	";
//echo $sql3;
$ade_ins=ociparse($conn, $sql3);
ociexecute($ade_ins);
$x = $y = $z = 0;
 //$json = json_encode($arr3=$DB3->nextrow());
 //echo $json;
 	while (($arr3 = oci_fetch_array($ade_ins, OCI_BOTH)) != false) {
	if($arr3['LEVELHIRARKI'] == 1){
		$x++;
		$nameClass = 'ade-instruktur';
		$index = $x;
	}else if($arr3["LEVELHIRARKI"] == 2){
		$y++;
    	$nameClass = 'ade-fa';
 		$index = $x.".".$y;
    }
	echo "<tr>";
		echo "<td class='$nameClass'>$index</td>"; 
		echo "<td class='$nameClass' align='center' nowrap>$arr3[PREFIXAGEN]-$arr3[NOAGEN]</td>";
		echo "<td class='$nameClass' nowrap>$arr3[NOLISENSIAGEN]</td>";
		echo "<td class='$nameClass' nowrap>$arr3[TGLMULAILISENSI]</td>";
		echo "<td class='$nameClass' nowrap>$arr3[TGLAKHIRLISENSI]</td>";
		echo "<td class='$nameClass' nowrap>$arr3[NAMAAGEN]</td>";
		echo "<td class='$nameClass' nowrap>$arr3[NAMABO]</td>";
		echo "<td class='$nameClass' nowrap>$arr3[NAMAJABATANAGEN]</td>";	  
		echo "<td class='$nameClass' nowrap>$arr3[TGLPENETAPAN]</td>";	  
		echo "<td class='$nameClass' nowrap>$arr3[NOSKAGEN]</td>";	  
		echo "<td class='$nameClass' nowrap>$arr3[TGLSKAGEN]</td>";	  
		echo "<td class='$nameClass' nowrap></td>";
		echo "<td class='$nameClass' style='background-color:$bgcolor;' nowrap>$arr3[TGLPKAJ]</td>";
		echo "<td class='$nameClass' style='background-color:$bgcolor;' nowrap></td>";
		echo "<td class='$nameClass' align='center' nowrap>";
		echo "<a href='javascript:void(0);' onclick=\"NewWindow('updspa_new2020.php?&noagen=$arr3[NOAGEN]&preagen=$arr3[PREFIXAGEN]&kdjabatanagen=$arr3[KDJABATANAGEN]','updspa',500,400,1);\">SPA</a>";
		echo "</td>";
		echo "<td class='$nameClass' style='background-color:$usia;' align='center' nowrap>$arr3[USIA]</td>";
	echo "</tr>";
}*/

/*==================== HIRARKI AGEN LPA ====================*/
?>
</table>

<hr size="1">
<H4> BANCASSURANCE </H4>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse;border-color:#006699;" width="800" id="AutoNumber1">
	<tr>
		<th class="verdana7blu" rowspan="3">No</th>
		<th class="verdana7blu" rowspan="3">Nomor Agen</th>
		<th class="verdana7blu" colspan="3">Lisensi Agen</th>
		<th class="verdana7blu" rowspan="3">Nama Agen</th>
		<th class="verdana7blu" rowspan="3">Kantor/Unit Kerja</th>
		<th class="verdana7blu" colspan="4">Penetapan Predikat Baru</th>
		<th class="verdana7blu" rowspan="3">Jenis Mutasi</th>
		<th class="verdana7blu" rowspan="2" colspan="2">PKAJ</th>
		<th class="verdana7blu" rowspan="3">SPA</th>
		<th class="verdana7blu" rowspan="3">Usia</th>
		<th class="verdana7blu" rowspan="3">Keterangan</th>
	</tr>
	<tr>
		<th class="verdana7blu" rowspan="2">Nomor Lisensi</th>
		<th class="verdana7blu" rowspan="2">Tgl Berlaku</th>
		<th class="verdana7blu" rowspan="2">Tgl Berakhir</th>
		<th class="verdana7blu" rowspan="2">Jabatan</th>
		<th class="verdana7blu" rowspan="2">PER TGL</th>
		<th class="verdana7blu" colspan="2">NO SPA/SK</th>
	</tr>
	<tr>
		<th class="verdana7blu">Nomor</th>
		<th class="verdana7blu">Tanggal</th>
		<th class="verdana7blu">Tanggal</th>
		<th class="verdana7blu">Sisa Berlaku</th>
	</tr>
<?
	$sql1 = "SELECT a.prefixagen, a.noagen, d.namaklien1 AS namaagen, namajabatanagen, TO_CHAR(a.tglpenetapan, 'dd/mm/yyyy') tglpenetapan, kdunitproduksi,
				a.noskagen, TO_CHAR(a.tglskagen, 'dd/mm/yyyy') tglskagen, FLOOR(MONTHS_BETWEEN(sysdate, d.tgllahir)/12) usia, a.kdjabatanagen,
				a.namabank, a.norekening, a.nodplk, a.nolisensiagen, to_char(tglmulailisensi,'dd/mm/yyyy') tglmulailisensi, 
				to_char(tglakhirlisensi,'dd/mm/yyyy')tglakhirlisensi, 
				(SELECT namakantor FROM $DBUser.tabel_001_kantor WHERE kdkantor = '$filterkantor') namabo, TO_CHAR(tglpkajagen, 'dd/mm/yyyy') tglpkaj, 
				floor(months_between(sysdate, tglpkajagen) /12) yearexppkaj, FLOOR(months_between(tglakhirlisensi,SYSDATE) /12) yearexpls,
				NVL((SELECT COUNT(*) FROM $DBUser.tabel_400_pkaj_agen WHERE noagen = a.noagen), 0) jmlpkaj,
				CASE WHEN FLOOR(ADD_MONTHS(tglpkajagen, 24) - sysdate) > 0 THEN FLOOR(ADD_MONTHS(tglpkajagen, 24) - sysdate) ELSE 0 END sisapkaj,
				CASE
					WHEN  a.NOLISENSIAGEN IS NOT NULL AND (ADD_MONTHS (SYSDATE,-3)) < a.TGLAKHIRLISENSI THEN 1 ELSE 0 END AS CEKLISENSI,
				CASE WHEN a.FILE_BAST IS NOT NULL THEN 1 ELSE 0 END AS CEKBASTFILE
			FROM $DBUser.tabel_400_agen a
			INNER JOIN $DBUser.tabel_406_kode_pangkat_agen b ON a.kdpangkat = b.kdpangkat
			INNER JOIN $DBUser.tabel_413_jabatan_agen c ON a.kdjabatanagen = c.kdjabatanagen
			INNER JOIN $DBUser.tabel_100_klien d ON a.noagen = d.noklien
			LEFT OUTER JOIN (
				SELECT noagen, MAX(tglpkajagen) tglpkajagen
				FROM $DBUser.tabel_400_pkaj_agen
				GROUP BY noagen
			) e ON a.noagen = e.noagen
			WHERE a.kdstatusagen NOT IN ('02', '04', '03')
				AND a.kdkantor = '$filterkantor'
				AND a.KDJABATANAGEN IN ('32','33','34','35','36','37','38')
			";
	$DB->parse($sql1);
	$DB->execute();
	$nopk = 1;
	$nameClass = 'agenpk';
	while($arr1=$DB->nextrow()) {
		echo "<tr>";
			echo "<td class='$nameClass'>$nopk</td>"; 
			echo "<td class='$nameClass' align='center' nowrap>$arr1[PREFIXAGEN]-$arr1[NOAGEN]</td>";
			if ($arr1[CEKLISENSI] == 0){  
				echo "<td class='$nameClass' style='background-color:#FF0000;' align='center' nowrap>$arr1[NOLISENSIAGEN]</td>";
			}else{
				echo "<td class='$nameClass' nowrap>$arr1[NOLISENSIAGEN]</td>";
			} 
			//echo "<td class='$nameClass' nowrap>$arr1[NOLISENSIAGEN]</td>";
			echo "<td class='$nameClass' nowrap>$arr1[TGLMULAILISENSI]</td>";
			echo "<td class='$nameClass' nowrap>$arr1[TGLAKHIRLISENSI]</td>";
			echo "<td class='$nameClass' nowrap>$arr1[NAMAAGEN]</td>";
			echo "<td class='$nameClass' nowrap>$arr1[NAMABO]</td>";
			echo "<td class='$nameClass' nowrap>$arr1[NAMAJABATANAGEN]</td>";	  
			echo "<td class='$nameClass' nowrap>$arr1[TGLPENETAPAN]</td>";	  
			echo "<td class='$nameClass' nowrap>$arr1[NOSKAGEN]</td>";	  
			echo "<td class='$nameClass' nowrap>$arr1[TGLSKAGEN]</td>";	  
			echo "<td class='$nameClass' nowrap></td>";
			echo "<td class='$nameClass' style='background-color:$bgcolor;' nowrap>$arr1[TGLPKAJ]</td>";
			echo "<td class='$nameClass' style='background-color:$bgcolor;' nowrap>".(!empty($arr0['TGLPKAJ']) ? "$arr1[SISAPKAJ] hari" : null)."</td>";
			if ($arr1[CEKLISENSI] != 0){  
				echo "<td class='$nameClass' style='background-color:#FF0000;' align='center' nowrap>SPA";
			}else{
				echo "<td class='$nameClass' align='center' nowrap>";
				echo "<a href='javascript:void(0);' onclick=\"NewWindow('updspa_new_lpa.php?&noagen=$arr1[NOAGEN]&preagen=$arr1[PREFIXAGEN]&kdjabatanagen=$arr1[KDJABATANAGEN]','updspa',500,400,1);\">SPA</a>";
			}
			echo "</td>";
			echo "<td class='$nameClass' style='background-color:$usia;' align='center' nowrap>$arr1[USIA]</td>";
			if ($arr1[CEKBASTFILE] == 0){  
				echo "<td class='$nameClass' style='background-color:#FF0000;' align='center' nowrap>Belum Upload File BAST.</td>";
			}else{
				echo "<td class='$nameClass' align='center' nowrap></td>";
			}
		echo "</tr>";
		$nopk++;
	}
?>
</table>
</br>
<hr size="1">

<!-- WORKSITE SPECIALIST -->
<H4> WORKSITE SPECIALIST </H4>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse;border-color:#006699;" width="800" id="AutoNumber1">
	<tr>
		<th class="verdana7blu" rowspan="3">No</th>
		<th class="verdana7blu" rowspan="3">Nomor Agen</th>
		<th class="verdana7blu" colspan="3">Lisensi Agen</th>
		<th class="verdana7blu" rowspan="3">Nama Agen</th>
		<th class="verdana7blu" rowspan="3">Kantor/Unit Kerja</th>
		<th class="verdana7blu" colspan="4">Penetapan Predikat Baru</th>
		<th class="verdana7blu" rowspan="3">Jenis Mutasi</th>
		<th class="verdana7blu" rowspan="2" colspan="2">PKAJ</th>
		<th class="verdana7blu" rowspan="3">SPA</th>
		<th class="verdana7blu" rowspan="3">Usia</th>
		<th class="verdana7blu" rowspan="3">Keterangan</th>
	</tr>
	<tr>
		<th class="verdana7blu" rowspan="2">Nomor Lisensi</th>
		<th class="verdana7blu" rowspan="2">Tgl Berlaku</th>
		<th class="verdana7blu" rowspan="2">Tgl Berakhir</th>
		<th class="verdana7blu" rowspan="2">Jabatan</th>
		<th class="verdana7blu" rowspan="2">PER TGL</th>
		<th class="verdana7blu" colspan="2">NO SPA/SK</th>
	</tr>
	<tr>
		<th class="verdana7blu">Nomor</th>
		<th class="verdana7blu">Tanggal</th>
		<th class="verdana7blu">Tanggal</th>
		<th class="verdana7blu">Sisa Berlaku</th>
	</tr>
<?
	$sql1 = "SELECT a.prefixagen, a.noagen, d.namaklien1 AS namaagen, namajabatanagen, TO_CHAR(a.tglpenetapan, 'dd/mm/yyyy') tglpenetapan, kdunitproduksi,
				a.noskagen, TO_CHAR(a.tglskagen, 'dd/mm/yyyy') tglskagen, FLOOR(MONTHS_BETWEEN(sysdate, d.tgllahir)/12) usia, a.kdjabatanagen,
				a.namabank, a.norekening, a.nodplk, a.nolisensiagen, to_char(tglmulailisensi,'dd/mm/yyyy') tglmulailisensi, 
				to_char(tglakhirlisensi,'dd/mm/yyyy')tglakhirlisensi, 
				(SELECT namakantor FROM $DBUser.tabel_001_kantor WHERE kdkantor = '$filterkantor') namabo, TO_CHAR(tglpkajagen, 'dd/mm/yyyy') tglpkaj, 
				floor(months_between(sysdate, tglpkajagen) /12) yearexppkaj, FLOOR(months_between(tglakhirlisensi,SYSDATE) /12) yearexpls,
				NVL((SELECT COUNT(*) FROM $DBUser.tabel_400_pkaj_agen WHERE noagen = a.noagen), 0) jmlpkaj,
				CASE WHEN FLOOR(ADD_MONTHS(tglpkajagen, 24) - sysdate) > 0 THEN FLOOR(ADD_MONTHS(tglpkajagen, 24) - sysdate) ELSE 0 END sisapkaj,
				CASE
					WHEN  a.NOLISENSIAGEN IS NOT NULL AND (ADD_MONTHS (SYSDATE,-3)) < a.TGLAKHIRLISENSI THEN 1 ELSE 0 END AS CEKLISENSI,
				CASE WHEN a.FILE_BAST IS NOT NULL THEN 1 ELSE 0 END AS CEKBASTFILE
			FROM $DBUser.tabel_400_agen a
			INNER JOIN $DBUser.tabel_406_kode_pangkat_agen b ON a.kdpangkat = b.kdpangkat
			INNER JOIN $DBUser.tabel_413_jabatan_agen c ON a.kdjabatanagen = c.kdjabatanagen
			INNER JOIN $DBUser.tabel_100_klien d ON a.noagen = d.noklien
			LEFT OUTER JOIN (
				SELECT noagen, MAX(tglpkajagen) tglpkajagen
				FROM $DBUser.tabel_400_pkaj_agen
				GROUP BY noagen
			) e ON a.noagen = e.noagen
			WHERE a.kdstatusagen NOT IN ('02', '04', '03')
				AND a.kdkantor = '$filterkantor'
				AND a.KDJABATANAGEN IN ('31')
			";
	$DB->parse($sql1);
	$DB->execute();
	$nopk = 1;
	$nameClass = 'agenpk';
	while($arr1=$DB->nextrow()) {
		echo "<tr>";
			echo "<td class='$nameClass'>$nopk</td>"; 
			echo "<td class='$nameClass' align='center' nowrap>$arr1[PREFIXAGEN]-$arr1[NOAGEN]</td>";
			if ($arr1[CEKLISENSI] == 0){  
				echo "<td class='$nameClass' style='background-color:#FF0000;' align='center' nowrap>$arr1[NOLISENSIAGEN]</td>";
			}else{
				echo "<td class='$nameClass' nowrap>$arr1[NOLISENSIAGEN]</td>";
			} 
			//echo "<td class='$nameClass' nowrap>$arr1[NOLISENSIAGEN]</td>";
			echo "<td class='$nameClass' nowrap>$arr1[TGLMULAILISENSI]</td>";
			echo "<td class='$nameClass' nowrap>$arr1[TGLAKHIRLISENSI]</td>";
			echo "<td class='$nameClass' nowrap>$arr1[NAMAAGEN]</td>";
			echo "<td class='$nameClass' nowrap>$arr1[NAMABO]</td>";
			echo "<td class='$nameClass' nowrap>$arr1[NAMAJABATANAGEN]</td>";	  
			echo "<td class='$nameClass' nowrap>$arr1[TGLPENETAPAN]</td>";	  
			echo "<td class='$nameClass' nowrap>$arr1[NOSKAGEN]</td>";	  
			echo "<td class='$nameClass' nowrap>$arr1[TGLSKAGEN]</td>";	  
			echo "<td class='$nameClass' nowrap></td>";
			echo "<td class='$nameClass' style='background-color:$bgcolor;' nowrap>$arr1[TGLPKAJ]</td>";
			echo "<td class='$nameClass' style='background-color:$bgcolor;' nowrap>".(!empty($arr0['TGLPKAJ']) ? "$arr1[SISAPKAJ] hari" : null)."</td>";
			if ($arr1[CEKLISENSI] != 0){  
				echo "<td class='$nameClass' style='background-color:#FF0000;' align='center' nowrap>SPA";
			}else{
				echo "<td class='$nameClass' align='center' nowrap>";
				echo "<a href='javascript:void(0);' onclick=\"NewWindow('updspa_new_lpa.php?&noagen=$arr1[NOAGEN]&preagen=$arr1[PREFIXAGEN]&kdjabatanagen=$arr1[KDJABATANAGEN]','updspa',500,400,1);\">SPA</a>";
			}
			echo "</td>";
			echo "<td class='$nameClass' style='background-color:$usia;' align='center' nowrap>$arr1[USIA]</td>";
			if ($arr1[CEKBASTFILE] == 0){  
				echo "<td class='$nameClass' style='background-color:#FF0000;' align='center' nowrap>Belum Upload File BAST.</td>";
			}else{
				echo "<td class='$nameClass' align='center' nowrap></td>";
			}
		echo "</tr>";
		$nopk++;
	}
?>
</table>
</br>
<hr size="1">

<form name="cariproposal" method="get" action="cetak_list_agenspa.php?tglspa=<?='$tglsp';?>" target="_blank">
<table>
	<tr>
		<td class="verdana10blk"><font class="verdana8blu">Tanggal Penetapan (DD-MM-YYYY) <input name="tglsp" type="text" size="12" /></font></td>
		<td><input type="submit" name="cariagen" value="CETAK"></td>
	</tr>
</table>
</form>

<hr size="1">
<a class="verdana10blk" href="../mnukeagenan">Menu Keagenan</a>
