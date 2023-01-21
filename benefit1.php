<?
  	include "../../includes/session.php";
	//echo $jua1."-CEK1";
  	include "../../includes/common.php";
	//echo $jua1."-CEK2";
	include "../../includes/database.php";
	//echo $jua1."-CEK3";
  	include "../../includes/formula44.php";
	//echo $jua1."-CEK4";
	include "../../includes/klien.php";
	//echo $jua1."-XXX";
	$prefixpertanggungan = (!$prefixpertanggungan) ? $kantor : $prefixpertanggungan;
	
	$DB=New database($userid, $passwd, $DBName);
	$DA=New database($userid, $passwd, $DBName);
	$DBX=New database($userid, $passwd, $DBName);
	$DBY=New database($userid, $passwd, $DBName);
  	$FM=new Formula($userid,$passwd,$prefixpertanggungan,$nopertanggungan);
	
	/************************************************************************************************/

	$sql = "select a.nosp,a.noagen,a.lamapembpremi_th,b.namaproduk,to_char(a.mulas,'DD/MM/YYYY') as tglmulas,premi1,".
			   "a.indexawal,a.notertanggung,a.juamainproduk, ".
				 "a.kdproduk,a.kdcarabayar,a.kdstatusmedical,a.usia_th,a.lamaasuransi_th,a.kdvaluta, a.nopolswitch ".
	       "from $DBUser.tabel_200_temp a, $DBUser.tabel_202_produk b ".
			   "where a.prefixpertanggungan='$prefixpertanggungan' ".
				 "and a.nopertanggungan='$nopertanggungan' and a.kdproduk=b.kdproduk";
  //echo $sql."<br><br>";
	$DB->parse($sql);
	$DB->execute();
  $prd=$DB->nextrow();
	
	$kdproduk=$prd["KDPRODUK"];
	$kdcarabayar=$prd["KDCARABAYAR"];
	$namaproduk=$prd["NAMAPRODUK"];
	$noagen=$prd["NOAGEN"];
	$nosp=$prd["NOSP"];
	$kdvaluta=$prd["KDVALUTA"];
	$pt=$prd["LAMAPEMBPREMI_TH"];
	$medical=$prd["KDSTATUSMEDICAL"];
	$nottg=$prd["NOTERTANGGUNG"];
	$usia=$prd["USIA_TH"];
	$masa=$prd["LAMAASURANSI_TH"];
	$jua=$prd["JUAMAINPRODUK"];
	$tglmulas=$prd["TGLMULAS"];
	$polswitch=$prd["NOPOLSWITCH"];
	$premisatu=$prd["PREMI1"];
	
	//echo $premisatu;
	
	//masukkan data topup khusus JL2
	/*----------------------- start top up -------------------*/
	
	if(isset($premitopup) && ($premitopup < $minpremitopup))
	{
	 echo "gagal... premi TOP UP minimal  $minpremitopup";
	}
	else
	{
	  $komisitopup = 0.02 * $premitopup;
		$komisitopuplain = 0.03 * $premitopup;
		$bentopupinvest = 0.95 * $premitopup;
	
		
    if(isset($addtopup))
    {
		  $sql = "delete $DBUser.tabel_404_temp where kdkomisiagen in ('29','30') ".
             "and prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ";
			//echo $sql;
			$DA->parse($sql);
      $DA->execute();
			$DA->commit;
			
			$sql = "insert into $DBUser.tabel_223_temp ".
    			 	 "(prefixpertanggungan,nopertanggungan,kdproduk,kdbenefit,premi,kdjenisbenefit,tglmutasi) ".
    				 "values ".
    				 "('$prefixpertanggungan','$nopertanggungan','$kodeproduk','BNFTOPUP','$premitopup','T',to_date('$tglmutasi','DD/MM/YYYY'))";
    	$DB->parse($sql);
      $DB->execute();
			$DB->commit;
			
			$sql = "insert into $DBUser.tabel_404_temp ".
            					 "(prefixpertanggungan,nopertanggungan,komisiagen,".
            					 "kdkomisiagen,noagen,thnkomisi,komisiagencb) ".
              		   "values ('$prefixpertanggungan','$nopertanggungan',$komisitopup,".
  									 		"'29','$noagen','1',$komisitopup) ";
      //echo $sql;
			$DB->parse($sql);
      $DB->execute();
			$DB->commit;
      
			$sql = "insert into $DBUser.tabel_404_temp ".
            					 "(prefixpertanggungan,nopertanggungan,komisiagen,".
            					 "kdkomisiagen,noagen,thnkomisi,komisiagencb) ".
              		   "values ('$prefixpertanggungan','$nopertanggungan',$komisitopuplain,".
  									 		"'30','$noagen','1',$komisitopuplain) ";
			$DB->parse($sql);
      $DB->execute();
    }
  	
  	if(isset($updatetopup))
    {
		  if($premitopup < $minpremitopup)
    	{
    	 echo "gagal... premi TOP UP minimal  $minpremitopup";
    	}
			else
			{
        $sql = "update $DBUser.tabel_223_temp set premi='$premitopup' ".
      			 	 "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
    					 "and kdproduk='$kodeproduk' and kdbenefit='BNFTOPUP'";
      	//echo $sql;
      	$DB->parse($sql);
        $DB->execute();
  			
  			$sql = "update $DBUser.tabel_404_temp set komisiagen=$komisitopup, komisiagencb=$komisitopup ".
              	"where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
    					  "and kdkomisiagen='29' and noagen='$noagen' ";
  			$DB->parse($sql);
        $DB->execute();
  			
  			$sql = "update $DBUser.tabel_404_temp set komisiagen=$komisitopuplain, komisiagencb=$komisitopuplain ".
              	"where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
    					  "and kdkomisiagen='30' and noagen='$noagen' ";
  			$DB->parse($sql);
        $DB->execute();
			}
    }
  	
  	if(isset($deletetopup))
    {
      $sql = "delete $DBUser.tabel_223_temp ".
    			 	 "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
  					 "and kdproduk='$kodeproduk' and kdbenefit='BNFTOPUP'";
    	$DB->parse($sql);
      $DB->execute();
			
			$sql = "delete $DBUser.tabel_404_temp where kdkomisiagen in ('29','30') ".
             "and prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ";
			//echo $sql;
			$DB->parse($sql);
      $DB->execute();
			
			$bentopupinvest = 0;
    }
	}

	
	//add topup sekaligus
	if($premitopupskg!="")
	{
		$komisitopupskg = 0.02 * $premitopupskg;
		$komisitopuplainskg = 0.03 * $premitopupskg;
		$bentopupinvestskg = 0.95 * $premitopupskg;
		
		if(isset($addtopupskg))
    {
			$sql = "insert into $DBUser.tabel_223_temp ".
    			 	 "(prefixpertanggungan,nopertanggungan,kdproduk,kdbenefit,premi,kdjenisbenefit,tglmutasi) ".
    				 "values ".
    				 "('$prefixpertanggungan','$nopertanggungan','$kodeproduk','BNFTOPUPSG','$premitopupskg','T',to_date('$tglmutasi','DD/MM/YYYY'))";
    	//echo $sql;
    	$DB->parse($sql);
      $DB->execute();
			
			$sql = "insert into $DBUser.tabel_404_temp ".
            					 "(prefixpertanggungan,nopertanggungan,komisiagen,".
            					 "kdkomisiagen,noagen,thnkomisi,komisiagencb) ".
              		   "values ('$prefixpertanggungan','$nopertanggungan',$komisitopupskg,".
  									 		"'32','$noagen','1',$komisitopupskg) ";
			$DB->parse($sql);
      $DB->execute();
      
			$sql = "insert into $DBUser.tabel_404_temp ".
            					 "(prefixpertanggungan,nopertanggungan,komisiagen,".
            					 "kdkomisiagen,noagen,thnkomisi,komisiagencb) ".
              		   "values ('$prefixpertanggungan','$nopertanggungan',$komisitopuplainskg,".
  									 		"'33','$noagen','1',$komisitopuplainskg) ";
			$DB->parse($sql);
      $DB->execute();
		}
		
  	if(isset($updatetopupskg))
    {
      $sql = "update $DBUser.tabel_223_temp set premi='$premitopupskg' ".
    			 	 "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
  					 "and kdproduk='$kodeproduk' and kdbenefit='BNFTOPUPSG'";
    	//echo $sql;
    	$DB->parse($sql);
      $DB->execute();
			
			$sql = "update $DBUser.tabel_404_temp set komisiagen=$komisitopupskg, komisiagencb=$komisitopupskg ".
            	"where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
  					  "and kdkomisiagen='32' and noagen='$noagen' ";
			$DB->parse($sql);
      $DB->execute();
			
			$sql = "update $DBUser.tabel_404_temp set komisiagen=$komisitopuplainskg, komisiagencb=$komisitopuplainskg ".
            	"where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
  					  "and kdkomisiagen='33' and noagen='$noagen' ";
			$DB->parse($sql);
      $DB->execute();
	  }
	
  	if(isset($deletetopupskg))
    {
      $sql = "delete $DBUser.tabel_223_temp ".
    			 	 "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
  					 "and kdproduk='$kodeproduk' and kdbenefit='BNFTOPUPSG'";
    	//echo $sql;
    	$DB->parse($sql);
      $DB->execute();
			
			$sql = "delete $DBUser.tabel_404_temp where kdkomisiagen in ('32','33') ".
             "and prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ";
			$DB->parse($sql);
      $DB->execute();
			
			$bentopupinvestskg = 0;
	  }
	}
	else
	{
	    $sql = "delete $DBUser.tabel_404_temp where kdkomisiagen in ('32','33') ".
             "and prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ";
			$DB->parse($sql);
      $DB->execute();
	}
	//die;
  /*----------------------- end top up -------------------*/
	
	function getclient($db,$noklien,&$nama) {
	  $sql="select noklien,namaklien1,to_char(tgllahir,'DD/MM/YYYY') tgllahir,jeniskelamin ".
		     "from $DBUser.tabel_100_klien ".
				 "where noklien='$noklien'";
    $db->parse($sql);
	  $db->execute();
	  $res=$db->nextrow();
	  $nama = $res["NAMAKLIEN1"];
		$nokln = $res["NOKLIEN"];
	}
	
	function GetFormula($DBX,$kdrumus,$DBUser = 'nadm') { //function GetFormula($DBX,$kdrumus) {
	  $sql="select rumus from $DBUser.tabel_224_rumus ".
		     "where kdrumus='$kdrumus'";
	  //echo $sql."<br><br>";
   	$DBX->parse($sql);
    $DBX->execute();
    $arr=$DBX->nextrow();
		$rumus=$arr["RUMUS"];
		return $rumus;
	}

	//echo "Echo : ".$DBX." ".$prefix." ".$noper."".$p1."".$FM->produk."<br>";
	//echo "Echo : ".$premistd." ".$premisum;

	function CompComm($DBX,$prefix,$noper,$premistd,$p1) {
	  //ditambah dalam rangka hitung komisi ADX 

	  $sql = "update $DBUser.tabel_200_temp set premi1='$p1' where ".
				 	 "prefixpertanggungan='$prefix' and nopertanggungan='$noper'";
		//echo $sql;
		$DBX->parse($sql);
	  $DBX->execute();
		
		
		$sql="begin $DBUser.compcomm('$prefix','$noper',$premistd,$p1); end;";
		//echo $sql;
		$DBX->parse($sql);
		$DBX->execute();
		return;
	}
	
	$kdcarabayarlama=$FM->cabayar;
	$nosp = $FM->nosp;
	$kdprod = $FM->produk;
	$masa = $FM->masa;
	//echo $kdcarabayarlama;
	$sql = "select nvl(skg,'0') skg from $DBUser.tabel_202_produk ".
			   "where kdproduk='$kdprod'";
	//echo $sql;			 
	$DB->parse($sql);
  $DB->execute();
	$arb=$DB->nextrow();
	$skg = $arb["SKG"]; // skg=1 hanya untuk override faktor perkalian komisi 1,14 HANYA UNTUK CARA BAYAR SEKALIGUS
	//echo $skg;
	
	//	if ($masa==1||($skg && $kdcarabayarlama=='X')) {

	if ($masa==1) {
	 $sql="update $DBUser.tabel_200_temp c set c.kdcarabayar='X' ".
	      "where c.prefixpertanggungan='$prefixpertanggungan' and ".
			  "c.nopertanggungan='$nopertanggungan' ";
	} else   {
	 $sql="update $DBUser.tabel_200_temp c set c.kdcarabayar= ".
	     "decode(c.kdcarabayar,'M','M','Q','Q','H','H','A','A','4') ".
			 "where c.prefixpertanggungan='$prefixpertanggungan' and ".
			 "c.nopertanggungan='$nopertanggungan' "; 
	}
	//echo $sql;
 
	$DB->parse($sql);
  $DB->execute();
	$DB->commit();				 	

	$sql="select kdproduk, kdstatusmedical from $DBUser.tabel_200_temp where ".
			 "prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ";
  $DB->parse($sql);
  $DB->execute();    
	$pro=$DB->nextrow();
	$kproduk=$pro["KDPRODUK"];
	$med= $pro["KDSTATUSMEDICAL"];
	
	//echo "KODE PRODUK = ".$kproduk;
	/*
	if($kproduk=="JSP") {
  	$sql="select distinct b.kdrumuspremi ".
  	     "from $DBUser.tabel_223_temp a,$DBUser.tabel_206_produk_benefit b ".	
  	     "where a.kdproduk=b.kdproduk and a.kdjenisbenefit='U' and ".
  			 "a.kdjenisbenefit=b.kdjenisbenefit and ".
  			 "a.prefixpertanggungan='$prefixpertanggungan' and a.nopertanggungan='$nopertanggungan' ";
  	//echo $sql;
  	$DBA=New database($userid, $passwd, $DBName);
  	$DBA->parse($sql);
    $DBA->execute();
  	$premistandar=0;
    while ($has=$DBA->nextrow()) {
  	 $koderumusstd=$has["KDRUMUSPREMI"];
  	 $rumuspremistd = GetFormula($DBA,$koderumusstd);	
  	 $FM1=new Formula($userid,$passwd,$prefixpertanggungan,$nopertanggungan);
  	 $FM1->parse($rumuspremistd);
  	 //dihide demi produk JSP tgl 23/09/2008 by kade & Bughost
  	 //$hasil = $FM1->execute($DBA);
     //$premistandar+=$hasil;
  	}
	
	} 
	else
	{
	*/
	 	$sql="select distinct b.kdrumuspremi ".
  	     "from $DBUser.tabel_223_temp a,$DBUser.tabel_206_produk_benefit b ".	
  	     "where a.kdproduk=b.kdproduk and a.kdjenisbenefit='U' and ".
  			 "a.kdjenisbenefit=b.kdjenisbenefit and ".
  			 "a.prefixpertanggungan='$prefixpertanggungan' and a.nopertanggungan='$nopertanggungan' ";
  	//echo $sql."<br />";
  	$DBA=New database($userid, $passwd, $DBName);
  	$DBA->parse($sql);
    $DBA->execute();
  	$premistandar=0;
    while ($has=$DBA->nextrow()) {
  	 $koderumusstd=$has["KDRUMUSPREMI"];
  	 $rumuspremistd = GetFormula($DBA,$koderumusstd);	
  	 $FM1=new Formula($userid,$passwd,$prefixpertanggungan,$nopertanggungan);
  	 $FM1->parse($rumuspremistd);
		//echo "KODE RUMUS STD = ".$koderumusstd."<br>";
  	 	//echo "RUMUS PREMI STD = ".$rumuspremistd."<br>";
  	 	//echo "HASIL = ".$hasil."<br>";
  	 $hasil = $FM1->execute($DBA);
	 
     $premistandar+=$hasil;
	 
  	}
	//}
	
	//echo ceil($premistandar);
		
	//============================================================================
	//Ambil jumlah premi rider untuk mencari nilai premi waiver
	//ditambahkan oleh agus , tanggal : 04 Agustus 2005

    
	$sqlrdr = "select b.kdrumuspremi  ".
						"from 	$DBUser.tabel_223_temp a, ".
						"				$DBUser.tabel_206_produk_benefit b, ".
						"				$DBUser.tabel_207_kode_benefit c  ".
						"where 	a.kdproduk=b.kdproduk ".
						"and    a.kdbenefit=b.kdbenefit ".
						"and   	c.faktorbenefit='1' ".
						"and  	c.kdjenisbenefit='R' ".
						"and    a.kdbenefit = c.kdbenefit ".
						"and 		a.kdjenisbenefit='R'  ".
						"and 		a.prefixpertanggungan='$prefixpertanggungan' ".
						"and 		a.nopertanggungan='$nopertanggungan' ";
						//echo $sqlrdr;

	$DBA=New database($userid, $passwd, $DBName);
	$DBA->parse($sqlrdr);
  $DBA->execute();
	$premirider=0;
  while ($has=$DBA->nextrow()) {
	 $koderumusrdr=$has["KDRUMUSPREMI"];
	 $rumuspremirider = GetFormula($DBA,$koderumusrdr);
	 $FM1=new Formula($userid,$passwd,$prefixpertanggungan,$nopertanggungan);
	 $FM1->parse($rumuspremirider);
	 $hasilx = $FM1->execute($DBA);

	//echo $sqlrdr;
	 echo "";
	// echo $rumuspremistd."<br>";
	// echo $hasil."<br>";

	 $premirider+=$hasilx;
	}

	//============================================================================



  //tambahan untuk ngecek status medical

	$sqlm = "select kdstatusmedical statusm from $DBUser.tabel_200_temp ".
			   " where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan'";

	//echo $sql;
	$DB->parse($sqlm);
  $DB->execute();
	$arb=$DB->nextrow();
	$medical = $arb["STATUSM"];


	if (!$kdcarabayarlama=='') {
	 $sql="update $DBUser.tabel_200_temp set kdcarabayar='$kdcarabayarlama',premistd=$premistandar ".//, premirider =$premirider ".
			  "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ";
	}
	//echo $sql;

	$DB->parse($sql);
  $DB->execute();
	$DB->commit();


