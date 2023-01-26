<?php
	include "../../includes/session.php"; 
	include "../../includes/database.php";
	$DB=new Database($userid,$passwd,$DBName);
	$pilihtanggal = $pilihtanggal ? $pilihtanggal : date('d');
	$pilihbulan = $pilihbulan ? $pilihbulan : date('n');
	$pilihtahun = $pilihtahun ? $pilihtahun : date('Y');
	$constklaim = "('ANUITAS', 'TAHAPAN')";

	if ($proses) {
		if ($cekbox) {
			foreach ($cekbox as $i => $v) {
				if ($i > 1000) {
					break;
				}
				
				$v_noizin = $noizin[$v];
				$v_prefixpertanggungan = $prefixpertanggungan[$v];
				$v_nopertanggungan = $nopertanggungan[$v];
				$v_kdklaim = $kdklaim[$v];
				$v_tglpengajuan = $tglpengajuan[$v];
				$v_nopemegangpolis = $nopemegangpolis[$v];
				
				//echo "$v_noizin $v_prefixpertanggungan $v_nopertanggungan $v_kdklaim $v_tglpengajuan $v_nopemegangpolis<br>";
				
				// otorisasi & terbitkan jurnal hutang klaim
				$sql = "UPDATE $DBUser.tabel_901_pengajuan_klaim SET
							status = 1, userptg = '$userid', tglptg = sysdate, userupdated = '$userid', tglupdated = sysdate, 
							approvekasi = 1
						WHERE prefixpertanggungan = '$v_prefixpertanggungan'
							AND nopertanggungan = '$v_nopertanggungan'
							AND kdklaim = '$v_kdklaim'
							AND TO_CHAR(tglpengajuan, 'dd/mm/yyyy') = '$v_tglpengajuan'";
				//echo $sql;
				$DB->parse($sql);
				$DB->execute();
				
				if ($DB->errormessage) {
					echo "<font color='red'>$DB->errorstring</font><br><br>";
				}
				
				// bentuk sip
				$sql = "BEGIN
							$DBUser.sip('$v_prefixpertanggungan', '$v_nopertanggungan', 'KP', '$v_kdklaim', sysdate, TO_DATE('$v_tglpengajuan', 'dd/mm/yyyy'));
						END;";
				$DB->parse($sql);
				$DB->execute();
				
				if ($DB->errormessage) {
					echo "<font color='red'>$DB->errorstring</font><br><br>";
				}
				
				// proses ke sentralisasi
				$sql = "UPDATE $DBUser.tabel_901_pengajuan_klaim SET 
							userupdated = user, tglupdated = sysdate, tglhitung = sysdate, status = 2
						WHERE prefixpertanggungan = '$v_prefixpertanggungan'
							AND nopertanggungan = '$v_nopertanggungan'
							AND kdklaim = '$v_kdklaim'
							AND TO_CHAR(tglpengajuan, 'dd/mm/yyyy') = '$v_tglpengajuan'";
				$DB->parse($sql);
				$DB->execute();
				
				if ($DB->errormessage) {
					echo "<font color='red'>$DB->errorstring</font><br><br>";
				}
				
				// update billing benefit
				$sql = "UPDATE $DBUser.tabel_800_pembayaran_anuitas SET 
							status = '2', tglstatus = sysdate, tglseatled = sysdate, nopemegangpolis = '$v_nopemegangpolis',
							tglupdated = sysdate, userupdated = '$userid', noizin = '$v_noizin'
						WHERE TO_CHAR(tglpengajuanklaim, 'dd/mm/yyyy') = '$v_tglpengajuan'
							AND prefixpertanggungan = '$v_prefixpertanggungan'
							AND nopertanggungan = '$v_nopertanggungan'
							AND kdjenisbenefit = '$v_kdklaim'";
				$DB->parse($sql);
				$DB->execute();
				
				if ($DB->errormessage) {
					echo "<font color='red'>$DB->errorstring</font><br><br>";
				}
			}
		}
	}
?>

