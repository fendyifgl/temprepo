<?
//echo $userid.'xxxx';
	include "../../includes/session.php"; 
  include "../../includes/database.php"; 
	include "../../includes/null.php";
	include "../../includes/klien.php";
	
	$prefixpertanggungan = (!$prefixpertanggungan||$prefixpertanggungan=='') ? $kantor : $prefixpertanggungan;
	$DB=New database($userid, $passwd, $DBName);	
	
	//echo $mode;
	//update info tambahan
	$sql = "update $DBUser.tabel_200_temp set premiumholiday='$premiumholiday',nopolswitch='$prefix$noper',taltup='$taltup',".
			 	 				 "tgltransfer=to_date('$tgltransfer','DD/MM/YYYY'), jmltransfer='$jmltransfer' ".
  		 	 "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan'";
  //echo $sql;
  $DB->parse($sql);
  $DB->execute();

  $juamainproduk = $juamainprodukaims ? $juamainprodukaims : $juamainproduk;
?>

<html>
<head>
<script type="text/javascript">
function blinkIt() {
 if (!document.all) return;
 else {
   for(i=0;i<document.all.tags('blink').length;i++){
      s=document.all.tags('blink')[i];
      s.style.visibility=(s.style.visibility=='visible')?'hidden':'visible';
   }
 }
}
</script>

<title>PT Asuransi Jiwa IFG Private Network</title>
<link href="../jws.css" rel="stylesheet" type="text/css">
</head>
<body onload="setInterval('blinkIt()',300)">
<div align="center">
<?
if ($mode=='edit'){
  echo "<form action=\"proposaltoke.php\" method=\"post\" name=\"edit\">";
} else {
  //if ($userid=='BAGUS'){
  //echo "<form action=\"proposaloke.php?nopropos=001636864\" method=\"post\" name=\"insert\">";
  //}
  //else{	
  echo "<form action=\"proposaloke.php\" method=\"post\" name=\"insert\">";
  //}
}