if ($nopertanggungan <> $noproposal) {
	$sql="select a.kdproduk,a.periodebayar,a.periodebenefit,a.kdbenefit,a.nilaibenefit,a.premi,a.kdjenisbenefit, ".
			 "TO_CHAR(a.expirasi,'DD/MM/YYYY'),b.kdrumusbenefit, b.kdrumuspremi, b.kdrumusexpirasi,c.namabenefit, b.kdrumusakhirpmb ".
       "from $DBUser.tabel_223_temp a, $DBUser.tabel_206_produk_benefit b, $DBUser.tabel_207_kode_benefit c ".
  	   "where a.prefixpertanggungan='$prefixpertanggungan' and a.nopertanggungan='$nopertanggungan' ".
       "and a.kdproduk=b.kdproduk(+) and a.kdbenefit=b.kdbenefit(+) and a.kdbenefit=c.kdbenefit(+) ".
			 "order by decode(a.kdjenisbenefit,'U',1,'R',2,'W',3,'I',99,'T',100,4) ";
} else {
	$sql="select a.kdproduk,a.periodebayar,a.periodebenefit,a.kdbenefit,a.nilaibenefit,a.premi,a.kdjenisbenefit, ".
			 "TO_CHAR(a.expirasi,'DD/MM/YYYY'),b.kdrumusbenefit, b.kdrumuspremi, b.kdrumusexpirasi,c.namabenefit, b.kdrumusakhirpmb ".
       "from $DBUser.tabel_223_temp a, $DBUser.tabel_200_temp x, $DBUser.tabel_206_produk_benefit b, $DBUser.tabel_207_kode_benefit c ".
  	   "where a.prefixpertanggungan=x.prefixpertanggungan and a.nopertanggungan=x.nopertanggungan ".
			 "and a.prefixpertanggungan='$prefixpertanggungan' and a.nopertanggungan='$nopertanggungan' ".
       "and a.kdproduk=b.kdproduk(+) and a.kdbenefit=b.kdbenefit(+) and a.kdbenefit=c.kdbenefit(+) ".
			 "order by decode(a.kdjenisbenefit,'U',1,'R',2,'W',3,'I',99,'T',100,4) ";
}
 //echo $sql."<br><br>";
	$DB->parse($sql);
  $DB->execute();
  $result = $DB->result();
  
  
		
/* update jua dan premi dari spajol by fendy 17/08/2021 */
if (substr($kdproduk, 0, 2) == 'PA') {
	$sql = "SELECT premi, uangasuransi
			FROM $DBUser.tabel_spaj_online_produksi a
			INNER JOIN $DBUser.tabel_200_temp b ON a.nospaj = b.nosp
			WHERE b.prefixpertanggungan = '$prefixpertanggungan'
				AND b.nopertanggungan = '$nopertanggungan'";
	$DB->parse($sql);
	$DB->execute();
	$smbr = $DB->nextrow();
	$jua1 = $smbr['UANGASURANSI'];
}

/* ambil data dari simulasi pos aims */
$sql = "SELECT b.premi, b.jpht, b.jpjdyt, b.jpjd, b.jpyt, b.jua
		FROM $DBUser.tabel_spaj_online a
		INNER JOIN jaim_302_hitung@jaim b ON a.buildid = b.buildid
		WHERE a.nospaj = '$nosp'";
$DB->parse($sql);
$DB->execute();
$resapp = $DB->nextrow();
$jua1 =  !empty($jua1) ? $jua1 : $resapp['JUA'];
$premistd = !empty($premistd) ? $premistd : $resapp['PREMI'];


/*********************************************************************************************************/
/*    LANJUT    */
/* 1. Update tabel 223 transaksi produk
/*********************************************************************************************************/