<html>
<head>
	<meta charset="utf-8" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
    <meta http-equiv="X-UA-Compatible" content="ie=edge" /> 
	<title>Klaim Kolektif</title>
	<link href="../../includes/transaksi.css" rel="stylesheet" type="text/css">
	<link href="../../includes/fontawesome5/web-fonts-with-css/css/fontawesome.css" rel="stylesheet">
	<link href="../../includes/fontawesome5/web-fonts-with-css/css/fa-brands.css" rel="stylesheet">
	<link href="../../includes/fontawesome5/web-fonts-with-css/css/fa-solid.css" rel="stylesheet">
	<link href="../../includes/fontawesome5/web-fonts-with-css/css/fa-regular.css" rel="stylesheet">
	<style> 
        #loader { 
            border: 12px solid #f3f3f3; 
            border-radius: 50%; 
            border-top: 12px solid #444444; 
            width: 70px; 
            height: 70px; 
            animation: spin 1s linear infinite; 
        } 
          
        @keyframes spin { 
            100% { 
                transform: rotate(360deg); 
            } 
        } 
          
        .center { 
            position: absolute; 
            top: 0; 
            bottom: 0; 
            left: 0; 
            right: 0; 
            margin: auto; 
        } 
    </style>
	<script language="JavaScript" type="text/javascript" src="../../includes/window.js" ></script>
	<script language="JavaScript">
		document.onreadystatechange = function() { 
            if (document.readyState !== "complete") { 
                document.querySelector( 
                  "body").style.visibility = "hidden"; 
                document.querySelector( 
                  "#loader").style.visibility = "visible"; 
            } else { 
                document.querySelector( 
                  "#loader").style.display = "none"; 
                document.querySelector( 
                  "body").style.visibility = "visible"; 
            } 
        }; 
		
		function checkAll(source) {
			checkboxes = document.getElementsByName('cekbox[]');
			for(var i=0, n=checkboxes.length;i<n;i++) {
				checkboxes[i].checked = source.checked;
			}
		}
		
		function updateForm() {
			document.getElementById("frm-daftar").submit();
		}
		
		function updateRekening(prefix, noper, kdklaim, tglpengajuan) {
			NewWindow('updaterekening.php?prefix='+prefix+'&noper='+noper+'&kdklaim='+kdklaim+'&tglpengajuan='+tglpengajuan, 'UpdateRekening', '650', '600');
		}
	</script>
</head>