?>
<table border="0" cellpadding="1" width="700" cellspacing="1" class="tblhead">
	<tr>
		<td class="tblisi">
			<table width="100%" border="0" cellpadding="1" cellspacing="1">
				<tr>
					<td width="100%" colspan="6"  align="center" class="tblhead"><b>KONFIRMASI PROPOSAL <?if (!strlen($noproposal)==0){echo $prefixpertanggungan."-".$noproposal; } ?>
					</b><br><?if (strlen($noproposal)==0){ echo "<font size=2>nomor diberikan otomatis setelah submit berhasil untuk proposal baru</font>"; }?>
					</td>
				</tr>
				<tr>
					<td width="100%" colspan="6"  align="center" class="tblisi1">
					<font size="2" color="red"><b>
					Periksa Baik baik Apakah Data Telah Lengkap Dan Benar</b><br>Premi dan JUA jangan sampai bernilai 0</td>
				</tr>				
				<tr>
					<td width="100%" align="center" colspan="6">
						<table width="95%" border="0" cellpadding="1" cellspacing="1" class="verdana8">	
							<tr>
								<td width="18%" >SPAJ nomor</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $nosp; ?></td>
								<td width="18%" >Tanggal SPAJ</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $tglsp; ?></td>
							</tr>
							<tr>
								<td width="18%" >BP3 nomor</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $nobp3; ?></td>
								<td width="18%" >Tanggal BP3</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $tglbp3; ?></td>
							</tr>
						</table>
					</td>
				</tr>
                
                	
                
                
                
				<tr>
					<td width="100%" colspan="6"  class="tblhead1" align="center">Tertanggung</td>
				</tr>
				<tr>
					<td width="100%" align="center" colspan="6">
						<table width="95%" border="0" cellpadding="0" cellspacing="0" class="verdana8">	
							<tr>
								<td width="18%" >Klien nomor</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $notertanggung; ?></td>
                <?
                
                	$sql="select a.namaklien1, a.namaklien2, b.namapekerjaan, c.namahobby, a.gelar,f.namaagama,".
                			 "to_char(a.tgllahir,'DD/MM/YYYY') tgllahir, decode(a.jeniskelamin,'P','PEREMPUAN','L','LAKI-LAKI') jeniskelamin,a.kdid||'-'||a.noid identitas, ".
                			 "a.tinggibadan,a.beratbadan,alamattetap01,alamattetap02,a.phonetetap01,a.phonetagih01,d.namakotamadya,e.namapropinsi,decode(a.meritalstatus,'L','LAJANG','K','KAWIN','J','JANDA','D','DUDA') merital ".
                			 "from $DBUser.tabel_100_klien a, $DBUser.tabel_105_pekerjaan b, $DBUser.tabel_114_hobby c, ".
                			 "$DBUser.tabel_109_kotamadya d, $DBUser.tabel_108_propinsi e,$DBUser.tabel_102_agama f ".
                		 	 "where a.kdpekerjaan=b.kdpekerjaan(+) and a.kdhobby=c.kdhobby(+) and a.kdagama=f.kdagama(+) ".
                			 "and a.kdpropinsitetap=e.kdpropinsi(+) and a.kdkotamadyatetap=d.kdkotamadya(+) and a.noklien='$notertanggung' ";
                	//echo $sql;	 
                	$DB->parse($sql);
                	$DB->execute();
                	$ara=$DB->nextrow();
                	$nama = (strlen($ara["GELAR"])==0) ? $ara["NAMAKLIEN1"] : $ara["NAMAKLIEN1"].",".$ara["GELAR"];
                ?>
								<td width="18%" >Nama</td>
								<td width="2%" >:</td>
								<td width="30%" ><?echo $nama; ?>
			 					</td>
							</tr>
							<tr>
								<td width="18%" >Tgl Lahir</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $ara["TGLLAHIR"]; ?></td>
								<td width="18%" >Jenis Kelamin</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $ara["JENISKELAMIN"]; ?></td>
							</tr>
							<tr>
								<td width="18%" >Alamat</td>
								<td width="2%" >:</td>							
								<td  colspan="4"><? echo $ara["ALAMATTETAP01"]." ".$ara["ALAMATTETAP02"]." ".$ara["NAMAKOTAMADYA"]." ".$ara["NAMAPROPINSI"]; ?></td>
							</tr>																
							<tr>
								<td width="18%" >Pekerjaan</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $ara["NAMAPEKERJAAN"]; ?></td>
								<td width="18%" >Hobby</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $ara["NAMAHOBBY"]; ?></td>
							</tr>
							<tr>
								<td width="18%" >Tinggi Badan</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $ara["TINGGIBADAN"]; ?> &nbsp;&nbsp;&nbsp;cm</td>
								<td width="18%" >Berat Badan</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $ara["BERATBADAN"]; ?>&nbsp;&nbsp;&nbsp;kg</td>
							</tr>						
							<tr>
								<td width="18%" >Identitas</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $ara["IDENTITAS"]; ?></td>
								<td width="18%" >Agama</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $ara["NAMAAGAMA"]; ?></td>
							</tr>
							<tr>
								<td width="18%" >Status Pernikahan</td>
								<td width="2%" >:</td>							
								<td  colspan="4"><? echo $ara["MERITAL"]; ?></td>
							</tr>	
							<tr>
								<td width="18%" >Telepon Tetap</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $ara["PHONETETAP01"]; ?></td>
								<td width="18%" >Telepon Tagih</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $ara["PHONETAGIH01"]; ?></td>
							</tr>
															
						</table>
					</td>
				</tr>
				<tr>
					<td width="100%" colspan="6"  class="tblhead1"><p align="center">Ketentuan Polis</td>
				</tr>
				<tr>
				  <td width="100%" align="center" colspan="6">
					  <table width="95%" border="0" cellpadding="0" cellspacing="0" class="verdana8">	
						  <tr>
							  <td width="18%" >Kode Produk</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $kdproduk; ?></td>
								<td width="18%" >Nama Produk</td>
								<td width="2%" >:</td>
                <?
								$sql = "select premi1 from $DBUser.tabel_200_temp ".
                			   "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan'";
                //echo $sql;
                	$DB->parse($sql);
                	$DB->execute();
                	$arr=$DB->nextrow();
								  $premi1 = $arr["PREMI1"];
									
                	$sql="select namaproduk,skg from $DBUser.tabel_202_produk where kdproduk='$kdproduk'";
                	$DB->parse($sql);
                	$DB->execute();
                	$ara=$DB->nextrow();
                	$kprod=$ara["SKG"];
                	
                	$sql = "select 'x' x from $DBUser.tabel_223_temp ".
                			   "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' and kdbenefit='JAMLKP'";
                	//echo $sql;
                	$DB->parse($sql);
                	$DB->execute();
                	$arr=$DB->nextrow();
                	$namaproduk = ($arr["X"]=='x') ? $ara["NAMAPRODUK"]." <font color=red>LENGKAP" : $ara["NAMAPRODUK"];
                  
                ?>
								<td width="30%" ><? echo $namaproduk; ?></td>
							</tr>
							<tr>
								<td width="18%" >Medical</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $kdstatusmedical; ?></td>
								<td width="18%" >Tgl Mulai</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $mulas; ?></td>
							</tr>
							<tr>
								<td width="18%" >Usia</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $usia_th." th, ".$usia_bl." bl."; ?></td>
								<td width="18%" >Lama Asuransi</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $lamaasuransi_th." th, ".$lamaasuransi_bl." bl.";?></td>
							</tr>
							<tr>
								<td width="18%" >Tgl Ekspirasi</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $expirasi; ?></td>
								<td width="18%" >Gadai Otomatis</td>
								<td width="2%" >:</td>
								<td width="30%" ><? if ($bpo=='1') { echo "SETUJU"; } else { echo "TIDAK SETUJU"; } ?>	</td>
							</tr>
							<tr>
								<td width="18%" >Akhir Premi</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $akhirpremi; ?></td>
								<td width="18%" >Lama Premi</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $lamapembpremi_th." th, ".$lamapembpremi_bl." bl.";?></td>
							</tr>
							<tr>
								<td width="18%" >V a l u t a</td>
								<td width="2%" >:</td>
                <?		
                	$sql="select namavaluta from $DBUser.tabel_304_valuta where kdvaluta='$kdvaluta' ";
                	$DB->parse($sql);
                	$DB->execute();
                	$ara=$DB->nextrow();
                
                ?>
								<td width="30%" ><? echo $ara["NAMAVALUTA"]; ?></td>
								<td width="18%" >Cara Bayar</td>
								<td width="2%" >:</td> 
                <?		
                	$sql="select namacarabayar,kdjeniscb,faktorkomisi from $DBUser.tabel_305_cara_bayar where kdcarabayar='$kdcarabayar' ";
                	$DB->parse($sql);
                	$DB->execute();
                	$ara=$DB->nextrow();
                	$faktorkomisi=$ara["FAKTORKOMISI"];
                	$kdjeniscb=$ara["KDJENISCB"];
					$carabayar=$ara["NAMACARABAYAR"];
                  ?>
								<td width="30%" ><? echo $ara["NAMACARABAYAR"]; ?></td>
							</tr>
							<tr>
								<td width="18%" >Index  Awal</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $indexawal; ?></td>
								<td width="18%" >Premi 5 th I</td>
								<td width="2%" >:</td>
								<td width="30%" ><font color="red"><? echo number_format($premi1,2); ?></td>
							</tr>
							<tr>
								<td width="18%" >J U A</td>
								<td width="2%" >:</td>
								<td width="30%" ><font color="red"><? echo number_format($juamainproduk,2); ?></td>
								<td width="18%" >Premi >5 tahun</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo number_format($premi2,2); ?></td>
							</tr>
							
							<tr>
								<td width="18%" >Premi Standar</td>
								<td width="2%" >:</td>
								<td width="30%" ><font color="red"> <? echo number_format($premistd,2) ; ?></td>
								<td>Auto Debet</td>
								<td>:</td>
								<td>
								<?=($autodebet==1)? "YA" : "TIDAK";?> 
								
								<? 
								if($autodebet==1)
								{
								$sql = "select namabank from $DBUser.tabel_399_bank where kdbank='$kdbank'";
      					$DB->parse($sql);
      					$DB->execute();
								$arr=$DB->nextrow();
								
								echo "(".$arr["NAMABANK"]." No.Rek. $norekening)";
								}
								?>
								</td>
							</tr>			
							<?
							$sql = "select kdbenefit,premi from $DBUser.tabel_223_temp where  
                      kdbenefit in ('BNFTOPUP','BNFTOPUPSG')
                      and prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan'";
							$DB->parse($sql);
      			  $DB->execute();
							while($top=$DB->nextrow())
							{
							  if($top["KDBENEFIT"]=="BNFTOPUP")
								{
								  $ptopupbk = $top["PREMI"];
								} else {
								  $ptopupsg = $top["PREMI"];
								}
							}
							?>
							<tr>
								<td width="18%" >Premi Top-up Berkala</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo number_format($ptopupbk,2); ?></td>
								<td width="18%" ></td>
								<td width="2%" ></td>
								<td width="30%" ></td>
							</tr>
						</table>
					</td>
				</tr>	
				<tr>
					<td width="100%" align="center" colspan="6"  class="tblhead1">Benefit</td>
				</tr>
				<tr>
				  <td width="100%" align="center" colspan="6">
						<table width="95%" border="0" cellpadding="0" cellspacing="0" class="verdana8">	
							<tr class="hijao">
								<td colspan="3" width="30%" align="left">Nama Benefit</td>
								<td width="17%" align="center">Benefit</td>
								<td width="15%"  align="center">Jatuh Tempo</td>
								<td width="20%" align="right">Premi (per tahun)</td>
							</tr>
            <?
            	$sql="select a.namabenefit,b.premi,b.nilaibenefit,b.kdjenisbenefit,to_char(b.expirasi,'DD/MM/YYYY') expirasi ".
            			 "from $DBUser.tabel_223_temp b, $DBUser.tabel_207_kode_benefit a ".
            			 "where a.kdbenefit=b.kdbenefit and ".
            			 "b.prefixpertanggungan='$prefixpertanggungan' and b.nopertanggungan='$nopertanggungan'";
							$DB->parse($sql);
            	$DB->execute();
            	while ($ara=$DB->nextrow()) {
            	  $jmlpremi+=$ara["PREMI"];
            		$jmlbenefit+=$ara["NILAIBENEFIT"];
            		$nb=$ara["NILAIBENEFIT"]!=0 ? number_format($ara["NILAIBENEFIT"],2):' ';
            		$np=$ara["PREMI"]!=0 ? number_format($ara["PREMI"],2):' ';	
            		echo "<tr>";
            		echo "<td colspan=3>".$ara["NAMABENEFIT"]."</td>";
            		echo "<td align=\"right\">".$nb."</td>";
            		echo "<td  align=\"center\">".$ara["EXPIRASI"]."</td>";
            		echo "<td  align=\"right\">".$np."</td>";
            		echo "</tr>";
            	}
            	  echo "<tr>";
            		echo "<td ></td>";
            		echo "<td ></td>";
            		echo "<td ></td>";
            		echo "<td ><hr size=1></td>";
            		echo "<td ></td>";
            		echo "<td ><hr size=1></td>";
            		echo "</tr>";
            		echo "<tr>";
            		echo "<td colspan=3 align=right>Jumlah</td>";
            		echo "<td  align=\"right\"></b></td>";
            		echo "<td ></td>";
            		echo "<td align=\"right\"><b>".number_format($jmlpremi,2)."</b></td>";
            		echo "</tr>";
            ?>
				 		</table>
					</td>
			 	</tr>
		 	 	<tr>
			 		<td width="100%" align="center" colspan="6" class="tblhead1">Pemegang Polis, Pembayar Premi, Beneficiary</td>
				</tr>
			 	<tr>
			 		<td width="100%" align="center" colspan="6">
						<table width="95%" border="0" cellpadding="0" cellspacing="0" class="verdana8">	
						 	<tr class="hijao">
						 		<td width="18%" align="center">Jenis</td>
								<td width="2%"></td>
								<td width="30%" align="center"> Nomor Klien</td>
								<td width="18%" align="center">Hubungan</td>
								<td width="2%"></td>
								<td width="30%" align="center">Nama</td>
							</tr>
			 				<tr>
			 					<td width="18%" >Pemegang Polis</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $pempolno; ?></td>
								<td width="18%" ><? echo $pempolhub; ?></td>
								<td width="2%" ></td>
								<td width="30%" ><? echo $pempolnama; ?></td>
							</tr>
			 				<tr>
			 					<td width="18%" >Pembayar Premi</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $pempreno; ?></td>
								<td width="18%" ><? echo $pemprehub; ?></td>
								<td width="2%" ></td>
								<td width="30%" ><? echo $pemprenama; ?></td>
							</tr>
            <? 
            $sql = "delete from $DBUser.tabel_219_temp ".
            		   "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan'";
            	$DB->parse($sql);
            	$DB->execute();
            	$DB->nextrow();
            		 
            for($i=1;$i<=$demit;$i++){
            	$k[$i]='klienno'.$i;
            	$a[$i]='hubungan'.$i;
            	$b[$i]='nama'.$i;
            	$ahw = $$k[$i];
            	
            	if ($notertanggung==$ahw) {
            	 $sql ="insert into $DBUser.tabel_219_temp (prefixpertanggungan,nopertanggungan,kdinsurable,notertanggung,noklien,nourut) ".
            			   "values ('$prefixpertanggungan','$nopertanggungan','04','$notertanggung','$ahw',$i) ";
            	} else {
            	 $sql ="insert into $DBUser.tabel_219_temp (prefixpertanggungan,nopertanggungan,kdinsurable,notertanggung,noklien,nourut) ".
            			   "select '$prefixpertanggungan','$nopertanggungan',b.kdhubungan,notertanggung,noklieninsurable,$i ".
            				 "from $DBUser.tabel_113_insurable a, $DBUser.tabel_218_kode_hubungan b ".
            				 "where a.notertanggung='$notertanggung' and a.noklieninsurable='$ahw' ".
            				 "and b.namahubungan='".$$a[$i]."' and a.kdhubungan=b.kdhubungan";
            	}			 
            	//echo "<font size=1>$sql<br>";
            	$DB->parse($sql);
            	$DB->execute();
            	$DB->nextrow();
            				 
            	echo "<tr>";
              echo "<td width=\"18%\" >Ahli Waris ".$i."</td>";
            	echo "<td width=\"2%\" >:</td>";
              echo "<td width=\"30%\" >".$ahw."</td>";
              echo "<td width=\"18%\" >".$$a[$i]."</td>";
            	echo "<td width=\"2%\" ></td>";
              echo "<td width=\"30%\" >".$$b[$i]."</td>";
              echo "</tr>";
            }
            ?>
			 			</table>
					</td>
			 	</tr>
		 	 	<tr>
			 		<td width="100%" align="center" colspan="6"  class="tblhead1">Penutup</td>
  			</tr>
			 	<tr>
			 		<td width="100%" align="center" colspan="6">
						<table width="95%" border="0" cellpadding="1" cellspacing="1" class="verdana8">	
							<tr class="hijao">
				 				<td width="18%" align="center">Jenis</td>
								<td width="2%"></td>
								<td width="30%" align="center"> Nomor Klien</td>
								<td width="50%" align="center">Nama</td>
							</tr>  
				 			<tr>
				 				<td width="18%">Penagih</td>
								<td width="2%">:</td>
                <?	
                	$sql="select namaklien1,namaklien2,noklien from $DBUser.tabel_100_klien where noklien=$nopenagih ";
                	$DB->parse($sql);
                	$DB->execute();
                	$ara=$DB->nextrow();
                ?>
								<td width="30%" ><? echo $ara["NOKLIEN"]; ?></td>
								<td width="50%" ><? echo $ara["NAMAKLIEN1"]." ".$ara["NAMAKLIEN2"]; ?></td>
								<!--<td width="2%" ></td>
								<td width="30%" ><? echo $ara["NAMAKLIEN2"]; ?></td>-->
							</tr>
			 				<tr>
              <?		
              	$sql="select namaklien1,namaklien2,noklien from $DBUser.tabel_100_klien where noklien=$noagen ";
              	$DB->parse($sql);
              	$DB->execute();
              	$ara=$DB->nextrow();
              ?>
								<td width="18%" >Agen</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $ara["NOKLIEN"]; ?></td>
								<td width="50%" ><? echo $ara["NAMAKLIEN1"]." ".$ara["NAMAKLIEN2"]; ?></td>
  						</tr>
			 				<tr>