if($propmtc14lanjut=="Lanjut") { //submit
  foreach ($result as $foo => $arr) {
		  $kdproduk  = $arr["KDPRODUK"];
		  $kdbenefit = $arr["KDBENEFIT"];
			$premi = ${"prm".$kdbenefit};			if (strlen($premi)==0) $premi="null";
			$benefit = ${"bnf".$kdbenefit};   if (strlen($benefit)==0) $benefit="null";
			$expirasi = ${"exp".$kdbenefit};  if (strlen($expirasi)==0) $expirasi="null";
			//echo $benefit;
			//echo $kdbenefit.$expirasi;
			//$lamapembayaran = ${"rms".$kdbenefit};
      // edit panjang tanggal JSP
			$akhirpembayaran = ${"akh".$kdbenefit};			
			$akhirpmb = ($akhirpembayaran==""||is_null($akhirpembayaran)||strlen($akhirpembayaran)<10) ? 'NULL' : "to_date('".$akhirpembayaran."','DD/MM/YYYY')";
			$expir = ($expirasi==""||is_null($expirasi)||strlen($expirasi)<10) ? 'NULL' : "to_date('".$expirasi."','DD/MM/YYYY')";      
			//$akhirpmb = ($akhirpembayaran==""||is_null($akhirpembayaran)) ? 'NULL' : "to_date('".$akhirpembayaran."','DD/MM/YYYY')";
			//$expir = ($expirasi==""||is_null($expirasi)) ? 'NULL' : "to_date('".$expirasi."','DD/MM/YYYY')";      
			
			if($kdbenefit=="RISKER"){ //resiko kerja rumus salah harusnya faktor resiko X faktor resiko kerja
				if(substr($kdproduk,0,3)=="JL2" || substr($kdproduk,0,3)=="JL3")
				{
				}
				else
				{
					$sql="update $DBUser.tabel_223_temp ".
						 "set premi=$resikokerja, nilaibenefit=$benefit,expirasi=$expir,".
							 "akhirpmb=$akhirpmb ".
					   "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
						 "and kdproduk='$kdproduk' and kdbenefit='$kdbenefit'";
				}
			} 
			else 
			{  			
				$sql="update $DBUser.tabel_223_temp ".
					 "set premi=$premi, nilaibenefit=$benefit,expirasi=$expir,".
						 "akhirpmb=$akhirpmb ".
				   "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
					 "and kdproduk='$kdproduk' and kdbenefit='$kdbenefit'";			
				//echo $sql."<br /><br />";
				//die;
			}
			
			if($kdbenefit=="BNFTOPUP" || $kdbenefit=="BNFTOPUPSG"){}
			else
			{
			$DB->parse($sql);
      $DB->execute();
			}
	}    //foreach

  /***********************************output***********************************************************/

	$faktor = $FM->faktorbayar;
	
  switch ($premijua) {	  
	 case 'premi': {		 
		$sql = "select sum(premi) premistd ".
				   "from $DBUser.tabel_223_temp ".
				   "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
				 	 "and kdjenisbenefit <>'X' ";
	//	echo $sql;			 
	//	die;
		$DB->parse($sql);
    $DB->execute();
		$ari=$DB->nextrow();

        //echo $sql;

		$sqlx2 = "select sum(premi) premi2jsp ".
				   	 "from $DBUser.tabel_223_temp ".
				   	 "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
				 	 	 "and kdbenefit not in ('WAIVER','EXTPREM')";
		//echo 	$sqlx2;
		$DB->parse($sqlx2);
    $DB->execute();
		$arix2=$DB->nextrow();
		$premix2=$arix2["PREMI2JSP"];
		
		$sqlx3 = "select sum(premi) premi2dmp ".
				   "from $DBUser.tabel_223_temp ".
				   "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
				 	 "and kdjenisbenefit in ('W','U')";
		$DB->parse($sqlx3);
    $DB->execute();
		$arix3=$DB->nextrow();
		$premi2dmp=$arix3["PREMI2DMP"]; //untuk menghitung premi 2 DMP
		
		//$premistd dari hidden untuk carabayar berkala dan skg <> 1
		//echo $premistandar."|".$premistd."|harus sama";
  
	  // Khusus perlakuan JSP diupdate tgl 9 okt 2003 by agus n kd
		
		
		//Script dibawah ini dipakai untuk menghandle kondisi khusus produk JSAP1 DAN JSAP2
		//dibuat oleh agus pada tanggal : 07/06/2005
		//==================================================================================
		
	
		if($kdproduk=="JSP" || $kdproduk=="JSPS" || $kdproduk=="JSPBTN" || $kdproduk=="JSPNNN" || $kdproduk=="JSPSN"){
				$premistandar=$premix2;
				echo $premix2;
		} 
		else {
		    $premistandar=$premistandar; 
		}
	
		if ($FM->kdjeniscb=='B') { //cara bayar berkala
  			//pengeculian produk DMP, premi 2 = premistd + sadu
				if($kdproduk=="DMP"){
  				$premi2=$premi2dmp * $faktor;
  				} else {
  		    $premi2=$premistandar * $faktor;
  			}
	 	
	//	  $premi2=$premistandar * $faktor;
		}	else if ($FM->cabayar=='X' or $FM->cabayar=='E') { // CARA BAYAR E, PREMI2=0, BY MR. JUMRY PP , TGL : 14/09/2005
		  $premi2=0;
		}	else if ($FM->cabayar=='J' ){ //or $FM->cabayar=='E'				 
		 // $premi2= $premix2 * $faktor;  //$premi2=$FM->premi1; untuk cara bayar sekaligus cicilan
		 
		// $premi2=$FM->premi1;
		//untuk produk DMP premi2= 0.95 premi1, diedit tgl 07/10/2004
		 
  		 if($kdproduk=="DMP"){
			     if($medical=="N"){ //perlakuan khusus untuk produk dmp medical. tarip premi pakai yang non tapi sudah ditambah 1.05
					 		$premi2=$premi2dmp / 1.05;
			       } else {
    		      $premi2=$FM->premi1;
							$jua1 = $jua1 * 1.05; //harus dikali lagi karena tarif preminya dikali 1.05 sehingga jua juga harus dikalikan 1.05
    			   }	
							
    			} else {
    		    $premi2=$FM->premi1; 
    			}
		}
		if ($FM->masa <= 5) {
		 $premi2=0;
		}
		
		if ($FM->valuta=='3') { //valuta
		  $jua1 =   round($jua1,2);
			$premi2 = round($premi2,2);
		} else {
			$jua1 =  round($jua1,0);
			$premi2 = round($premi2,0);
			$premistd = round($premistd,0);
		}
		
		//echo "JUA :".$jua1." | premi2 :".$premi2." premistandar  $premistd<br><br>";
    
		
				
    print( "<script language=\"JavaScript\" type=\"text/javascript\">\n" );
    print( "<!--\n" );
	  if ($jua1==0) {
     print( "	 alert('Nilai JUA Nol, Kemungkinan Belum Ada Tarifnya')\n" );
	   echo "window.opener.document.ntryprop.submit.disabled=true;";
	  }
		
		if(substr($kdproduk,0,3)=="JL2" || substr($kdproduk,0,3)=="JL3")
		{
			//khusus unitlink berkala, JUA minimal sebesar Rp. 7.500.000, diupdate tgl 17/09/2008 by bughost/sukendro
			if(substr($kdproduk,0,4)=="JL2B" && $jua1<7500000)
			{
				  $jua1 = 7500000;
						$sql = "update $DBUser.tabel_200_temp set juamainproduk ='$jua1' ".
						 "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan'";
			  $DB->parse($sql);
			  $DB->execute();
			  $DB->commit();
			} 
			  printf ("window.opener.document.ntryprop.nilai.value='%s';".
						"window.opener.document.ntryprop.premi2.value='%s';".
								"window.opener.document.ntryprop.juamainproduk.value='%s';".
								"window.opener.document.ntryprop.premistd.value='%s';",$premiakhir,$premiakhir,$jua1,$premistd);
								//"window.opener.document.ntryprop.premistd.value='%s';",$premiakhir,$premi2,$jua1,$premistd);
		  
			}
			else
			{
				if ( $kdproduk=="JTP") {
					$sql="select ua from $DBUser.TABEL_205_TARIP_PREMI_TELE ".
		     			"where premi=".round($FM->premi1,0);
						
					//echo $sql;	
					$DBX->parse($sql);
					$DBX->execute();
					$arr=$DBX->nextrow();
					$jua1=$arr["UA"];
					$premistd=round($FM->premi1,0);		
					$premi2=round($FM->premi1,0);	
					}
					$sql = "update $DBUser.tabel_200_temp set juamainproduk ='$jua1' ".
						 "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan'";
					$DB->parse($sql);
					$DB->execute();
					$DB->commit();
					printf ("window.opener.document.getElementsByName('premi2')[0].value = '$premi2';". //printf ("window.opener.document.ntryprop.premi2.value='%s';".
						"window.opener.document.getElementsByName('juamainproduk')[0].value = '$jua1';". //"window.opener.document.ntryprop.juamainproduk.value='%s';".
						"window.opener.document.getElementsByName('premistd')[0].value = '$premistd';"); //"window.opener.document.ntryprop.premistd.value='%s';",$premi2,$jua1,$premistd);
			}
	  	print("window.close()");
		print("//-->\n" );
		print("</script>\n" );
	 } 
	 break;
	 
	 case 'jua' : {		 
		$sql = "select premi from $DBUser.tabel_223_temp ".
				   "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
				   "and kdjenisbenefit='X' ";
		//echo $sqlx1;
		$DB->parse($sql);
    $DB->execute();
		$ari=$DB->nextrow();
		$extra = $ari["PREMI"];
		
		#-------------------------[ JSP START ]-----------------------------------------------
	  $sqlx1 = "select sum(premi) premi1jsp ".
				   "from $DBUser.tabel_223_temp ".
				   "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
				 	 "and kdbenefit <>'WAIVER2' and kdjenisbenefit <>'R'";
		//echo $sqlx1;
		$DB->parse($sqlx1);
    $DB->execute();
		$arix1=$DB->nextrow();
		$premix1=$arix1["PREMI1JSP"];
					 
		$sqlx2 = "select sum(premi) premi2jsp ".
				   "from $DBUser.tabel_223_temp ".
				   "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
				 	 "and kdjenisbenefit <>'X' and kdbenefit <>'WAIVER' and kdjenisbenefit <>'R'";
		//echo $sqlx2;
		$DB->parse($sqlx2);
    $DB->execute();
		$arix2=$DB->nextrow();
		$premix2=$arix2["PREMI2JSP"];
		
		
		$sqlx3 = "select sum(premi) premi3jsp ".
				   "from $DBUser.tabel_223_temp ".
				   "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
				 	 "and kdjenisbenefit='U'";
		$DB->parse($sqlx3);
    $DB->execute();
		$arix3=$DB->nextrow();
		$premix3=$arix3["PREMI3JSP"];
		
		
		//-----------------------------------------------
				 
		#
		#-------------------------[ JSP END ]-----------------
		#
		// perlakuan khusus untuk produk JSP
		if($kdproduk=="JSP" || $kdproduk=="JSPS" || $kdproduk=="JSPBTN" || $kdproduk=="JSPNNN" || $kdproduk=="JSPSN"){
		    $premiup=$premix2;
				$jmlpremi=$premix1;
				echo $jmlpremi;
		} else {
		    //echo $premistandar."|".$premistd;
			  $premiup= $jmlpremi-$extra;
		}
		
		
		if ($FM->kdjeniscb=='B') { //cara bayar berkala	
				$p2 = $premiup * $faktor;
				$p1 = $jmlpremi * $faktor;
		} else if ($FM->cabayar== 'X' or $FM->cabayar== 'E' ){ //CARA BAYAR E, PREMI2 =0, BY MR. JUMRY KP TGL:14/09/2005
				$p2=0;
				$p1=$jmlpremi  * $faktor;
		} else if ($FM->cabayar == 'J'){ //or $FM->cabayar== 'E'
				$p1=$jmlpremi * $faktor;
				
				//tambahan premi2 DMP, premi2=0.95 premi1
				
				//untuk produk DMP premi2= 0.95 premi1, diedit tgl 07/10/2004
		 
    		 if($kdproduk=="DMP"){
				 			//tambahan kondisi untuk DMP medical premi1 = premi2, diedit tanggall 08/02/2005
							
    							if ($medical =="M"){
    								 	$p2=$p1 /1.05 ;
    									$p1=$p2;
          				} else {
          						$p2=$p1 /1.05 ;
          				}
     				} else {
      				$p2=$premiup * $faktor;
      			}
		}
		if ($FM->masa <= 5) {
		 $p2=0;
		}
						//valuta 
						if ($FM->valuta=='3') {
							 $p1=round($p1,2);
							 $p2=round($p2,2);
						} else {
							 $p1=round($p1,0);
							 $p2=round($p2,0);
						}							 
	  $sql = "select premiminimal from $DBUser.tabel_202_produk ".
    			   "where kdproduk='$kdproduk'";
    $DB->parse($sql);
    $DB->execute();
    $arrpremi=$DB->nextrow();
    $premiminimal=$arrpremi["PREMIMINIMAL"];    			   
    if($p1<$premiminimal){
    echo "Anda pilih produk $kdproduk. Premi yang Anda masukkan kurang dari Rp. $premiminimal! Masukkan nilai Premi sesuai dengan ketentuan yang berlaku.";
    die;
    }				//desimal jika dollar
		$premi1akhir=round($p1 + $jmlresikokerja,0);
		$premi2akhir=round($p2 + $jmlresikokerja,0);	
		
		#-----[ PERHITUNGAN TAMBAHAN RESIKO PEKERJAAN ]------------------------------------------ 
    # 
		/*
		echo "premi std = ".number_format($premistd,2)."<br>";
		echo "premi 1 = ".number_format($p1,2)."<br>";
		echo "premi 2 = ".number_format($p2,2)."<br>";
		echo "resiko pekerjaan = ".number_format($jmlresikokerja,2)."<br>";
		echo "Premi 1 akhir = ".number_format($premi1akhir,2)."<br>";
		echo "Premi 2 akhir = ".number_format($premi2akhir,2)."<br>";
		*/
		
		if($kdproduk=="JSP" || $kdproduk=="JSPS" || $kdproduk=="JSPBTN" || $kdproduk=="JSPNNN" || $kdproduk=="JSPSN"){ // hitung ulang komisi agen karena premi dipotong waiver
      CompComm($DB,$prefixpertanggungan,$nopertanggungan,$premistd,$p1);
    }
		
	  print( "<script language=\"JavaScript\" type=\"text/javascript\">\n" );
    print( "<!--\n" );
	if($nopertanggungan=="153431786"){
	$p1 = 34714750;
	}
	  if ($p1 == 0) {
     print( "	 alert('Nilai Premi Nol, Periksa Lagi atau Mungkin Belum Ada Tarifnya')\n" );
	   echo "window.opener.document.ntryprop.submit.disabled=true;";
	  }
		
		$sql = "update $DBUser.tabel_200_temp set premi1 ='$p1' ".
          			 "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan'";
					// echo $sql;
					 //die;
          $DB->parse($sql);
          $DB->execute();
          $DB->commit();
					
	  printf ("window.opener.document.ntryprop.premi1.value='%s';".
					  "window.opener.document.ntryprop.premi2.value='%s';".
				    "window.opener.document.ntryprop.premistd.value='%s';",$p1,$p2,$premistd,$premirider);
			
	  print( "window.close()");
    print( "//-->\n" );
    print( "</script>\n" );

	 } 	break;
	}  //switch
		

	if(substr($kdproduk,0,3)=="JL2" || substr($kdproduk,0,3)=="JL3")
 	{
		$sql = "update $DBUser.tabel_200_temp set premistd=$premistd,premi1=$premiakhir,premilink=$premiakhir ".
				 	 "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ";
		$DB->parse($sql);
		$DB->execute();
		}

    if(substr($kdproduk,0,5)=="JL2XS" || substr($kdproduk,0,5)=="JL3XS")
 	  {
  		$sql = "update $DBUser.tabel_223_temp set nilaibenefit=round(0.1*$premilinked)  ".
  				 	 "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
  					 "and kdbenefit='JMNKEC' ";
  		$DB->parse($sql);
  		$DB->execute();
			//echo $sql;
			$sql = "update $DBUser.tabel_223_temp set nilaibenefit=round(0.05*$premilinked)  ".
  				 	 "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
  					 "and kdbenefit='BNFCRIL' ";
  		$DB->parse($sql);
  		$DB->execute();
		}
		
		if(($kdproduk)=="ASIB" || ($kdproduk)=="ASPB" || ($kdproduk)=="ASI" || ($kdproduk)=="ASP" || ($kdproduk)=="AI0" || ($kdproduk)=="AEP" || ($kdproduk)=="JSHAA" || ($kdproduk)=="JSIAA" || ($kdproduk)=="JSAA")
 	  	{
		$sql = "update $DBUser.tabel_223_temp set nilaibenefit=$premisatu  ".
				 	 "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
					 "and kdbenefit in ('RESTPREBNF','RESTPREHT2') ";
		$DB->parse($sql);
		$DB->execute();
		
		$sql = "update $DBUser.tabel_223_temp set premi=$premisatu  ".
				 	 "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
					 "and kdbenefit='BNFPHT' ";
		$DB->parse($sql);
		$DB->execute();
		}
		
		if(substr($kdproduk,0,3)=="JL2" || substr($kdproduk,0,3)=="JL3")
 	  	{
		$sql = "update $DBUser.tabel_223_temp set nilaibenefit=$benfitinvestakhir  ".
				 	 "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ".
					 "and kdbenefit='INVPRDJL' ";
		$DB->parse($sql);
		$DB->execute();
		//echo $sql;
		//die;
		}
		else
		{
		$sql = "update $DBUser.tabel_200_temp set premistd=$premistd ".
				 	 "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan' ";
		//echo $sql;
		$DB->parse($sql);
		$DB->execute();
		}
		
	
	// Tambahan dari fendy agar premi bulat sesuai yang di entry 21/02/2019
	if ((substr($kdproduk, 0, 3) == 'AI0' || ($kdproduk) == 'AJSAN') && $premijua == 'premi') {
		$sqlupd = "update $DBUser.tabel_200_temp SET premi1 = '$premi1', premistd = '$premi1' WHERE prefixpertanggungan = '$prefixpertanggungan' AND nopertanggungan = '$nopertanggungan'";
		$DBY->parse($sqlupd);
		$DBY->execute();
	}
	
	exit;
}	 


 //if
