<?php
	include "../../includes/common.php";
	include "../../includes/database.php";
	include "../../includes/session.php";
	$DB=New Database($userid, $passwd, $DBName);
	
	$sql = "SELECT b.nopolbaru, kdacceptance, b.kdproduk, b.kdstatusfile, b.kdpertanggungan, 
				kdcetakbk, TO_CHAR(tglcetakbk,'dd/mm/yyyy') tglcetakbk, usercetakbk, 
				kdcetaktterima, TO_CHAR(tglcetaktterima,'dd/mm/yyyy') tglcetaktterima, usercetaktterima,
				kdcetakdesisi, TO_CHAR(tglcetakdesisi,'dd/mm/yyyy') tglcetakdesisi, usercetakdesisi,
				kdcetakpolis, TO_CHAR(tglcetakpolis,'dd/mm/yyyy') tglcetakpolis, usercetakpolis,
				kdcetaksup, TO_CHAR(tglcetaksup, 'dd/mm/yyyy') tglcetaksup, usercetaksup,
				kducapanselamat, TO_CHAR(tglucapanselamat, 'dd/mm/yyyy') tglucapanselamat, userucapanselamat,
				kdcetakkk, usercetakkk, TO_CHAR(tglcetakkk, 'dd/mm/yyyy') tglcetakkk
			FROM $DBUser.tabel_214_acceptance_dokumen a
			INNER JOIN $DBUser.tabel_200_pertanggungan b ON a.prefixpertanggungan = b.prefixpertanggungan
				AND a.nopertanggungan = b.nopertanggungan
			WHERE a.prefixpertanggungan = '$prefix' AND a.nopertanggungan = '$noper'";
	//echo $sql;
	$DB->parse($sql);
	$DB->execute();
	$r = $DB->nextrow();
	$kdprodukbancass = array('JSSPBTN','JSSPQNB');
	$kdprodukanuitas = array('AI0','AI0BNI','ASI','ASIBNI','ASP','ASPBNI','JSAEP', 'ASIB', 'ASPB', 'AI0B', 'AI0N', 'AI0NB');  // Anuitas
	$kdprodukgjterusan = array('JSGTP'); // Gaji terusan
	$kdprodukklgnpendidikan = array('JSKPD'); // Kelangsungan pendidikan
	$kdprodukkrdtmenurun = array('AKM'); // Kredit menurun
	$kdprodukjskeluarga = array('JSKEL'); // JS keluarga
	$kdprodukjssinergi = array('JSR1','JSR2','JSR3','JSR4'); // JS Sinergi
	$kdprodukjsria = array('JSRIA'); // JS Replacement income assurance
	$kdprodukjsretirement = array('JSRPAX','JSRPAB','JSRPAS','JSRPAT','JSRPAK');
	$kdprodukjsaa = array('JSAA'); // JS Plan annuity assurance
	$kdprodukjsguardian = array('JL4XG'); // JS Guardian assurance
	$kdprodukjspns = array('JSPNS', 'JSPNSB', 'JSPNSK'); // JS Pensiun Nyaman Sejahtera
	$kdprodukjsiaa = array('JSIAA'); // JS Index Annuity Assurance
	$kdprodukjsipa = array('JSIPA'); // JS Index Plan Assurance
	$kdprodukjl4bl = array('JL4BL', 'JL4BLN'); // JS Promapan
	$kdprodukjssp5 = array('JSSP5'); // JS Saving Plan
	$kdprodukjsspoa = array('JSSPOA'); // JS Optima Assurance
	$kdprodukjsproidaman = array('JL4X','JL4XN'); // JS Proidaman
	$kdprodukanuitasnew = array('APPSH', 'APP85', 'APP75', 'APP65');
?>

<link href="../jws.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../../includes/jquery.min.js" ></script>
<script language="JavaScript" type="text/javascript" src="../../includes/jquery.formatter.min.js" ></script>
<script language="JavaScript" type="text/javascript">
	$(document).ready(function () {
		$('.angka').formatter({ 'pattern': '{{999999999}}' });
		$("#btnSUP").click(function() {
			$.ajax({
				type : 'GET',
				url : 'http://192.168.2.23/jiwasraya/polis/cetaksup.php',
				data : "prefixpertanggungan=<?=$prefix?>&nopertanggungan=<?=$noper?>",
				success : function(data) {
					$("#dokumen").submit();
				}
			});
		});
		$("#btnKK").click(function() {
			$.ajax({
				type : 'GET',
				url : 'http://192.168.2.23/jiwasraya/polis/cetakkk.php',
				data : "prefixpertanggungan=<?=$prefix?>&nopertanggungan=<?=$noper?>",
				success : function(data) {
					$("#dokumen").submit();
				}
			});
		});
		$("#btnUS").click(function() { $("#dokumen").submit(); });
	});
	
	function validasi9(obj) {
		var val = pad($(obj).val(), 9);
		$(obj).val(val);
		
		$("#dokumen").submit();
	}
	
	function pad (str, max) {
		str = str.toString();
		return str.length < max ? pad("0" + str, max) : str;
	}

	setInterval(function() {
        window.location.reload();
    }, 5000);
	
	function Popup(url, name, w, h, s) {
		window.location.reload();
		var l = (screen.width-w)/2;
		var t = (screen.height-h)/2;
		window.open(url, name, 'width='+w+',height='+h+',top='+t+',left='+l+',scrollbars='+s+',resizable=yes');
		//window.location.reload();
	}