<?
	$sql="select kdstatusfile,namastatusfile from $DBUser.tabel_299_status_file";			
	$DB->parse($sql);			
	$DB->execute();	    
	$ara=$DB->nextrow();			    
?>	
								<td width="18%" >Status</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $ara["NAMASTATUSFILE"]; ?></td>
								<td width="50%" ></td>
							</tr>
			 			</table>
					</td>
		 		</tr>
                
                <!--PMN-->
                <tr>
					<td width="100%" colspan="6"  class="tblhead1" align="center"><b><font color="#FF0000" >PMN - Prinsip Mengenal Nasabah</font></b></td>
				</tr>
                <tr>
					<td width="100%" align="center" colspan="6">
						<table width="95%" border="0" cellpadding="0" cellspacing="0" class="verdana8">	
							<tr>
								<td width="18%" >Klien nomor</td>
								<td width="2%" >:</td>
								<td width="30%" ><? echo $notertanggung; ?></td>
                <?
                
                	$sql="select a.namaklien1, a.namaklien2, b.namapekerjaan, c.namahobby, a.gelar,f.namaagama,".
                			 "to_char(a.tgllahir,'DD/MM/YYYY') tgllahir, ROUND(months_between (sysdate,a.tgllahir)/12,0) usiapp, decode(a.jeniskelamin,'P','PEREMPUAN','L','LAKI-LAKI') jeniskelamin,a.kdid||'-'||a.noid identitas, ".
                		"a.tinggibadan,a.beratbadan,alamattetap01,alamattetap02,a.phonetetap01,a.phonetagih01,d.namakotamadya,e.namapropinsi,decode(a.meritalstatus,'L','LAJANG','K','KAWIN','J','JANDA','D','DUDA') merital ".
                			 "from $DBUser.tabel_100_klien a, $DBUser.tabel_105_pekerjaan b, $DBUser.tabel_114_hobby c, ".
                			 "$DBUser.tabel_109_kotamadya d, $DBUser.tabel_108_propinsi e,$DBUser.tabel_102_agama f ".
                		 	 "where a.kdpekerjaan=b.kdpekerjaan(+) and a.kdhobby=c.kdhobby(+) and a.kdagama=f.kdagama(+) ".
                			 "and a.kdpropinsitetap=e.kdpropinsi(+) and a.kdkotamadyatetap=d.kdkotamadya(+) and a.noklien='$pempolno' ";
                	//echo $sql;	 
                	$DB->parse($sql);
                	$DB->execute();
                	$ara=$DB->nextrow();
                	$nama = (strlen($ara["GELAR"])==0) ? $ara["NAMAKLIEN1"] : $ara["NAMAKLIEN1"].",".$ara["GELAR"];
					
					$warnaus = (($ara["USIAPP"]/1)>=22) ? "#009F00" : "#FF0000" ;
					$flagus = (($ara["USIAPP"]/1)>=22) ? "" : "<blink><img src='red_flag.png' width='15' height='15'></blink>" ;
					$warnacb = ($carabayar=='SEKALIGUS') ? "#FF0000" : "#009F00" ;
					$flagcb = ($carabayar=='SEKALIGUS') ? "<blink><img src='red_flag.png' width='15' height='15'></blink>" : "" ;
					$warnaprm = (($premi1/1)>=500000000) ? "#FF0000" : "#009F00"  ;
					$flagprm = (($premi1/1)>=500000000) ? "<blink><img src='red_flag.png' width='15' height='15'></blink>" : "" ;
					
					if ($ara["NAMAPEKERJAAN"]=='PEGAWAI BUMN' ||
					$ara["NAMAPEKERJAAN"]=='PEGAWAI BUMD' ||
					$ara["NAMAPEKERJAAN"]=='PEGAWAI NEGERI SIPIL' ||
					$ara["NAMAPEKERJAAN"]=='TNI / POLRI' ||
					$ara["NAMAPEKERJAAN"]=='IBU RUMAH TANGGA' ||
					$ara["NAMAPEKERJAAN"]=='MAHASISWA' ||
					$ara["NAMAPEKERJAAN"]=='GUBERNUR') {
						$warnakrj = "#FF0000" ;
						$flagkrj = "<blink><img src='red_flag.png' width='15' height='15'></blink>" ;
					} else {
						$warnakrj = "#009F00" ;
						$flagkrj = "" ;
					}
					






					
                ?>
								<td width="18%" >Nama</td>
								<td width="2%" >:</td>
								<td width="30%" ><?echo $nama;?>
			 					</td>
							</tr>
							<tr>
								<td width="18%" >Usia Pempol</td>
								<td width="2%" >:</td>
								<td width="30%" ><b><font color= "<? echo $warnaus; ?>"><? echo $ara["USIAPP"]; ?> &nbsp;TAHUN </font></b><? echo $flagus;?></td>
							</tr>
							<tr>
								<td width="18%" >Premi</td>
								<td width="2%" >:</td>							
								<td><b><font color= "<? echo $warnaprm; ?>"><? echo number_format($premi1,2); ?></font></b><? echo $flagprm;?></td>
                                <td width="18%" >Cara Bayar</td>
								<td width="2%" >:</td>
								<td width="30%" ><b><font color= "<? echo $warnacb; ?>"><? echo $carabayar; ?> </font></b><?echo $flagcb;?></td>
							</tr>																
							<tr>
								<td width="18%" >Pekerjaan</td>
								<td width="2%" >:</td>
								<td width="30%" ><b><font color= "<? echo $warnakrj; ?>"><? echo $ara["NAMAPEKERJAAN"]; ?></font></b><? echo $flagkrj;?></td>
								<td width="18%" ></td>
								<td width="2%" ></td>
								<td width="30%" ></td>
							</tr>
							
															
						</table>
					</td>
				</tr>
                <!--PMN-->
                
				<tr>
			 		<td width="100%" align="center" colspan="6" class="verdana8">