/*********************************************************************************************************************/
	$kdproduk=$FM->produk;
	$faktor = $FM->faktorbayar;
	$noagen=$FM->agen; 
 	$pt=$FM->pt;
	$jua=$FM->jua;
	$kdbasispremi=$FM->kdbasispremi;
	$cabayar=$FM->cabayar;
	$cabar=$FM->namacarabayar;	
	
	$sql="select namaproduk from $DBUser.tabel_202_produk where kdproduk='$kdproduk'";
  $DB->parse($sql);
	$DB->execute();
  $prd=$DB->nextrow();
	$namaproduk=$prd["NAMAPRODUK"];


?>

<html>
<head>
<title>Benefit Proposal Lanjutan</title>
<link href="../jws.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../../includes/window.js"></script>
<?
  print( "<script language=\"JavaScript\" type=\"text/javascript\">\n" );
  print( "<!--\n" );
	print( "function SubmitOK(){\n" );
			
			

  switch ($premijua) {
	case 'jua':	
	print("nospaj = window.opener.document.ntryprop.nosp.value;\n" );
	print("if(nospaj!='')\n" );
	print("window.opener.document.ntryprop.submit.disabled=false;\n" );
	print("else\n" );
	print("window.opener.document.ntryprop.submit.disabled=true;\n" );
  break;
	case 'premi':
	 switch ($vara){
	 case '0': //ok
	  print( "		window.opener.document.ntryprop.vara.value=1;\n" );
	print("if(nospaj!='')\n" );
	print("window.opener.document.ntryprop.submit.disabled=false;\n" );
	print("else\n" );
	print("window.opener.document.ntryprop.submit.disabled=true;\n" );
	  print( "		window.opener.document.ntryprop.cekpolis.disabled=true;\n" );
	  print( "		window.opener.document.ntryprop.buton.disabled=false;\n" );
	 break;
	 case '1':
	  print( "		window.opener.document.ntryprop.vara.value=2;\n" );
	print("if(nospaj!='')\n" );
	print("window.opener.document.ntryprop.submit.disabled=false;\n" );
	print("else\n" );
	print("window.opener.document.ntryprop.submit.disabled=true;\n" );
	  print( "		window.opener.document.ntryprop.cekpolis.disabled=true;\n" );
	  print( "		window.opener.document.ntryprop.buton.disabled=true;\n" );
	 break;
	 case '2':
	  print( "		window.opener.document.ntryprop.vara.value=0;\n" );
print("if(nospaj!='')\n" );
	print("window.opener.document.ntryprop.submit.disabled=false;\n" );
	print("else\n" );
	print("window.opener.document.ntryprop.submit.disabled=true;\n" );
	print( "		window.opener.document.ntryprop.cekpolis.disabled=true;\n" );
	  print( "		window.opener.document.ntryprop.buton.disabled=true;\n" );
	 break;
	 }
	
  break;
	}	
	
			print("var kprod = window.opener.document.ntryprop.kdproduk.value;\n" );
			print("if(kprod=='JSSK' || kprod=='JSSP'){ ");
			print("alert('Tanggal dan Jumlah Transfer mohon diisi!!');\n" );
			print( "window.opener.document.ntryprop.tgltransfer.focus();\n" );
			print( "window.opener.document.ntryprop.submit.disabled=true;\n" );
			print("} else {");
			print( "window.opener.document.ntryprop.tgltransfer.value='';\n" );
			print( "window.opener.document.ntryprop.jmltransfer.value='';\n" );
			print("}");
			
	print( "}\n" );
  print( "//-->\n" );
  print( "</script>" );
