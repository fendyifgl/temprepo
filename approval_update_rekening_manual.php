<?php
	include "../../includes/session.php";
	include "../../includes/database.php";
	$DB = New database($userid, $passwd, $DBName);
	$pilihbulan = $pilihbulan ? $pilihbulan : date('n');
	$pilihtahun = $pilihtahun ? $pilihtahun : date('Y');
	$pilihstatus = isset($pilihstatus) ? $pilihstatus : 'semua';

	$user_approve = in_array($modul, array('ALL','POA','INQ'));
?>
<html>
<head>
	<link href="../../includes/fontawesome5/web-fonts-with-css/css/fontawesome.css" rel="stylesheet">
	<link href="../../includes/fontawesome5/web-fonts-with-css/css/fa-brands.css" rel="stylesheet">
	<link href="../../includes/fontawesome5/web-fonts-with-css/css/fa-solid.css" rel="stylesheet">
	<link href="../../includes/fontawesome5/web-fonts-with-css/css/fa-regular.css" rel="stylesheet">
    <script language="JavaScript" type="text/javascript" src="../../includes/window.js" ></script>
	<script type="text/javascript">
		function checkAll(source) {
			checkboxes = document.getElementsByName('cekbox[]'); console.log(checkboxes);
			for(var i=0, n=checkboxes.length;i<n;i++) {
				checkboxes[i].checked = source.checked;
			}
		}
		function lihatMedia(nopolis, jenis) {
			NewWindow('daftar_pengkinian_data_image.php?nopolis='+nopolis+'&jenis='+jenis, 'lihatMedia', '620', '600');
		}
	</script>
    <title>Approval Update Rekening Manual</title>