<?
	$sql="select a.thnkomisi,a.komisiagen,b.namakomisiagen,b.kdkomisiagen, ".
	     "decode(b.kdkomisiagen,'02',0,a.komisiagen) ko, a.komisiagen,".
			 "decode(b.kdkomisiagen,'02',b.namakomisiagen,b.namakomisiagen||' TAHUN '||a.thnkomisi) nk, ".
	     "decode(b.kdkomisiagen,'02',a.komisiagen,decode('$kprod','1',decode('$kdjeniscb','B',a.komisiagen/$faktorkomisi,'X',a.komisiagen),decode('$kdjeniscb','B',a.komisiagen/$faktorkomisi,'X',a.komisiagen*$faktorkomisi) ) ) k ".  
			 "from $DBUser.tabel_404_temp a, $DBUser.tabel_402_kode_komisi_agen b ".
			 "where a.kdkomisiagen=b.kdkomisiagen and ".
			 "a.prefixpertanggungan='$prefixpertanggungan' and a.nopertanggungan='$nopertanggungan' ".
			 "order by b.namakomisiagen desc";
	//echo $sql;
	$DB->parse($sql);
	$DB->execute();
?>
	<table cellspacing="0" cellpadding="0" border="0" width="60%" class="verdana8">
  <tr class="tblhead1" align="center">
  <td rowspan="2" >Tahun</td>
  <td  rowspan="2">Nama Komisi</td>
  <td colspan="2">K o m i s i</td>
  </tr>
  <tr class="tblhead1" align="center">
  <td>Dalam Tahun</td>
  <td>Sesuai Cara Bayar</td>
  </tr>