?>
<script language="JavaScript">
<!-- 
function open_on_entrance(url,name)
{ 
  new_window = window.open('refresh.php','refresh', ' menubar,resizable,dependent,status,width=300,height=200,left=10,top=10')
}
// -->
</script>
</head>
<body>
<form name="propmtc14" method="POST" action="<? PHP_SELF; ?>">
<? getclient($DB,$noagen,$namaagen); ?>	
<font face="Verdana" size="2">
<table width="100%">
 <tr>
  <td align="right"><font face="Verdana" size="1" color="#0033CC">F1336</font></td>
 </tr>
 <tr>
  <td align="center" class="arial12blkb"><b>Benefit Produk <?echo ($noproposal==$nopertanggungan) ? "Proposal Nomor ".$prefixpertanggungan."-".$nopertanggungan : '';?></b></td>
 </tr>
</table>
<hr size="1">
<table width="100%" cellpadding="1" cellspacing="1" class="tblhead">
<tr class="tblhead1">
 <td>
 <table width="100%" cellpadding="1" cellspacing="0" class="tblhead1">
  <tr>
   <td>No. SP</td>
   <td>: <?echo $nosp. "".$nokln;?> </td>
	 <td>Agen Penutup</td>
	 <td>: <? echo $namaagen."  [".$noagen."]" ?> </td>
  </tr>
  <tr>
   <td>Kode Produk</td>
	 <td>: <? echo $kdproduk . " - ".$namaproduk; ?> </td>
   <td>Lama Pembayaran Premi</td>
	 <td>: <? echo $pt; ?> tahun secara <? echo $cabar; ?></td>
  </tr>
	<tr>
   <td>Basis Premi</td>
	 <td>: <? echo $kdbasispremi; ?> </td>
   <td>Basis Bayar</td>
	 <td>: <? echo $FM->kdbasisbayar ?> </td>
  </tr>
  </tr>
 </table>
 </td>
</tr>
</table> 
<?
	if(substr($kdproduk,0,3)=="JL2" || substr($kdproduk,0,3)=="JL3")
 	{
	$sql = "select premilink from $DBUser.tabel_200_temp where ".
				 "prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan'";
	$DB->parse($sql);
  $DB->execute();
  $r=$DB->nextrow();
	$premilink = $r["PREMILINK"];
  }	
  
?>
<hr size=1>
<table width="100%" cellpadding="1" cellspacing="1" class="tblhead">
<tr class="tblisi1">
 <td>
 <table border=0 width="100%" class=tblisi>
	<tr class=hijao align=center>
	 <td>No</font>
	 <td>Kode</td>
	 <td>Nama Benefit</td>
	 <td>Jumlah Benefit</td>
	 <td>Premi</td>
	 <td>Jatuh Tempo</td>
	 <td>Jenis</td>
	</tr>