</head>
<body>
	<form action="<? $PHP_SELF; ?>" method="post" name="memreg">
		<table cellpadding="3" cellspacing="2" border="0">
			<tr>
				<td colspan="3"><font face="Verdana" size="2"><b>Approval Update Rekening Manual</b></font></td>
			</tr>
			<tr>
				<td>Pengajuan</td>
				<td width="10">:</td>
				<td>
					<select name='pilihtanggal'>
						<?php
						for($i=1;$i<=31;$i++) {
							$selected = @$pilihtanggal ? ($pilihtanggal == $i ? 'selected' : '') : (date('d') == $i ? 'selected' : '');
							echo "<option value='$i' $selected>$i</option>";
						} ?>
					</select>
					<select name='pilihbulan'>
						<!-- <option value='semua' selected>-- Semua Bulan --</option> -->
						<?php
						$bulan = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
						foreach ($bulan as $i => $v) {
							//$selected = $pilihbulan == $i ? 'selected' : '';
							$selected = @$pilihbulan ? ($pilihbulan == $i ? 'selected' : '') : (date('m') == $i ? 'selected' : '');
							echo "<option value='$i' $selected>$v</option>";
						} ?>
					</select>
					<select name='pilihtahun'>
						<?php $tahun = date('Y');
						for ($i=$tahun;$i>=$tahun-3;$i--) {
							$selected = $pilihtahun == $i ? 'selected' : '';
							$selected = @$pilihtahun ? ($pilihtahun == $i ? 'selected' : '') : ($tahun == $i ? 'selected' : '');
							echo "<option value='$i' $selected>$i</option>";
						} ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Status</td>
				<td>:</td>
				<td>
					<select name='pilihstatus'>
						<option value='semua' selected>Semua Status</option>
						<?php 
						$sql = "SELECT kdstatus, namastatus
								FROM $DBUser.tabel_999_kode_status
								WHERE jenisstatus = 'REKENING'";
						$DB->parse($sql);
						$DB->execute();
						foreach ($DB->result() as $i => $v) {
							$selected = $pilihstatus == "$v[KDSTATUS]" ? 'selected' : '';
							echo "<option value='$v[KDSTATUS]' $selected>$v[NAMASTATUS]</option>";
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2"></td>
				<td align="left"><input name="submit" value="Periksa Status" type="submit"></td>
			</tr>
		</table>
		
		<?php 
		// Setuju Approve
		if ($approve) {
			if (count($cekbox) == 0) {
				echo "Tidak ada data yang disetujui";
			} else { 
				foreach ($cekbox as $i => $v) {
					$v = base64_decode(base64_decode($v));
					$prefix = substr($v,0,2);
					$noper = substr($v,2);
					
					$where = "PREFIXPERTANGGUNGAN = '{$prefix}' AND NOPERTANGGUNGAN = '{$noper}'";
					
					$sql = "SELECT * FROM $DBUser.TABEL_100_KLIEN_REKENING_TMP WHERE {$where} AND STATUS = '0'";
					//$sql = "UPDATE jaim_000_pengkinian_data@jaim SET kdstatus = '3', userupdated = '$userid', tglupdated = sysdate WHERE id = '$v'";
					$DB->parse($sql);
					$DB->execute();
					$res = $DB->nextrow();
					
					if(count($res) > 0 && @$res){
						
						// Select Rekening Original
						$sql = "SELECT * FROM $DBUser.TABEL_100_KLIEN_REKENING WHERE {$where}";
					
						$DB->parse($sql);
						$DB->execute();
						$rekOri = $DB->nextrow();
						
						
						if(count($rekOri) > 0 && @$rekOri){
							// Update Status Rekening Temp
							$sql = "UPDATE $DBUser.TABEL_100_KLIEN_REKENING_TMP SET status = '1', TGLUPDATED = SYSDATE, USERUPDATED = '$userid' WHERE {$where} AND STATUS = '0'";
							$DB->parse($sql);
							$DB->execute();
							if ($DB->errormessage) {
								echo "<font face='Verdana' size='2' color='red'>Gagal TABEL_100_KLIEN_REKENING_TMP, error : $DB->errorstring</font><br /><br />";
							}
							else {
							// Update Log Rekening Updated
								$sql = "INSERT INTO $DBUser.TABEL_100_KLIEN_REKENING_LOG(PREFIXPERTANGGUNGAN, NOPERTANGGUNGAN,KDBANK,CABANGBANK,NOREKENING,ATASNAMA,STATUS,USERUBAH,TGLUBAH,KETERANGAN) 
										VALUES('{$rekOri['PREFIXPERTANGGUNGAN']}', '{$rekOri['NOPERTANGGUNGAN']}', '{$rekOri['KDBANK']}', '{$rekOri['CABANGBANK']}', '{$rekOri['NOREKENING']}', '{$rekOri['ATASNAMA']}', '1', '{$userid}', SYSDATE, 'UPDATE')";
								$DB->parse($sql);
								$DB->execute();
								if ($DB->errormessage) {
									echo "<font face='Verdana' size='2' color='red'>Gagal TABEL_100_KLIEN_REKENING_LOG, error : $DB->errorstring</font><br /><br />";
								} else {
									// Update Rekening Original
									$sql = "UPDATE $DBUser.tabel_100_klien_rekening SET KDBANK = '{$res['KDBANK']}',
									CABANGBANK = '{$res['CABANGBANK']}', NOREKENING = '{$res['NOREKENING']}', ATASNAMA = '{$res['ATASNAMA']}', STATUS = '1',
									TGLUPDATED = SYSDATE, USERUPDATED = '$userid'
									WHERE {$where}";
									$DB->parse($sql);
									$DB->execute();
									if ($DB->errormessage) {
										echo "<font face='Verdana' size='2' color='red'>Gagal tabel_100_klien_rekening, error : $DB->errorstring</font><br /><br />";
									} else {
										// Update Rekening API
										$sql = "UPDATE $DBUser.tabel_100_klien_rekening_api SET KDBANK = '{$res['KDBANK']}', REMARK = 'MANUAL', CODE = '0000', DESCRIPTION = 'Inquiry Success', ACCOUNTNAME = '{$res['ATASNAMA']}' , ACCOUNTNUMBER = '{$res['NOREKENING']}' 
										WHERE {$where} AND utl_raw.cast_to_varchar2(request) LIKE '%$res[NOREKENING]%'";
										$DB->parse($sql);
										$DB->execute();
										if ($DB->errormessage) {
											echo "<font face='Verdana' size='2' color='red'>Gagal tabel_100_klien_rekening_api, error : $DB->errorstring</font><br /><br />";
										} 
									}
								}
							}
						}
						else{
							echo "Tidak ada data yang disetujui";
						}
					}else{
						echo "Tidak ada data yang disetujui";
					}
				}
			}
		}
		// Tolak Reject
		else if ($reject) {
			if (count($cekbox) == 0) {
				echo "Tidak ada data yang ditolak";
			} else { 
				foreach ($cekbox as $i => $v) {
					$v = base64_decode(base64_decode($v));
					$prefix = substr($v,0,2);
					$noper = substr($v,2);
					
					$where = "PREFIXPERTANGGUNGAN = '{$prefix}' AND NOPERTANGGUNGAN = '{$noper}'";
					
					$sql = "SELECT * FROM $DBUser.TABEL_100_KLIEN_REKENING_TMP WHERE {$where} AND STATUS = 0";
					//$sql = "UPDATE jaim_000_pengkinian_data@jaim SET kdstatus = '3', userupdated = '$userid', tglupdated = sysdate WHERE id = '$v'";
					$DB->parse($sql);
					$DB->execute();
					$res = $DB->nextrow();
					if(count($res) > 0){
						// Update Status Rekening Temp
							$sql = "UPDATE $DBUser.TABEL_100_KLIEN_REKENING_TMP SET status = 'X', TGLUPDATED = SYSDATE, USERUPDATED = '$userid' WHERE {$where} AND STATUS = 0";
							$DB->parse($sql);
							$DB->execute();
							echo "<script>alert('Success Update Data Rekening Ter Tolak'); window.href.location = `./approval_update_rekening_manual.php` </script>";
							if ($DB->errormessage) {
								echo "<font face='Verdana' size='2' color='red'>Gagal TABEL_100_KLIEN_REKENING_TMP, error : $DB->errorstring</font><br /><br />";
							}
					}else{
						echo "Tidak ada data yang ditolak";
					}
				}
			}
		}
		
		
		if ($submit || $approve || $reject) { 
				$tgl = str_pad($pilihtanggal, 2, "0", STR_PAD_LEFT)."-".str_pad($pilihbulan, 2, "0", STR_PAD_LEFT)."-$pilihtahun";
				$validDate = "TO_DATE('{$tgl}', 'dd-mm-yyyy')";
				//$filtertanggal = $pilihstatus != 'semua' ? " AND TO_CHAR(a.tglrekam, 'ddmmyyyy') = '".str_pad($pilihtanggal, 2, "0", STR_PAD_LEFT).str_pad($pilihbulan, 2, "0", STR_PAD_LEFT)."$pilihtahun' " : "";
				$filtertanggal = $pilihstatus != '' ? " AND TRUNC(a.tglrekam) = {$validDate}" : "";
				$filterstatus = $pilihstatus == "" ? " AND a.status IS NOT NULL " : 
					($pilihstatus == 'semua' ? "" : " AND a.status = '$pilihstatus' ");
				
				$sql = "SELECT ROWNUM as ID, A.PREFIXPERTANGGUNGAN||A.NOPERTANGGUNGAN NOPOLIS, D.NAMAKLIEN1 NAMAPEMPOL, A.NOREKENING , A.ATASNAMA, B.NAMABANK,A.STATUS, E.NAMASTATUS
				FROM $DBUser.TABEL_100_KLIEN_REKENING_TMP A 
					INNER JOIN $DBUser.TABEL_399_BANK B  ON A.KDBANK = B.KDBANK
					INNER JOIN $DBUser.TABEL_200_PERTANGGUNGAN C ON A.PREFIXPERTANGGUNGAN||A.NOPERTANGGUNGAN = C.PREFIXPERTANGGUNGAN||C.NOPERTANGGUNGAN
					INNER JOIN $DBUser.TABEL_100_KLIEN D ON C.NOPEMEGANGPOLIS = D.NOKLIEN
					INNER JOIN $DBUser.TABEL_999_KODE_STATUS E ON A.STATUS = E.KDSTATUS AND E.JENISSTATUS = 'REKENING'
					WHERE 1=1 
							$filtertanggal
							$filterstatus
						ORDER BY a.status, a.tglrekam";
				$DB->parse($sql);
				$DB->execute();
				/*
				echo "<pre>";
	print_r ($sql);
	echo "</pre>"; die; */
		?>
		
			<br />
			<table border="0" width="100%" cellspacing="1" cellpadding="2">
				<tr bgcolor="#C2CAED" align="center">
					<td rowspan="2"><font face="Verdana" size="1"><b>No</b></font></td>
					<td rowspan="2"><font face="Verdana" size="1"><b>No Polis</b></font></td>
					<td rowspan="2"><font face="Verdana" size="1"><b>Nama Pemegang Polis</b></font></td>
					<td colspan="3"><font face="Verdana" size="1"><b>Update</b></font></td>
					<td rowspan="2"><font face="Verdana" size="1"><b>Status</b></font></td>
					<?php if ($user_approve) { ?>
						<td rowspan="2"><input type='checkbox' onclick='checkAll(this)'/></td>
					<?php } ?>
				</tr>
				<tr bgcolor="#C2CAED" align="center">
					<td><font face="Verdana" size="1"><b>Nomor Rekening</b></font></td>
					<td><font face="Verdana" size="1"><b>Nama Pemilik Rekening</b></font></td>
					<td><font face="Verdana" size="1"><b>Nama Bank</b></font></td>
				</tr>
				<?php
				
				foreach ($DB->result() as $i => $v) { 
					$bgcolor = $v['KDSTATUS'] == "" ? "#FFFF33" : ($i%2 ? "#A6ECFA" : "#FFFFFF"); ?>
					<tr bgcolor="<?=$bgcolor?>">
						<td align="center"><font face="Verdana" size="1"><?=$i+1?></font></td>
						<td align="center">
							<font face="Verdana" size="1"><a href="javascript:void(0);" onclick="NewWindow('../polis/polis.php?prefix=<?=substr($v['NOPOLIS'],0,2)?>&noper=<?=substr($v['NOPOLIS'],2)?>','',800,600,1)">
								<?=$v['NOPOLIS']?>
							</a></font>
						</td>
						<td align="center"><font face="Verdana" size="1"><?=$v['NAMAPEMPOL']?></font></td>
						
						<td><font face="Verdana" size="1"><?=$v['NOREKENING']?></font></td>
						<td><font face="Verdana" size="1"><?=$v['ATASNAMA']?></font></td>
						<td><font face="Verdana" size="1"><?=$v['NAMABANK']?></font></td>
						
						<!--
						<td nowrap>
							<a href='javascript:void(0);' onClick="lihatMedia('<?="$v[NOPOLENCRYPT]"?>', 'swafoto')"><font face="Verdana" size="1">swa</font></a>
							|
							<a href='javascript:void(0);' onClick="lihatMedia('<?="$v[NOPOLENCRYPT]"?>', 'rekening')"><font face="Verdana" size="1">rek</font></a>
						</td>
						-->
						<td><font face="Verdana" size="1"><?=$v['NAMASTATUS']?></font></td>

						<?php if ($v['STATUS'] == "0" && ($user_approve) ) { ?>
						
							<td style="text-align:center">
								
								<input type="checkbox" name="cekbox[]" value="<?= base64_encode(base64_encode($v['NOPOLIS'])) ?>" />
							</td>
						<?php }else{ ?>
							<td style="text-align:center">
								&nbsp;
							</td>
						<?php } ?>
					</tr>
				<?php } ?>
				<tr>
					<td colspan="13">
						<div align="left"><font size='2'><i>Untuk melakukan proses approval/reject update rekening silahkan klik tombol sebelah kanan.</i></font></div>
						<div align="right">
							
							<?php if ($user_approve) { ?>
								<input type="submit" name="approve" value="Setuju" onclick="confirm('Apakah Anda yakin akan menyetujui perubahan data rekening')" />
								<input type="submit" name="reject" value="Tolak" onclick="confirm('Apakah Anda yakin ingin reject?')">
							<?php } ?>							
						</div>
					</td>
				</tr>
			</table>
		<?php } ?>
	
	<form>
</body>
</html>