<?
 
 $jmlkomisi=0;
	$i=1;
  while($arr=$DB->nextrow()) {
	  include "../../includes/belang.php";
		$ko = $arr["KO"];
		$k  = $arr["K"];
		//echo $arr["KOMISIAGEN"]."|".$ko."|".$k;
		$ko =  ($kdjeniscb=='X') ? $k : $ko;
	  $add = ($arr["KDKOMISIAGEN"]=='02') ? $k : $ko;
 		
		$ko = ($ko==0) ? '' : number_format($ko,2);
		$k = ($k==0) ? '' : number_format($k,2);
		echo "<td align=\"center\">".$arr["THNKOMISI"]."</font></td>";
		echo "<td align=\"left\">".$arr["NK"]."</font></td>";
	  echo "<td align=\"right\">".$ko."</font></td>";
		echo "<td align=\"right\">".$k."</font></td>";
	  echo "</tr>";
		$i++;
		$jmlkomisi += $add;
	}
  echo "<tr class=tblisi1>";
  echo "<td colspan=\"2\" align=center class=verdana8>Jumlah Komisi</td>";
  echo "<td align=\"right\"  class=verdana8>".number_format($jmlkomisi,2)."</td>";
  echo "<td></td></tr>";
	echo "</table>";	
?>	
					 </td>		
				 </tr>
		 	</table>
		</td>
	</tr>