<? 
	$no = 1; 
	$jmlpremi = 0; 
	$jmlbenefit = 0;
  $i = 0;
	reset($result);
  foreach ($result as $foo => $arr) {
		$kdproduk = $arr["KDPRODUK"];
		$kdbenefit = $arr["KDBENEFIT"];
		$namabenefit = $arr["NAMABENEFIT"];
		$kdjenisbenefit = $arr["KDJENISBENEFIT"];
 	  $kdrumus = $arr["KDRUMUSPREMI"];
		//echo $kdrumus."<br>";
		$rumuspremi = GetFormula($DB,$kdrumus);
		//echo "Rumus Premi : ".$rumuspremi."<br>";
 	  $kdrumus = $arr["KDRUMUSBENEFIT"];
		$rumusbenefit = GetFormula($DB,$kdrumus);
		//echo "Rumus benefit : ".$rumusbenefit."<br>";
		//echo "Rumus : ".$kdrumus."<br>";
 	  
		$kdrumus = $arr["KDRUMUSEXPIRASI"];
		$rumusexpirasi = GetFormula($DB,$kdrumus);
		$kdrumus = $arr["KDRUMUSAKHIRPMB"];
		$rumusakhirpmb = GetFormula($DB,$kdrumus);


		switch(substr($kdbenefit,0,2)){
		  case "CP": $adacp="Y"; $premi_cp=0; break;
		  default : $premi_cp=$hasilpremi;
		}

		if ($kdjenisbenefit=="R") {  //Additional benefit
			$FM->add1 = $arr["PERIODEBAYAR"];
			$FM->add2 = $arr["PERIODEBENEFIT"];
			$kdrumus = $arr["KDRUMUSEXPIRASI"];
			$rumusexpirasi = GetFormula($DB,$kdrumus);
			//echo $kdbenefit."|".$rumusexpirasi;
		}
		$hasilpremi = $arr["PREMI"];
		$hasilbenefit = $arr["NILAIBENEFIT"];
		$hasilexpirasi = $arr["EXPIRASI"];
		
		
		//echo "kdbenefit = ".$kdbenefit."<br /> rumuspremi = ".$rumuspremi."<br /> premistandar= ".$premistandar."<br /> hasilpremi = ".$hasilpremi."<br />faktor = ".$faktor."<br /> hasilexpirasi=".$hasilexpirasi."<br><br>";

    /*********************************************************************/ 
		if(is_null($hasilpremi)||is_null($hasilbenefit)||is_null($hasilexpirasi)) {
		  if ((strlen($rumuspremi)==0) && (strlen($rumusbenefit)==0)) {
		    $hasilpremi = 0;
		    $hasilbenefit = 0;
				$hasilexpirasi = NULL;
		  } 
			else 
			{
			  //echo $rumuspremi."<br />";
			  $FM->parse($rumuspremi);
		    $hasilpremi=$FM->execute($DB);
				//echo "hasil premi = ".$hasilpremi."<br />";
				
				$FM->parse($rumusbenefit);
				$hasilbenefit=$FM->execute($DB);	
				//echo "rumus benefit = ".$rumusbenefit."|| rumuspremi = $rumuspremi<br />";
        //;echo "rumuspremi = ".$rumuspremi."<br />";
        
				$FM->parse($rumusexpirasi);
        $hasilexpirasi=$FM->execute($DB);
				
				$FM->parse($rumusakhirpmb);
        $hasilakhirpmb=$FM->execute($DB);
		
				// premi standar khusus produk anyar JL2XB -- update 
				//echo "premilink = ".$premilink;
				/*---------------------------------------------------------------------------*/
    		// ditutup berdasarkan permintaan Ary tgl 24 Juli 2008
    		// tidak ada pengurangan premi rider pada investasi
				/*
				if(substr($kdproduk,0,3)=="JL2"){
					 $premistandar = $premilink;
		 		}
				else
				{
				   $premistandar = ($premistandar==0||$premistandar=='') ? $hasilpremi : $premistandar;
				}
		    /*---------------------------------------------------------------------------*/
    		$premistandar = ($premistandar==0||$premistandar=='') ? $hasilpremi : $premistandar;
				
		  //echo $premistandar;
				if ($kdjenisbenefit=="U") {
				 	 $hasilpremiu = $hasilpremi;
					 //echo $hasilpremiu."INI DIA";
				 	 global $hasilpremiu;
				}
				
				//echo $kdbenefit."| rumus premi : ".$rumuspremi."|".$premistandar."| hasil premi : ".$hasilpremi."|".$faktor."<br><br>";
				//echo $kdbenefit."|".$rumusexpirasi."|".$hasilexpirasi."<br><br>";
			}		
			//echo $kdbenefit."|".$rumuspremi."|".$premistandar."|".$hasilpremi."|".$faktor."<br><br>";
		}	//if
		
		
		if(substr($kdproduk,0,3)=="JL2" || substr($kdproduk,0,3)=="JL3"){
		    /*---------------------------------------------------------------------------*/
    		// ditutup berdasarkan permintaan Ary tgl 24 Juli 2008
    		// tidak ada pengurangan premi rider pada investasi
				/*
    		if($arr["KDJENISBENEFIT"]=="R")
    		{
    		  $premi_r += $hasilpremi; 
					//update premi rider 
					$sql = "update $DBUser.tabel_223_temp set premi='".round($hasilpremi,2)."' where ".
							 	 "kdbenefit='".$kdbenefit."' and prefixpertanggungan='$prefixpertanggungan' ".
    				 		 "and nopertanggungan='$nopertanggungan'";
    		  //echo $sql."<br />";
					$DB->parse($sql);
    			$DB->execute();
				}
				*/
				/*---------------------------------------------------------------------------*/
						
    		//echo "jenisbenefit : ".$arr["KDJENISBENEFIT"]."=".$hasilpremi."<br />";
			
			
    		if($kdbenefit=="KMSTTPJL")
    		{
    		  $benefit_r = $hasilbenefit; 
    		}
    		//echo "benefit r = ".$benefit_r."<br />";
    		$pengurangpremi = $premi_r + $benefit_r;
    		//echo "pengurang = ".$pengurangpremi."<br />";
		}
		
			if($arr["KDBENEFIT"]=="CI" || $arr["KDBENEFIT"]=="TERM" || $arr["KDBENEFIT"]=="DEATHSU65")
			{
			$akumulasiua=$akumulasiua+$hasilbenefit;
			}
		 if(($kdproduk)=="ASIB" || ($kdproduk)=="ASPB" || ($kdproduk)=="ASI" || ($kdproduk)=="ASP" || ($kdproduk)=="AI0" || ($kdproduk)=="AEP" || ($kdproduk)=="JSHAA"  || ($kdproduk)=="JSIAA" || ($kdproduk)=="JSAA" )
 	  		{
				$premistandar = $premisatu;
			}
	
    include "../../includes/belang.php";
		echo "<td class=verdana8 align=center>$no</td>\n";
		echo "<td class=verdana8>".$kdbenefit."</td>";
		echo "<td class=verdana8>".$namabenefit."</td>";

		/*  kalo 0 jangan diliatin */	
		//echo $hasilpremi." * ".$faktor;
		
    #---------[ penambahan resiko pekerjaan ------------------------------------------------ 
    if($kdbenefit=="RISKER"){
    	$sql = "select a.nosp,a.noagen,a.lamapembpremi_th,b.namaproduk,".
    			   "a.indexawal,a.notertanggung,a.juamainproduk, ".
    				 "a.kdproduk,a.kdcarabayar,a.kdstatusmedical,a.usia_th,a.lamaasuransi_th,a.kdvaluta ".
    	       "from $DBUser.tabel_200_temp a, $DBUser.tabel_202_produk b ".
    			   "where a.prefixpertanggungan='$prefixpertanggungan' ".
    				 "and a.nopertanggungan='$nopertanggungan' and a.kdproduk=b.kdproduk";
      //echo $sql."<br><br>";
    	$DB->parse($sql);
    	$DB->execute();
      $prd=$DB->nextrow();
    	
    	$namaproduk=$prd["NAMAPRODUK"];
    	$noagen=$prd["NOAGEN"];
    	$nosp=$prd["NOSP"];
    	$kdvaluta=$prd["KDVALUTA"];
    	$pt=$prd["LAMAPEMBPREMI_TH"];
    	$medical=$prd["KDSTATUSMEDICAL"];
    	$nottg=$prd["NOTERTANGGUNG"];
    	$usia=$prd["USIA_TH"];
    	$masa=$prd["LAMAASURANSI_TH"];
    	$jua=$prd["JUAMAINPRODUK"];
    	
    	$sql = "select kurs from $DBUser.tabel_999_kurs_transaksi where tglkursberlaku=".
    	       "(select max(tglkursberlaku) from $DBUser.tabel_999_kurs_transaksi ".
    	     	 "where tglkursberlaku<=sysdate and kdvaluta='$kdvaluta') ".
    	     	 "and kdvaluta='$kdvaluta'";	
    	$DB->parse($sql);
    	$DB->execute();
    	$res=$DB->nextrow();
    	$idx = $res["KURS"];
     
      $indexawal = ($indexawal==''||strlen($indexawal)==0) ? $idx : $indexawal;					 		
      $juadlrp=$jua*$indexawal;
      
    	$KLN=new Klien($userid,$passwd,$nottg);		
    	
    	// cari resiko pekerjaan :
    	$sql="select faktorresiko/1000 resiko ".
    			 "from $DBUser.tabel_229_resiko_produk ".
    			 "where kdproduk='$kdproduk' and kdvaluta='$kdvaluta' and usia=$usia and masa=$masa ";
    	$DB->parse($sql);
    	$DB->execute();
    	$res=$DB->nextrow();
    	$fakrnow=($res["RESIKO"]==0) ? 1 : $res["RESIKO"];
    	$rskg = $fakrnow*$juadlrp;
    	$resikokerja=$KLN->nilairesiko * $rskg;
    	/*
			echo "Resiko Saat ini : ".number_format($rskg,2)."<br>";
    	echo "Faktor Resiko Pekerjaan : ".$KLN->nilairesiko."<br>";
      echo "Penambahan Resiko : ".number_format($resikokerja,2)."<br>";
		  */
		}	
	  #-------------------------------------- end resiko kerja -----------------------------

		if($kdbenefit=="RISKER"){
		 if(substr($kdproduk,0,3)=="JL2" || substr($kdproduk,0,3)=="JL3"){
					$hasilpremi = ($arr["KDJENISBENEFIT"]=="U") ? $premilink : $hasilpremi;
					$test=$hasilpremi!=0 ? number_format($hasilpremi*$faktor,2):'';
		 }
		 else
		 {
		 $test=number_format($resikokerja,2);
		 $hasilpremi=$resikokerja;
		 }
		} 
		else 
		{
		 if(substr($kdproduk,0,3)=="JL2" || substr($kdproduk,0,3)=="JL3"){
					$hasilpremi = ($arr["KDJENISBENEFIT"]=="U") ? $premilink : $hasilpremi;
		 }
		 
		 
		 if(($kdproduk)=="ASIB" || ($kdproduk)=="ASPB" || ($kdproduk)=="ASI" || ($kdproduk)=="ASP" || ($kdproduk)=="AI0" || ($kdproduk)=="AJSAN" || ($kdproduk)=="AEP" || ($kdproduk)=="JSHAA" || ($kdproduk)=="JSIAA" || ($kdproduk)=="JSAA" )
 	  		{
				$test=$hasilpremi!=0 ? number_format(($premisatu*$faktor),2):'';
			} else {
				$test=$hasilpremi!=0 ? number_format($hasilpremi*$faktor,2):'';
			}
		}
		
		
		
		if(substr($kdproduk,0,3)=="JL2" && $kdbenefit=="INVPRDJL")
		{
		  $benfitinvestakhir = $premilink - $pengurangpremi + $bentopupinvest  + $bentopupinvestskg;
		  
			$tist= number_format($benfitinvestakhir,2);

		}
		else
		{
		  if(substr($kdproduk,0,5)=="JL2XS" && $kdbenefit=="BNFCRIL")
		  {
			  $tist = number_format((0.25*$premilink),2);
			}
			elseif(substr($kdproduk,0,5)=="JL2XS" && $kdbenefit=="JMNKEC")
		  {
			  $tist = number_format((0.5*$premilink),2);
			}
			elseif(substr($kdproduk,0,5)=="JL3XS" && $kdbenefit=="BNFCRIL")
		  {
			  $tist = number_format((0.05*$premilink),2);
			}
			elseif(substr($kdproduk,0,5)=="JL3XS" && $kdbenefit=="JMNKEC")
		  {
			  $tist = number_format((0.1*$premilink),2);
			}
			else 
			{
		   $tist=$hasilbenefit!=0 ? number_format($hasilbenefit,2):'';
			}
		}
		
		if((($kdproduk)=="ASIB" || ($kdproduk)=="ASPB" || ($kdproduk)=="ASI" || ($kdproduk)=="ASP" || ($kdproduk)=="AI0" || ($kdproduk)=="JSHAA")|| ($kdproduk)=="AEP" || ($kdproduk)=="JSIAA" && ($kdbenefit=="RESTPREBNF" || $kdbenefit=="RESTPREHT2"))
		{
		  
			$tist= number_format($premisatu,2);
			//echo "$premisatu asfads";
		}
		
		//JL2 -> tampilkan premi top up
		if($arr["KDBENEFIT"]=="BNFTOPUP"){
		  $premitopup = $arr["PREMI"];
		  $test = number_format($premitopup,2);
		} elseif ($arr["KDBENEFIT"]=="BNFTOPUPSG") {
		  $premitopupskg = $arr["PREMI"];
		  $test = number_format($premitopupskg,2);
		//TARIF RIDER TAHUNAN TIDAK DIKALIKAN FAKTOR BAYAR LAGI
		} elseif (substr($arr["KDBENEFIT"],0,2)=="CP" || $arr["KDBENEFIT"]=="PA" || $arr["KDBENEFIT"]=="WAIVER" || $arr["KDBENEFIT"]=="CACAD" || $arr["KDBENEFIT"]=="CI" || $arr["KDBENEFIT"]=="TERM" || $arr["KDBENEFIT"]=="CI53" || $arr["KDBENEFIT"]=="TI" || substr($arr["KDBENEFIT"],0,4)=="JSHC" ) {
		  $test = number_format($hasilpremi,2);
		} elseif (($arr["KDBENEFIT"])=="BNFPHT" && (($kdproduk)=="ASIB" || ($kdproduk)=="ASPB" || ($kdproduk)=="ASI" || ($kdproduk)=="ASP" || ($kdproduk)=="AI0" || ($kdproduk)=="AJSAN" || ($kdproduk)=="AEP" || ($kdproduk)=="JSHAA" || ($kdproduk)=="JSIAA" || ($kdproduk)=="JSAA") ) {
		  $test = number_format(($premisatu),2);
		} else {
		  $premitopup = "";
			$premitopupskg = "";
		  $test = $test;
		}
		 
		/*===== edit by fendy jika produk anuitas premi samakan saja =====*/
		if ((substr($kdproduk, 0, 3) == 'AI0' || ($kdproduk)=="AJSAN") && $premijua == 'premi') {
			$tist = trim($kdbenefit) == 'RESTPREBNF' ? $premi1 : $tist;
			$hasilbenefit = trim($kdbenefit) == 'RESTPREBNF' ? $premi1 : $hasilbenefit;
			$test = $test > 0 ? $premi1 : $test;
			$hasilpremi = $test;
		}
		if (substr($kdproduk, 0, 2) == 'PA' && $kdbenefit == 'DEATHKC') {
			$test = $premi1;
			$hasilpremi = $premi1;
			$tist = $jua1;
			$hasilbenefit = $jua1;
			
			/*$sql = "UPDATE $DBUser.tabel_223_temp SET nilaibenefit = $tist, 
						premi = $test
					WHERE prefixpertanggungan = '$prefixpertanggungan' 
						AND nopertanggungan = '$nopertanggungan'
						AND kdbenefit IN ('DEATHKC')";
			$DB->parse($sql);
			$DB->execute();
			$DB->commit();*/
		}
		/*===== end edit by fendy =====*/
		/****
		 *  Analysis: 
		 *
		 *	If date value in the form '01-AUG-05', the following line will fail
		 *  the date representation must uniform in 'DD/MM/YYYY' format
		 *  
		 * (I'm not sure, it's need confirmation!)
		 *
		 *  --- Udi --- Aug, 24th, 2005
		 ****/
		$tast=(strlen($hasilexpirasi)==10) ? $hasilexpirasi : '';

		if (in_array($kdproduk, array('APPSH', 'APP65', 'APP75', 'APP85'))) {
			if ($kdbenefit == 'BNFPHT') {
				$tist = $resapp['JPHT'];
				$test = $resapp['PREMI'];
				$hasilbenefit = $tist;
				$hasilpremi = $test;
				$hasilakhirpmb = $tast;
			} else if ($kdbenefit == 'BNFPJD') { 
				$tist = $resapp['JPJD'];
				$hasilbenefit = $tist;
			} else if ($kdbenefit == 'BNFPYT') { 
				$tist = $resapp['JPYT'];
				$hasilbenefit = $tist;
			} else if ($kdbenefit == 'RESTPREBNF') {
				$tist = $resapp['PREMI'];
				$hasilbenefit = $tist;
			}
		}
				
		echo "<td align=right class=verdana8>".$tist."";// premilink =  ".$premilink." - ".$pengurangpremi." + ".$bentopupinvest." + ".$bentopupinvestskg."";
		echo "   <input type=\"hidden\" name=bnf".$kdbenefit." value=".$hasilbenefit.">";
		echo "   <input type=\"hidden\" name=exp".$kdbenefit." value=".$hasilexpirasi."></td>";
		echo "<td align=\"right\" class=verdana8>".$test."";
		echo "   <input type=\"hidden\" name=prm".$kdbenefit." value=".$hasilpremi.">";
		echo "   <input type=\"hidden\" name=akh".$kdbenefit." value=".$hasilakhirpmb.">";
		echo "</td>";
		echo "<td align=center class=verdana8blk>".$tast."</td>";
		echo "<td align=center class=verdana8>".$arr["KDJENISBENEFIT"]."</td>";
	  echo "</tr>";
	  
			
		/*---------------------------------------------------------------------------*/
    // ditutup berdasarkan permintaan Ary tgl 24 Juli 2008
    // tidak ada pengurangan premi rider pada investasi
				
		/*
		if(substr($kdproduk,0,3)=="JL2"){
					$hasilpremi = ($arr["KDJENISBENEFIT"]=="U") ? $hasilpremi : 0;
		}
		*/
		/*---------------------------------------------------------------------------*/
		
		
		//hasil tambahan script oleh DediZ 02/07/2010 14:40 TAMBAHIN R
		//if($arr["KDJENISBENEFIT"]=="R"){
		
		if((substr($arr["KDBENEFIT"],0,3)=="CPB" || substr($arr["KDBENEFIT"],0,3)=="CPM" || $arr["KDBENEFIT"]=="PA" || $arr["KDBENEFIT"]=="WAIVER" || $arr["KDBENEFIT"]=="CACAD" || $arr["KDBENEFIT"]=="CI" || $arr["KDBENEFIT"]=="TERM") || $arr["KDBENEFIT"]=="TI" || $arr["KDBENEFIT"]=="CI53" ||  substr($arr["KDBENEFIT"],0,4)=="JSHC"  && $hasilpremi > 0) {
		//$hasilpremi=0;	biaya 2000 hanya diawal saja
			if(substr($kdproduk,0,3)=="JL2" || substr($kdproduk,0,3)=="JL3") {		
				$jmlpremi = $jmlpremi + ($arr["KDJENISBENEFIT"]=="S" ? 0 : ($hasilpremi-(substr($arr["KDBENEFIT"],0,3)=="CPB" ? 0 : /*2000*/0) )); 		
			} else {
				$hasilpremi=0;
			}
		}else{
		//--------------------------------------------------
		$jmlpremi = $jmlpremi + ($arr["KDJENISBENEFIT"]=="S" ? 0 : $hasilpremi); 
		//echo $jmlpremi." + ".($arr["KDJENISBENEFIT"]."==S ? 0 : ".$hasilpremi); 
		//hasil tambahan script oleh DediZ 02/07/2010 14:40
		if(($kdproduk)=="ASIB" || ($kdproduk)=="ASPB" || ($kdproduk)=="ASI" || ($kdproduk)=="ASP" || ($kdproduk)=="AI0" || ($kdproduk)=="AEP" || ($kdproduk)=="JSHAA" || ($kdproduk)=="JSIAA" || ($kdproduk)=="JSAA")
 	  		{
				$jmlpremi = ceil($premisatu);
				
			}
		}
		
		//--------------------------------------------------
		$jmlbenefit = $jmlbenefit + $hasilbenefit; 
		
		$jmlpremi_cp+=$premi_cp;
		//echo $hasilpremi;
		$no ++;
		$i++;
		
	} //foreach

 //echo $premisubmit;
 //echo $jmlpremi."*".$faktor;
					 if ($cabayar=='X' or $cabayar=='E' or $cabayar=='J') {
					 		CompComm($DB,$prefixpertanggungan,$nopertanggungan,$premistandar,$jmlpremi*$faktor);	
					 } else {
  					/*---------------------------------------------------------------------------*/
            // ditutup berdasarkan permintaan Ary tgl 24 Juli 2008
            // tidak ada pengurangan premi rider pada investasi
						/*
					    if(substr($kdproduk,0,3)=="JL2"){
							CompComm($DB,$prefixpertanggungan,$nopertanggungan,$premistandar,$jmlpremi*$faktor);
							//echo "compcommdisini: premistandar = $premistandar; hasilpremiu = $hasilpremiu; jmlpremi=$jmlpremi";
							}
							else
							{
					 */
					 //echo $prefixpertanggungan."-".$nopertanggungan."-".$hasilpremiu."-".$jmlpremi*$faktor;
				      CompComm($DB,$prefixpertanggungan,$nopertanggungan,$hasilpremiu,$jmlpremi*$faktor);
					 //		}
					 /*---------------------------------------------------------------------------*/
					 }
					 
					 if(substr($kdproduk,0,3)=="JL2" || substr($kdproduk,0,3)=="JL3"){
  					 $sql = "select sum(premi) as premirider ".
                      "from $DBUser.tabel_223_temp where substr(kdproduk,1,2)='JL' and kdjenisbenefit='R' ".
                      "and prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan'";
  					 //echo $sql;
						 $DB->parse($sql);
          	 $DB->execute();
          	 $pres=$DB->nextrow();
						 //echo $pres["PREMIRIDER"];
						 //$premirider =  $pres["PREMIRIDER"] * (1.5/100);
						 if ($cabayar=='X')
						 {
						 $premirider = 0;
						 }
						 else
						 {
  					 $premirider =  $pres["PREMIRIDER"] * (1.5/100);
  					 }
  					 
  					 $sql = "insert into $DBUser.tabel_404_temp ".
            					 "(PREFIXPERTANGGUNGAN,NOPERTANGGUNGAN,KOMISIAGEN,".
            					 "KDKOMISIAGEN,NOAGEN,THNKOMISI,KOMISIAGENCB) ".
              		   "values ('$prefixpertanggungan','$nopertanggungan',$premirider,".
  									 		"'24','$noagen','1',$premirider) ";
             //echo $sql;
						 $DB->parse($sql);
             $DB->execute();
             $DB->commit;
					 }
					 
					 //==================================
	
					 if($kdproduk=="JSDG0" || $kdproduk=="JSDG0" || $kdproduk=="JSDM0" || $kdproduk=="JSDMPP" || $kdproduk=="JSPNNN" || $kdproduk=="JSPSN" || $kdproduk=="JSPBTN" || $kdproduk=="JSP" || $kdproduk=="JSPS" || $kdproduk=="JSSHTT" || $kdproduk=="P30" ||$kdproduk=="SC5" || $kdproduk=="SC6" || $kdproduk=="ST5" || $kdproduk=="ST6"  || $kdproduk=="JSSHTB"){
  					 $sql = "select sum(premi) as premirider ".
                      "from $DBUser.tabel_223_temp where kdjenisbenefit='R' ".
                      "and prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan'";
  					 //echo $sql;
						$DB->parse($sql);
          	 			$DB->execute();
          	 			$pres=$DB->nextrow();
						 //echo $pres["PREMIRIDER"];
						 //$premirider =  $pres["PREMIRIDER"] * (1.5/100);
						 if ($cabayar=='4' || $cabayar=='A')
						 {
							$premirider =  $pres["PREMIRIDER"] * (1.5/100);
						 }
						 else
						 {
							$premirider = 0;  					 
						 }
  					 
  					 $sql = "insert into $DBUser.tabel_404_temp ".
            					 "(PREFIXPERTANGGUNGAN,NOPERTANGGUNGAN,KOMISIAGEN,".
            					 "KDKOMISIAGEN,NOAGEN,THNKOMISI,KOMISIAGENCB) ".
              		   "values ('$prefixpertanggungan','$nopertanggungan',$premirider,".
  									 		"'24','$noagen','1',$premirider) ";
             //echo $sql;
						 $DB->parse($sql);
             $DB->execute();
             $DB->commit;
					 }
					 //==================================