<body>
	<div id="loader" class="center"></div>
	<h4>DAFTAR MANFAAT KLAIM KOLEKTIF</h4>
	<form id="frm-daftar" action="<?=$PHP_SELF;?>" method="post">
	<input type='hidden' name='cari' value='<?=$cari?>' />
	<table cellpadding="1" cellspacing="2" border="0">
		<tr>
			<td>Periode</td>
			<td>:</td>
			<td>
				<select name='pilihtanggal'>
					<option value='semua' selected>-- Semua --</option>
					<?php $tanggal = date('d');
					for ($i=1;$i<=31;$i++) {
						$selected = $pilihtanggal == $i ? 'selected' : '';
						echo "<option value='$i' $selected>$i</option>";
					} ?>
				</select>
				<select name='pilihbulan'>
					<option value='semua' selected>-- Semua --</option>
					<?php
					$bulan = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
					foreach ($bulan as $i => $v) {
						$selected = $pilihbulan == $i ? 'selected' : '';
						echo "<option value='$i' $selected>$v</option>";
					} ?>
				</select>
				<select name='pilihtahun'>
					<?php $tahun = date('Y')+1;
					for ($i=$tahun-3;$i<=$tahun;$i++) {
						$selected = $pilihtahun == $i ? 'selected' : '';
						echo "<option value='$i' $selected>$i</option>";
					} ?>
				</select>
			</td>
			<td rowspan="5" valign="top">
				<table border="0" style="margin-left:8px;" cellpadding="3">
					<tr>
						<td>
							<font face="Verdana" size="1">
							<i class="far fa-edit fa-lg" style="color:red;"></i> Edit Rekening
							</font>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>Klaim</td>
			<td>:</td>
			<td>
				<select name="pilihklaim" onFocus="highlight(event)" class="c">
					<option value='semua' selected>-- Semua --</option>
					<?php 
					$sql = "SELECT kdklaim, namaklaim, kelompok 
							FROM $DBUser.tabel_902_kode_klaim
							WHERE kdklaim IN $constklaim";
					$DB->parse($sql);
					$DB->execute();
					while ($r = $DB->nextrow()) {
						$selected = $pilihklaim == $r['KDKLAIM'] ? 'selected' : '';
						echo "<option value='$r[KDKLAIM]' $selected>$r[NAMAKLAIM]</option>";
					} ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Status</td>
			<td>:</td>
			<td>
				<select name='pilihstatus'>
					<option value='semua' selected>-- Semua --</option>
					<?php 
					$status = array('0' => 'Pengajuan', '1' => 'Otorisasi', '2' => 'Verifikasi', '3' => 'Selesai');
					foreach ($status as $i => $v) {
						$selected = $pilihstatus == "$i" ? 'selected' : '';
						echo "<option value='$i' $selected>$i - $v</option>";
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Urutkan</td>
			<td>:</td>
			<td>
				<select name='pilihurut'>
					<?php
					$urut = array(
						'c.mulas' => 'Tanggal Mulas', 
						'a.tglbooked' => 'Tanggal Jatuh Tempo', 
						'a.status' => 'Status', 
						'a.namabank' => 'Bank', 
						'a.cabangbank' => 'Cabang', 
						'a.norekeningbank' => 'Nomor Rekening', 
						'a.penerimasip' => 'Atas Nama' 
					);
					foreach ($urut as $i => $v) {
						$selected = $pilihurut == $i ? 'selected' : '';
						echo "<option value='$i' $selected>$v</option>";
					}
					?>
				</select>
				<select name='pilihascdesc'>
					<?php
					$ascdesc = array('ASC' => 'Ascending', 'DESC' => 'Descending');
					foreach ($ascdesc as $i => $v) {
						$selected = $pilihascdesc == $i ? 'selected' : '';
						echo "<option value='$i' $selected>$v</option>";
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td colspan="1" align="left"><input name="cari" value="Cari" type="submit" style="padding:2px 12px;"></td>
		</tr>
	</table>
	</form>
	
	<hr size="1">
		
	<form name="frm-proses" action="<? $PHP_SELF; ?>" method="post">
	<input type='hidden' name='pilihbulan' value='<?=$pilihbulan?>' />
	<input type='hidden' name='pilihtahun' value='<?=$pilihtahun?>' />
	<input type='hidden' name='constklaim' value='<?=$constklaim?>' />
	<table border="0" cellspacing="1" cellpadding="4" width="100%" bordercolor="#B3CFFF">
		<tr bgcolor="#b1c8ed" align="center">
			<td rowspan='2'><b>No</b></td>
			<td rowspan='2'><b>No Polis</b></td>
			<td rowspan='2'><b>Pemegang Polis</b></td>
			<td rowspan='2'><b>Produk</b></td>
			<td rowspan='2'><b>Benefit</b></td>
			<td colspan='2' bgcolor="#7dc2d9"><b>Tanggal</b></td>
			<td rowspan='2'><b>Nilai Benefit</b></td>
			<td colspan='7' bgcolor="#7dc2d9"><b>Rekening</b></td>
			<td rowspan='2'><b>Status</b></td>
			<td rowspan='2'><b><input type='checkbox' onclick='checkAll(this)' /></b></td>
			<td rowspan='2'><b></b></td>
		</tr>
		<tr bgcolor="#7dc2d9" align="center">
			<td><b>Mulas</b></td>
			<td><b>Jatuh Tempo</b></td>
			<td><b>Bank</b></td>
			<td><b>Cabang</b></td>
			<td><b>Nomor</b></td>
			<td><b>Atas Nama</b></td>
			<td><b>Atas Nama API</b></td>
			<td><b>Hasil API</b></td>
			<td><b>Terakhir Updated</b></td>
		</tr>
		<?php
		if ($cari) {			
			if($pilihtanggal != 'semua'){
				$filterbulan = $pilihbulan != 'semua' ? " AND TO_CHAR(a.tglpengajuan, 'ddmmyyyy') = '".str_pad($pilihtanggal, 2, "0", STR_PAD_LEFT).str_pad($pilihbulan, 2, "0", STR_PAD_LEFT)."$pilihtahun' " : "";
			}else{
				$filterbulan = $pilihbulan != 'semua' ? " AND TO_CHAR(a.tglpengajuan, 'mmyyyy') = '".str_pad($pilihbulan, 2, "0", STR_PAD_LEFT)."$pilihtahun' " : "AND TO_CHAR(a.tglpengajuan, 'yyyy') = '$pilihtahun' ";
			}

			$filterklaim = $pilihklaim != 'semua' ? " AND a.kdklaim = '$pilihklaim' " : "AND a.kdklaim IN ('ANUITAS','TAHAPAN')";
			$filterstatus = $pilihstatus != 'semua' ? " AND a.status = '$pilihstatus' " : "";
			
			$sql = "SELECT NVL(c.nopolbaru, c.prefixpertanggungan || c.nopertanggungan) nopolis, c.kdproduk, 
						NVL(
							b.kdbenefit,
							(SELECT kdbenefit 
								FROM $DBUser.tabel_223_transaksi_produk 
								WHERE prefixpertanggungan = a.prefixpertanggungan
									AND nopertanggungan = a.nopertanggungan
									AND kdjenisbenefit = 'W'
									AND expirasi = a.tglbooked
									AND NVL(status, 0) IN ('0', '7')
							) 
						)kdbenefit,
						TO_CHAR(c.mulas, 'dd/mm/yyyy') mulas, TO_CHAR(a.tglbooked, 'dd/mm/yyyy') tglbooked, a.nilaibenefit, a.namabank, 
						a.cabangbank, a.norekeningbank,	CASE WHEN i.kdbank = '014' THEN 'Exclude' ELSE h.description END description, 
						CASE WHEN i.kdbank = '014' THEN 'Not Check' ELSE h.status END statusrekening, h.accountname atasnamaapi, 
						a.penerimasip, a.status, f.namastatus, a.noizin, a.prefixpertanggungan, a.nopertanggungan, 
						a.kdklaim, TO_CHAR(a.tglpengajuan, 'dd/mm/yyyy') tglpengajuan, c.nopemegangpolis, d.namaklien1,
						CASE WHEN (LOWER(TRIM(d.namaklien1)) LIKE ('%' || LOWER(TRIM(a.penerimasip)) || '%') OR LOWER(TRIM(a.penerimasip)) LIKE ('%' || LOWER(TRIM(d.namaklien1)) || '%'))
							AND
							(
								LOWER(TRIM(h.accountname)) LIKE ('%' || LOWER(TRIM(a.penerimasip)) || '%') OR LOWER(TRIM(a.penerimasip)) LIKE ('%' || LOWER(TRIM(h.accountname)) || '%') OR
								LOWER(TRIM(d.namaklien1)) LIKE ('%' || LOWER(TRIM(h.accountname)) || '%') OR LOWER(TRIM(h.accountname)) LIKE ('%' || LOWER(TRIM(d.namaklien1)) || '%')
							)
							THEN 1
							ELSE 0
						END pempolsamarekening, 
						(
							SELECT COUNT(a.nopertanggungan) 
							FROM tabel_219_pemegang_polis_baw z
							INNER JOIN tabel_100_klien y ON z.noklien = y.noklien
							WHERE z.prefixpertanggungan = a.prefixpertanggungan
								AND z.nopertanggungan = a.nopertanggungan
								AND (
									LOWER(y.namaklien1) LIKE ('%' || LOWER(a.penerimasip) || '%')
									OR
									LOWER(a.penerimasip) LIKE ('%' || LOWER(y.namaklien1) || '%')
								)
						) pempolahrissamarekening,
						TO_CHAR(NVL(i.tglupdated, i.tglrekam),'dd-mm-yyyy') tglupdaterekening,
						CASE WHEN ADD_MONTHS(NVL(i.tglupdated, i.tglrekam), 12) >= sysdate THEN 1 ELSE 0 END bypasssamarekening,
						CASE WHEN NVL(i.tglupdated, i.tglrekam) < TO_DATE('01012023', 'ddmmyyyy') THEN 1 ELSE 0 END beforepengkinian
					FROM $DBUser.tabel_901_pengajuan_klaim a
					LEFT OUTER JOIN $DBUser.tabel_800_pembayaran_anuitas b ON a.prefixpertanggungan = b.prefixpertanggungan
						AND a.nopertanggungan = b.nopertanggungan
						AND a.tglbooked = b.tglbooked
						AND a.kdklaim = b.kdjenisbenefit
						AND a.tglpengajuan = b.tglpengajuanklaim
					INNER JOIN $DBUser.tabel_200_pertanggungan c ON a.prefixpertanggungan = c.prefixpertanggungan
						AND a.nopertanggungan = c.nopertanggungan
					INNER JOIN $DBUser.tabel_100_klien d ON c.nopemegangpolis = d.noklien
					LEFT OUTER JOIN $DBUser.tabel_900_klaim_pusat e ON a.prefixpertanggungan = e.prefixpertanggungan
						AND a.nopertanggungan = e.nopertanggungan
						AND a.kdklaim = e.kdklaim
						AND a.tglpengajuan = e.tglpengajuan
					LEFT OUTER JOIN $DBUser.tabel_999_kode_status f ON a.status = f.kdstatus
						AND f.jenisstatus = 'KLAIM'
					LEFT OUTER JOIN (
						SELECT MAX(batch) batch, prefixpertanggungan, nopertanggungan, 
							UTL_RAW.CAST_TO_VARCHAR2(request) request
						FROM $DBUser.tabel_100_klien_rekening_api
						GROUP BY prefixpertanggungan, nopertanggungan, UTL_RAW.CAST_TO_VARCHAR2(request)
					) g ON a.prefixpertanggungan = g.prefixpertanggungan
						AND a.nopertanggungan = g.nopertanggungan
						AND g.request LIKE ('%' || a.norekeningbank || '%')
					LEFT OUTER JOIN $DBUser.tabel_100_klien_rekening_api h ON g.batch = h.batch
						AND g.prefixpertanggungan = h.prefixpertanggungan
						AND g.nopertanggungan = h.nopertanggungan
					LEFT OUTER JOIN $DBUser.tabel_100_klien_rekening i ON a.prefixpertanggungan = i.prefixpertanggungan
						AND a.nopertanggungan = i.nopertanggungan
					WHERE c.kdpertanggungan = 2
						AND c.kdstatusfile IN ('1', '8', '9', '3', '4', 'L')
						AND a.klaimgroup = '1'
						$filterklaim
						$filterbulan
						$filterstatus
					ORDER BY $pilihurut $pilihascdesc";
		
			//echo $sql;
			$DB->parse($sql);
			$DB->execute();
			$i=1; 
			while ($r=$DB->nextrow()) { ?>
				<input type="hidden" name="noizin[<?=$i?>]" value="<?=$r['NOIZIN']?>" />
				<input type="hidden" name="prefixpertanggungan[<?=$i?>]" value="<?=$r['PREFIXPERTANGGUNGAN']?>" />
				<input type="hidden" name="nopertanggungan[<?=$i?>]" value="<?=$r['NOPERTANGGUNGAN']?>" />
				<input type="hidden" name="kdklaim[<?=$i?>]" value="<?=$r['KDKLAIM']?>" />
				<input type="hidden" name="tglpengajuan[<?=$i?>]" value="<?=$r['TGLPENGAJUAN']?>" />
				<input type="hidden" name="nopemegangpolis[<?=$i?>]" value="<?=$r['NOPEMEGANGPOLIS']?>" />
				
				<?php
					if ((in_array($r['KDPRODUK'], array('AJSAN', 'JSANUITAS')) && $r['BYPASSSAMAREKENING'] == 0 && (($r['KDBENEFIT'] == 'BNFPHT' && $r['PEMPOLSAMAREKENING'] == 0) || ($r['KDBENEFIT'] == 'BNFPJD' && $r['PEMPOLAHRISSAMAREKENING'] == 0))) || // Polis Anuitas
					 	(!in_array($r['KDPRODUK'], array('AJSAN', 'JSANUITAS')) && $r['PEMPOLSAMAREKENING'] == 0 && $r['BEFOREPENGKINIAN'])) { // Polis Lain
						$color = "#CBBEFE";
					} else if ($r['NAMABANK'] === NULL || $r['CABANGBANK'] === NULL || $r['NOREKENINGBANK'] === NULL || $r['PENERIMASIP'] === NULL || $r['DESCRIPTION'] === NULL) {
						$color = "#FFFF00";
					} else if ($r['STATUS'] == '0' && $r['NILAIBENEFIT'] < 1) {
						$color = "#00FF00";
					} else if ($i%2) {
						$color = "#FFFFFF";
					} else {
						$color = "#E4E4E4";
					}
				?>
				
				<tr bgcolor="<?=$color?>">
					<td align="center"><?=$i;?></td>
					<td align="center"><?=$r['NOPOLIS']?></td>
					<td align="left"><?=$r['NAMAKLIEN1']?></td>
					<td align="center"><?=$r['KDPRODUK']?></td>
					<td align="center"><?=$r['KDBENEFIT']?></td>
					<td align="center"><?=$r['MULAS']?></td>
					<td align="center"><?=$r['TGLBOOKED']?></td>
					<td align="right"><?=number_format($r['NILAIBENEFIT'], 2, ',', '.')?></td>
					<td><?=$r['NAMABANK']?></td>
					<td><?=$r['CABANGBANK']?></td>
					<td><?=$r['NOREKENINGBANK']?></td>
					<td><?=$r['PENERIMASIP']?></td>
					<td><?=$r['ATASNAMAAPI']?></td>
					<td><?=$r['DESCRIPTION'].($r['DESCRIPTION'] ? ' | ' : '').$r['STATUSREKENING']?></td>
					<td align="center"><?=$r['TGLUPDATEREKENING']?></td>
					<td align="center" nowrap><?="$r[STATUS]"?></td>
					<td align="center">
						<?php if ($r['STATUS'] == '0' && in_array($color, array('#FFFFFF','#E4E4E4','#00FF00')) && in_array($r['STATUSREKENING'], array('Active', 'Not Check')) && ($r['BYPASSSAMAREKENING'] == 1 || !in_array($r['KDPRODUK'], array('AJSAN', 'JSANUITAS')))) {
							echo "<input type='checkbox' name='cekbox[]' value='$i' />";
						} ?>
					</td>
					<td align="center">
						<?php if ($r['STATUS'] == '0') { ?>
							<a href='javascript:void(0);' onClick="updateRekening('<?=$r['PREFIXPERTANGGUNGAN']?>', '<?=$r['NOPERTANGGUNGAN']?>', '<?=$r['KDKLAIM']?>', '<?=$r['TGLPENGAJUAN']?>')"><i class="far fa-edit fa-lg" style="color:red;margin:0 3px;"></i></a>
						<?php } ?>
					</td>
				</tr>
				<?php $i++;
			}
		} ?>
		
		<tr>
			<td colspan="18" bgcolor="#FFFF99" align="center"><b>Guna menghindari hang pada saat proses otorisasi & sentralisasi, sistem akan membatasi 1000 polis per prosesnya.</b></td>
		</tr>
		<tr>
			<td colspan="18">
				<div align="right"><input type="submit" name="proses"  value="Proses Otorisasi & Sentralisasi" onclick="return confirm('Apakah Anda yakin <?=$userid?>?')" /></div>
				<strong>
					<div align="left">
						*Pastikan Rekening telah sesuai untuk menghindari proses retur, jika tidak sesuai silahkan ubah rek kemudian refresh halaman ini <br/>
						<font style="background-color:#FFFF00;">*Warna Kuning berarti nomor rekening / nama bank / cabang / atas nama masih ada yang kosong atau rekening belum dilakukan pengecekan via API atau sudah dilakukan pengecekan via API namun rekening tidak aktif.</font> <br/>
						<font style="background-color:#00FF00;">*Warna Hijau berarti nilai manfaat lebih kecil sama dengan Rp.0.</font><br/>
						<font style="background-color:#CBBEFE;">*Warna Biru berarti nama pemegang polis / ahli waris tidak sama dengan pemilik rekening.</font>
					</div>
				</strong>
			</td>
		</tr>
	</table>
	</form>
	
	<hr size="1" color="#c0c0c0">
	
	<table width="100%">
		<tr>
			<td width="50%" class="arial10" align="left"><a href="../polisserv.php">Menu Pemeliharaan Polis</a></td>
			<td width="50%" class="arial10" align="right"><a href="../mnuutama.php">Menu Utama</a></td>
		</tr>
	</table>

</body>
</html>
