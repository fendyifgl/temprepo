<?php
	
	include "./includes/session.php";
	include "./includes/database.php"; 
	include "../../../includes/common.php";
	include "./includes/pertanggungan.php";	
	include "./includes/duit.php";
	include "./includes/klien.php";
	include "./libs/qr-sat/qr_img.php";
	
    require('./libs/fpdf181/fpdf.php');

    define("FPDF_FONTPATH", "./libs/fpdf181/font/");
	
	define("QRCODE", "./libs/phpqrcode");
	define("QRCODE_TEMP_DIR", "./libs/qr-sat/temp");
	
	$data['user_id']		 = $userid;
	$data['password']		 = $passwd;
	$data['db']				 = $DBName;
	$data['dbuser']			 = $DBUser;
	$data['prefix']			 = trim($_GET['prefix']);
	$data['nopertanggungan'] = trim($_GET['nopertanggungan']);
	$data['paragraph1']		 = "Penanggung dengan ini menyatakan setuju untuk membayarkan Manfaat Anuitas atas diri Tertanggung sebagaimana "
							 . "yang tercantum dalam Polis ini berdasarkan syarat dan ketentuan Data Polis, Syarat Umum Polis, Ketentuan Khusus, "
							 . "Ketentuan Tambahan dan ketentuan lainnya (bila ada) yang dilekatkan/dilampirkan pada Polis "
							 . "dan merupakan satu kesatuan dan bagian yang tidak terpisahkan dari Polis ini.";
	$data['paragraph2']		 = "Dalam hal Pemegang Polis keberatan dan ingin membatalkan maksud untuk mempertanggungkan diri Tertanggung "
							 . "berdasarkan Polis ini, maka dapat mengembalikan Polis ini dalam masa Free Look Provision, yaitu dalam jangka "
							 . "waktu 14 (empat belas) hari kalender sejak Polis ini diterima.";
	$data['paragraph3']		 = "Dalam hal masa Free Look Provision tersebut telah terlewati, maka \"Pemegang Polis dengan ini menyatakan bahwa "
							 . "Pertanggungan sudah disetujui sesuai dengan Data Polis, Syarat Umum Polis, Ketentuan Khusus, Ketentuan Tambahan "
							 . "dan atau ketentuan lainnya\".";
	
	class CetakPolis extends FPDF {
		private $user_id;
		private $password;
		private $DBUser;
		private $db;
		private $prefix;
		private $nopertanggungan;
		private $paragraph1;
		private $paragraph2;
		private $paragraph3;
		private $tgl_cetak;
		private $jam_cetak;
		private $arr;
		private $arrs;
		private $arrr;
		private $ars;
		private $art;
		private $arrp;
		private $arrp2;
		private $arrk;
		private $arrt;
		private $arrt2;
		private $arrat;
		private $arrmp;
		
		private $pg_w		= 190;
		private $num_space	= 10;
		private $height		= 5;
		private $premi1		= 0;
		private $premi2		= 0;
		private $cash_plan	= 0;
		private $flag_dst	= false;
		
		protected $B=0;
		protected $I=0;
		protected $U=0;
		protected $HREF='';
		protected $ALIGN='';
		
		protected $column = 0; // Current column
		protected $y0;      // Ordinate of column start
		
		public function __construct($data) {
			parent::__construct('P', 'mm', 'A4');
            $this->SetMargins(10, 40);
			$this->user_id		   = $data['user_id'];
			$this->password		   = $data['password'];
			$this->DBUser		   = $data['dbuser'];
			$this->db			   = $data['db'];
			$this->prefix		   = $data['prefix'];
			$this->nopertanggungan = $data['nopertanggungan'];
			$this->paragraph1	   = $data['paragraph1'];
			$this->paragraph2	   = $data['paragraph2'];
			$this->paragraph3	   = $data['paragraph3'];
			$this->tgl_cetak	   = date('Ymd');
			$this->jam_cetak	   = date('His');
			
			$this->Init();			
			$this->SPAJ();
			$this->DataPolis();
			$this->KetentuanPolis();
			//$this->syaratUmum();
			//$this->AsuransiTambahan();
		}
		
		public function Init() {
			$DA	  = new Database($this->user_id, $this->password, $this->db);
			$DBUser = $this->DBUser;
			
			$sql = "SELECT a.PREFIXPERTANGGUNGAN, a.TGLSP, TO_CHAR(a.MULAS, 'DD/MM/YYYY') AS MULAS, a.USIA_TH, a.NOPERTANGGUNGAN, 
						TO_CHAR(a.EXPIRASI, 'DD/MM/YYYY') AS EXPIRASI, a.LAMAPEMBPREMI_BL AS PERIODE_BULAN, a.NOPEMEGANGPOLIS, 
						a.LAMAASURANSI_TH, a.LAMAASURANSI_BL,TO_CHAR(SYSDATE, 'DD/MM/YYYY') AS TGLCETAK, a.JUAMAINPRODUK, 
						a.JUAMAINPRODUK, a.PREMI1, a.PREMI2, /*CASE WHEN SUBSTR(a.NOSP, 0, 1) = 'O' THEN k.nomorspajcetak ELSE a.NOSP END*/ a.NOSP, 
						a.KDVALUTA, a.KDCARABAYAR, a.KDSTATUSMEDICAL, DECODE (a.KDCARABAYAR, 'X', 1, a.LAMAPEMBPREMI_TH) LAMAPEMBPREMI_TH, 
						a.KDPRODUK, a.NOPOLBARU,
						(SELECT NAMAVALUTA FROM $DBUser.TABEL_304_VALUTA WHERE KDVALUTA = a.KDVALUTA) AS NAMAVALUTA,
						(SELECT CASE WHEN COUNT(*) > 0 THEN b.NAMAPRODUK || ' LENGKAP' ELSE b.NAMAPRODUK END FROM $DBUser.TABEL_223_TRANSAKSI_PRODUK WHERE PREFIXPERTANGGUNGAN=a.PREFIXPERTANGGUNGAN AND NOPERTANGGUNGAN=a.NOPERTANGGUNGAN and KDBENEFIT='JAMLKP') NAMAPRODUK,
						a.TGLNEXTBOOK, a.TGLLASTPAYMENT, b.KETERANGAN, c.NAMACARABAYAR,
						(SELECT NAMAKLIEN1 FROM $DBUser.TABEL_100_KLIEN WHERE NOKLIEN = a.NOAGEN) AS NAMAAGEN, 
						(SELECT (SELECT NAMAAREAOFFICE FROM $DBUser.TABEL_410_AREA_OFFICE WHERE KDAREAOFFICE = v.KDAREAOFFICE AND KDKANTOR=v.KDKANTOR) FROM $DBUser.TABEL_400_AGEN v WHERE noagen=a.noagen) AS KTRAGEN, 
						(SELECT kn.NAMAKANTOR FROM $DBUser.TABEL_001_KANTOR kn, $DBUser.TABEL_400_AGEN ag WHERE kn.KDKANTOR = ag.KDKANTOR AND ag.NOAGEN = a.NOAGEN ) AS KANTORFOOTER, 
						(SELECT NAMAPEJABAT FROM $DBUser.TABEL_002_PEJABAT pj INNER JOIN $DBUser.TABEL_500_PENAGIH pg ON pj.KDKANTOR = pg.KDRAYONPENAGIH WHERE pg.NOPENAGIH = a.NOPENAGIH AND KDORGANISASI = '160s') AS NAMAPEJABAT, 
						(SELECT pj.NAMAJABATAN FROM $DBUser.TABEL_001_KANTOR kn, $DBUser.TABEL_400_AGEN ag, $DBUser.TABEL_002_PEJABAT pj WHERE kn.KDKANTOR = ag.KDKANTOR AND ag.NOAGEN = a.NOAGEN AND kn.KDKANTOR = pj.KDKANTOR AND pj.KDORGANISASI = '160s' ) AS NAMAJABATAN,
						d.GELAR AS GELARPP, d.ALAMATTETAP01, d.ALAMATTETAP02, TO_CHAR(d.TGLLAHIR, 'dd/mm/yyyy') TGLLAHIR,
						d.KODEPOSTETAP, d.PHONETETAP01, d.NAMAKLIEN1 as PEMEGANGPOLIS, LENGTH(d.NAMAKLIEN1) PANJANG, d.NOID, d.MERITALSTATUS,
						DECODE(e.GELAR, null, null, ', ' || e.GELAR) AS GELARTTG,
						DECODE(d.GELAR, null, null, ', ' || d.GELAR) AS GELARPP, 
						e.NAMAKLIEN1 as TERTANGGUNG,  TO_CHAR(e.TGLLAHIR, 'dd/mm/yyyy') TGLLAHIRTT, 
						d.NOID,
						(SELECT x.FAKTORBAYAR FROM $DBUser.TABEL_311_FAKTOR_BAYAR x WHERE x.KDVALUTA = a.KDVALUTA and x.KDCARABAYAR = a.KDCARABAYAR and x.KDBASIS = f.KDBASISBAYAR) AS FAKTORBAYAR, a.PREMISTD,
						--d.ALAMATTETAP01 || ' ' || d.ALAMATTETAP02 || ' ' || g.NAMAKOTAMADYA || ' ' || h.NAMAPROPINSI AS ALAMATPEMPOL,
						d.ALAMATTETAP01 AS ALAMATPEMPOL,
						i.KDMAPPING, TO_CHAR(SYSDATE, 'ddmmyyyy') TGLCETAKQR, a.NOREKENINGDEBET,
                        (SELECT NAMAPEJABAT FROM $DBUser.TABEL_002_PEJABAT WHERE KDKANTOR = 'KP' AND KDORGANISASI = '000') AS NAMADIREKTUR,
                        (SELECT NAMAJABATAN FROM $DBUser.TABEL_002_PEJABAT WHERE KDKANTOR = 'KP' AND KDORGANISASI = '000') AS JABATANDIREKTUR
					FROM $DBUser.TABEL_200_PERTANGGUNGAN a
					INNER JOIN $DBUser.TABEL_202_PRODUK b ON a.KDPRODUK = b.KDPRODUK
					INNER JOIN $DBUser.TABEL_305_CARA_BAYAR c ON a.KDCARABAYAR = c.KDCARABAYAR
					INNER JOIN $DBUser.TABEL_100_KLIEN d ON a.NOPEMEGANGPOLIS = d.NOKLIEN
					INNER JOIN $DBUser.TABEL_100_KLIEN e ON a.NOTERTANGGUNG = e.NOKLIEN
					LEFT OUTER JOIN $DBUser.TABEL_247_PERTANGGUNGAN_BASIS f ON a.PREFIXPERTANGGUNGAN = f.PREFIXPERTANGGUNGAN
						AND a.NOPERTANGGUNGAN = f.NOPERTANGGUNGAN
					LEFT OUTER JOIN $DBUser.TABEL_109_KOTAMADYA g ON d.KDKOTAMADYATETAP = g.KDKOTAMADYA
					-- LEFT OUTER JOIN $DBUser.TABEL_108_PROPINSI h ON d.KDPROPINSITETAP = h.KDPROPINSI
					LEFT OUTER JOIN $DBUser.TABEL_108_PROPINSI h ON g.KDPROPINSI = h.KDPROPINSI
					LEFT OUTER JOIN $DBUser.TABEL_001_KANTOR i ON a.PREFIXPERTANGGUNGAN = i.KDKANTOR
					LEFT OUTER JOIN $DBUser.TABEL_SPAJ_ONLINE j ON a.NOSP = j.NOSPAJ
					WHERE a.KDPERTANGGUNGAN = '2'
						AND a.PREFIXPERTANGGUNGAN = '$this->prefix'
						AND a.NOPERTANGGUNGAN = '$this->nopertanggungan'";
			$DA->parse($sql);
			$DA->execute();
			$this->arr = $DA->nextrow();
			
			
			$sql = "SELECT NVL((SELECT NVL(premi,0) 
										FROM $DBUser.TABEL_223_TRANSAKSI_PRODUK 
										WHERE prefixpertanggungan = a.prefixpertanggungan AND nopertanggungan = a.nopertanggungan 
											AND kdbenefit='BNFTOPUPSG'),0) AS premitup,
						NVL((SELECT NVL(premi,0) 
								FROM $DBUser.TABEL_223_TRANSAKSI_PRODUK
								WHERE prefixpertanggungan = a.prefixpertanggungan AND nopertanggungan = a.nopertanggungan AND kdbenefit='BNFTOPUP'),0) AS premitub 
					FROM $DBUser.TABEL_200_PERTANGGUNGAN a 
					WHERE a.prefixpertanggungan = '$this->prefix' AND a.nopertanggungan = '$this->nopertanggungan'";
			$DA->parse($sql);
			$DA->execute();
			$this->arrs = $DA->nextrow();
			
			$sql = "SELECT SUM(a.premi) AS premi2jsap 
					FROM $DBUser.TABEL_223_TRANSAKSI_PRODUK a
					INNER JOIN $DBUser.TABEL_200_PERTANGGUNGAN b ON a.PREFIXPERTANGGUNGAN = b.PREFIXPERTANGGUNGAN
						AND a.NOPERTANGGUNGAN = b.NOPERTANGGUNGAN
					WHERE  a.kdjenisbenefit in ('U') AND a.prefixpertanggungan = '$this->prefix' 
						AND a.nopertanggungan = '$this->nopertanggungan'";
			$DA->parse($sql);
			$DA->execute();
			$this->arrr = $DA->nextrow();
			
			/*===== penerima manfaat asuransi =====*/
			$sql = "SELECT a.NOTERTANGGUNG, a.NOURUT, a.KDINSURABLE, a.NOKLIEN,
						DECODE (b.namahubungan, 'DIRI TERTANGGUNG', 'TERTANGGUNG', 'ANAK YG DIBEASISWAKAN', b.namahubungan, 'PEMEGANG POLIS', b.namahubungan, b.namahubungan || ' TERTANGGUNG') AS NAMAHUBUNGAN,
						c.NAMAKLIEN1 || DECODE (c.GELAR, NULL, NULL, ', ' || c.GELAR) AS NAMAKLIEN1
					FROM $DBUser.TABEL_219_PEMEGANG_POLIS_BAW a
					INNER JOIN $DBUser.TABEL_218_KODE_HUBUNGAN b ON a.KDINSURABLE = b.KDHUBUNGAN
					INNER JOIN $DBUser.TABEL_100_KLIEN c ON a.NOKLIEN = c.NOKLIEN
					WHERE a.PREFIXPERTANGGUNGAN = '$this->prefix'
						AND a.NOPERTANGGUNGAN = '$this->nopertanggungan'
					ORDER BY a.NOURUT";
			$DA->parse($sql);
			$DA->execute();
			$data = array();
			while($value = $DA->nextrow()) {
				$data[] = $value;
			}
			$this->ars = $data;
			
			/*===== asuransi tambahan =====*/
			$sql = "SELECT MIN (nilaibenefit) nilaibenefit,
						kdbnfx,
						DECODE (SUBSTR (kdbnfx, 1, 4),
							'HCPB', 'HCP PLUS BEDAH',
							'HCPM', 'HCP MURNI',
							'SP-D','JS SPOUSE PAYOR DB',
							'SP-T','JS SPOUSE PAYOR TPD',
							'PB-D','JS PAYOR DB',
							'PB-T','JS PAYOR TPD',
							MAX((SELECT MAX (namabenefit)
								 FROM $DBUser.TABEL_207_KODE_BENEFIT
								 WHERE   kdbenefit = xx.kdbnfx))) AS namabenefit,
						DECODE (SUBSTR (kdbnfx, 1, 2),
							'SP','TAMBAHAN',
							'PB','TAMBAHAN','UTAMA') AS ATAS,
						max(exp) AS exp
					FROM (
						SELECT nilaibenefit, EXP, kdbnf, 
							CASE
								WHEN x > 0 AND SUBSTR (kdbnf, 1, 3) = 'HCP'
									THEN
										'HCPB' || SUBSTR (kdbnf, -3)
								WHEN x = 0 AND SUBSTR (kdbnf, 1, 3) = 'CPM'
									THEN
										'HCPM' || SUBSTR (kdbnf, -3)
								ELSE
									kdbnf
							END AS kdbnfx
						FROM (
							SELECT nilaibenefit,
								(SELECT NVL (KDASALBENEFIT, KDBENEFIT)
								 FROM $DBUser.TABEL_206_PRODUK_BENEFIT
								 WHERE   KDPRODUK = A.KDPRODUK
									  AND KDBENEFIT = A.KDBENEFIT)
								KDBNF,
								TO_CHAR (a.expirasi, 'dd/mm/yyyy') EXP, 
									(SELECT COUNT (*)
									 FROM $DBUser.TABEL_223_TRANSAKSI_PRODUK
									 WHERE PREFIXPERTANGGUNGAN = a.PREFIXPERTANGGUNGAN
										 AND NOPERTANGGUNGAN = a.NOPERTANGGUNGAN AND kdbenefit LIKE 'CPB%') AS x
							FROM $DBUser.TABEL_223_TRANSAKSI_PRODUK A,
							$DBUser.TABEL_207_KODE_BENEFIT B
							WHERE   PREFIXPERTANGGUNGAN = '$this->prefix'
								AND NOPERTANGGUNGAN = '$this->nopertanggungan'
								AND A.KDJENISBENEFIT = 'R'
								AND A.KDBENEFIT NOT LIKE '%ICU%'
								AND A.KDBENEFIT = B.KDBENEFIT
								AND A.KDBENEFIT NOT IN ('GADPOL', 'JAMLKP'))
					) xx
					GROUP BY kdbnfx";
			$DA->parse($sql);
			$DA->execute();
			$data = array();
			while($value = $DA->nextrow()) {
				$data[] = $value;
			}
			$this->art = $data;
			
			/*===== ketentuan polis token-token =====*/
			$sql = "SELECT juamainproduk AS jua, $DBUser.terbilang(juamainproduk) AS juaterbilang, 
						TO_CHAR(mulas,'DD/MM/YYYY') AS mulas, TO_CHAR(expirasi,'DD/MM/YYYY') AS expirasi, 
						premi1, premi2,
						DECODE (b.kdcarabayar, 'E', 5, 'J', 10, lamapembpremi_th) pt,
						DECODE (b.kdcarabayar, 'E', 0, 'J', 0, lamapembpremi_bl) ptb, usia_th,
						b.kdproduk, b.kdvaluta,
						(SELECT notasi FROM $DBUser.tabel_304_valuta za WHERE za.kdvaluta = b.kdvaluta) AS notasi,
						(SELECT namaproduk FROM $DBUser.tabel_202_produk zb WHERE zb.kdproduk = b.kdproduk) AS namaproduk,
						b.kdcarabayar, TO_CHAR(ADD_MONTHS(mulas, 1), 'DD/MM/YYYY') tglmulaipremi,
						TO_CHAR(b.tglakhirpremi,'DD/MM/YYYY') AS tglakhirpremi, 
						DECODE (a.meritalstatus, 'L', 'B', 'K', 'K', 'D', 'B', 'J', 'B', '*') bk,
						c.kdbasispremi, c.kdbasistebus, c.kdbasisskg, c.kdbasiscwa, c.kdbasisbayar,
						to_char(TRUNC(((10 * DECODE (b.kdcarabayar, 'E', 5, 'J', 10, lamapembpremi_th)) + (0.83 * DECODE (b.kdcarabayar, 'E', 0, 'J', 0, lamapembpremi_bl)) + 100),1)) AS DM0PROSEN
					FROM $DBUser.TABEL_100_KLIEN a
					INNER JOIN $DBUser.TABEL_200_PERTANGGUNGAN b ON a.NOKLIEN = b.NOTERTANGGUNG
					INNER JOIN $DBUser.TABEL_247_PERTANGGUNGAN_BASIS c ON b.PREFIXPERTANGGUNGAN = c.PREFIXPERTANGGUNGAN 
						AND b.NOPERTANGGUNGAN = c.NOPERTANGGUNGAN
					WHERE b.PREFIXPERTANGGUNGAN = '$this->prefix'
						AND b.NOPERTANGGUNGAN = '$this->nopertanggungan'";
			$DA->parse($sql);
			$DA->execute();
			$this->arrp = $DA->nextrow();
			
			$sql = "SELECT kdbenefit,nilaibenefit, to_char(expirasi,'DD/MM/YYYY') AS expirasi, 
						to_char(expirasi,'MM/YYYY') AS expirasib, to_char(akhirpmb,'MM/YYYY') AS akhirpmb
					FROM $DBUser.tabel_223_transaksi_produk
					WHERE prefixpertanggungan='$this->prefix'
						AND nopertanggungan='$this->nopertanggungan'";
			$DA->parse($sql);
			$DA->execute();
			$data = array();
			while($value = $DA->nextrow()) {
				$data[] = $value;
			}
			$this->arrp2 = $data;
			
			/*===== ketentuan polis redaksi =====*/
			$sql = "SELECT b.noparagraph, b.kdparagraph, b.judul, b.teks
					FROM $DBUser.tabel_239_redaksi_produk a, $DBUser.tabel_298_redaksi_ b
					WHERE a.kdproduk='".$this->arrp['KDPRODUK']."' AND a.kdvaluta='".$this->arrp['KDVALUTA']."'
						  AND a.kdcarabayar='".($this->arrp['KDCARABAYAR'] == 'X' ? 'X' : 'B')."' AND a.bk IN ('".$this->arrp['BK']."','*')
						  AND a.kdredaksi=b.kdredaksi
						  AND TO_DATE('".$this->arr['MULAS']."', 'dd/mm/yyyy') BETWEEN periodeawal AND periodeakhir
					ORDER BY b.noparagraph";
			//echo $sql;
			$DA->parse($sql);
			$DA->execute();
			$data = array();
			while($value = $DA->nextrow()) {
				$data[] = $value;
			}
			$this->arrk = $data;

			/*===== nilai tebus/ekspirasi (header) =====*/
			$sql = "SELECT a.kdproduk, a.kdvaluta, DECODE(a.kdproduk, 'DMP', a.lamaasuransi_th, 'JSPEI5', a.lamaasuransi_th, 'JSPEIP', a.lamaasuransi_th, a.lamapembpremi_th) AS LPP,
						a.usia_th,
						DECODE(a.kdcarabayar, 'X', 'X', 'E', 'E', 'J', 'J', 'M', 'M', 'Q', 'Q', 'H', 'H', 'A', 'A', '1', 'M', 'B') AS cbyr,
						DECODE(a.kdproduk, 'JSPEI5', premi1, 'JSPEIP', premi1, 'JSSPO7A', (premi1/0.76923), 'JSSPO8', (premi1/0.76923), 'JSSPO9', (premi1/0.76923),
						    'JSGTP',(SELECT jualama FROM $DBUser.polis_history_jua WHERE prefixpertanggungan = a.prefixpertanggungan AND nopertanggungan = a.nopertanggungan AND tglmutasi = (SELECT MAX(tglmutasi) FROM $DBUser.polis_history_jua WHERE prefixpertanggungan = a.prefixpertanggungan AND nopertanggungan = a.nopertanggungan)),
						    a.juamainproduk) AS jua,
						NVL((SELECT SUM(za.juabebaspremi) FROM $DBUser.tabel_603_mutasi_pert za WHERE za.prefixpertanggungan=a.prefixpertanggungan AND za.nopertanggungan=a.nopertanggungan),0) AS juabp,
						CASE WHEN SUBSTR(a.kdproduk,1,5) = 'AJSPP' THEN b.kdbasistebus || '-2' ELSE b.kdbasistebus END kdbasistebus
					FROM $DBUser.TABEL_200_PERTANGGUNGAN a
					INNER JOIN $DBUser.TABEL_247_PERTANGGUNGAN_BASIS b ON a.PREFIXPERTANGGUNGAN = b.PREFIXPERTANGGUNGAN
						AND a.NOPERTANGGUNGAN = b.NOPERTANGGUNGAN
					WHERE a.PREFIXPERTANGGUNGAN = '$this->prefix'
						AND a.NOPERTANGGUNGAN = '$this->nopertanggungan'";
			$DA->parse($sql);
			$DA->execute();
			$this->arrt = $DA->nextrow();
			
			/*===== nilai tebus/ekspirasi (detail) =====*/
			$kp				   = $this->arrt['KDPRODUK'];
			$this->arrt['LPP'] = ($kp == "HTB" || $kp == "HTK" || $kp == "HTS" || $kp == "HTT" || $kp == "ADB" || 
								 $kp == "ADK" || $kp == "ADS" || $kp == "ADT" || $kp == "ADX") && $this->arrt['LPP'] > 20
							   ? 20 : $this->arrt['LPP'];
			$this->flag_dst	   = ($kp == "HTB" || $kp == "HTK" || $kp == "HTS" || $kp == "HTT" || $kp == "ADB" || 
								 $kp == "ADK" || $kp == "ADS" || $kp == "ADT" || $kp == "ADX" && $this->arrt['LPP']) > 20
							   ? true : false;
			$sql = "SELECT a.t, a.tarif, NVL(b.tarif, 0) as tarifs
					FROM $DBUser.TABEL_231_TARIF_TEBUS a
					LEFT OUTER JOIN $DBUser.TABEL_231_tarif_tebus b ON a.kdproduk = b.kdproduk
						AND a.masa = b.masa AND a.usia = b.usia AND a.kdvaluta = b.kdvaluta
						AND b.cara = 'X' AND a.kdbasis = b.kdbasis AND a.kdtarif = b.kdtarif AND a.t = b.t
					WHERE a.kdproduk = '".$this->arrt['KDPRODUK']."' AND a.masa = '".$this->arrt['LPP']."'
						AND a.usia = '".$this->arrt['USIA_TH']."' AND a.kdvaluta = '".$this->arrt['KDVALUTA']."' 
						AND a.cara = '".$this->arrt['CBYR']."' AND a.kdbasis = '".$this->arrt['KDBASISTEBUS']."' 
						AND a.kdtarif = 'TEBUS'
					ORDER BY a.t";
			$DA->parse($sql); //echo $sql;
			$DA->execute();
			$data = array();
			while($value = $DA->nextrow()) {
				$data[] = $value;
			}
			$this->arrt2 = $data;
			
			/*===== lakukan pengecekan terhadap cash plan =====*/
			$sql = "SELECT COUNT(1) AS CP
					FROM $DBUser.TABEL_223_TRANSAKSI_PRODUK
					WHERE PREFIXPERTANGGUNGAN = '$this->prefix'
						AND NOPERTANGGUNGAN = '$this->nopertanggungan'
						AND KDPRODUK = '$kp'
						AND KDBENEFIT LIKE 'CP%'";
			$DA->parse($sql);
			$DA->execute();
			$cp = $DA->nextrow();
			$this->cash_plan = $cp['CP'];
			
			/*===== asuransi tambahan =====*/
			$sql = "SELECT KDPRODUK, KDBENEFIT, NAMABENEFIT, MAX(LAMAPERIODE) 
					FROM (
						SELECT KDPRODUK, KDBENEFIT, NAMABENEFIT, LAMAPERIODE
						FROM (
							SELECT a.kdproduk,
								DECODE (SUBSTR (a.kdbenefit, 1, 2), 
								'CP', 'HCP',
								NVL(a.KDASALBENEFIT,a.kdbenefit)) AS kdbenefit, 
								DECODE (SUBSTR (a.kdbenefit, 1, 2), 'CP', 'JS HOSPITAL CASH PLAN', b.namabenefit) AS namabenefit, 
								lamaperiode
							FROM $DBUser.tabel_206_produk_benefit a, $DBUser.tabel_207_kode_benefit b
							WHERE a.kdbenefit = b.kdbenefit
								AND a.kdproduk = 'JL4B'
								AND a.kdjenisbenefit = 'R'
								AND b.kdbenefit <> 'RATEUP'
								AND b.kdkelompokbenefit IN ('B', 'E', 'D', 'T', 'C', 'R')
								AND b.faktorbenefit <> 'X'
								AND DECODE (SUBSTR (a.kdbenefit, 1, 2), 'CP', 'HCP', a.kdbenefit) NOT IN (
									SELECT   DECODE (SUBSTR (kdbenefit, 1, 2), 'CP', 'HCP', kdbenefit)
									FROM   $DBUser.tabel_223_transaksi_produk
									WHERE   prefixpertanggungan = '$this->prefix' AND nopertanggungan = '$this->nopertanggungan')
						)
						GROUP BY   KDPRODUK, KDBENEFIT, NAMABENEFIT,LAMAPERIODE
					)
					GROUP BY KDPRODUK, KDBENEFIT, NAMABENEFIT
					ORDER BY max(LAMAPERIODE)";
			$DA->parse($sql);
			$DA->execute();
			$data = array();
			while($value = $DA->nextrow()) {
				$data[] = $value;
			}
			$this->arrat = $data;
			
			/*===== historis cetakan polis =====*/
			$sql = "SELECT CASE WHEN (
							SELECT COUNT(KDMUTASI)
							FROM $DBUser.TABEL_603_MUTASI_PERT 
							WHERE PREFIXPERTANGGUNGAN = '$this->prefix' AND NOPERTANGGUNGAN = '$this->nopertanggungan' AND KDMUTASI IN ('28')
						) > 0 THEN '99' 
						ELSE (
							SELECT LPAD(COUNT(KDMUTASI), 2, '0') 
							FROM $DBUser.TABEL_603_MUTASI_PERT 
							WHERE PREFIXPERTANGGUNGAN = '$this->prefix' AND NOPERTANGGUNGAN = '$this->nopertanggungan' AND KDMUTASI IN ('32', '33') 
						)END AS KDCETAK
					FROM DUAL";
			$DA->parse($sql);
			$DA->execute();
			$this->arrmp = $DA->nextrow();
		}
		
		public function SPAJ() {
			$this->AddPage();
			
			$arr			= $this->arr;
			
			/*$today			= date("j-g-Y");*/
			/*$premi_standard = $arrr["PREMI2JSAP"];*/
			/*$premi_2_jsap	= $arrr["PREMI2JSAP"];*/
			/*$lama_premi		= $arr["LAMAPEMBPREMI_TH"];*/
			/*$kd_produk		= $arr["KDPRODUK"];*/
			/*$kd_ht			= substr($kd_produk, 0, 2);*/
			/*$kd_sts_medical = $arr["KDSTATUSMEDICAL"];*/
			/*$kd_cara_bayar	= $arr["KDCARABAYAR"];*/
			$nama_agen		= $arr["NAMAAGEN"];
			$ktr_agen		= $arr["KTRAGEN"];
			$nama_pejabat	= strpos($arr["NAMAPEJABAT"], ',') > 0 
							? ucwords(strtolower(substr($arr["NAMAPEJABAT"], 0, strpos($arr["NAMAPEJABAT"], ','))))
							. substr($arr["NAMAPEJABAT"], strpos($arr["NAMAPEJABAT"], ","))
							: ucwords(strtolower($arr["NAMAPEJABAT"]));
			$nama_jabatan	= ucwords(strtolower($arr["NAMAJABATAN"]));
			/*$extra_premi	= 5;*/
			/*$sisa_bayar		= $lama_premi - $extra_premi;*/
			$tgl_cetak		= $arr["TGLCETAK"];
			/*$faktor_bayar	= $arr["FAKTORBAYAR"];*/
			/*$macam_polis	= $arr["KDVALUTA"] == 0 ? "RUPIAH DENGAN INDEX" 
							: ($arr["KDVALUTA"] == 1 ? "RUPIAH TANPA INDEX" 
							: ($arr['KDVALUTA'] == 3 ? "US DOLLAR" : NULL));*/
			/*$premi1			= $kd_produk == "JSAP1" && $kd_produk == "JSAP2" ? $premi1jsap * $faktor_bayar : $arr["PREMI1"];*/
			/*$premi2			= $kd_produk == "JSAP1" && $kd_produk == "JSAP2" ? $premi_2_jsap * $faktor_bayar : $arr["PREMI2"];*/
			/*$besarnya		= $kd_cara_bayar == "X" || $kd_cara_bayar == "E" || $kd_cara_bayar == "J"  || $kd_sts_medical == "M" || $kd_ht == "HT" || $lama_premi < 5
							? $arr['NOTASI']." ".number_format($premi1, 2)." DIBAYAR SECARA ".$arr["NAMACARABAYAR"]
							: $arr['NOTASI']." ".number_format($premi1, 2)." DIBAYAR SECARA ".$arr["NAMACARABAYAR"]." SELAMA 5 TAHUN "." DAN ".$arr["NOTASI"]." ".number_format($premi2,2)." UNTUK ".$sisabayar." TAHUN BERIKUTNYA ";*/
			/*$macas			= $arr["KDPRODUK"]=='JL4B' ? "Regular"
							: ($arr["KDPRODUK"]=='JL4X' ? "Single" : NULL);*/
			/*$klien			= new Klien($this->user_id, $this->password, $arr["NOPEMEGANGPOLIS"]);*/
			$height			= $this->height;
			
			$this->SetFont('Arial','B',14);
			$this->Cell($this->pg_w, $height, 'POLIS ASURANSI JIWA', 0, 1, 'C');
			$this->SetFont('Arial','B',10);
			$this->Cell($this->pg_w, $height, "NOMOR POLIS : ".$this->arr['NOPOLBARU'], 0, 0, 'C');
			
			
			$this->Ln(10);
			
			
			$this->font_title('B');
			$this->Cell($this->pg_w, $height, 'PT ASURANSI JIWA IFG', 0, 1, 'C');
			$this->custom_font(8,'');
			$this->Cell($this->pg_w, $height, 'BERKEDUDUKAN DI JAKARTA', 0, 1, 'C');
			$this->Cell($this->pg_w, $height, "SELANJUTNYA DISEBUT PENANGGUNG", 0, 0, 'C');
			
			
			$this->Ln(5);
			
			
			$this->font_body();
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell($this->pg_w-$this->num_space-102, $height, "Atas Surat Permohonan Asuransi Jiwa (SPAJ) nomor : ", 0);
			$this->font_body('B');
			$x1 = $this->GetX();
			$this->Write(5, $arr["NOSP"]);
			$x2 = $this->GetX();
			$y1 = $this->GetY();
			$this->font_body();
			$this->MultiCell($this->pg_w-($this->num_space*2)-($x2-$x1)-($this->pg_w-$this->num_space-102), 5, ", beserta semua pernyataan dan keterangan yang ****************************", 0, 'J');
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->SetXY($this->GetX(), $y1+5);
			$this->SetFillColor(255,255,255);
			$this->MultiCell($this->pg_w-($this->num_space*2), 5, "disampaikan oleh:", 0, 'J', true);
			
			$this->Ln(5);
			
			
			$this->font_title('B');
			$this->Cell($this->pg_w, $height, $arr["PEMEGANGPOLIS"].$arr["GELARPP"], 0, 1, "C");
			$this->font_body();
			$this->Cell($this->pg_w, $height, "(Selanjutnya disebut Pemegang Polis)", 0, 1, "C");
			
			$this->Ln(5);
			
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->MultiCell($this->pg_w-($this->num_space*2), $height, $this->paragraph1, 0);
			
			
			$this->Ln(2);
			
			
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))/3, $height, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))/3, $height, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))/3, $height, "Jakarta, ".ucwords(strtolower($this->tgl_indonesia($tgl_cetak))), 0, 1, 'C');
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))/3, $height, '', 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))/3, $height, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))/3, $height, "PT ASURANSI JIWA IFG", 0, 1, 'C');
            $this->Image('./images/tandatangan.png', 130, $this->GetY()-7, 60);
			
			$this->Ln(20);
			
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$x1 = $this->GetX();
			$y1 = $this->GetY();
			$this->Cell(($this->pg_w-($this->num_space*2))/3, 5, $nama_pejabat , 0, 1, 'C');
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))/3, 4, $nama_jabatan, 0, 0, 'C');
			
			$this->SetXY($x1 + ($this->pg_w-($this->num_space*2))/3, $y1);
			
			$x1 = $this->GetX();
			$y1 = $this->GetY();
			$this->font_ttd();
			//$this->MultiCell(($this->pg_w-($this->num_space*2))/3, 3, "Bea Materai Lunas Rp 10.000 berdasarkan keputusan\nKantor Pelayanan Pajak Tanggal : xx/xxxxxx/2021\nNomor  xxx/xxx/xxxxx/xxxxxx/2021", 0, 'C', false);
			$y2 = $this->GetY();
			$yH = $y2 - $y1;
			
			$this->SetXY($x1 + ($this->pg_w-($this->num_space*2))/3, $y2 - $yH);
			$this->SetFont('Arial', '', 9);
			$this->Cell(($this->pg_w-($this->num_space*2))/3, 5, $arr['NAMADIREKTUR'], 0, 1, 'C');
			
			$this->SetXY($x1 + ($this->pg_w-($this->num_space*2))/3, $this->GetY());
			$this->Cell(($this->pg_w-($this->num_space*2))/3, 4, $arr['JABATANDIREKTUR'], 0, 1, 'C');
			
			
			$this->Ln(15);
			
			$this->font_body('B');
			$this->Cell($this->pg_w, $height, "MOHON PELAJARI POLIS INI DENGAN CERMAT", 0, 1, "C");
			
			$this->Ln(2);
			
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->font_body();
			$this->MultiCell($this->pg_w-($this->num_space*2), $height, $this->paragraph2, 0);
			
			$this->Ln(2);
			
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->font_body();
			$this->MultiCell($this->pg_w-($this->num_space*2), $height, $this->paragraph3, 0);
			
			// italic free look provision
			$this->SetXY($this->GetX()+112.2, $this->GetY()-27);
			$this->SetFont('Arial', 'I', 9);
			$this->Cell(29.3, $height, 'Free Look Provision', 0, 1, 'L', true);
			$this->SetXY($this->GetX()+35, $this->GetY()+7);
			$this->Cell(29.3, $height, 'Free Look Provision', 0, 0, 'L', true);
			
			$this->SetXY(10.00125, 199.00125);
			
			/*QRCode engine*/
			$filename = QRCODE_TEMP_DIR."/".substr(md5(md5(strtotime('now')+date("u"))), -10, 10).".png";
			$data_qrc = ('https://asuransi.ifg-life.id/scan/?q=retail&n='.base64_encode($this->prefix.$this->nopertanggungan));
			$image = new Qrcode();
			$image->setdata($data_qrc);
			$image->calculate();
			$image->save($filename);
			/*end of QRCode */
			
			$this->Image($filename, 158, 220, 30, 30);
			$this->Ln(49);
			$this->Cell($this->num_space + 140, $height, NULL, 0, 0, 'C');
			$this->SetFont('Arial', 'I', 8);
			$this->Cell(26, $height, $arr['TGLCETAKQR'].$this->arrmp['KDCETAK'], 0, 0, 'C');
			
			/*$this->Ln(69);
			$this->SetFont('Arial','',7);
			$this->Cell($this->num_space, 4, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))/4, 4, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))*3/8, 4, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))*3/8, 4, $nama_agen.'/'.$ktr_agen, 0, 1, 'L');
			$this->Cell($this->num_space, 4, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))/4, 4, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))*3/8, 4, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))*3/8, 4, $arr["KANTORFOOTER"], 0, 1, 'L');*/
		}
		
		public function DataPolis() {
			$this->AddPage();
			
			$height			= $this->height;
			$arr			= $this->arr;
			$arrs			= $this->arrs;
			$arrr			= $this->arrr;
			$kd_cara_bayar	= $arr["KDCARABAYAR"];
			$lama_premi		= $arr["LAMAPEMBPREMI_TH"];
			$sisa_lm_bayar	= $kd_cara_bayar == 'J' ? 5 : abs($arr["LAMAPEMBPREMI_TH"]) - 5;
			$kd_produk		= $arr["KDPRODUK"];
			$kd_ht			= substr($kd_produk, 0, 2);
			$kd_sts_medical = $arr["KDSTATUSMEDICAL"];
			$premi_2_jsap	= $arrr["PREMI2JSAP"];
			$faktor_bayar	= $arr["FAKTORBAYAR"];
			$premi1			= $kd_produk == "JSAP1" && $kd_produk == "JSAP2" ? $premi_1_jsap * $faktor_bayar : $arr["PREMI1"];
			$premi2			= $kd_produk == "JSAP1" && $kd_produk == "JSAP2" ? $premi_2_jsap * $faktor_bayar : $arr["PREMI2"];
			$premi_standard = $arrr["PREMI2JSAP"];
			$tgl_expirasi_p	= $this->arrp['TGLAKHIRPREMI']; // edited $kd_produk == "JSP" ? date('d/m/Y', strtotime($arr['EXPIRASI']." -5 year")) : $arr['EXPIRASI'];
			
			
			//foreach($this->arrp2 as $i => $value2) {
				if (in_array($arr['KDPRODUK'], array('APP65','APP75','APP85'))) {
					$akhirasuransi = $arr['EXPIRASI']; 
					$akhirasuransiText = $arr['LAMAASURANSI_TH']." Tahun, {$arr['LAMAASURANSI_BL']} Bulan";
					//break;
				} else {
					$akhirasuransi = '-';
					$akhirasuransiText = "Seumur Hidup";
				}
			//}

			$this->font_title('B');
			$this->Cell($this->pg_w, $height, 'DATA POLIS', 0, 1, 'C');
			$this->Cell($this->pg_w, $height, "NOMOR : ".$this->arr['NOPOLBARU'], 0, 0, 'C');
			
			
			$this->Ln(15);
			
			
			$this->SetFont('Arial','B',9);
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))*7/25, $height, "Nama Pemegang Polis", 0, 0, 'L');
			$this->Cell(($this->pg_w-($this->num_space*2))/25, $height, ":", 0, 0, 'L');
			$this->Cell(($this->pg_w-($this->num_space*2))*17/25, $height, $arr["PEMEGANGPOLIS"].$arr["GELARPP"], 0, 1, 'L');
			//TAMBAHAN CRF - 30/01/2020 - TEGUH
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
            $this->Cell(($this->pg_w-($this->num_space*2))*7/25, $height, "Nomor Induk Kependudukan", 0, 0, 'L');
            $this->Cell(($this->pg_w-($this->num_space*2))/25, $height, ":", 0, 0, 'L');
            $this->Cell(($this->pg_w-($this->num_space*2))*17/25, $height, $arr["NOID"], 0, 1, 'L');
            //
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))*7/25, $height, "Alamat Pemegang Polis", 0, 0, 'L');
			$this->Cell(($this->pg_w-($this->num_space*2))/25, $height, ":", 0, 0, 'L');
			//$this->Cell(($this->pg_w-($this->num_space*2))*17/25, $height, $arr["ALAMATPEMPOL"], 1, 1, 'L');
			$this->MultiCell(($this->pg_w-($this->num_space*2))*17/25, 5, $arr["ALAMATPEMPOL"], 0, 'L', true);
			//
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))*7/25, $height, "Macam Asuransi", 0, 0, 'L');
			$this->Cell(($this->pg_w-($this->num_space*2))/25, $height, ":", 0, 0, 'L');
			$this->Cell(($this->pg_w-($this->num_space*2))*17/25, $height, $arr["NAMAPRODUK"], 0, 1, 'L');
			//
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))*7/25, $height, "Masa Asuransi", 0, 0, 'L');
			$this->Cell(($this->pg_w-($this->num_space*2))/25, $height, ":", 0, 0, 'L');
			$this->SetFont('Arial','',9);
			$this->Cell(($this->pg_w-($this->num_space*2))*17/25, $height, $akhirasuransiText, 0, 1, 'L');
			//
			$this->SetFont('Arial','B',9);
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))*7/25, $height, "Anuitas Sebulan", 0, 0, 'L');
			$this->Cell(($this->pg_w-($this->num_space*2))/25, $height, ":", 0, 0, 'L');
			$this->SetFont('Arial','',9);
			$this->Cell(($this->pg_w-($this->num_space*2))*17/25, $height, "Rp".number_format($arr["JUAMAINPRODUK"],2,",","."), 0, 1, 'L');
			//
			$this->SetFont('Arial','B',9);
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))*7/25, $height, "Valuta", 0, 0, 'L');
			$this->Cell(($this->pg_w-($this->num_space*2))/25, $height, ":", 0, 0, 'L');
			$this->SetFont('Arial','',9);
			$this->Cell(($this->pg_w-($this->num_space*2))*17/25, $height, $arr["NAMAVALUTA"], 0, 1, 'L');
			//
			$this->SetFont('Arial','B',9);
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))*7/25, $height, "Premi", 0, 0, 'L');
			$this->Cell(($this->pg_w-($this->num_space*2))/25, $height, ":", 0, 0, 'L');
			//$this->Cell(($this->pg_w-($this->num_space*2))/25, $height, "Rp.", 0, 0, 'L');
			$this->SetFont('Arial','',9);
			if ($kd_cara_bayar == "X" /*|| $kd_cara_bayar == "E" || $kd_cara_bayar == "J"*/ || $kd_sts_medical == "M" || $kd_ht == "HT" || $lama_premi < 5) {
				$this->Cell(($this->pg_w-($this->num_space*2))*17/25, $height, "Rp".number_format($premi1,2,",","."), 0, 1, 'L');
			}
			else if ($premi2 > 0) {
				$this->Cell(($this->pg_w-($this->num_space*2))*17/25, $height, "Rp".number_format($premi1,2,",",".")." DIBAYAR UNTUK 5 TAHUN PERTAMA", 0, 1, 'L'); // $premi_standard -> $premi1
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				$this->Cell(($this->pg_w-($this->num_space*2))*8/25, $height, NULL, 0, 0, 'L');
				$this->Cell(($this->pg_w-($this->num_space*2))*17/25, $height, "DAN Rp".number_format($premi2,2,",",".")." UNTUK ".$sisa_lm_bayar." TAHUN BERIKUTNYA", 0, 1, 'L');
			}
			else {
				$this->Cell(($this->pg_w-($this->num_space*2))*16/25, $height, number_format($premi_standard,2,",",".")." DIBAYAR UNTUK 5 TAHUN PERTAMA", 0, 1, 'L');
			}
			/*
			$this->SetFont('Arial','B',9);
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))*7/25, $height, "Nomor Host to Host", 0, 0, 'L');
			$this->Cell(($this->pg_w-($this->num_space*2))/25, $height, ":", 0, 0, 'L');
			$this->SetFont('Arial','',9);
			$this->Cell(($this->pg_w-($this->num_space*2))*17/25, $height, $arr["KDMAPPING"].$arr['NOPERTANGGUNGAN'], 0, 1, 'L');
			*/
			if($arr["KDPRODUK"] == 'JL4B') {
				$this->SetFont('Arial','B',9);
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				$this->Cell(($this->pg_w-($this->num_space*2))*7/25, $height, "Top Up Reguler", 0, 0, 'L');
				$this->Cell(($this->pg_w-($this->num_space*2))/25, $height, ":", 0, 0, 'L');
				$this->Cell(($this->pg_w-($this->num_space*2))/25, $height, "Rp.", 0, 0, 'L');
				$this->SetFont('Arial','',9);
				$this->Cell(($this->pg_w-($this->num_space*2))*16/25, $height, number_format($arrs["PREMITUB"],2,",","."), 0, 1, 'L');
			}
			/*Akhir tambahan topup  oleh Dedi 19/03/2014*/
			//
			$this->SetFont('Arial','B',9);
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))*7/25, $height, "Cara Bayar Premi", 0, 0, 'L');
			$this->Cell(($this->pg_w-($this->num_space*2))/25, $height, ":", 0, 0, 'L');
			$this->SetFont('Arial','',9);
			$this->Cell(($this->pg_w-($this->num_space*2))*17/25, $height, $arr["NAMACARABAYAR"], 0, 1, 'L');
			
			
			$this->Ln(4);
			
			
			$this->SetFont('Arial','B',9);
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell($this->pg_w-($this->num_space*2), $height, "Penerima Manfaat Anuitas", 0, 1, 'L');
			$this->SetFont('Arial','',9);
			
			foreach($this->ars as $value) {
				$nama = strlen($value["GELAR"]) == 0 ? $value["NAMAKLIEN1"].",".$value["GELAR"] : $value["NAMAKLIEN1"];
				$hub  = $value["KDINSURABLE"] == '04' 
					  ? ($ars["NOKLIEN"] == $ars["NOTERTANGGUNG"] ? "DIRI TERTANGGUNG" : "BELUM DIDEFINISIKAN")
					  : $ars["NAMAHUBUNGAN"];
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				$this->Cell($this->pg_w-($this->num_space*2), $height, trim($value["NOURUT"]).". ".trim($value["NAMAHUBUNGAN"]).", ".trim($nama), 0, 1, 'L');
			}
			
			
			$this->Ln(4);
			
			$this->SetFont('Arial','B',9);
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))*7/25, $height, "Nama Tertanggung", 0, 0, 'L');
			$this->Cell(($this->pg_w-($this->num_space*2))/25, $height, ":", 0, 0, 'L');
			
			$x = $this->GetX();
			$y = $this->GetY();
			
			$this->SetFont('Arial','',9);
			$this->SetXY($x, $y);
			$this->MultiCell(($this->pg_w-($this->num_space*2))*9/25, $height, $arr["TERTANGGUNG"].$arr["GELARTTG"], 0, 'L');
			$this->SetXY($x + ($this->pg_w-($this->num_space*2))*9/25, $y);
			$this->SetFont('Arial','B',9);
			$this->Cell(($this->pg_w-($this->num_space*2))*4/25, $height, "Tanggal Lahir", 0, 0, 'L');
			$this->Cell(($this->pg_w-($this->num_space*2))/25, $height, ":", 0, 0, 'L');
			$this->SetFont('Arial','',9);
			$this->Cell(($this->pg_w-($this->num_space*2))*3/25, $height, $arr["TGLLAHIRTT"], 0, 1, 'L');
			
			if(strlen($arr["TERTANGGUNG"].$arr["GELARTTG"]) > 40){
				$this->ln();
			}
			
			
			// ========================================== Changes =================================================
			
			
			//
			$this->SetFont('Arial','B',9);
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))*7/25, $height, "Nama Pemegang Polis", 0, 0, 'L');
			$this->Cell(($this->pg_w-($this->num_space*2))/25, $height, ":", 0, 0, 'L');
			
			$x = $this->GetX();
			$y = $this->GetY();
			
			$this->SetFont('Arial','',9);
			$this->SetXY($x, $y);
			$this->MultiCell(($this->pg_w-($this->num_space*2))*9/25, $height, $arr["PEMEGANGPOLIS"].$arr["GELARPP"], 0, 'L');
			$this->SetFont('Arial','B',9);
			$this->SetXY($x + ($this->pg_w-($this->num_space*2))*9/25, $y);
			$this->Cell(($this->pg_w-($this->num_space*2))*4/25, $height, "Tanggal Lahir", 0, 0, 'L');
			$this->Cell(($this->pg_w-($this->num_space*2))/25, $height, ":", 0, 0, 'L');
			$this->SetFont('Arial','',9);
			$this->Cell(($this->pg_w-($this->num_space*2))*3/25, $height, $arr["TGLLAHIR"], 0, 1, 'L');
			
			if(strlen($arr["TERTANGGUNG"].$arr["GELARTTG"]) > 40){
				$this->ln();
			}
			
			$this->Ln(3);
			
			
			$this->SetFont('Arial','B',8);
			$this->SetFillColor(224,224,224);
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Cell(($this->pg_w-($this->num_space*2))*7/25, $height*3, "Macam Asuransi", 0, 0, 'C', true);
			
			$x1 = $this->GetX();
			$y1 = $this->GetY();
			$this->MultiCell(($this->pg_w-($this->num_space*2))*3/25, 5, "Ketentuan &\nManfaat di", 0, 'C', true);
			$y2 = $this->GetY();
			$yH = $y2 - $y1;
			
			$this->SetXY($x1 + ($this->pg_w-($this->num_space*2))*3/25, $y2 - $yH);
			
			$this->Cell(($this->pg_w-($this->num_space*2))*6/25, $height*3, "Anuitas Sebulan", 0, 0, 'C', true);
			
			$x1 = $this->GetX();
			$y1 = $this->GetY();
			$this->MultiCell(($this->pg_w-($this->num_space*2))*5/25, 5, "Tanggal Mulai\nAsuransi\n ", 0, 'C', true);
			$y2 = $this->GetY();
			$yH = $y2 - $y1;
			
			$this->SetXY($x1 + ($this->pg_w-($this->num_space*2))*5/25, $y2 - $yH);
			/*
			$x1 = $this->GetX();
			$y1 = $this->GetY();
			$this->MultiCell(($this->pg_w-($this->num_space*2))*4/25, 5, "Akhir\nPembayaran\nPremi", 0, 'C', true);
			$y2 = $this->GetY();
			$yH = $y2 - $y1;
			
			$this->SetXY($x1 + ($this->pg_w-($this->num_space*2))*4/25, $y2 - $yH);
			*/
			$this->MultiCell(($this->pg_w-($this->num_space*2))*4/25, 5, "Tanggal Akhir\nAsuransi\n ", 0, 'C', true);
			
			$this->SetXY($x, $y + $height*2);
			$this->Cell(($this->pg_w-($this->num_space*2))*18/25, $height, NULL, 0, 1, 'C', true);
			
			
			$this->Ln(4);
			
			
			/*$this->SetFont('Arial','B',9);
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2)), $height, "ASURANSI DASAR", 0, 1, 'L');
			$this->Ln(1);*/
			//
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->SetFont('Arial','',7);
			
			$x1 = $this->GetX();
			$y1 = $this->GetY();
			$this->MultiCell(($this->pg_w-($this->num_space*2))*7/25, 4, $arr["NAMAPRODUK"], 0, 'L');
			$y2 = $this->GetY();
			$yH = $y2 - $y1;
			
			$this->SetXY($x1 + ($this->pg_w-($this->num_space*2))*7/25, $y2 - $yH);
			
			$y = $this->GetY();
			$h = $y2 == $this->GetY ? 4 : $y2 - $y;
			$x1 = $this->GetX();
			$y1 = $this->GetY();
			$this->MultiCell(($this->pg_w-($this->num_space*2))*3/25, $h, "SUP\nKK", 0, 'C');
			$y2 = $this->GetY();
			$yH = $y2 - $y1;
			
			$this->SetXY($x1 + ($this->pg_w-($this->num_space*2))*3/25, $y2 - $yH);
			
			$this->Cell(($this->pg_w-($this->num_space*2))*4/25, $h*2, "Rp".number_format($arr["JUAMAINPRODUK"], 2, ",", "."), 0, 0, 'R');
			$this->Cell(($this->pg_w-($this->num_space*2))*9/25, $h*2, $arr['MULAS'], 0, 0, 'C');
			//$this->Cell(($this->pg_w-($this->num_space*2))*4/25, $h*2, '-', 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))*0.1/25, $h*2, $akhirasuransi, 0, 1, 'C');

			/*$this->Cell(($this->pg_w-($this->num_space*2))*4/25, $h, number_format($arr["JUAMAINPRODUK"], 2, ",", "."), 0, 0, 'R');
			$this->Cell(($this->pg_w-($this->num_space*2))*4/25, $h, $arr['MULAS'], 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))*4/25, $h, $tgl_expirasi_p, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))*3/25, $h, $arr["EXPIRASI"], 0, 1, 'C');*/
			
			
			$this->Ln(5);
			
			
			$this->SetFont('Arial','B',9);
			/*
			if (!empty($this->art)) {
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				$this->MultiCell(($this->pg_w-($this->num_space*2))*7/25, 4, "Asuransi Tambahan", 0, 'L');
				//$this->Cell(($this->pg_w-($this->num_space*2)), $height, "Asuransi Tambahan", 0, 1, 'L');
				$this->Ln(1);
				
				$this->SetFont('Arial','',7);
				foreach($this->art as $i => $value) {
					
					$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
					$this->SetFont('Arial','',7);
					
					$x1 = $this->GetX();
					$y1 = $this->GetY();
					$this->MultiCell(($this->pg_w-($this->num_space*2))*7/25, 4, trim(substr($value["NAMABENEFIT"],0,25)), 0, 'L');
					$y2 = $this->GetY();
					$yH = $y2 - $y1;
					
					$this->SetXY($x1 + ($this->pg_w-($this->num_space*2))*7/25, $y2 - $yH);
					
					$y = $this->GetY();
					$h = $y2 == $this->GetY ? 4 : $y2 - $y;
					$x1 = $this->GetX();
					$y1 = $this->GetY();
					$this->MultiCell(($this->pg_w-($this->num_space*2))*3/25, $h, trim($value["KDBNFX"]), 0, 'C');
					$y2 = $this->GetY();
					$yH = $y2 - $y1;
					
					$this->SetXY($x1 + ($this->pg_w-($this->num_space*2))*3/25, $y2 - $yH);
					
					$this->Cell(($this->pg_w-($this->num_space*2))*4/25, $h*2, number_format($value["NILAIBENEFIT"], 2, ",", "."), 0, 0, 'R');
					$this->Cell(($this->pg_w-($this->num_space*2))*9/25, $h*2, trim($value["ATAS"]), 0, 0, 'C');
					//$this->Cell(($this->pg_w-($this->num_space*2))*4/25, $h*2, '-', 0, 0, 'C');
					$this->Cell(($this->pg_w-($this->num_space*2))*1/25, $h*2, $value["EXP"], 0, 1, 'C');

					$this->Ln(1);
				}
			}
			*/
		}
		
		public function KetentuanPolis() {
			/*echo "<pre>";
	print_r ($this->arr);
	echo "</pre>";*/
			
			$this->AddPage();
			
			$height = $this->height;
			$no_h	= 1;
			$data	= array();
						
			$this->font_title('B');
			$this->Cell($this->pg_w, $height, 'LAMPIRAN POLIS', 0, 1, 'C');
			$this->Cell($this->pg_w, $height, "NOMOR POLIS : ".$this->arr['NOPOLBARU'], 0, 0, 'C');
			
			$this->Ln(15);
			
			$this->SetFont('Arial','',10);
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell($this->pg_w-($this->num_space*2), $height, "Ketentuan Pembayaran Manfaat Anuitas: ", 0, 1, 'L');
			
			$this->Ln(5);
			/*===== ketentuan sebelum nilai tebus =====*/
			// cek redaksi jika kdparagraph null atau = T, maka TOP
			foreach($this->arrp2 as $i => $value2) {
				if (@$value2['KDBENEFIT'] == 'BNFPHT') {
					$mulai1month = $value2['EXPIRASI']; 
					break;
				} else {
					$mulai1month = date('d/m/Y', strtotime("+1 month", strtotime($this->arrp['MULAS'])));
				}
			}
			$noTitle = 1;
			foreach($this->arrk as $i => $value) {
				if($this->arr['MERITALSTATUS'] != "L"){
					
					if (!$value['KDPARAGRAPH'] || $value['KDPARAGRAPH'] == 'T') {
						$judul = str_replace("{N_NMPRODUK}", $this->arr['NAMAPRODUK'], $value['JUDUL']);
						$text  = preg_replace('/[\\\\\r\n]/', '', $value["TEKS"]);
						$text  = str_replace("{NEWLINE}", "\n", $text);
						$text  = str_replace("{N_JUA}", number_format($this->arrp['JUA'], 2, ",", "."), $text);
						$text  = str_replace("{L_JUATERBILANG}", $this->arrp['JUATERBILANG'], $text);
						$text  = str_replace("{T_MULAS}", $mulai1month, $text);
						$text  = str_replace("{T_MULAS_1YEAR}", $this->arrp['MULAS_1YEAR'], $text);
						$text  = str_replace("{B_MULAS}", $this->arrp['MULAS'], $text);
						$text  = str_replace("{T_EXPIRASI}", $this->arrp['EXPIRASI'], $text);
						$text  = str_replace("{B_EXPIRASI}", substr($this->arrp['EXPIRASI'], 3), $text);
						$text  = str_replace("{N_PREMI1}", number_format($this->arrp['PREMI1'], 2, ",", "."), $text);
						$text  = str_replace("{N_PREMI2}", number_format($this->arrp['PREMI2'], 2, ",", "."), $text);
						$text  = str_replace("{N_MASA}", $this->arrp['PT'], $text);
						$text  = str_replace("{N_USIA}", $this->arrp['USIA_TH'], $text);
						$text  = str_replace("{N_KDPRODUK}", $this->arrp['KDPRODUK'], $text);
						$text  = str_replace("{N_NMPRODUK}", $this->arr['NAMAPRODUK'], $text);
						$text  = str_replace("{N_KDVALUTA}", $this->arrp['KDVALUTA'], $text);
						$text  = str_replace("{N_NOTASI}", $this->arrp['NOTASI'], $text);
						$text  = str_replace("{N_CARABAYAR}", $this->arrp['KDCARABAYAR'], $text);
						$text  = str_replace("{N_DM0PROSEN}", $this->arrp['DM0PROSEN'], $text);
						$text  = str_replace("{T_AKHPRM}", $this->arrp['TGLAKHIRPREMI'], $text);
						$text  = str_replace("{T_AKHPRM}", substr($this->arrp['TGLAKHIRPREMI'], 3), $text);
						$text  = str_replace("{T_LAMAPEMBPREMI_TH}", $this->arr["LAMAPEMBPREMI_TH"], $text);
						$text  = str_replace("{T_BNFPHT}", $this->arrp['TGLMULAIPREMI'], $text); //tambahan untuk mulai manfaat anuitas adalah 1 bulan setelah pembayaran/mulas Teguh 15/10/2019
						
						// used for unit-linked
						if ($this->arrp['KDCARABAYAR'] == '1' || $this->arrp['KDCARABAYAR'] == 'M') {
							$text = str_replace("{N_NMCB}", "PREMI BULANAN", $text);
							if (substr($this->arrp['KDPRODUK'], 0, 3) == 'JL2') {
								$text = str_replace("{N_FAKTL1}", "25 X", $text);
								$text = str_replace("{N_FAKTL65}", "20 X", $text);
							}
							else {
								$text = str_replace("{N_FAKTL1}", "25 X", $text);
								$text = str_replace("{N_FAKTL65}", "5 X", $text);
							}
						}
						else if ($this->arrp['KDCARABAYAR'] == '2' || $this->arrp['KDCARABAYAR'] == 'Q') {
							$text = str_replace("{N_NMCB}", "PREMI KUARTALAN", $text);
							if (substr($this->arrp['KDPRODUK'], 0, 3) == 'JL2') {
								$text = str_replace("{N_FAKTL1}", "8 X", $text);
								$text = str_replace("{N_FAKTL65}", "7 X", $text);
							}
							else {
								$text = str_replace("{N_FAKTL1}", "15 X", $text);
								$text = str_replace("{N_FAKTL65}", "3 X", $text);
							}
						}
						else if ($this->arrp['KDCARABAYAR'] == '3' || $this->arrp['KDCARABAYAR'] == 'H') {
							$text = str_replace("{N_NMCB}", "PREMI SEMESTERAN", $text);
							if (substr($this->arrp['KDPRODUK'], 0, 3) == 'JL2') {
								$text = str_replace("{N_FAKTL1}", "4 X", $text);
								$text = str_replace("{N_FAKTL65}", "4 X", $text);
							}
							else {
								$text = str_replace("{N_FAKTL1}", "10 X", $text);
								$text = str_replace("{N_FAKTL65}", "2 X", $text);
							}
						}
						else if ($this->arrp['KDCARABAYAR'] == '4' || $this->arrp['KDCARABAYAR'] == 'A' || $this->arrp['KDCARABAYAR'] == 'E' || $this->arrp['KDCARABAYAR'] == 'J') {
							$text = str_replace("{N_NMCB}", "PREMI TAHUNAN", $text);
							if (substr($this->arrp['KDPRODUK'], 0, 3) == 'JL2') {
								$text = str_replace("{N_FAKTL1}", "2 X", $text);
								$text = str_replace("{N_FAKTL65}", "2 X", $text);
							}
							else {
								$text = str_replace("{N_FAKTL1}", "5 X", $text);
								$text = str_replace("{N_FAKTL65}", "1 X", $text);
							}
						}
						else {
							$text = str_replace("{N_NMCB}", "PREMI SEKALIGUS", $text);
							if (substr($this->arrp['KDPRODUK'], 0, 3) == 'JL2') {
								$text = str_replace("{N_FAKTL1}", "130% X", $text);
								$text = str_replace("{N_FAKTL65}", "50% X", $text);
							}
							else {
								$text = str_replace("{N_FAKTL1}", "125% X", $text);
								$text = str_replace("{N_FAKTL65}", "10% X", $text);
							}
						}
						
						foreach($this->arrp2 as $i => $value2) {
							$text = str_replace("{N_".$value2['KDBENEFIT']."}", number_format($value2['NILAIBENEFIT'], 2, ",", "."), $text);
							$text = str_replace("{T_".$value2['KDBENEFIT']."}", $value2['EXPIRASI'], $text);
							$text = str_replace("{B_".$value2['KDBENEFIT']."}", $value2['EXPIRASIB'], $text);
							$text = str_replace("{A_".$value2['KDBENEFIT']."}", $value2['AKHIRPMB'], $text);
						}
						
						$this->font_body('B');

						// header text
						if (strpos($judul, "/}") !== false) {
							$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');

							$no = str_replace("/}", NULL, str_replace("{NUMBER=", NULL, substr($judul, 0, strpos($judul, "/}")+2)));
							$this->Cell(6, $height, $no, 0, 0, 'L');

							$judul = substr($judul, strpos($judul, "/}")+2);
							if (strpos($judul, "{STYLE=") !== false) {
								$this->font_body(str_replace("/}", NULL, str_replace("{STYLE=", NULL, substr($judul, 0, strpos($judul, "/}")+2))));
								$judul = substr($judul, strpos($judul, "/}")+2);
							}
							$this->MultiCell($this->pg_w-($this->num_space*2)-6, 5, $judul, 0, 'J');
						}
						else {
							$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
							$no	   = $no_h == 1 ? 'A. '
								   : ($no_h == 2 ? 'B. ' 
								   : ($no_h == 3 ? 'C. ' 
								   : ($no_h == 4 ? 'D. ' 
								   : ($no_h == 5 ? 'E. ' 
								   : ($no_h == 6 ? 'F. ' 
								   : ($no_h == 7 ? 'G. ' : $no_h))))));
							$this->MultiCell($this->pg_w-($this->num_space*2), 5, $no.$judul, 0, 'J');
						}
						
						// $addpage true jika {ADDPAGE} ditemukan
						if (strpos($text, "{ADDPAGE}") !== false) {
							$addpage = true;
							$text = str_replace("{ADDPAGE}", "", $text);
						}
						else {
							$addpage = false;
						}

						// untuk menghapus produk js prestasi tahapan beasiswa yang 0
						/*=== catatan harus sama = ", sebesar Rp.0,00" tanpa tanda kutip ===*/
						$tahapan0 = strpos($text, ', sebesar Rp.0,00');
						if ($tahapan0 > 0) {
							$replace_tahapan = substr($text, $tahapan0-30, 48);
							$text = str_replace($replace_tahapan, '', $text);
						}
						
						// untuk indentation
						$text = str_replace("{TAB}", "    ", $text);
						
						// detail text
						$this->SetFont('Arial','',9);
						if (!empty($text)) {
							$arr_text = explode("{INDENT", $text);
							foreach($arr_text as $j => $v) {
								if (strpos($v, '/}') !== false && !empty($v)) {
									$indent = substr($v, 0, strpos($v, '='));
									$no = substr($v, 2, strpos($v, '/}') - 2);
									$val = substr($v, strpos($v, "/}")+2);
									
									switch($indent) {
										case 0:
											$nospace = 6;
											$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
											$this->Cell($nospace, $height, $no, 0, 0, 'L');
											break;
										case 1:
											$indentspace = 6;
											$nospace = 6;
											$this->Cell($this->num_space+$indentspace, $height, NULL, 0, 0, 'C');
											$this->Cell($nospace, $height, $no, 0, 0, 'L');
											//$val = str_replace('{/INDENT1}','',substr($v, strpos($v, "/}")+2));
											break;
										case 2:
											$indentspace = 12;
											$nospace = 6;
											$this->Cell($this->num_space+$indentspace, $height, NULL, 0, 0, 'C');
											$this->Cell($nospace, $height, $no, 0, 0, 'L');
											//$val = str_replace('{/INDENT2}','',substr($v, strpos($v, "/}")+2));
											break;
										case 3:
											$indentspace = 18;
											$nospace = 9;
											$this->Cell($this->num_space+$indentspace, $height, NULL, 0, 0, 'C');
											$this->Cell($nospace, $height, $no, 0, 0, 'L');
											//$val = str_replace('{/INDENT3}','',substr($v, strpos($v, "/}")+2));
											break;
									}
									
									$this->MultiCell($this->pg_w-($this->num_space*2+$nospace)-$indentspace, 5, $val, 0, 'J');
								}
								else if (!empty($v)) {
									$val = str_replace("}", NULL, $v);
									$this->Cell($this->num_space+6, $height, NULL, 0, 0, 'C');
									$this->MultiCell($this->pg_w-($this->num_space*2+5), 5, $val, 0, 'J');
								}
							}
							$no_h++;
						}
						
						// addpage jika $addpage = true
						if ($addpage) {
							$this->AddPage();
							$this->font_title('B');
							$this->Cell($this->pg_w, $height, 'KETENTUAN - KETENTUAN KHUSUS', 0, 1, 'C');
							$this->Cell($this->pg_w, $height, "POLIS NOMOR : ".$this->arr['NOPOLBARU'], 0, 0, 'C');
							
							$this->Ln(10);
						}
						
						$this->Ln(2);
					}
				}else{
					if(!in_array($value['NOPARAGRAPH'], array("2","3"), true)){
						if (!$value['KDPARAGRAPH'] || $value['KDPARAGRAPH'] == 'T') {
							$judul = str_replace("{N_NMPRODUK}", $this->arr['NAMAPRODUK'], $value['JUDUL']);
							$text  = preg_replace('/[\\\\\r\n]/', '', $value["TEKS"]);
							$text  = str_replace("{NEWLINE}", "\n", $text);
							$text  = str_replace("{N_JUA}", number_format($this->arrp['JUA'], 2, ",", "."), $text);
							$text  = str_replace("{L_JUATERBILANG}", $this->arrp['JUATERBILANG'], $text);
							$text  = str_replace("{T_MULAS}", $mulai1month, $text);
							$text  = str_replace("{T_MULAS_1YEAR}", $this->arrp['MULAS_1YEAR'], $text);
							$text  = str_replace("{B_MULAS}", $this->arrp['MULAS'], $text);
							$text  = str_replace("{T_EXPIRASI}", $this->arrp['EXPIRASI'], $text);
							$text  = str_replace("{B_EXPIRASI}", substr($this->arrp['EXPIRASI'], 3), $text);
							$text  = str_replace("{N_PREMI1}", number_format($this->arrp['PREMI1'], 2, ",", "."), $text);
							$text  = str_replace("{N_PREMI2}", number_format($this->arrp['PREMI2'], 2, ",", "."), $text);
							$text  = str_replace("{N_MASA}", $this->arrp['PT'], $text);
							$text  = str_replace("{N_USIA}", $this->arrp['USIA_TH'], $text);
							$text  = str_replace("{N_KDPRODUK}", $this->arrp['KDPRODUK'], $text);
							$text  = str_replace("{N_NMPRODUK}", $this->arr['NAMAPRODUK'], $text);
							$text  = str_replace("{N_KDVALUTA}", $this->arrp['KDVALUTA'], $text);
							$text  = str_replace("{N_NOTASI}", $this->arrp['NOTASI'], $text);
							$text  = str_replace("{N_CARABAYAR}", $this->arrp['KDCARABAYAR'], $text);
							$text  = str_replace("{N_DM0PROSEN}", $this->arrp['DM0PROSEN'], $text);
							$text  = str_replace("{T_AKHPRM}", $this->arrp['TGLAKHIRPREMI'], $text);
							$text  = str_replace("{T_AKHPRM}", substr($this->arrp['TGLAKHIRPREMI'], 3), $text);
							$text  = str_replace("{T_LAMAPEMBPREMI_TH}", $this->arr["LAMAPEMBPREMI_TH"], $text);
							$text  = str_replace("{T_BNFPHT}", $this->arrp['TGLMULAIPREMI'], $text); //tambahan untuk mulai manfaat anuitas adalah 1 bulan setelah pembayaran/mulas Teguh 15/10/2019
							
							// used for unit-linked
							if ($this->arrp['KDCARABAYAR'] == '1' || $this->arrp['KDCARABAYAR'] == 'M') {
								$text = str_replace("{N_NMCB}", "PREMI BULANAN", $text);
								if (substr($this->arrp['KDPRODUK'], 0, 3) == 'JL2') {
									$text = str_replace("{N_FAKTL1}", "25 X", $text);
									$text = str_replace("{N_FAKTL65}", "20 X", $text);
								}
								else {
									$text = str_replace("{N_FAKTL1}", "25 X", $text);
									$text = str_replace("{N_FAKTL65}", "5 X", $text);
								}
							}
							else if ($this->arrp['KDCARABAYAR'] == '2' || $this->arrp['KDCARABAYAR'] == 'Q') {
								$text = str_replace("{N_NMCB}", "PREMI KUARTALAN", $text);
								if (substr($this->arrp['KDPRODUK'], 0, 3) == 'JL2') {
									$text = str_replace("{N_FAKTL1}", "8 X", $text);
									$text = str_replace("{N_FAKTL65}", "7 X", $text);
								}
								else {
									$text = str_replace("{N_FAKTL1}", "15 X", $text);
									$text = str_replace("{N_FAKTL65}", "3 X", $text);
								}
							}
							else if ($this->arrp['KDCARABAYAR'] == '3' || $this->arrp['KDCARABAYAR'] == 'H') {
								$text = str_replace("{N_NMCB}", "PREMI SEMESTERAN", $text);
								if (substr($this->arrp['KDPRODUK'], 0, 3) == 'JL2') {
									$text = str_replace("{N_FAKTL1}", "4 X", $text);
									$text = str_replace("{N_FAKTL65}", "4 X", $text);
								}
								else {
									$text = str_replace("{N_FAKTL1}", "10 X", $text);
									$text = str_replace("{N_FAKTL65}", "2 X", $text);
								}
							}
							else if ($this->arrp['KDCARABAYAR'] == '4' || $this->arrp['KDCARABAYAR'] == 'A' || $this->arrp['KDCARABAYAR'] == 'E' || $this->arrp['KDCARABAYAR'] == 'J') {
								$text = str_replace("{N_NMCB}", "PREMI TAHUNAN", $text);
								if (substr($this->arrp['KDPRODUK'], 0, 3) == 'JL2') {
									$text = str_replace("{N_FAKTL1}", "2 X", $text);
									$text = str_replace("{N_FAKTL65}", "2 X", $text);
								}
								else {
									$text = str_replace("{N_FAKTL1}", "5 X", $text);
									$text = str_replace("{N_FAKTL65}", "1 X", $text);
								}
							}
							else {
								$text = str_replace("{N_NMCB}", "PREMI SEKALIGUS", $text);
								if (substr($this->arrp['KDPRODUK'], 0, 3) == 'JL2') {
									$text = str_replace("{N_FAKTL1}", "130% X", $text);
									$text = str_replace("{N_FAKTL65}", "50% X", $text);
								}
								else {
									$text = str_replace("{N_FAKTL1}", "125% X", $text);
									$text = str_replace("{N_FAKTL65}", "10% X", $text);
								}
							}
							
							foreach($this->arrp2 as $i => $value2) {
								$text = str_replace("{N_".$value2['KDBENEFIT']."}", number_format($value2['NILAIBENEFIT'], 2, ",", "."), $text);
								$text = str_replace("{T_".$value2['KDBENEFIT']."}", $value2['EXPIRASI'], $text);
								$text = str_replace("{B_".$value2['KDBENEFIT']."}", $value2['EXPIRASIB'], $text);
								$text = str_replace("{A_".$value2['KDBENEFIT']."}", $value2['AKHIRPMB'], $text);
							}
							
							$this->font_body('B');

							// header text
							if (strpos($judul, "/}") !== false) {
								$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');

								$no = str_replace("/}", NULL, str_replace("{NUMBER=", NULL, substr($judul, 0, strpos($judul, "/}")+2)));
								$this->Cell(6, $height, $no, 0, 0, 'L');

								$judul = substr($judul, strpos($judul, "/}")+2);
								if (strpos($judul, "{STYLE=") !== false) {
									$this->font_body(str_replace("/}", NULL, str_replace("{STYLE=", NULL, substr($judul, 0, strpos($judul, "/}")+2))));
									$judul = substr($judul, strpos($judul, "/}")+2);
								}
								$this->MultiCell($this->pg_w-($this->num_space*2)-6, 5, $judul, 0, 'J');
							}
							else {
								$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
								$no	   = $no_h == 1 ? 'A. '
									   : ($no_h == 2 ? 'B. ' 
									   : ($no_h == 3 ? 'C. ' 
									   : ($no_h == 4 ? 'D. ' 
									   : ($no_h == 5 ? 'E. ' 
									   : ($no_h == 6 ? 'F. ' 
									   : ($no_h == 7 ? 'G. ' : $no_h))))));
								$this->MultiCell($this->pg_w-($this->num_space*2), 5, $no.$judul, 0, 'J');
							}
							
							// $addpage true jika {ADDPAGE} ditemukan
							if (strpos($text, "{ADDPAGE}") !== false) {
								$addpage = true;
								$text = str_replace("{ADDPAGE}", "", $text);
							}
							else {
								$addpage = false;
							}

							// untuk menghapus produk js prestasi tahapan beasiswa yang 0
							/*=== catatan harus sama = ", sebesar Rp.0,00" tanpa tanda kutip ===*/
							$tahapan0 = strpos($text, ', sebesar Rp.0,00');
							if ($tahapan0 > 0) {
								$replace_tahapan = substr($text, $tahapan0-30, 48);
								$text = str_replace($replace_tahapan, '', $text);
							}
							
							// untuk indentation
							$text = str_replace("{TAB}", "    ", $text);
							
							// detail text
							$this->SetFont('Arial','',9);
							if (!empty($text)) {
								$arr_text = explode("{INDENT", $text);
								foreach($arr_text as $j => $v) {
									if (strpos($v, '/}') !== false && !empty($v)) {
										$indent = substr($v, 0, strpos($v, '='));
										$no = substr($v, 2, strpos($v, '/}') - 2);
										$val = substr($v, strpos($v, "/}")+2);
										
										switch($indent) {
											case 0:
												$nospace = 6;
												$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
												$this->Cell($nospace, $height, $no, 0, 0, 'L');
												break;
											case 1:
												$indentspace = 6;
												$nospace = 6;
												$this->Cell($this->num_space+$indentspace, $height, NULL, 0, 0, 'C');
												$this->Cell($nospace, $height, $no, 0, 0, 'L');
												//$val = str_replace('{/INDENT1}','',substr($v, strpos($v, "/}")+2));
												break;
											case 2:
												$indentspace = 12;
												$nospace = 6;
												$this->Cell($this->num_space+$indentspace, $height, NULL, 0, 0, 'C');
												$this->Cell($nospace, $height, $no, 0, 0, 'L');
												//$val = str_replace('{/INDENT2}','',substr($v, strpos($v, "/}")+2));
												break;
											case 3:
												$indentspace = 18;
												$nospace = 9;
												$this->Cell($this->num_space+$indentspace, $height, NULL, 0, 0, 'C');
												$this->Cell($nospace, $height, $no, 0, 0, 'L');
												//$val = str_replace('{/INDENT3}','',substr($v, strpos($v, "/}")+2));
												break;
										}
										
										$this->MultiCell($this->pg_w-($this->num_space*2+$nospace)-$indentspace, 5, $val, 0, 'J');
									}
									else if (!empty($v)) {
										$val = str_replace("}", NULL, $v);
										$this->Cell($this->num_space+6, $height, NULL, 0, 0, 'C');
										$this->MultiCell($this->pg_w-($this->num_space*2+5), 5, $val, 0, 'J');
									}
								}
								$no_h++;
							}
							
							// addpage jika $addpage = true
							if ($addpage) {
								$this->AddPage();
								$this->font_title('B');
								$this->Cell($this->pg_w, $height, 'KETENTUAN - KETENTUAN KHUSUS', 0, 1, 'C');
								$this->Cell($this->pg_w, $height, "POLIS NOMOR : ".$this->arr['NOPOLBARU'], 0, 0, 'C');
								
								$this->Ln(10);
							}
							
							$this->Ln(2);
						}
					}
				}
			}
			
			/** perhitungan nilai tebus **/
			if ($this->arrt['KDPRODUK'] == "HTB" || $this->arrt['KDPRODUK'] == "HTK" || $this->arrt['KDPRODUK'] == "HTS" || $this->arrt['KDPRODUK'] == "HTT" && count($this->arrt2) > 0) {
				$this->Cell(25, 8, NULL, 0, 0, 'L');
				$x1 = $this->GetX();
				$y1 = $this->GetY();
				$this->MultiCell(140/6, 4, "AKHIR TAHUN KE", 1, 'C');
				$y2 = $this->GetY();
				$yH = $y2 - $y1;
				
				$this->SetXY($x1 + 140/6, $y2 - $yH);
				
				$this->Cell(140/3, 8, "NILAI EKSPIRASI", 1, 0, 'C');
				
				$x1 = $this->GetX();
				$y1 = $this->GetY();
				$this->MultiCell(140/6, 4, "AKHIR TAHUN KE", 1, 'C');
				$y2 = $this->GetY();
				$yH = $y2 - $y1;
				
				$this->SetXY($x1 + 140/6, $y2 - $yH);
				$this->Cell(140/3, 8, "NILAI EKSPIRASI", 1, 0, 'C');
				$this->Cell(25, 8, NULL, 0, 1, 'L');
			}
			else if ($this->arrt['KDPRODUK'] == "ADB" || $this->arrt['KDPRODUK'] == "ADK" || $this->arrt['KDPRODUK'] == "ADS" || $this->arrt['KDPRODUK'] == "ADT" || $this->arrt['KDPRODUK'] == "ADX" && count($this->arrt2) > 0) {
				$this->Cell(25, 8, NULL, 0, 0, 'L');
				$x1 = $this->GetX();
				$y1 = $this->GetY();
				$this->MultiCell(140/6, 4, "AKHIR TAHUN KE", 1, 'C');
				$y2 = $this->GetY();
				$yH = $y2 - $y1;
				
				$this->SetXY($x1 + 140/6, $y2 - $yH);
				
				$this->Cell(140/3, 8, "NILAI TEBUS", 1, 0, 'C');
				
				$x1 = $this->GetX();
				$y1 = $this->GetY();
				$this->MultiCell(140/6, 4, "AKHIR TAHUN KE", 1, 'C');
				$y2 = $this->GetY();
				$yH = $y2 - $y1;
				
				$this->SetXY($x1 + 140/6, $y2 - $yH);
				$this->Cell(140/3, 8, "NILAI TEBUS", 1, 0, 'C');
				$this->Cell(25, 8, NULL, 0, 1, 'L');
			}
			else if (count($this->arrt2) > 0) {
				$this->Cell(25, 8, NULL, 0, 0, 'L');
				$x1 = $this->GetX();
				$y1 = $this->GetY();
				$this->MultiCell(140/6, 4, "AKHIR TAHUN KE", 1, 'C');
				$y2 = $this->GetY();
				$yH = $y2 - $y1;
				
				$this->SetXY($x1 + 140/6, $y2 - $yH);
				
				$this->Cell(140/3, 8, "NILAI TEBUS", 1, 0, 'C');
				
				$x1 = $this->GetX();
				$y1 = $this->GetY();
				$this->MultiCell(140/6, 4, "AKHIR TAHUN KE", 1, 'C');
				$y2 = $this->GetY();
				$yH = $y2 - $y1;
				
				$this->SetXY($x1 + 140/6, $y2 - $yH);
				$this->Cell(140/3, 8, "NILAI TEBUS", 1, 0, 'C');
				$this->Cell(25, 8, NULL, 0, 1, 'L');
			}
			
			$this->arrt['LPP'] = $this->nopertanggungan == '001457864' ? 9 : $this->arrt['LPP'];
			
			// buat array baru untuk menampung data tebus menjadi dua tabel
			$j	   = 0;
			$lst_t = end($this->arrt2);
			$count = count($this->arrt2) <= $this->arrt['LPP'] || $lst_t['T'] == $this->arrt['LPP'] ? count($this->arrt2) : $this->arrt['LPP'];
			$k	   = $count%2 == 1 ? $count/2+0.5 : $count/2;
			$data  = array();
			foreach($this->arrt2 as $i => $value) {
				if ($i < $k) {
					if ($this->arrt['KDPRODUK'] == "JSSPO1" || $this->arrt['KDPRODUK'] == "JSSPO2" || $this->arrt['KDPRODUK'] == "JSSPO7A" || $this->arrt['KDPRODUK'] == "JSSPO8" || $this->arrt['KDPRODUK'] == "JSSPO9") {
						$data[$i]['NO']	   = $value['T'];
						$data[$i]['NILAI'] = round(0.001 * ($value['TARIF'] * $this->arrt['JUA'] + $value['TARIFS'] * $this->arrt['JUABP']), -3);
					}
					else {
						$data[$i]['NO']	   = $value['T'];
						$data[$i]['NILAI'] = 0.001 * ($value['TARIF'] * $this->arrt['JUA'] + $value['TARIFS'] * $this->arrt['JUABP']);
					}
					
					if ($this->flag_dst) {
						$data[$i]['NO2']	= "..";
						$data[$i]['NILAI2'] = "DAN SETERUSNYA...";
					}
					else {
						$data[$i]['NO2']	= NULL;
						$data[$i]['NILAI2'] = NULL;
					}
				}
				else {
					if ($this->arrt['KDPRODUK'] == "JSSPO1" || $this->arrt['KDPRODUK'] == "JSSPO2" || $this->arrt['KDPRODUK'] == "JSSPO7A" || $this->arrt['KDPRODUK'] == "JSSPO8" || $this->arrt['KDPRODUK'] == "JSSPO9") {
						$data[$j]['NO2']	   = $value['T'];
						$data[$j]['NILAI2'] = round(0.001 * ($value['TARIF'] * $this->arrt['JUA'] + $value['TARIFS'] * $this->arrt['JUABP']), -3);
					}
					else {
						$data[$j]['NO2']	= $value['T'];
						$data[$j]['NILAI2'] = 0.001 * ($value['TARIF'] * $this->arrt['JUA'] + $value['TARIFS'] * $this->arrt['JUABP']);
					}
					$j++;
				}
			}
			
			// tampilkan detail ke pdf
			$val_dst = "DAN SETERUSNYA...";
			$cek = 0;
			foreach($data as $i => $value) {
				if ($i < $k) {
					$nilai2 = empty($value['NILAI2']) ? NULL 
							: ($this->flag_dst && $value['NILAI2'] == $val_dst['NILAI2'] ? $value['NILAI2'] : number_format($value['NILAI2'], 2, ",", "."));
					
					$this->Cell(25, 5, NULL, 0, 0, 'L');
					$this->Cell(140/6, 5, $value['NO'], 'LR', 0, 'C');
					$this->Cell(140/3, 5, number_format($value['NILAI'], 2, ",", "."), 'LR', 0, 'R');
					$this->Cell(140/6, 5, $value['NO2'], 'LR', 0, 'C');
					$this->Cell(140/3, 5, $nilai2, 'LR', 0, 'R');
					$this->Cell(25, 5, NULL, 0, 1, 'L');
					$cek = 1;
				}
			}
			
			if ($cek) {
				$this->Cell(25, 5, NULL, 0, 0, 'L');
				$this->Cell(140, 0, NULL, 1, 0, 'L');
			}
			/** akhir dari perhitungan nilai tebus **/
			
			$this->Ln(5);
			
			
			/*==== ketentuan setelah nilai tebus =====*/
			// cek redaksi jika kdparagraph = M, maka MIDDLE
			foreach($this->arrk as $i => $value) {
				if ($value['KDPARAGRAPH'] == 'M') {
					$judul = str_replace("{N_NMPRODUK}", $this->arr['NAMAPRODUK'], $value['JUDUL']);
                    $text  = preg_replace('/[\\\\\r\n]/', '', $value["TEKS"]);
					$text  = str_replace("{NEWLINE}", "\n", $text);
					$text  = str_replace("{N_JUA}", number_format($this->arrp['JUA'], 2, ",", "."), $text);
					$text  = str_replace("{L_JUATERBILANG}", $this->arrp['JUATERBILANG'], $text);
					$text  = str_replace("{T_MULAS}", $this->arrp['MULAS'], $text);
					$text  = str_replace("{T_MULAS_1YEAR}", $this->arrp['MULAS_1YEAR'], $text);
					$text  = str_replace("{B_MULAS}", $this->arrp['MULAS'], $text);
					$text  = str_replace("{T_EXPIRASI}", $this->arrp['EXPIRASI'], $text);
					$text  = str_replace("{B_EXPIRASI}", substr($this->arrp['EXPIRASI'], 3), $text);
					$text  = str_replace("{N_PREMI1}", number_format($this->arrp['PREMI1'], 2, ",", "."), $text);
					$text  = str_replace("{N_PREMI2}", number_format($this->arrp['PREMI2'], 2, ",", "."), $text);
					$text  = str_replace("{N_MASA}", $this->arrp['PT'], $text);
					$text  = str_replace("{N_USIA}", $this->arrp['USIA_TH'], $text);
					$text  = str_replace("{N_KDPRODUK}", $this->arrp['KDPRODUK'], $text);
					$text  = str_replace("{N_NMPRODUK}", $this->arr['NAMAPRODUK'], $text);
					$text  = str_replace("{N_KDVALUTA}", $this->arrp['KDVALUTA'], $text);
					$text  = str_replace("{N_NOTASI}", $this->arrp['NOTASI'], $text);
					$text  = str_replace("{N_CARABAYAR}", $this->arrp['KDCARABAYAR'], $text);
					$text  = str_replace("{N_DM0PROSEN}", $this->arrp['DM0PROSEN'], $text);
					$text  = str_replace("{T_AKHPRM}", $this->arrp['TGLAKHIRPREMI'], $text);
					$text  = str_replace("{T_AKHPRM}", substr($this->arrp['TGLAKHIRPREMI'], 3), $text);
					$text  = str_replace("{T_LAMAPEMBPREMI_TH}", $this->arr["LAMAPEMBPREMI_TH"], $text);
					
					// used for unit-linked
					if ($this->arrp['KDCARABAYAR'] == '1' || $this->arrp['KDCARABAYAR'] == 'M') {
						$text = str_replace("{N_NMCB}", "PREMI BULANAN", $text);
						if (substr($this->arrp['KDPRODUK'], 0, 3) == 'JL2') {
							$text = str_replace("{N_FAKTL1}", "25 X", $text);
							$text = str_replace("{N_FAKTL65}", "20 X", $text);
						}
						else {
							$text = str_replace("{N_FAKTL1}", "25 X", $text);
							$text = str_replace("{N_FAKTL65}", "5 X", $text);
						}
					}
					else if ($this->arrp['KDCARABAYAR'] == '2' || $this->arrp['KDCARABAYAR'] == 'Q') {
						$text = str_replace("{N_NMCB}", "PREMI KUARTALAN", $text);
						if (substr($this->arrp['KDPRODUK'], 0, 3) == 'JL2') {
							$text = str_replace("{N_FAKTL1}", "8 X", $text);
							$text = str_replace("{N_FAKTL65}", "7 X", $text);
						}
						else {
							$text = str_replace("{N_FAKTL1}", "15 X", $text);
							$text = str_replace("{N_FAKTL65}", "3 X", $text);
						}
					}
					else if ($this->arrp['KDCARABAYAR'] == '3' || $this->arrp['KDCARABAYAR'] == 'H') {
						$text = str_replace("{N_NMCB}", "PREMI SEMESTERAN", $text);
						if (substr($this->arrp['KDPRODUK'], 0, 3) == 'JL2') {
							$text = str_replace("{N_FAKTL1}", "4 X", $text);
							$text = str_replace("{N_FAKTL65}", "4 X", $text);
						}
						else {
							$text = str_replace("{N_FAKTL1}", "10 X", $text);
							$text = str_replace("{N_FAKTL65}", "2 X", $text);
						}
					}
					else if ($this->arrp['KDCARABAYAR'] == '4' || $this->arrp['KDCARABAYAR'] == 'A' || $this->arrp['KDCARABAYAR'] == 'E' || $this->arrp['KDCARABAYAR'] == 'J') {
						$text = str_replace("{N_NMCB}", "PREMI TAHUNAN", $text);
						if (substr($this->arrp['KDPRODUK'], 0, 3) == 'JL2') {
							$text = str_replace("{N_FAKTL1}", "2 X", $text);
							$text = str_replace("{N_FAKTL65}", "2 X", $text);
						}
						else {
							$text = str_replace("{N_FAKTL1}", "5 X", $text);
							$text = str_replace("{N_FAKTL65}", "1 X", $text);
						}
					}
					else {
						$text = str_replace("{N_NMCB}", "PREMI SEKALIGUS", $text);
						if (substr($this->arrp['KDPRODUK'], 0, 3) == 'JL2') {
							$text = str_replace("{N_FAKTL1}", "130% X", $text);
							$text = str_replace("{N_FAKTL65}", "50% X", $text);
						}
						else {
							$text = str_replace("{N_FAKTL1}", "125% X", $text);
							$text = str_replace("{N_FAKTL65}", "10% X", $text);
						}
					}
					
					foreach($this->arrp2 as $i => $value2) {
						$text = str_replace("{N_".$value2['KDBENEFIT']."}", number_format($value2['NILAIBENEFIT'], 2, ",", "."), $text);
						$text = str_replace("{T_".$value2['KDBENEFIT']."}", $value2['EXPIRASI'], $text);
						$text = str_replace("{B_".$value2['KDBENEFIT']."}", $value2['EXPIRASIB'], $text);
						$text = str_replace("{A_".$value2['KDBENEFIT']."}", $value2['AKHIRPMB'], $text);
					}
					
					$this->font_body('B');

                    // header text
                    if (strpos($judul, "/}") !== false) {
                        $this->Cell($this->num_space, $height, NULL, 0, 0, 'C');

                        $no = str_replace("/}", NULL, str_replace("{NUMBER=", NULL, substr($judul, 0, strpos($judul, "/}")+2)));
                        $this->Cell(6, $height, $no, 0, 0, 'L');

                        $judul = substr($judul, strpos($judul, "/}")+2);
                        if (strpos($judul, "{STYLE=") !== false) {
                            $this->font_body(str_replace("/}", NULL, str_replace("{STYLE=", NULL, substr($judul, 0, strpos($judul, "/}")+2))));
                            $judul = substr($judul, strpos($judul, "/}")+2);
                        }
                        $this->MultiCell($this->pg_w-($this->num_space*2)-6, 5, $judul, 0, 'J');
                    }
                    else {
                        $this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
                        $this->MultiCell($this->pg_w-($this->num_space*2), 5, $judul, 0, 'J');
                    }
					
					// $addpage true jika {ADDPAGE} ditemukan
					if (strpos($text, "{ADDPAGE}") !== false) {
						$addpage = true;
						$text = str_replace("{ADDPAGE}", "", $text);
					}
					else {
						$addpage = false;
					}

                    // untuk menghapus produk js prestasi tahapan beasiswa yang 0
                    /*=== catatan harus sama = ", sebesar Rp.0,00" tanpa tanda kutip ===*/
                    $tahapan0 = strpos($text, ', sebesar Rp.0,00');
                    if ($tahapan0 > 0) {
                        $replace_tahapan = substr($text, $tahapan0-30, 48);
                        $text = str_replace($replace_tahapan, '', $text);
                    }
					
					// untuk indentation
					$text = str_replace("{TAB}", "    ", $text);
					
					// detail text
					$this->SetFont('Arial','',9);
					if (!empty($text)) {
						$arr_text = explode("{INDENT", $text);
						foreach($arr_text as $j => $v) {
							if (strpos($v, '/}') !== false && !empty($v)) {
								$indent = substr($v, 0, strpos($v, '='));
								$no = substr($v, 2, strpos($v, '/}') - 2);
								$val = substr($v, strpos($v, "/}")+2);
								
								switch($indent) {
									case 0:
                                        $nospace = 6;
                                        $this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
                                        $this->Cell($nospace, $height, $no, 0, 0, 'L');
                                        break;
									case 1:
										$indentspace = 6;
										$nospace = 6;
										$this->Cell($this->num_space+$indentspace, $height, NULL, 0, 0, 'C');
										$this->Cell($nospace, $height, $no, 0, 0, 'L');
										//$val = str_replace('{/INDENT1}','',substr($v, strpos($v, "/}")+2));
										break;
									case 2:
										$indentspace = 12;
										$nospace = 6;
										$this->Cell($this->num_space+$indentspace, $height, NULL, 0, 0, 'C');
										$this->Cell($nospace, $height, $no, 0, 0, 'L');
										//$val = str_replace('{/INDENT2}','',substr($v, strpos($v, "/}")+2));
										break;
									case 3:
										$indentspace = 18;
										$nospace = 9;
										$this->Cell($this->num_space+$indentspace, $height, NULL, 0, 0, 'C');
										$this->Cell($nospace, $height, $no, 0, 0, 'L');
										//$val = str_replace('{/INDENT3}','',substr($v, strpos($v, "/}")+2));
										break;
								}
								
								$this->MultiCell($this->pg_w-($this->num_space*2+$nospace)-$indentspace, 5, $val, 0, 'J');
							}
							else if (!empty($v)) {
								$val = str_replace("}", NULL, $v);
								$this->Cell($this->num_space+6, $height, NULL, 0, 0, 'C');
								$this->MultiCell($this->pg_w-($this->num_space*2+5), 5, $val, 0, 'J');
							}
						}
					}
					
					// addpage jika $addpage = true
					if ($addpage) {
						$this->AddPage();
						$this->font_title('B');
						$this->Cell($this->pg_w, $height, 'KETENTUAN - KETENTUAN KHUSUS', 0, 1, 'C');
						$this->Cell($this->pg_w, $height, "POLIS NOMOR : ".$this->arr['NOPOLBARU'], 0, 0, 'C');
						
						$this->Ln(10);
					}
					
					$this->Ln(2);
					$no_h++;
				}
			}
			
			
			// jika valuta asing (US$)
			if ($this->arrt['KDVALUTA'] == '3') {
				$paragraph = "* SEGALA HAK DAN KEWAJIBAN BERUPA PEMBAYARAN SEJUMLAH UANG YANG TIMBUL DARI PERJANJIAN ASURANSI "
						   . "MENURUT POLIS INI DILAKUKAN DALAM MATA UANG RUPIAH BERDASARKAN NILAI TUKAR KURS TENGAH MATA UANG "
						   . "DOLLAR AMERIKA SERIKAT YANG DITETAPKAN OLEH BANK INDONESIA.";
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'L');
				$this->MultiCell($this->pg_w-($this->num_space*2+5), $height, $paragraph, 0, 'J');
				$this->Ln(2);
			}
			else if ($this->arrt['KDVALUTA'] == '0') {
				$no	   = $no_h == 1 ? 'I. '
					   : ($no_h == 2 ? 'II. ' 
					   : ($no_h == 3 ? 'III. ' 
					   : ($no_h == 4 ? 'IV. ' 
					   : ($no_h == 5 ? 'V. ' 
					   : ($no_h == 6 ? 'VI. ' : $no_h)))));
				$judul = "PELAKSANAAN PEMBAYARAN HAK DAN KEWAJIBAN";
				$text  = "PELAKSANAAN PEMBAYARAN HAK DAN KEWAJIBAN AKAN SELALU DIKAITKAN DENGAN INDEKS ASURANSI JIWA PADA SAAT "
					   . "PEMBAYARAN. KECUALI APABILA POLIS TELAH BEBAS PREMI DALAM MASA PEMBAYARAN PREMI, MAKA PELAKSANAAN "
					   . "PEMBAYARAN HAK DAN KEWAJIBAN BERDASARKAN INDEKS YANG BERLAKU PADA SAAT POLIS DINYATAKAN BEBAS PREMI.";
				
				$this->font_body();
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				$this->Cell(5, $height, $no, 0, 0, 'L');
				$this->MultiCell($this->pg_w-($this->num_space*2)-5, 5, $judul, 0, 'J');
				$this->Ln(2);
				$this->SetFont('Arial','',9);
				$this->Cell($this->num_space+5, $height, NULL, 0, 0, 'C');
				$this->MultiCell($this->pg_w-($this->num_space*2+5), 5, $text, 0, 'J');
				$this->Ln(2);
				
				$no_h++;
			}
			
			//
			if ($this->arrt['KDPRODUK'] == 'JSAP1' || $this->arrt['KDPRODUK'] == 'JSAP2') {
				$paragraph = "PREMI PADA POLIS ADALAH PREMI POKOK, APABILA ADA TAMBAHAN JAMINAN TAMBAHAN, "
						   . "JUMLAH  DAN  RINCIAN  PREMI  TERCANTUM  DI  NOTICE  SEBAGAI LAMPIRAN POLIS.";
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'L');
				$this->MultiCell($this->pg_w-($this->num_space*2+5), $height, $paragraph, 0, 'J');
				$this->Ln(2);
			}
			
			// jika ada clash of clan eh cash plan maksudnya
			if ($this->cash_plan > 0) {
				$no	   = $no_h == 1 ? 'I. '
					   : ($no_h == 2 ? 'II. ' 
					   : ($no_h == 3 ? 'III. ' 
					   : ($no_h == 4 ? 'IV. ' 
					   : ($no_h == 5 ? 'V. ' 
					   : ($no_h == 6 ? 'VI. ' : $no_h)))));
				$judul = "MANFAAT JAMINAN TAMBAHAN CASH PLAN DAN SYARAT-SYARAT JAMINAN TAMBAHAN "
					   . "CASH PLAN TERTUANG PADA LAMPIRAN JAMINAN TAMBAHAN CASH PLAN DAN SYARAT-SYARAT JAMINAN TAMBAHAN CASH PLAN.";
				
				$this->font_body();
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				$this->Cell(5, $height, $no, 0, 0, 'L');
				$this->MultiCell($this->pg_w-($this->num_space*2)-5, 5, $judul, 0, 'J');
				$this->Ln(2);
				
				$no_h++;
			}
			
			// untuk klausula
			/*$this->AddPage();
			$no	   = $no_h == 1 ? 'I. '
				   : ($no_h == 2 ? 'II. ' 
				   : ($no_h == 3 ? 'III. ' 
				   : ($no_h == 4 ? 'IV. ' 
				   : ($no_h == 5 ? 'V. ' 
				   : ($no_h == 6 ? 'VI. ' 
				   : ($no_h == 7 ? 'VII. ' : $no_h))))));
			$judul = "KLAUSULA.";
			$text  = "PELAKSANAAN PEMBAYARAN HAK DAN KEWAJIBAN AKAN SELALU DIKAITKAN DENGAN INDEKS ASURANSI JIWA PADA SAAT "
				   . "PEMBAYARAN. KECUALI APABILA POLIS TELAH BEBAS PREMI DALAM MASA PEMBAYARAN PREMI, MAKA PELAKSANAAN "
				   . "PEMBAYARAN HAK DAN KEWAJIBAN BERDASARKAN INDEKS YANG BERLAKU PADA SAAT POLIS DINYATAKAN BEBAS PREMI.";
			$satu  = "APABILA TERDAPAT/TERJADI PERUBAHAN PADA MANFAAT, BIAYA, SYARAT DAN KETENTUAN UMUM POLIS, AKAN DIBERITAHUKAN "
				   . "KEPADA PEMEGANG POLIS PADA ALAMAT TERKINI PEMEGANG POLIS YANG TERCATAT PADA PENANGGUNG PALING LAMBAR 30 (TIGA "
				   . "PULUH) HARI KERJA SEJAK SEBELUM TERJADINYA PERUBAHAN.";
			$dua  = "PERJANJIAN INI TELAH DISESUAIKAN DENGAN KETENTUAN PERATURAN PERUNDANG-UNDANGAN TERMASUK PERATURAN OTORITAS JASA "
				   . "KEUANGAN.";
			
			$this->font_body('B');
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell(5, $height, $no, 0, 0, 'L');
			$this->MultiCell($this->pg_w-($this->num_space*2)-5, 5, $judul, 0, 'J');
			$this->Ln(2);
			$this->SetFont('Arial','',9);
			$this->Cell($this->num_space+5, $height, NULL, 0, 0, 'C');
			$this->Cell(6, $height, '1.', 0, 0, 'L');
			$this->MultiCell($this->pg_w-($this->num_space*2+5)-6, 5, $satu, 0, 'J');
			$this->SetFont('Arial','',9);
			$this->Cell($this->num_space+5, $height, NULL, 0, 0, 'C');
			$this->Cell(6, $height, '2.', 0, 0, 'L');
			$this->MultiCell($this->pg_w-($this->num_space*2+5)-6, 5, $dua, 0, 'J');*/
		}
		
		public function AsuransiTambahan() {
			$this->AddPage();
			$this->Ln(12);
			
			$height = $this->height;
			
			$this->SetFont('Arial','',9);
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->MultiCell($this->pg_w-($this->num_space*2), 5, "Asuransi Tambahan dan Ketentuan Khusus yang tidak berlaku", 0, 'J');
			$this->Ln(2);
			
			$this->SetFont('Arial','B',9);
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell(($this->pg_w-($this->num_space*2))*3/5, $height, "Asuransi Tambahan", 0, 0, 'L');
			$this->Cell(($this->pg_w-($this->num_space*2))*2/5, $height, "Ketentuan & Manfaat di", 0, 1, 'L');
			
			$this->SetFont('Arial','',9);
			foreach($this->arrat as $i => $value) {
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				$this->Cell(($this->pg_w-($this->num_space*2))*3/5, $height, $value['NAMABENEFIT'], 0, 0, 'L');
				$this->Cell(($this->pg_w-($this->num_space*2))*2/5, $height, $value['KDBENEFIT'], 0, 1, 'L');
			}
		}
		
		public function syaratUmum(){
			$this->AddPage();
			//fopen('./includes/template-anuitas.pdf','wb');
			/*
			$pdf = new FPDI();
			$pdf->setSourceFile('./includes/template-anuitas.pdf');
			
			for($i=0; $i<$pagecount; $i++){
				$pdf->AddPage();  
				$tplidx = $pdf->importPage($i+1, '/MediaBox');
				$pdf->useTemplate($tplidx); 
			}
			*/
			
			$height = $this->height;
			//$no_h	= 1;
			$data	= array();
						
			$this->font_title('B');
			$this->Cell($this->pg_w, $height, 'SYARAT-SYARAT UMUM POLIS (SUP)', 0, 2, 'C');
			$this->Cell($this->pg_w, $height, "ASURANSI JIWA PERORANGAN", 0, 1, 'C');
			$this->Cell($this->pg_w, $height, "ASURANSI ". $this->arr["NAMAPRODUK"], 0, 0, 'C');
			
			$this->Ln(15);
			
			/*
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
            $this->Cell(($this->pg_w-($this->num_space*2))*9/27, $height, "PASAL 1", 0, 0, 'C');
            //$this->Cell(($this->pg_w-($this->num_space*2))*6/24, $height, "Biaya Asuransi per Bulan", 0, 0, 'C');
			
            $this->Cell(($this->pg_w-($this->num_space*2))*6/24, $height, "", 0, 0, 'C');
            $this->Cell(($this->pg_w-($this->num_space*2))*9/24, $height, "Biaya Asuransi per Bulan", 0, 0, 'C');
			
			$this->Ln();	
			$this->Cell(($this->pg_w-($this->num_space*2))*12/27, $height, "ARTI DAN ISTILAH", 0, 0, 'C');
			*/
			$this->PrintChapter(1,'A RUNAWAY REEF',"The year 1866 was marked by a bizarre development, an unexplained and downright inexplicable phenomenon that surely no one has forgotten. Without getting into those rumors that upset civilians in the seaports and deranged the public mind even far inland, it must be said that professional seamen were especially alarmed. Traders, shipowners, captains of vessels, skippers, and master mariners from Europe and America, naval officers from every country, and at their heels the various national governments on these two continents, were all extremely disturbed by the business.
In essence, over a period of time several ships had encountered an enormous thing at sea, a long spindle-shaped object, sometimes giving off a phosphorescent glow, infinitely bigger and faster than any whale.
The relevant data on this apparition, as recorded in various logbooks, agreed pretty closely as to the structure of the object or creature in question, its unprecedented speed of movement, its startling locomotive power, and the unique vitality with which it seemed to be gifted.  If it was a cetacean, it exceeded in bulk any whale previously classified by science.  No naturalist, neither Cuvier nor Lacépède, neither Professor Dumeril nor Professor de Quatrefages, would have accepted the existence of such a monster sight unseen -- specifically, unseen by their own scientific eyes. \n
Striking an average of observations taken at different times -- rejecting those timid estimates that gave the object a length of 200 feet, and ignoring those exaggerated views that saw it as a mile wide and three long--you could still assert that this phenomenal creature greatly exceeded the dimensions of anything then known to ichthyologists, if it existed at all.\n
Now then, it did exist, this was an undeniable fact; and since the human mind dotes on objects of wonder, you can understand the worldwide excitement caused by this unearthly apparition. As for relegating it to the realm of fiction, that charge had to be dropped.\n
In essence, on July 20, 1866, the steamer Governor Higginson, from the Calcutta & Burnach Steam Navigation Co., encountered this moving mass five miles off the eastern shores of Australia. Captain Baker at first thought he was in the presence of an unknown reef; he was even about to fix its exact position when two waterspouts shot out of this inexplicable object and sprang hissing into the air some 150 feet.  So, unless this reef was subject to the intermittent eruptions of a geyser, the Governor Higginson had fair and honest dealings with some aquatic mammal, until then unknown, that could spurt from its blowholes waterspouts mixed with air and steam.\n
Similar events were likewise observed in Pacific seas, on July 23 of the same year, by the Christopher Columbus from the West India & Pacific Steam Navigation Co.  Consequently, this extraordinary cetacean could transfer itself from one locality to another with startling swiftness, since within an interval of just three days, the Governor Higginson and the Christopher Columbus had observed it at two positions on the charts separated by a distance of more than 700 nautical leagues.\n
Fifteen days later and 2,000 leagues farther, the Helvetia from the Compagnie Nationale and the Shannon from the Royal Mail line, running on opposite tacks in that part of the Atlantic lying between the United States and Europe, respectively signaled each other that the monster had been sighted in latitude 42 degrees 15' north and longitude 60 degrees 35' west of the meridian of Greenwich.  From their simultaneous observations, they were able to estimate the mammal's minimum length at more than 350 English feet; this was because both the Shannon and the Helvetia were of smaller dimensions, although each measured 100 meters stem to stern. Now then, the biggest whales, those rorqual whales that frequent the waterways of the Aleutian Islands, have never exceeded a length of 56 meters--if they reach even that.\n
One after another, reports arrived that would profoundly affect public opinion:  new observations taken by the transatlantic liner Pereire, the Inman line's Etna running afoul of the monster, an official report drawn up by officers on the French frigate Normandy, dead-earnest reckonings obtained by the general staff of Commodore Fitz-James aboard the Lord Clyde. In lighthearted countries, people joked about this phenomenon, but such serious, practical countries as England, America, and Germany were deeply concerned.\n
In every big city the monster was the latest rage; they sang about it in the coffee houses, they ridiculed it in the newspapers, they dramatized it in the theaters.  The tabloids found it a fine opportunity for hatching all sorts of hoaxes. In those newspapers short of copy, you saw the reappearance of every gigantic imaginary creature, from Moby Dick, that dreadful white whale from the High Arctic regions, to the stupendous kraken whose tentacles could entwine a 500-ton craft and drag it into the ocean depths. They even reprinted reports from ancient times: the views of Aristotle and Pliny accepting the existence of such monsters, then the Norwegian stories of Bishop Pontoppidan, the narratives of Paul Egede, and finally the reports of Captain Harrington -- whose good faith is above suspicion--in which he claims he saw, while aboard the Castilian in 1857, one of those enormous serpents that, until then, had frequented only the seas of France's old extremist newspaper, The Constitutionalist.\n");
			//$this->PrintChapter(2,'THE PROS AND CONS','20k_c2.txt');
			
		}
		
		public function SetCol($col)
		{
			// Set position at a given column
			$this->column = $col;
			$x = $this->num_space+$col*100;
			$this->SetLeftMargin($x);
			$this->SetX($x);
		}

		public function AcceptPageBreak()
		{
			// Method accepting or not automatic page break
			if($this->column<1)
			{
				// Go to next column
				$this->SetCol($this->column+1);
				// Set ordinate to top
				$this->SetY($this->y0);
				// Keep on page
				return false;
			}
			else
			{
				// Go back to first column
				$this->SetCol(0);
				// Page break
				return true;
			}
		}

		public function ChapterTitle($num, $label)
		{
			// Title
			/*
			$this->SetFont('Arial','',12);
			$this->SetFillColor(200,220,255);
			$this->Cell(0,6,"Chapter $num : $label",0,1,'L',true);
			$this->Ln(4);
			*/
			// Save ordinate
			$this->y0 = $this->GetY();
		}

		public function ChapterBody($txt)
		{
			// Font
			$this->SetFont('Arial','B',10);
			// Output text in a 6 cm width column
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
            $this->MultiCell(90,5,"PASAL 1\nARTI DAN ISTILAH ", 0,'C',false);
			$this->Ln(8);
			
			$this->SetFont('Arial','',10);
			
			// Pasal 1 Paragpaph 1 
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell($this->num_space+2, 5, "(1)", 0, 0, 'C');
			$this->MultiCell(70-2,5,"Ketentuan dan istilah dalam Syaratsyarat Umum Polis ini, sepanjang tidak ditentukan atau diatur lain, atau dinyatakan sebaliknya dalam klausul/lampiran Polis dan/atau endorsement dan/atau dokumen lain sehubungan dengan Polis, berlaku dan mengikat dalam Asuransi ini.", 0, "J");
			$this->Ln();
			// Pasal 1 Paragpaph 2
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell($this->num_space+2, 5, "(2)", 0, 0, 'C');
			$this->MultiCell(70-2,5,"Dalam syarat-syarat umum Polis ini yang dimaksud dengan:", 0, "J");
			$this->Ln(0);
				// Subcell Pasal 1 Paragpaph 2
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space-1, 5, 'a. ', 0, 0, 'C');
				
				$this->MultiCell(70-10,5,"Asuransi adalah Asuransi ". $this->arr["NAMAPRODUK"], 0, "J");
				$this->Ln(0);
				// =========================================================================================
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space-1, 5, 'b. ', 0, 0, 'C');
				
				$this->MultiCell(70-10,5,"Penanggung adalah PT Asuransi Jiwa IFG atau penggantinya menurut hukum;", 0, "J");
				$this->Ln(0);
				// =========================================================================================
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space-1, 5, 'c. ', 0, 0, 'C');
				
				$this->MultiCell(70-10,5,"Pemegang Polis adalah pihak yang mengadakan perjanjian Asuransi atau Penggantinya menurut hukum dengan Penanggung;", 0, "J");
				$this->Ln(0);
				// =========================================================================================
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space-1, 5, 'd. ', 0, 0, 'C');
				
				$this->MultiCell(70-10,5,"Tertanggung adalah orang yang atas jiwanya diadakan perjanjian asuransi jiwa dimana jenis perjanjian asuransinya diuraikan dalam Polis, dalam Asuransi ini yang menjadi Tertanggung adalah Pemegang Polis;", 0, "J");
				$this->Ln(0);
				// =========================================================================================
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space-1, 5, 'e. ', 0, 0, 'C');
				
				$this->MultiCell(70-10,5,"Surat Permintaan Asuransi Jiwa (SPAJ) adalah formulir permohonan tertulis dan/atau elektronik untuk mengadakan suatu perjanjian Asuransi yang diisi dan ditandatangani dan/atau divalidasi oleh calon Pemegang Polis dan/atau calon Tertanggung;", 0, "J");
				$this->Ln(0);
				// =========================================================================================
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space-1, 5, 'f. ', 0, 0, 'C');
				
				$this->MultiCell(70-10,5,"Polis adalah dokumen perjanjian Asuransi yang berbentuk cetak, digital dan/atau elektronik ", 0, "J");
				$this->Ln(0);
				// =========================================================================================
				//$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				//$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+7, 5, null, 0, 0, 'C');
				
				$this->MultiCell(70-5,5,"yang dikeluarkan oleh Penanggung termasuk Syarat-syarat Umum Polis, Data Polis, pernyataanpernyataan dan ketentuan lainnya (apabila ada) beserta segala tambahan/perubahannya yang memuat syarat-syarat perjanjian Asuransi yang merupakan lampiran tidak terpisahkan dari Polis;", 0, "J");
				$this->Ln(0);
				// =========================================================================================				
				//$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				//$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+7, 5, 'g. ', 0, 0, 'C');
				
				$this->MultiCell(70-5,5,"Premi adalah sejumlah uang yang tercantum dalam Polis yang harus dibayarkan oleh Pemegang Polis kepada Penanggung sehubungan dengan diadakannya Polis;", 0, "J");
				$this->Ln(0);
				// =========================================================================================
				//$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				//$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+7, 5, 'h. ', 0, 0, 'C');
				
				$this->MultiCell(70-5,5,"Penerima Manfaat Anuitas adalah Pemegang Polis/Tertanggung, atau Istri/Suami atau Anak (Anak-anak) Pemegang Polis/Tertanggung atau pihak yang ditunjuk oleh Pemegang Polis dan sah secara hukum atau Ahli Waris Pemegang Polis/Tertanggung yang sah secara hukum;", 0, "J");
				$this->Ln(0);
				// =========================================================================================
				//$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				//$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+7, 5, 'i. ', 0, 0, 'C');
				
				$this->MultiCell(70-5,5,"Janda/Duda adalah Istri/Suami yang sah dari Pemegang Polis/Tertanggung yang meninggal dunia, dan namanya tercantum di dalam Polis;", 0, "J");
				$this->Ln(0);
				// =========================================================================================
				//$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				//$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+7, 5, 'j. ', 0, 0, 'C');
				
				$this->MultiCell(70-5,5,"Anak adalah Anak (anak-anak) yang sah dari Pemegang Polis/ Tertanggung yang namanya tercantum didalam Polis dengan ketentuan maksimal 3 (tiga) orang anak.", 0, "J");
				$this->Ln(0);
				// =========================================================================================
				//$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				//$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+7, 5, 'k. ', 0, 0, 'C');
				
				$this->MultiCell(70-5,5,"Tanggal Mulai Asuransi adalah tanggal dimulainya perjanjian Asuransi/ pertanggungan;", 0, "J");
				$this->Ln(0);
				// =========================================================================================
				//$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				//$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+7, 5, 'l. ', 0, 0, 'C');
				
				$this->MultiCell(70-5,5,"Tanggal Akhir Asuransi adalah tanggal berakhirnya perjanjian Asuransi/pertanggungan.", 0, "J");
				$this->Ln(0);
				// =========================================================================================
				//$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				//$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+7, 5, 'm. ', 0, 0, 'C');
				
				$this->MultiCell(70-5,5,"Masa Asuransi adalah masa berlakunya Asuransi yaitu sejak Tanggal Mulai Asuransi sampai dengan Tanggal Akhir Asuransi.", 0, "J");
				$this->Ln(0);
				// =========================================================================================
				//$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				//$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+7, 5, 'n. ', 0, 0, 'C');
				
				$this->MultiCell(70-5,5,"Usia adalah usia seseorang yang ditentukan berdasarkan ulang tahun", 0, "J");
				$this->Ln(0);
				// =========================================================================================
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				$this->Cell($this->num_space*2, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space, 5, NULL, 0, 0, 'C');
				
				$this->MultiCell(70-10,5,"terakhir yang bersangkutan sampai dengan pecahan bulan;", 0, "J");
				$this->Ln(0);
				// =========================================================================================
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space-1, 5, 'o. ', 0, 0, 'C');
				
				$this->MultiCell(70-10,5,"Hari Kerja adalah hari Senin sampai Jumat (tidak termasuk harilibur Nasional di Republik Indonesia);", 0, "J");
				$this->Ln(0);
				// =========================================================================================
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space-1, 5, 'p. ', 0, 0, 'C');
				
				$this->MultiCell(70-10,5,"Bekerja adalah kegiatan ekonomi yang dilakukan seseorang dengan maksud memperoleh pendapatan atau keuntungan dan/atau untuk mencari nafkah sebagai mata pencaharian.", 0, "J");
				$this->Ln(0);
				// =========================================================================================
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space-1, 5, 'q. ', 0, 0, 'C');
				
				$this->MultiCell(70-10,5,"Menikah adalah melakukan ikatan (akad) perkawinan yang sah antara laki-laki dan perempuan sebagai suami dan istri yang dilakukan sesuai dengan ketentuan hukum yang berlaku.", 0, "J");
				$this->Ln();
			
			$this->SetFont('Arial','B',10);
			// Output text in a 6 cm width column
			$this->Cell($this->num_space-5, $height, NULL, 0, 0, 'C');
            $this->MultiCell(90,5,"PASAL 2\nHAK UNTUK MEMPELAJARI POLIS\n(FREE LOOK PROVISION)", 0,'C',false);
			$this->Ln(5);
			$this->SetFont('Arial','',10);
			// Pasal 2 Paragpaph 1
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell($this->num_space+2, 5, "(1)", 0, 0, 'C');
			$this->MultiCell(70-2,5,"Pemegang Polis mempunyai hak untuk mempelajari Polis dalam waktu 14 (empat belas) hari kalender sejak Polis diterima Pemegang Polis. Pemegang Polis hanya memiliki 2 (dua) pilihan keputusan, yaitu :", 0, "J");
			$this->Ln(0);
				// Subcell Pasal 1 Paragpaph 2
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space-1, 5, 'a. ', 0, 0, 'C');
				
				$this->MultiCell(70-10,5,"Setuju dengan semua ketentuan dalam Polis secara keseluruhan;\natau", 0, "J");
				$this->Ln(0);
				// =========================================================================================
				$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
				$this->Cell($this->num_space+1, 5, NULL, 0, 0, 'C');
				$this->Cell($this->num_space-1, 5, 'b. ', 0, 0, 'C');
				
				$this->MultiCell(70-10,5,"Tidak setuju dengan semua ketentuan dalam Polis secara keseluruhan.", 0, "J");
				$this->Ln(2);
			
			// Pasal 2 Paragpaph 2
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell($this->num_space+2, 5, "(2)", 0, 0, 'C');
			$this->MultiCell(70-2,5,"Jika Pemegang Polis menyatakan sebagaimana tercantum pada ayat (1) butir b, maka Pemegang Polis harus memberitahukan secara tertulis kepada Penanggung dan pemberitahuan itu harus sudah diajukan ke Penanggung paling lambat 14 (empat belas) hari kalender sejak Polis diterima Pemegang Polis. Jika dalam kurun waktu tersebut, Penanggung tidak menerima pemberitahuan secara tertulis dari Pemegang Polis, maka Pemegang Polis dianggap setuju dengan semua Ketentuan Polis secara ", 0, "J");
			$this->Ln(0);
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell($this->num_space, 5, null, 0, 0, 'C');
			$this->MultiCell(70,5,"keseluruhan.", 0, "J");
			$this->Ln(5);
			
			// Pasal 2 Paragpaph 3
			//$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell($this->num_space, 5, "(3)", 0, 0, 'C');
			$this->MultiCell(70,5,"Jika Pemegang Polis menyatakan sebagaimana tercantum dalam ayat (1) butir b, maka Pemegang Polis harus mengembalikan dokumen Polis kepada Penanggung dan dengan sendirinya Polis menjadi batal sejak awal dan Penanggung akan mengembalikan Premi yang telah disetor kepada Pemegang Polis. Biaya yang timbul atas pencetakan polis baik berupa biaya polis, biaya meterai, biaya pemeriksaan kesehatan dan sebagainya (jika ada), tidak dikembalikan", 0, "J");
			$this->Ln(5);
			
			$this->SetFont('Arial','B',10);
			// Output text in a 6 cm width column
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
            $this->MultiCell(70,5,"PASAL 3\nDASAR PERJANJIAN ASURANSI", 0,'C',false);
			$this->Ln(5);
			$this->SetFont('Arial','',10);
			
			// Pasal 3 Paragpaph 1
			//$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell($this->num_space, 5, "(1)", 0, 0, 'C');
			$this->MultiCell(70,5,"Pemegang	Polis	dan/atau Tertanggung wajib menyampaikan kepada Penanggung SPAJ, formulir- formulir dan dokumen-dokumen lain yang disyaratkan setelah diisi atau dibuat secara benar dan lengkap sebagai dasar diadakannya Polis dan oleh karenanya merupakan bagian yang tidak terpisahkan dari Polis. Kebenaran dokumen tersebut menjadi tanggung jawab Pemegang Polis dan/atau Tertanggung.", 0, "J");
			$this->Ln(2);
			
			// Pasal 3 Paragpaph 2
			//$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell($this->num_space, 5, "(2)", 0, 0, 'C');
			$this->MultiCell(70,5,"Apabila keterangan, pernyataan atau pemberitahuan (selain mengenai hal- hal sebagaimana tercantum pada ayat (3)	di Pasal ini) yang disampaikan kepada Penanggung ternyata keliru atau tidak benar atau ternyata terdapat penyembunyian keadaan yang diketahui oleh Pemegang Polis dan/atau Tertanggung, meskipun dilakukannya dengan itikad baik, yang sifatnya sedemikian rupa sehingga pertanggungan dan/atau Polis tidak akan diadakan atau ", 0, "J");
			$this->Ln(0);
			// Pasal 3 Paragpaph 2 Lanjutan
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell($this->num_space, 5, NULL, 0, 0, 'C');
			$this->Cell($this->num_space+2, 5, NULL, 0, 0, 'C');
			$this->MultiCell(70-2,5,"tidak diadakan dengan syarat-syarat yang sama bila Penanggung mengetahui keadaan yang sesungguhnya dari hal itu, maka pertanggungan dan Polis dengan sendirinya menjadi batal sejak pertanggungan dimulai, dan dalam hal demikian Penanggung akan mengembalikan sisa dana (jika ada) sesuai ketentuan yang berlaku di Penanggung.", 0, "J");
			$this->Ln(2);
			// Pasal 3 Paragpaph 3
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell($this->num_space+2, 5, "(3)", 0, 0, 'C');
			$this->MultiCell(70-2,5,"Dengan persetujuan Penanggung, perjanjian Asuransi dapat dilanjutkan dalam hal terjadi kesalahan atau kekeliruan sepanjang kesalahan atau kekeliruan tersebut tidak materiil, setelah terlebih dahulu diadakan penyesuaian dengan keadaan sebenarnya.", 0, "J");
			$this->Ln(5);
			
			$this->SetFont('Arial','B',10);
			// Output text in a 6 cm width column
			$this->Cell($this->num_space-5, $height, NULL, 0, 0, 'C');
            $this->MultiCell(90,5,"PASAL 4\nMULAI BERLAKU DAN BERAKHIRNYA\nASURANSI", 0,'C',false);
			$this->Ln(5);
			$this->SetFont('Arial','',10);
			
			// Pasal 4 Paragpaph 1
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell($this->num_space+2, 5, "(1)", 0, 0, 'C');
			$this->MultiCell(70-2,5,"Tanpa mengurangi ketentuan Pasal 3 di atas, Asuransi IFG Premier Annuity Plan mulai berlaku sejak Tanggal Mulai Asuransi yang tertera pada Polis atau dalam	Perubahan	Polis (lampiran/klausula Polis) dengan ketentuan bahwa Premi sekaligus telah dilunasi.", 0, "J");
			$this->Ln(2);
			// Pasal 4 Paragpaph 2
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell($this->num_space+2, 5, "(2)", 0, 0, 'C');
			$this->MultiCell(70-2,5,"Polis tidak dapat diubah, ditambah atau dikurangi oleh siapa pun selain atas persetujuan Pemegang Polis dan Penanggung, kecuali diatur lain di dalam Syarat-Syarat Umum Polis Asuransi Jiwa Perorangan ini atau di dalam ketentuan-ketentuan lainnya yang merupakan lampiran yang tak terpisahkan dari Polis.", 0, "J");
			$this->Ln(2);
			// Pasal 4 Paragpaph 3
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->Cell($this->num_space+2, 5, "(3)", 0, 0, 'C');
			$this->MultiCell(70-2,5,"Asuransi IFG Premier Annuity Plan berakhir setelah tidak ada lagi Penerima Manfaat Anuitas yang berhak menerima Manfaat Anuitas menurut ketentuan Manfaat Anuitas IFG Premier Annuity Plan.", 0, "J");
			$this->Ln(7);
			
			/*
			$this->SetFont('Arial','B',10);
			// Output text in a 6 cm width column
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
            $this->MultiCell(70,5,"PASAL 5\nKETENTUAN TIDAK DAPAT\nDISANGGAH\n(INCONTESTABLE PERIOD)", 0,'C',false);
			$this->Ln(5);
			$this->SetFont('Arial','',10);
			*/
			
			/*
			$this->SetFont('Arial','',10);
			$this->Cell($this->num_space, $height, NULL, 0, 0, 'C');
			$this->MultiCell(70,5,$txt);
			$this->Ln();
			
			$this->Ln();
			// Mention
			$this->SetFont('','I');
			$this->Cell(0,5,'(end of excerpt)');
			*/
			// Go back to first column
			$this->SetCol(0);
		}

		private function PrintChapter($num, $title, $file)
		{
			// Add chapter
			//$this->AddPage();
			$this->ChapterTitle($num,$title);
			$this->ChapterBody($file);
		}
		
		function WriteHTML($html)
		{
			//HTML parser
			$html=str_replace("\n",' ',$html);
			$a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
			foreach($a as $i=>$e)
			{
				if($i%2==0)
				{
					//Text
					if($this->HREF)
						$this->PutLink($this->HREF,$e);
					elseif($this->ALIGN=='center')
						$this->Cell(0,5,$e,0,1,'C');
					else
						$this->Write(5,$e);
				}
				else
				{
					//Tag
					if($e[0]=='/')
						$this->CloseTag(strtoupper(substr($e,1)));
					else
					{
						//Extract properties
						$a2=explode(' ',$e);
						$tag=strtoupper(array_shift($a2));
						$prop=array();
						foreach($a2 as $v)
						{
							if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
								$prop[strtoupper($a3[1])]=$a3[2];
						}
						$this->OpenTag($tag,$prop);
					}
				}
			}
		}

	    function OpenTag($tag,$prop)
		{
			//Opening tag
			if($tag=='B' || $tag=='I' || $tag=='U')
				$this->SetStyle($tag,true);
			if($tag=='A')
				$this->HREF=$prop['HREF'];
			if($tag=='BR')
				$this->Ln(5);
			if($tag=='P')
				$this->ALIGN=$prop['ALIGN'];
			if($tag=='HR')
			{
				if( !empty($prop['WIDTH']) )
					$Width = $prop['WIDTH'];
				else
					$Width = $this->w - $this->lMargin-$this->rMargin;
				$this->Ln(2);
				$x = $this->GetX();
				$y = $this->GetY();
				$this->SetLineWidth(0.4);
				$this->Line($x,$y,$x+$Width,$y);
				$this->SetLineWidth(0.2);
				$this->Ln(2);
			}
		}

		function CloseTag($tag)
		{
			//Closing tag
			if($tag=='B' || $tag=='I' || $tag=='U')
				$this->SetStyle($tag,false);
			if($tag=='A')
				$this->HREF='';
			if($tag=='P')
				$this->ALIGN='';
		}

		function SetStyle($tag,$enable)
		{
			//Modify style and select corresponding font
			$this->$tag+=($enable ? 1 : -1);
			$style='';
			foreach(array('B','I','U') as $s)
				if($this->$s>0)
					$style.=$s;
			$this->SetFont('',$style);
		}

		function PutLink($URL,$txt)
		{
			//Put a hyperlink
			$this->SetTextColor(0,0,255);
			$this->SetStyle('U',true);
			$this->Write(5,$txt,$URL);
			$this->SetStyle('U',false);
			$this->SetTextColor(0);
		}
		
		private function tgl_indonesia($tanggal) {
			$tanggal = empty($tanggal) ? date('d/m/Y') : $tanggal;
			$bulan	 = array("JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI", "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER");
			$tgl	 = substr($tanggal, 0, 2);
			$bln	 = substr($tanggal, 3, 2);
			$thn	 = substr($tanggal, 6, 4);
			
			return $tgl." ".$bulan[$bln-1]." ".$thn;
		}
		
		private function changeIndititle($no_h, $text){
			$no	   = $no_h == 1 ? 'A. '
				   : ($no_h == 2 ? 'B. ' 
				   : ($no_h == 3 ? 'C. ' 
				   : ($no_h == 4 ? 'D. ' 
				   : ($no_h == 5 ? 'E. ' 
				   : ($no_h == 6 ? 'F. ' 
				   : ($no_h == 7 ? 'G. ' : $no_h))))));
			
			return $no;
		}
		
		private function font_title($bold = false) {
			$this->SetFont('Arial', $bold ? 'B' : '', 12);
		}
		
		private function font_body($bold = false) {
			$this->SetFont('Arial', $bold ? 'B' : '', 9);
		}
		
		private function custom_font($size, $bold) {
			$this->SetFont('Arial', $bold ? 'B' : '', $size);
		}
		
		private function font_ttd($bold = false) {
			$this->SetFont('Arial', $bold ? 'B' : '', 6);
		}
		
		private function font_footer($bold = false) {
			//$this->SetFont('Arial', $bold ? 'B' : '', 8);
		}
		
		
	
	}
	
			
	$pdf = new CetakPolis($data);
	$pdf->AliasNbPages();
	$pdf->Output();
?>