$sql = "delete from $DBUser.tabel_247_temp ".
		   "where prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$noproposal' ";
$DB->parse($sql);
$DB->execute();
$DB->commit;

$sql = "insert into $DBUser.tabel_247_temp(prefixpertanggungan,nopertanggungan,".
		   "kdbasispremi,kdbasistebus,kdbasisskg,kdbasiscwa,kdbasisbayar) values ".
			 "('$prefixpertanggungan','$nopertanggungan',".
			 "'".$FM->kdbasispremi."','".$FM->kdbasistebus."','".$FM->kdbasisskg."".
			 "','".$FM->kdbasiscwa."','".$FM->kdbasisbayar."')";			
//echo $sql;
$DB->parse($sql);
$DB->execute();
$DB->commit;

?>
	<tr class=tblhead>
	<td colspan="4" align=left>Premi Yang Harus Dibayar Secara <? echo $cabar; ?></td>
	<td align=right><?=number_format(((substr($kdproduk, 0, 3) == 'AI0' || ($kdproduk)=="AJSAN" || substr($kdproduk, 0, 2) == 'PA' || substr($kdproduk, 0, 2) == 'AP')&& $premijua == 'premi' ? $premi1 : ($jmlpremi*$faktor)+$premitopup+$premitopupskg),2);	?></td>
	<td colspan=2></td>
	</tr>
	<tr class="tblisi1">
	<td colspan="4" align=left>Premi Standar Tahunan</td>
	<td align=right><?=number_format(((substr($kdproduk, 0, 3) == 'AI0' || ($kdproduk)=="AJSAN" || substr($kdproduk, 0, 2) == 'PA' || substr($kdproduk, 0, 2) == 'AP') && $premijua == 'premi' ? $premi1 : $premistandar+$premitopup+$premitopupskg),2); ?></td>
	<td colspan=2></td>
	</tr>
	</table>
	<input type="hidden" name="premilinked" value="<?=$premilink;?>">
	
</td>
</tr>
</table>

<hr size=1>
<?php 
$akumulasiua=$akumulasiua+$jua;
$sql="select resikoawal from $DBUser.TABEL_226_BATAS_RESIKO where (select usia_th from $DBUser.tabel_200_temp a ".
    			   "where a.prefixpertanggungan='$prefixpertanggungan' ".
    				 "and a.nopertanggungan='$nopertanggungan') between batasbawah and batasatas AND KDPRODUK=NVL((SELECT KDPRODUK FROM $DBUser.TABEL_226_BATAS_RESIKO WHERE KDPRODUK='$kdproduk' GROUP BY KDPRODUK),'*')";
$DB->parse($sql);
$DB->execute();
$batasua=$DB->nextrow();
//echo $sql;
//echo $batasua["RESIKOAWAL"].'/'.$akumulasiua;
//echo 'x'.$med;
if ($akumulasiua>$batasua["RESIKOAWAL"] && $med!='M') {
	 echo "<font color=red>Proses proposal harus Medical!, Akumulasi UA (".number_format($akumulasiua,2).") melebihi ketentuan (".number_format($batasua["RESIKOAWAL"],2)."). Ubah proposal menjadi medical atau silakan hubungi bagian Underwriting Head Office</font><br /></br />";
			   //echo "<a href=javascript:window.close()>CLOSE</a>";
				// die;
	}
// cek JUA dan Premi minimal
    	$sql = "select a.kdvaluta,to_char(a.mulas,'DD/MM/YYYY') as tglmulas ".
    	       "from $DBUser.tabel_200_temp a ".
    			   "where a.prefixpertanggungan='$prefixpertanggungan' ".
    				 "and a.nopertanggungan='$nopertanggungan'";
					//echo $sql;	 
    	$DB->parse($sql);
    	$DB->execute();
      $val=$DB->nextrow();
    	$kdvaluta=$val["KDVALUTA"];
			$tglmulas=$val["TGLMULAS"];
			
    	$sql = "select kurs from $DBUser.tabel_999_kurs_transaksi where tglkursberlaku=".
    	       "(select max(tglkursberlaku) from $DBUser.tabel_999_kurs_transaksi ".
    	     	 "where tglkursberlaku<=sysdate and kdvaluta='$kdvaluta') ".
    	     	 "and kdvaluta='$kdvaluta'";	
			//			 echo $sql;
    	$DB->parse($sql);
    	$DB->execute();
    	$res=$DB->nextrow();
    	$idx = $res["KURS"];
