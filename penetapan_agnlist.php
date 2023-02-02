<?php
  include "../../includes/session.php";
  include "../../includes/database.php";
  
	
	$DB=New database($userid, $passwd, $DBName);
	$DB1=New database($userid, $passwd, $DBName);	
	$formname=(!$a) ? "ntryprop" : $a;	
	$fieldname=(!$b) ? "noagen" : $b;	
	$jumhis="select count(*) jmlhis from $DBUser.tabel_417_histori_jabatan where noagen='$noagen'";
	$DB1->parse($jumhis);
	$DB1->execute();
	$arrj=$DB1->nextrow();
	$jmlhist=$arrj["JMLHIS"];
	
	
	$cekpn="select kdpangkat from $DBUser.tabel_400_agen where noagen='$noagen'";
	$DB1->parse($cekpn);
	$DB1->execute();
	$arc=$DB1->nextrow();	
	$kdpangkat=$arc["KDPANGKAT"];
	
		//echo $cekpn."<br>".$jumhis;
?>	
  <html><title>Agen List</title>
  <link href="../../includes/jws2005.css" rel="stylesheet" type="text/css">
	<script language="JavaScript" type="text/javascript" src="../../includes/highlight.js"></script>
	<script language="JavaScript" type="text/javascript">
	<!--
  function OnSumbit(theForm) {
	 var a = theForm.nama.value;
	 if (a.length < 3) {
	  if (confirm('Masukkan 3 Hurup Pertama Yang Ingin Dicari\nKlik OK Untuk Semuanya')) {
		 theForm.nama.value='ALL';
		 return true;
		} else {
		 theForm.nama.focus();
		 return false;
		}  
	 } else {
	  return true;
	 }	
	} 
	//-->
	</script>
	<body>
	<form name="porm" method="post" action="<?echo $PHP_SELF;?>" onsubmit="return OnSumbit(document.porm)">
	
	<br>
	<b>Daftar Penetapan Agen</b><br>
	<?

  if (!$nama) {
	 //$dannama = 'kampret';
	} elseif ($nama=='ALL') {
	 $dannama = '';
	} else{ 
   $dannama = "and b.namaklien1 like '".strtoupper($nama)."%'"; 
  }
	$ad = ($o==1) ?  'desc' : 'asc';
	$f = (!$f) ? '2' : $f;
	
	$sql = "select A.*, TO_CHAR(A.TGLJABATAN,'YYYY') AS THNJABATAN, TO_CHAR(A.TGLJABATAN,'DDMMYYYY') AS TGL from $DBUser.tabel_417_histori_jabatan A where noagen='$noagen' and nopkajagen='$nopkaj' ".
			     		 "order by noagen";
				//echo $sql;
	$DB->parse($sql);
	$DB->execute();
	
?>
	<table border="0" width="100%" cellpadding="2" cellspacing="1">
  <tr bgcolor="#f89aa4">
    <?
    $o = (int)!((boolean)$o);
        echo "<td align=\"center\"><a href=\"$PHP_SELF?a=$a&b=$b&nama=$nama&f=1&o=$o&kdkantor=$kdkantor\"><b>Nomor SPA</b></a></td>" ;
        //echo "<td align=\"center\"><a href=\"$PHP_SELF?a=$a&b=$b&nama=$nama&f=2&o=$o&kdkantor=$kdkantor\"><b>Nama</b></a></td>" ;
   			//echo "<td align=\"center\"><b>Kode Kantor</b></td>";
   			//echo "<td align=\"center\"><a href=\"$PHP_SELF?a=$a&b=$b&nama=$nama&f=3&o=$o&kdkantor=$kdkantor\"><b>Area Office</b></a></td>";
    ?>
  </tr>