</script>

<center>
<table border="0" cellpadding="4" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" id="AutoNumber2">
	<tr style="border:1px solid #000;">
		<td colspan='2' bgcolor="#006699" style='min-width:600px;text-align:center;'>
			<font style="color:#FFFFFF;font-weight:bold;" size="2" face="Verdana">CETAK DOKUMEN</font>
		</td>
	</tr>
	<tr style="border-left:1px solid #000;border-right:1px solid #000;">
		<td width="200" bgcolor="#CCEEFF">Nomor Polis</td>
		<td bgcolor="#CCEEFF">
			<form id="dokumen">
			<input type="hidden" style="width:26px;text-align:center;" value="<?php echo $prefix;?>">
			<!----->
			<input type="hidden" class="angka" style="width:75px;" value="<?php echo $noper;?>" >
			<input type="text" class="angka" style="width:150px;" value="<?php echo $r['NOPOLBARU'];?>" >
			</form>
		</td>
	</tr>
	
	<?php if ($r['KDSTATUSFILE'] == '1' && $r['KDPERTANGGUNGAN'] == '2') { ?>
	<tr style="border-left:1px solid #000;border-right:1px solid #000;">
		<td colspan="2" class="verdana10blk" bgcolor="#CCEEFF">
			<font color="#ff6600" size="3"><b>PERHATIAN !</b></font><br>
			Dokumen hanya bisa dicetak satu kali.<br><br>
			
			Persiapan :
			<ul style="margin-top:0px;margin-bottom:0px;">
				<li>Mohon siapkan kertas dengan logo dan printer.</li>
				<li>Setting ukuran font(text size) Browser Anda. (Klik View->Text Size->Medium)</li>
				<li>Kosongkan nilai header dan footer pada Page Setup Browser Anda <br>(Klik File->Page Setup->Headers & Footers)</li>
			</ul>
			Mencetak diluar seting diatas kemungkinan menyebabkan cetakan menjadi 2 halaman.<br><br>
		</td>
	</tr>
	<!--tr style="border-left:1px solid #000;border-right:1px solid #000;">
		<td width="200" bgcolor="#CCEEFF">Berita Keputusan</td>
		<td bgcolor="#CCEEFF">: 
			<input type="button" name="cetak" value="YA. CETAK SEKARANG" onClick="Popup('cetakanbk.php?prefixpertanggungan=<? echo $prefix; ?>&nopertanggungan=<? echo $noper; ?>','',650,500,1)">
		</td>
	</tr-->
	<tr style="border-left:1px solid #000;border-right:1px solid #000;">
		<td width="200" bgcolor="#CCEEFF">Tanda Terima</td>
		<td bgcolor="#CCEEFF">: 
			<?php 
				if (in_array($r['KDPRODUK'],$kdprodukbancass)) { ?>
					<input type="button" name="cetak" value="YA. CETAK SEKARANG" onClick="Popup('../bancas/tanda_terima.php?prefixpertanggungan=<? echo $prefix; ?>&nopertanggungan=<? echo $noper; ?>','',650,500,1)">
				<?php } else { ?>
					<input type="button" name="cetak" value="YA. CETAK SEKARANG" onClick="Popup('tanda_terima.php?prefixpertanggungan=<? echo $prefix; ?>&nopertanggungan=<? echo $noper; ?>','',650,500,1)">
				<?php }
			?>
		</td>
	</tr>
	<!--tr style="border-left:1px solid #000;border-right:1px solid #000;">
		<td width="200" bgcolor="#CCEEFF">Pengantar Polis</td>
		<td bgcolor="#CCEEFF">: 
			<input type="button" name="cetak" value="YA. CETAK SEKARANG" onClick="Popup('upload_pengantar_polis.pdf','',650,500,1)">
		</td>
	</tr>
	<tr style="border-left:1px solid #000;border-right:1px solid #000;">
		<td width="200" bgcolor="#CCEEFF">Desisi Polis</td>
		<td bgcolor="#CCEEFF">:
			<input type="button" name="cetak" value="YA. CETAK SEKARANG" onClick="Popup('cetakan_desisi.php?prefixpertanggungan=<?echo $prefix;?>&nopertanggungan=<?echo $noper;?>','',800,500,1)">
		</td>
	</tr-->
	<tr style="border-left:1px solid #000;border-right:1px solid #000;">
		<td width="200" bgcolor="#CCEEFF">Cetak Polis</td>
		<td bgcolor="#CCEEFF">: 
			<?php if (strlen($r['KDCETAKPOLIS']) <= 0) {
				if ($r['KDPRODUK'] == 'JL4') { ?>
					<input type="button" name="cetak" value="YA. CETAK SEKARANG" >
				<?php } else { ?>
					<input type="button" name="cetak" value="YA. CETAK SEKARANG" onClick="Popup('../proposal/ulink/test.cetak.polis_.php?prefix=<?php echo $prefix; ?>&nopertanggungan=<?php echo $noper; ?>','',650,500,1)">
				<?php }
			} else {
				echo "Sudah dicetak $r[USERCETAKPOLIS] pada tanggal $r[TGLCETAKPOLIS]";
			} ?>
		</td>
	</tr>
	<?php if (in_array($r['KDPRODUK'],$kdprodukbancass)) { ?>
	<tr style="border-left:1px solid #000;border-right:1px solid #000;">
		<td width="200" bgcolor="#CCEEFF">Ucapan Terima Kasih</td>
		<td bgcolor="#CCEEFF">: 
			<input type="button" name="cetak" value="YA. CETAK SEKARANG" onClick="Popup('../bancas/ucapan_terimakasih.php?prefixpertanggungan=<? echo $prefix; ?>&nopertanggungan=<? echo $noper; ?>','',650,500,1)">
		</td>
	</tr>
	<?php }
	if (in_array($r['KDPRODUK'],$kdprodukanuitas) || // Anuitas
		in_array($r['KDPRODUK'],$kdprodukgjterusan) || // Gaji terusan
		in_array($r['KDPRODUK'],$kdprodukklgnpendidikan) || // Kelangsungan pendidikan
		in_array($r['KDPRODUK'],$kdprodukkrdtmenurun) || // Kredit menurun
		in_array($r['KDPRODUK'],$kdprodukjskeluarga) || // JS keluarga
		in_array($r['KDPRODUK'],$kdprodukjssinergi) || // JS Sinergi
		in_array($r['KDPRODUK'],$kdprodukjsria) || // JS Replacement income assurance
		in_array($r['KDPRODUK'],$kdprodukjsretirement) || // JS Retirement plan assurance
		in_array($r['KDPRODUK'],$kdprodukjsaa) || // JS Plan annuity assurance
		in_array($r['KDPRODUK'],$kdprodukjsguardian) || // JS Guardian assurance
		in_array($r['KDPRODUK'],$kdprodukjspns) || // JS Pensiun Nyaman Sejahtera
		in_array($r['KDPRODUK'],$kdprodukjsiaa) || // JS Index Annuity Assurance
		in_array($r['KDPRODUK'],$kdprodukjsipa) || // JS Index Plan Annuity Assurance
		in_array($r['KDPRODUK'],$kdprodukjl4bl) || // JS Promapan 2018
		in_array($r['KDPRODUK'],$kdprodukjssp5) || // JS Saving Plan
		in_array($r['KDPRODUK'],$kdprodukjsspoa) || // JS Optima Assurance
		in_array($r['KDPRODUK'],$kdprodukjsproidaman) || // JS Proidaman
		in_array($r['KDPRODUK'],$kdprodukanuitasnew) // JS Anuitas Premier Plan
	)
	{ ?>
	<tr style="border-left:1px solid #000;border-right:1px solid #000;">
		<td width="200" bgcolor="#CCEEFF">Syarat Umum Polis</td>
		<td bgcolor="#CCEEFF">: 
			<?php 
				if (in_array($r['KDPRODUK'], $kdprodukanuitas)) {
					$filesup = 'upload_sup_anuitas_watermark.pdf';
				} else if (in_array($r['KDPRODUK'], $kdprodukgjterusan)) {
					$filesup = 'upload_sup_gaji_terusan_watermark.pdf';
				} else if (in_array($r['KDPRODUK'], $kdprodukklgnpendidikan)) {
					$filesup = 'upload_sup_kelangsungan_pendidikan_watermark.pdf';
				} else if (in_array($r['KDPRODUK'], $kdprodukkrdtmenurun)) {
					$filesup = 'upload_sup_jiwa_kredit_watermark.pdf';
				} else if (in_array($r['KDPRODUK'], $kdprodukjskeluarga)) {
					$filesup = 'upload_sup_proteksi_keluarga_watermark.pdf';
				} else if (in_array($r['KDPRODUK'], $kdprodukjssinergi)) {
					$filesup = 'upload_sup_jssinergi_watermark.pdf';
				} else if (in_array($r['KDPRODUK'], $kdprodukjsria)) {
					$filesup = 'upload_sup_jsria_watermark.pdf';
				} else if (in_array($r['KDPRODUK'], $kdprodukjsretirement)) {
					$filesup = 'upload_sup_jsrpa_watermark.pdf';
				} else if (in_array($r['KDPRODUK'], $kdprodukjsaa)) {
					$filesup = 'upload_sup_jsaa_watermark.pdf';
				} else if (in_array($r['KDPRODUK'], $kdprodukjsguardian)) {
					$filesup = 'upload_sup_jsguardian_watermark.pdf';
				} else if (in_array($r['KDPRODUK'], $kdprodukjspns)) {
					$filesup = 'upload_sup_jspns_watermark.pdf';
				} else if (in_array($r['KDPRODUK'], $kdprodukjsiaa)) {
					$filesup = 'upload_sup_jsiaa_watermark.pdf';
				} else if (in_array($r['KDPRODUK'], $kdprodukjsipa)) {
					$filesup = 'upload_sup_jsipa_watermark.pdf';
				} else if (in_array($r['KDPRODUK'], $kdprodukjl4bl)) {
					$filesup = 'upload_sup_jl4bl_watermark.pdf';
				} else if (in_array($r['KDPRODUK'], $kdprodukjssp5)) {
					$filesup = 'upload_sup_jssp_watermark.pdf';
				} else if (in_array($r['KDPRODUK'], $kdprodukjsspoa)) {
					$filesup = 'upload_sup_jsspoa_watermark.pdf';
				} else if (in_array($r['KDPRODUK'], $kdprodukjsproidaman)) {
					$filesup = 'upload_sup_jl4x_watermark.pdf';
				} else if (in_array($r['KDPRODUK'], $kdprodukanuitasnew)) {
					$filesup = 'upload_sup_appx_watermark.pdf';
				} ?>
				<input id='btnSUP' type="button" name="cetak" value="YA. CETAK SEKARANG" onClick="Popup('<?=$filesup?>','',650,500,1)">
		</td>
	</tr>
	<?php }
	if (in_array($r['KDPRODUK'],$kdprodukjl4bl) || // JS Promapan 2018
		in_array($r['KDPRODUK'],$kdprodukjsproidaman) // JS Proidaman
	) 
	{ ?>
	<tr style="border-left:1px solid #000;border-right:1px solid #000;">
		<td width="200" bgcolor="#CCEEFF">Ketentuan Khusus</td>
		<td bgcolor="#CCEEFF">:
			<?php 
				if (in_array($r['KDPRODUK'], $kdprodukjl4bl)) {
					$filekk = 'upload_kk_jl4bl_watermark.pdf';
				} else if (in_array($r['KDPRODUK'], $kdprodukjsproidaman)) {
					$filekk = 'upload_kk_jl4x_watermark.pdf';
				} ?>
				<input id="btnKK" type="button" name="cetak" value="YA. CETAK SEKARANG" onClick="Popup('<?=$filekk?>','',650,500,1)">
		</td>
	</tr>
	<?php } ?>

	<?php if (in_array($r['KDPRODUK'],$kdprodukjssinergi)) { ?>
	<tr style="border-left:1px solid #000;border-right:1px solid #000;">
		<td width="200" bgcolor="#CCEEFF">Welcome Greeting</td>
		<td bgcolor="#CCEEFF">: 
			<input id="btnUS" type="button" name="cetak" value="YA. CETAK SEKARANG" onClick="Popup('ucapanselamat.php?prefixpertanggungan=<? echo $prefix; ?>&nopertanggungan=<? echo $noper; ?>','',650,500,1)">
		</td>
	</tr>
	<?php } ?>
	<tr style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;">
		<td colspan="2" bgcolor="#CCEEFF"></td>
	</tr>
	
	<?php } else { ?>
	<tr style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;">
		<td colspan="2" bgcolor="#CCEEFF">Polis tidak ditemukan / tidak aktif / belum dikonversi...</td>
	</tr>
	<?php } ?>
</table>
</center>

<hr size="1">
<div id="noprint2">