</table>
<input type="hidden" name="mode" value="<? echo $mode; ?>">
<input type="hidden" name="noproposal" value="<? echo $noproposal; ?>">
<input type="hidden" name="prefixpertanggungan" value="<? echo $prefixpertanggungan; ?>">
<input type="hidden" name="nopertanggungan" value="<? echo $nopertanggungan; ?>">
<input type="hidden" name="premi1" value="<?php echo $premi1; ?>">
<input type="hidden" name="premi2" value="<?php echo $premi2; ?>">
<input type="hidden" name="juamainproduk" value="<?php echo $juamainproduk; ?>">
<input type="hidden" name="premistd" value="<?php echo $premistd; ?>">
<input type="hidden" name="notertanggung" value="<? echo $notertanggung; ?>">
<input type="hidden" name="kdper" value="<? echo $kdper; ?>">

<input type="hidden" name="autodebet" value="<?=$autodebet;?>">
<input type="hidden" name="kdbank" value="<?=$kdbank;?>">
<input type="hidden" name="norekening" value="<?=$norekening;?>">

<?
  $aw='';
	for($i=1;$i<=$demit;$i++){
		$k[$i]='klienno'.$i;	$a[$i]='hubungan'.$i;	$b[$i]='nama'.$i;
		print( "<input type=\"hidden\" name=\"no".$i."\" value=\"$no".$i."\">\n" );  
		print( "<input type=\"hidden\" name=\"nama".$i."\" value=\"".$$b[$i]."\">\n" );  
		print( "<input type=\"hidden\" name=\"klienno".$i."\" value=\"".$$k[$i]."\">\n" );  
		print( "<input type=\"hidden\" name=\"hubungan".$i."\" value=\"".$$a[$i]."\">");
		$aw.="&aw".$i."=".$$k[$i];
	}	