<?
	$i=0;
	while($arr=$DB->nextrow()) {
	//$pkajnya=substr($arr["KDKANTOR"],-1)=="A"? "cetak_pkaj_lamp1pk.php":"cetak_pkaj_lamp1.php";
	if($arr["KDJABATANAGEN"]=="10" || $arr["KDJABATANAGEN"]=="11" || $arr["KDJABATANAGEN"]=="12" || $arr["KDJABATANAGEN"]=="13"){
	$pkajnya="cetak_pkaj_lamp1pk.php";
	}else{
	$pkajnya="cetak_pkaj_lamp1.php";
	}
	  ?>

	<tr>
		<td align=center>
			<?php
				if($arr['KDJABATANAGEN'] !='29' && $arr['PERIHAL']=='MIGRASI') { ?>
					<a href="#" onClick="window.open('../agen/cetak_spa_penetapan_migrasi.php?nopkaj=<?=$nopkaj;?>&noagen=<?=$noagen;?>&kt=<?=$kota;?>&ket=<?=$arr["KETERANGAN"];?>&tgljabatan=<?=$arr["TGL"];?>&tglpkaj=<?=$tglpkaj;?>','','width=800,height=600,top=100,left=100,scrollbars=yes');">
					<font face="Arial" size="2"><?=$arr["KETERANGAN"];?></font></a>
				<?
				}else if (in_array($arr['KDJABATANAGEN'], array("31","32","33","34","35","36","37","38")) && $arr['URAIAN'] =='TETAP' ) { ?>
					<a href="#" onClick="window.open('../agen/cetak_spa_penetapan_lpa.php?nopkaj=<?=$nopkaj;?>&noagen=<?=$noagen;?>&kt=<?=$kota;?>&ket=<?=$arr["KETERANGAN"];?>&tgljabatan=<?=$arr["TGL"];?>&tglpkaj=<?=$tglpkaj;?>','','width=800,height=600,top=100,left=100,scrollbars=yes');">
					<font face="Arial" size="2"><?=$arr["KETERANGAN"];?></font></a>
				<?php } else if (in_array($arr['KDJABATANAGEN'], array("31","32","33","34","35","36","37","38")) && $arr['URAIAN'] =='PEMBERHENTIAN KARNA EVALUASI' ) { ?>
					<a href="#" onClick="window.open('../agen/cetak_spa_pemberhentian_validasi_lpa.php?nopkaj=<?=$nopkaj;?>&noagen=<?=$noagen;?>&kt=<?=$kota;?>&ket=<?=$arr["KETERANGAN"];?>&tgljabatan=<?=$arr["TGL"];?>&tglpkaj=<?=$tglpkaj;?>','','width=800,height=600,top=100,left=100,scrollbars=yes');">
					<font face="Arial" size="2"><?=$arr["KETERANGAN"];?></font></a>
				<?php } else if (in_array($arr['KDJABATANAGEN'], array("31","32","33","34","35","36","37","38")) && $arr['URAIAN'] =='PEMUTUSAN PKAJ' ) { ?>
					<a href="#" onClick="window.open('../agen/cetak_spa_pemutusan_pkaj_lpa.php?nopkaj=<?=$nopkaj;?>&noagen=<?=$noagen;?>&kt=<?=$kota;?>&ket=<?=$arr["KETERANGAN"];?>&tgljabatan=<?=$arr["TGL"];?>&tglpkaj=<?=$tglpkaj;?>','','width=800,height=600,top=100,left=100,scrollbars=yes');">
					<font face="Arial" size="2"><?=$arr["KETERANGAN"];?></font></a>
				<?php } else if (in_array($arr['KDJABATANAGEN'], array("31","32","33","34","35","36","37","38")) && $arr['URAIAN'] =='MENGUNDURKAN DIRI' ) { ?>
					<a href="#" onClick="window.open('../agen/cetak_spa_resign_lpa.php?nopkaj=<?=$nopkaj;?>&noagen=<?=$noagen;?>&kt=<?=$kota;?>&ket=<?=$arr["KETERANGAN"];?>&tgljabatan=<?=$arr["TGL"];?>&tglpkaj=<?=$tglpkaj;?>','','width=800,height=600,top=100,left=100,scrollbars=yes');">
					<font face="Arial" size="2"><?=$arr["KETERANGAN"];?></font></a> 
				<?php } else if($arr['KDJABATANAGEN'] != '29' && $arr["URAIAN"]=="MENGUNDURKAN DIRI" ) { ?>
					<a href="#" onClick="window.open('../agen/cetak_spa_resign_n012020.php?nopkaj=<?=$nopkaj;?>&noagen=<?=$noagen;?>&kt=<?=$kota;?>&ket=<?=$arr["KETERANGAN"];?>&tgljabatan=<?=$arr["TGL"];?>&tglpkaj=<?=$tglpkaj;?>','','width=800,height=600,top=100,left=100,scrollbars=yes');">
					<font face="Arial" size="2"><?=$arr["KETERANGAN"];?></font></a>
				<? 
				} elseif($arr['KDJABATANAGEN'] !='29' && $arr["URAIAN"]=="PEMBERHENTIAN"){ ?>
					<a href="#" onClick="window.open('../agen/cetak_spa_pemberhentian_n012020.php?nopkaj=<?=$nopkaj;?>&noagen=<?=$noagen;?>&kt=<?=$kota;?>&ket=<?=$arr["KETERANGAN"];?>&tgljabatan=<?=$arr["TGL"];?>&tglpkaj=<?=$tglpkaj;?>','','width=800,height=600,top=100,left=100,scrollbars=yes');">
					<font face="Arial" size="2"><?=$arr["KETERANGAN"];?></font></a><?
				} elseif( $arr['KDJABATANAGEN'] !='29' && $arr["URAIAN"]=="MENINGGAL DUNIA"){ ?>
					<a href="#" onClick="window.open('../agen/cetak_spa_meninggal_n012020.php?nopkaj=<?=$nopkaj;?>&noagen=<?=$noagen;?>&kt=<?=$kota;?>&ket=<?=$arr["KETERANGAN"];?>&tgljabatan=<?=$arr["TGL"];?>&tglpkaj=<?=$tglpkaj;?>','','width=800,height=600,top=100,left=100,scrollbars=yes');">
					<font face="Arial" size="2"><?=$arr["KETERANGAN"];?></font></a><?
				} else { ?>
					<a href="#" onClick="window.open('../agen/cetak_spa_penetapan_n012020.php?nopkaj=<?=$nopkaj;?>&noagen=<?=$noagen;?>&kt=<?=$kota;?>&ket=<?=$arr["KETERANGAN"];?>&tgljabatan=<?=$arr["TGL"];?>&tglpkaj=<?=$tglpkaj;?>','','width=800,height=600,top=100,left=100,scrollbars=yes');">
					<font face="Arial" size="2"><?=$arr["KETERANGAN"];?></font></a><? 
				}?>
		</td>
	</tr>
	
<?
   
$i++;
} ?>
		</td>
	</tr>
</table>

</body>
</html>