$juarp=$jua*$idx;
$premirp=$jmlpremi*$faktor*$idx;
$jmlpremi_cp_rp = $jmlpremi_cp*$faktor*$idx;

//echo "Cash Plan : ".$adacp." Premi RP = ".$premirp." Hasil Premi : ".$jmlpremi_cp_rp." cara bayar : -".$FM->cabayar."-";
//echo $premistd.'xxx';
//echo "JUA :".$jua1." | premi2 :".$premistd." premistandar  $premistd<br><br>";
if($adacp=="Y")// casplan boleh semua cara bayar
{
  //if(($FM->cabayar==1) || ($FM->cabayar==2) || ($FM->cabayar==3))
	//{ 
      //echo "CP hanya boleh dengan cara bayar Tahunan atau Sekaligus<br><br>";
  	  //echo "<a href=javascript:window.close()>CLOSE</a>";
  	  //die;
	//} 
}

/* --- awal penguncian --*/

if($premijua=="jua"){
if($nopertanggungan=="153431786"){
	$premirp = 34714750;
}
  if($premirp >= 100000 || substr($kdproduk,0,2)=="PA" || substr($kdproduk,0,5)=="JSKEL") {

		if(substr($kdproduk,0,6)=="JSSPOX")// DIRUBAH KARENA OPTIMA 7 TIDAK ADA KUOTA 05/10/2012
		{
		  //$premicadangan 			= 100000000000;
			$premicadangan 			= 150000000;
			$premijsspohitungan = $jmlpremi;
			
			//echo $kdproduk;
			//echo "| lama premi : ".$pt." jumlah premi : ".$jmlpremi;
			
			 $sql = "select sum(premi1) as totalpremimasuk ".
              "from $DBUser.tabel_200_pertanggungan ".
							"where kdproduk like 'JSSPO%' and  kdstatusfile='1' and  kdpertanggungan='2' ".
              "and lamaasuransi_th='".$pt."' group by lamaasuransi_th";
			 $DB->parse($sql);
    	 $DB->execute();
    	 $res=$DB->nextrow();
    	 $premicurrent      = $res["TOTALPREMIMASUK"];	
			 $totpremisementara = $premicurrent+$premijsspohitungan;
			 //echo "<br />Premi exist : ".$premicurrent." + ".$premijsspohitungan." = ".$totpremisementara;		
		   if($totpremisementara > $premicadangan)
			 {
			   echo "<font color=red>Proses proposal tidak dapat dilanjutkan, premi melebihi ketentuan. Silakan hubungi bagian Marketing Head Office</font><br /></br />";
			   echo "<a href=javascript:window.close()>CLOSE</a>";
				 die;
			 }
			 else
			 {
			   $msg = "";
			 }
			   /*
               Script ini di komentari oleh udi pada tgl 15 januari 2007
               untuk mengakomodasi pemilihan produk JSSPO dengan benefit Cash Plan
               sebab premi Cash Plan bukan kelipatan 500000

		      $batas = 500000;
			  $filterpremi = $premirp%$batas;
			  if($filterpremi==0)
				{}
				else
				{
				 echo "Premi hitung sebesar Rp. ".number_format($premirp,2,",",".").". Premi produk $kdproduk harus kelipatan Rp. 500.000,- sebaiknya Anda entry Premi saja<br /><br />";
				 echo "<a href=javascript:window.close()>CLOSE</a>";
    		 die;
				}
             */
		}
		else
		{
		  //selain JSSPO
		}

		
	} else {
		echo "Premi hitung kurang dari syarat minimal (Rp. 100.000,-), proses tidak dapat dilanjutkan<br>".
				 "Tingkatkan JUA sampai premi mecapai syarat minimal! <br><br>";
		echo "<a href=javascript:window.close()>CLOSE</a>";
		die;
	}
	
	if(substr($kdproduk,0,4)=="JSAP")
	{
	  	if($adacp=="Y" && $jmlpremi_cp_rp < 3000000 && ($cabayar=="Y" || $cabayar=="4") )
    	{
    	  echo "Cara Bayar = Tahunan. Premi hitung kurang dari syarat minimal (Rp. 3.000.000,-) untuk tambahan CP, proses tidak dapat dilanjutkan<br>".
    				 "Tingkatkan JUA sampai premi mecapai syarat minimal! <br><br>";
    		echo "<a href=javascript:window.close()>CLOSE</a>";
    		die;
    	}
    	
    	if($adacp=="Y" && $jmlpremi_cp_rp < 40000000 && $cabayar=="X")
    	{
    	  echo "Cara Bayar = Sekaligus. Premi hitung kurang dari syarat minimal (Rp. 40.000.000,-) untuk tambahan CP, proses tidak dapat dilanjutkan<br>".
    				 "Tingkatkan JUA sampai premi mecapai syarat minimal! <br><br>";
    		echo "<a href=javascript:window.close()>CLOSE</a>";
    		die;
    	}
	
	}
	else
	{
        /*
            Script ini dikomenentari oleh Udi untuk mem bypass batasan minimal
            premi cash plan

	  	if($adacp=="Y" && $jmlpremi_cp_rp < 2500000 && ($cabayar=="Y" || $cabayar=="4") )
    	{
    	  echo "Cara Bayar = Tahunan. Premi hitung kurang dari syarat minimal (Rp. 2.500.000,-) untuk tambahan CP, proses tidak dapat dilanjutkan<br>".
    				 "Tingkatkan JUA sampai premi mecapai syarat minimal! <br><br>";
    		echo "<a href=javascript:window.close()>CLOSE</a>";
    		die;
    	}

    	if($adacp=="Y" && $jmlpremi_cp_rp < 20000000 && $cabayar=="X")
    	{
    	  echo "Cara Bayar = Sekaligus. Premi hitung kurang dari syarat minimal (Rp. 20.000.000,-) untuk tambahan CP, proses tidak dapat dilanjutkan<br>".
    				 "Tingkatkan JUA sampai premi mecapai syarat minimal! <br><br>";
    		echo "<a href=javascript:window.close()>CLOSE</a>";
    		die;
    	}

        */

	}
}


//echo $jmlpremi_cp_rp." | CARABAYAR = ".$cabayar." | ".$jmlpremi_cp." | ".$faktor." | ".$idx." | ".$cabayar." | ".$adacp;

// tambahan benefit TOP UP khusus untuk produk JL2 berkala
if(substr($kdproduk,0,3)=="JL2" || substr($kdproduk,0,3)=="JL3")
{
?>
<table>
<?
$minimaltopupberkala = 1000; 
//$minimaltopupberkala = 100000; //update by sukendro 17/07/2008
//$minimaltopupberkala = $premistandar * 0.3;

if($cabayar!="X"){ //kalau carabayar sekaligus, hanya pake yg berkala saja
?>
<tr>
<td><font size="2">Premi Top UP Berkala</font></td>
<td>
<? 
if($premitopup==""){
?>
<input type="text" name="premitopup" value="<?=$minimaltopupberkala;?>" size="20">
<input type="submit" name="addtopup" value="TAMBAH" />
<? 
} else {
?>
<input type="text" name="premitopup" value="<?=$premitopup;?>" size="20">
<input type="submit" name="updatetopup" value="UPDATE" />
<input type="submit" name="deletetopup" value="DELETE" />
<? 
}
?>
</td>
</tr>
<? 
}
?>
<tr>
<td><font size="2">Premi Top UP Sekaligus</font></td>
<td>
<? 
if($premitopupskg==""){
//$minimaltopupsekaligus = $cabayar=="X" ? ($premistandar * 0.3) : 0;
?>
<input type="text" name="premitopupskg" value="<?=$minimaltopupsekaligus;?>" size="20">
<input type="submit" name="addtopupskg" value="TAMBAH" /> <font size="2">(Minimal 1000 unit)</font>
<? 
} else {
?>
<input type="text" name="premitopupskg" value="<?=$premitopupskg;?>" size="20">
<input type="submit" name="updatetopupskg" value="UPDATE" />
<input type="submit" name="deletetopupskg" value="DELETE" /> <font size="2">(Minimal 1000 unit)</font>
<? 
}
?>
</td>
</tr>
</table>
<input type="hidden" name="minpremitopup" value="<?=$minimaltopupberkala;?>" />
<input type="hidden" name="premiakhir" value="<?=$jmlpremi+$premitopup;?>" />
<input type="hidden" name="benfitinvestakhir" value="<?=$benfitinvestakhir;?>" />
<input type="hidden" name="tglmutasi" value="<?=$tglmulas;?>" />
<hr size="1">
<?
}

if ($juarp >= $juaminimal || $juaminimal==""){

?>
<table width="100%">
<tr>
  <td class="arial10"><a href="benefit.php?state=0&premijua=<?echo $premijua;?>&noproposal=<?echo $noproposal;?>&nopertanggungan=<?echo $nopertanggungan;?>&prefixpertanggungan=<?echo $prefixpertanggungan;?>&kdper=<?echo $kdper;?>&vara=<?echo $vara;?>&kdproduk=<?echo $kdproduk;?>">Back</a></td>
	<td align="right">
	  <input type="hidden" name="mode" value="insert">
	  <input type="hidden" name="nopertanggungan" value="<? echo $nopertanggungan; ?>">
	  <input type="hidden" name="premistd" value="<? echo $premistandar; ?>">
	  <input type="hidden" name="jmlpremi" value="<? echo $jmlpremi; ?>">
	  <input type="hidden" name="jmlbenefit" value="<? echo $jmlbenefit; ?>">
		<input type="hidden" name="resikokerja" value="<? echo $resikokerja; ?>">
		<input type="hidden" name="kodeproduk" value="<? echo $kdproduk; ?>">
		<input type="hidden" name="noagen" value="<? echo $noagen; ?>">
		<? printf("<input type=\"button\" name=\"tariftebus\" value=\"Nilai Tebus\" onclick=\"NewWindow('tebus.php?jua=%s&pref=%s&noper=%s','popuptebus',400,500,1);\">",$jua,$prefixpertanggungan,$nopertanggungan); ?>
		<? printf("<input type=\"button\" name=\"propmtc14komisi\" value=\"Komisi\" onclick=\"NewWindow('popupkom.php?cabayar=%s&prefixpertanggungan=%s&nopertanggungan=%s&noproposal=%s&noagen=%s&premi1=%s','popupkomisi',650,450,1);\">",$cabayar,$prefixpertanggungan,$nopertanggungan,$noproposal,$noagen,$jmlpremi); ?>
    <input type="submit" name="propmtc14lanjut" value="Lanjut"  onclick="javascript:SubmitOK();">
	</td>
</tr> 
</table>
<?

} else {
  echo "Jua hitung sebesar Rp. ".number_format($juarp,2)." kurang dari Jua minimal yang disyaratkan sebesar Rp.".number_format($juaminimal,2)."<br>";
	echo "<a href=javascript:window.close()>CLOSE</a>";
} ;

?>

</form>
</body>
</html>