?>
<table width="700" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
 <td align="center" colspan="2"><input type="submit" value="SUBMIT" name="submit"></td>
</tr>
</form>
<tr>
 <form action="ntryprop.php" method="post" name="ediprop"> 
 <input type="hidden" name="nottg" value="<? echo $notertanggung; ?>">
 <input type="hidden" name="nosp" value="<? echo $nosp; ?>">
 <input type="hidden" name="tglsp" value="<? echo $tglsp; ?>">
 <input type="hidden" name="gotom" value="<? echo $bpo; ?>">
 <input type="hidden" name="kdcb" value="<? echo $kdcarabayar; ?>">
 <input type="hidden" name="kdpro" value="<? echo $kdproduk; ?>">
 <input type="hidden" name="kdmed" value="<? echo $kdstatusmedical; ?>">
 <input type="hidden" name="nobp3" value="<? echo $nobp3; ?>">
 <input type="hidden" name="tgbp3" value="<? echo $tglbp3; ?>">
 <input type="hidden" name="mulas" value="<? echo $mulas; ?>">
 <input type="hidden" name="usith" value="<? echo $usia_th; ?>">
 <input type="hidden" name="usibl" value="<? echo $usia_bl; ?>">
 <input type="hidden" name="lprth" value="<? echo $lamapembpremi_th; ?>">
 <input type="hidden" name="lprbl" value="<? echo $lamapembpremi_bl; ?>">
 <input type="hidden" name="lamth" value="<? echo $lamaasuransi_th; ?>">
 <input type="hidden" name="lambl" value="<? echo $lamaasuransi_bl; ?>">
 <input type="hidden" name="expir" value="<? echo $expirasi; ?>">
 <input type="hidden" name="akhpr" value="<? echo $akhirpremi; ?>">
 <input type="hidden" name="jua" value="<? echo $juamainproduk; ?>">
 <input type="hidden" name="cabar" value="<? echo $kdcarabayar; ?>">
 <input type="hidden" name="idxaw" value="<? echo $indexawal; ?>">
 <input type="hidden" name="kdval" value="<? echo $kdvaluta; ?>">
 <input type="hidden" name="p1" value="<? echo $premi1; ?>">
 <input type="hidden" name="p2" value="<? echo $premi2; ?>">
 <input type="hidden" name="nopng" value="<? echo substr($nopenagih,1,10); ?>">
 <input type="hidden" name="noagn" value="<? echo substr($noagen,1,10); ?>">
 <input type="hidden" name="nopp" value="<? echo $pempolno; ?>">
 <input type="hidden" name="nopre" value="<? echo $pempreno; ?>">
 <input type="hidden" name="hubpp" value="<? echo $pempolhub; ?>">
 <input type="hidden" name="hubpre" value="<? echo $pemprehub; ?>">
 <input type="hidden" name="nampp" value="<? echo $pempolnama; ?>">
 <input type="hidden" name="nampre" value="<? echo $pemprenama; ?>">
 <input type="hidden" name="demit" value="<? echo $demit; ?>">
 <input type="hidden" name="maxdemit" value="<? echo $maxdemit; ?>">
 <input type="hidden" name="kdper" value="<? echo $kdper; ?>">
<?
if (!$mode=='edit'||$mode=='baru') {
?> 
 <td class="verdana8" align="left"><input name="back" type="submit" value="Back"></td>
 <?
} 
 $noproposal = (!$noproposal) ? $nopertanggungan : $noproposal;
 //echo $noproposal."|".$nopertanggungan;
 
 //khusus JSP update temp lagi
 if($kdproduk=="JSP")
 {
   $sql = "update $DBUser.tabel_200_temp set premi1='$premi1' ".
					"where  prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan'";
   $DB->parse($sql);
	 $DB->execute();
 }
 ?>
 <td class="verdana8" align="right"><input name="print" type="button" onClick="window.open('printprop.php?prefixpertanggungan=<?echo $prefixpertanggungan;?>&nopertanggungan=<?echo $nopertanggungan;?>&mode=<?echo $mode;?>&noproposal=<?echo $noproposal;?>&p1=<?echo $premi1;?>&p2=<?echo $premi2;?>&j=<?echo $juamainproduk;?>')" value="Print"></td>
 </form>
</tr>
</table>

</div>
</body>
</html>	