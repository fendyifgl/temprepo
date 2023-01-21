<?
    include "../../includes/database.php";  
    include "../../includes/session.php";
    include "../../includes/common.php";
    include "../includes/monthselector.php";
    include "../../includes/klien.php";
    include "../../includes/pertanggungan.php";

    $DB = new Database($userid,$passwd,$DBName);
	
	$sql = "SELECT prefixpertanggungan, nopertanggungan
			FROM $DBUser.tabel_200_pertanggungan
			WHERE nopolbaru = '$nopolbaru'";
	$DB->parse($sql);
	$DB->execute();
	$r = $DB->nextrow();
	
	if (empty($prefixpertanggungan))
		$prefixpertanggungan = $r['PREFIXPERTANGGUNGAN'];
	if (empty($nopertanggungan))
		$nopertanggungan = $r['NOPERTANGGUNGAN'];
	
    $PER=New Pertanggungan($userid,$passwd,$prefixpertanggungan,$nopertanggungan);
    $KLN=New Klien($userid,$passwd,$PER->notertanggung);
    $KLN2=New Klien($userid,$passwd,$PER->nopemegangpolis);

    $sql =  "UPDATE $DBUser.tabel_214_acceptance_dokumen
                SET kdcetaktterima='1',usercetaktterima=user,tglcetaktterima=sysdate 
             WHERE prefixpertanggungan='$prefixpertanggungan' and nopertanggungan='$nopertanggungan'";
    $DB->parse($sql);
    $DB->execute();
    $DB->commit();

    $sqla = "SELECT A.PREFIXPERTANGGUNGAN,
                A.NOPERTANGGUNGAN, A.NOPOLBARU,
                C.KDKIRIMPOLIS,
                CASE
                    WHEN C.KDKIRIMPOLIS = 'alamatkorespondensi' THEN B.ALAMATTAGIH01  
                    ELSE B.ALAMATTETAP01
                END ALAMAT01,
                CASE
                    WHEN C.KDKIRIMPOLIS = 'alamatkorespondensi' THEN B.ALAMATTAGIH02  
                    ELSE B.ALAMATTETAP02
                END ALAMAT02,
                CASE
                    WHEN C.KDKIRIMPOLIS = 'alamatkorespondensi' THEN (SELECT NAMAKOTAMADYA FROM $DBUser.TABEL_109_KOTAMADYA WHERE KDKOTAMADYA = B.KDKOTAMADYATAGIH)
                    ELSE (SELECT NAMAKOTAMADYA FROM $DBUser.TABEL_109_KOTAMADYA WHERE KDKOTAMADYA = B.KDKOTAMADYATETAP)
                END KOTA,
                CASE
                    WHEN C.KDKIRIMPOLIS = 'alamatkorespondensi' THEN (SELECT NAMAPROPINSI FROM $DBUser.TABEL_108_PROPINSI WHERE KDPROPINSI = (SELECT KDPROPINSI FROM $DBUser.TABEL_109_KOTAMADYA WHERE KDKOTAMADYA = B.KDKOTAMADYATAGIH))
                    ELSE (SELECT NAMAPROPINSI FROM $DBUser.TABEL_108_PROPINSI WHERE KDPROPINSI = (SELECT KDPROPINSI FROM $DBUser.TABEL_109_KOTAMADYA WHERE KDKOTAMADYA = B.KDKOTAMADYATETAP))
                END PROPINSI,
                CASE
                    WHEN C.KDKIRIMPOLIS = 'alamatkorespondensi' THEN B.KODEPOSTAGIH
                    ELSE B.KODEPOSTETAP
                END KODEPOS
				/*B.ALAMATTETAP01, B.ALAMATTETAP02, (SELECT NAMAKOTAMADYA FROM $DBUser.TABEL_109_KOTAMADYA WHERE KDKOTAMADYA = B.KDKOTAMADYATETAP) KOTA,
				(SELECT NAMAPROPINSI FROM $DBUser.TABEL_108_PROPINSI WHERE KDPROPINSI = (SELECT KDPROPINSI FROM $DBUser.TABEL_109_KOTAMADYA WHERE KDKOTAMADYA = B.KDKOTAMADYATETAP)) PROPINSI,
				B.KODEPOSTETAP*/
            FROM $DBUser.TABEL_200_PERTANGGUNGAN A
                LEFT JOIN $DBUser.TABEL_100_KLIEN B ON B.NOKLIEN = A.NOPEMEGANGPOLIS
                LEFT OUTER JOIN $DBUser.TABEL_SPAJ_ONLINE C ON A.NOSP = C.NOSPAJ
            WHERE A.PREFIXPERTANGGUNGAN = '$prefixpertanggungan'
                AND A.NOPERTANGGUNGAN = '$nopertanggungan'";
    $DB->parse($sqla);
    $DB->execute();
    $arra=$DB->nextrow();

    $sql = "SELECT to_char(sysdate,'DD') tgl,to_char(sysdate,'MM') bln, to_char(sysdate,'YYYY') thn FROM dual";
    $DB->parse($sql);
    $DB->execute();
    $arx=$DB->nextrow();

    $tgl=$arx["TGL"];
    $bln=$arx["BLN"];
    $thn=$arx["THN"];
    switch($bln){
        case  01 : $bln="Januari"; break;
        case  02 : $bln="Pebruari"; break;
        case  03 : $bln="Maret"; break;
        case  04 : $bln="April"; break;
        case  05 : $bln="Mei"; break;
        case  06 : $bln="Juni"; break;
        case  07 : $bln="Juli"; break;
        case  08 : $bln="Agustus"; break;
        case  09 : $bln="September"; break;
        case  10 : $bln="Oktober"; break;
        case  11 : $bln="Nopember"; break;
        case  12 : $bln="Desember"; break;
    }

    
    $sql = "SELECT NILAIBENEFIT FROM $DBUser.TABEL_223_TRANSAKSI_PRODUK WHERE KDBENEFIT = 'DNAWL' AND PREFIXPERTANGGUNGAN = '$prefixpertanggungan' AND NOPERTANGGUNGAN = '$nopertanggungan'";
    $DB->parse($sql);
    $DB->execute();
    $arr_dn=$DB->nextrow();

    require_once('../pelaporan/libs/fpdf/fpdf.php');
    require_once('../pelaporan/libs/fpdf/gen_barcode_39.php');
    $pdf = new FPDF('P','mm','A4');
    $pdf = new PDF_Code39();
    
    $pdf->AddPage();

    /*** HEADER ***/
    $pdf->ln(25);
    $pdf->SetLeftMargin(20);

    $logo_js = '../images/logo-ifg.png';
    $logo_bumn = '../images/logo_bumn.png';
    
    //$pdf->Image($logo_bumn, 21, 18, 47, 9);
    $pdf->Image($logo_js, 162, 10, 30, 30);

    $pdf->SetFont('Arial','',9);
    $pdf->Cell(100,4,'',0,0,'L');
    $pdf->Cell(70,4,'Jakarta, '.$tgl.'/'.$bln.'/'.$thn,0,0,'R');
    $pdf->ln(12);

    $pdf->Cell(100,4,'Kepada Yth,',0,0,'L');
    $pdf->Cell(70,4,'',0,0,'R');
    $pdf->ln(5);

    // $pdf->Cell(100,4,'Bapak/Ibu. '.$PER->namapemegangpolis,0,0,'L');
    // $pdf->ln(5);
    // $pdf->Cell(100,4,$KLN2->alamattagih1,0,0,'L');
    // $pdf->ln(5);
    // $pdf->Cell(100,4,$KLN2->alamattagih2,0,0,'L');
    // $pdf->ln(5);
    // $pdf->Cell(100,4,$KLN2->namakodyatagih.' - '.$KLN2->propinsitagih.' '.$KLN2->kodepostagih,0,0,'L');
    // $pdf->ln(15);

    $pdf->Cell(100,4,'Bapak/Ibu. '.$PER->namapemegangpolis,0,0,'L');
    $pdf->ln(5);
    // $pdf->Cell(100,4,$arra["ALAMAT01"],0,0,'L');
    // $pdf->ln(5);
    // $pdf->Cell(100,4,$arra["ALAMAT02"],0,0,'L');
    // $pdf->ln(5);

    $pdf->SetFont('Arial','',8);
    $pdf->MultiCell(90,4,$arra["ALAMAT01"],0,'L','');

    //$pdf->Cell(90,4,$arra["KOTA"].' - '.$arra["PROPINSI"].' '.$arra["KODEPOS"],0,0,'L');
    $pdf->ln(10);


    $pdf->SetFont('Arial','',9);
    $pdf->Cell(100,4,'Dengan Hormat,',0,0,'L');
    $pdf->ln(8);
    $pdf->Cell(20,4,'Perihal:',0,0,'L');
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(140,4,'PENGANTAR POLIS / TANDA TERIMA',0,0,'C');
    $pdf->ln(8);

    $pdf->SetFont('Arial','',9);
    $pdf->Cell(170,4,'Bersama ini kami kirimkan Polis Asuransi Jiwa Nomor './*$prefixpertanggungan.'-'.$nopertanggungan*/$arra['NOPOLBARU'].' dengan spesifikasi sebagai berikut :',0,0,'L');
    $pdf->ln(6);

    $pdf->Cell(5,4,'-',0,0,'L');
    $pdf->Cell(55,4,'Pemegang Polis',0,0,'L');
    $pdf->Cell(110,4,': '.$PER->namapemegangpolis,0,0,'L');
    $pdf->ln(5);

    $pdf->Cell(5,4,'-',0,0,'L');
    $pdf->Cell(55,4,'Tertanggung',0,0,'L');
    $pdf->Cell(110,4,': '.$PER->namatertanggung,0,0,'L');
    $pdf->ln(5);

    $pdf->Cell(5,4,'-',0,0,'L');
    $pdf->Cell(55,4,'Macam Asuransi',0,0,'L');
    $pdf->Cell(110,4,': '.$PER->namaproduk,0,0,'L');
    $pdf->ln(5);

    if (in_array($PER->produk, array('APP65','APP75','APP85', 'APPSH'))){
		if(date('H:i:s', strtotime($PER->mulas)) == '00:00:00' || substr($PER->mulas, 11, 19) == '00:00:00'){
			$PER->mulas = substr($PER->mulas, 0, 10);
		}
	}

    $pdf->Cell(5,4,'-',0,0,'L');
    $pdf->Cell(55,4,'Mulai Asuransi',0,0,'L');
    $pdf->Cell(110,4,': '.$PER->mulas,0,0,'L');
    $pdf->ln(5);

    $pdf->Cell(5,4,'-',0,0,'L');
    $pdf->Cell(55,4,'Nomor SPAJ',0,0,'L');
    $pdf->Cell(110,4,': '.$PER->nosp,0,0,'L');
    $pdf->ln(5);

    if (in_array($PER->produk, array('APPSH'))) {
		
		$pdf->Cell(5,4,'-',0,0,'L');
		$pdf->Cell(55,4,'Masa Asuransi',0,0,'L');
		$pdf->Cell(110,4,': Seumur Hidup',0,0,'L');
		$pdf->ln(5);
	} else {
		$pdf->Cell(5,4,'-',0,0,'L');
		$pdf->Cell(55,4,'Masa Asuransi',0,0,'L');
		
		$pdf->Cell(110,4,': '.$PER->lamaasuransi.' Tahun, '.$PER->lamaasuransi_bl.' Bulan',0,0,'L');
		$pdf->ln(5);
	}

    if (in_array($PER->produk, array('APP65','APP75','APP85', 'APPSH'))){
		$textAnuitas = 'Anuitas Sebulan';
	}else{
		$textAnuitas = 'Jumlah Uang Asuransi';
		
		$pdf->Cell(5,4,'-',0,0,'L');
		$pdf->Cell(55,4,'Masa Pembayaran Premi',0,0,'L');
		$pdf->Cell(110,4,': '.$PER->lamapremi.' Tahun, '.$PER->lamapremi_bl.' Bulan',0,0,'L');
		$pdf->ln(5);
	}

    $pdf->Cell(5,4,'-',0,0,'L');
    $pdf->Cell(55,4,$textAnuitas,0,0,'L');
    $pdf->Cell(10,4,': '.$PER->notasi,0,0,'L');
    $pdf->Cell(25,4,number_format($PER->jua,2, ',','.'),0,0,'R');
    $pdf->ln(5);

    $pdf->Cell(5,4,'-',0,0,'L');
    $pdf->Cell(55,4,'Premi Sebesar',0,0,'L');
    $pdf->Cell(10,4,': '.$PER->notasi,0,0,'L');
    $pdf->Cell(25,4,number_format($PER->premi1,2, ',','.'),0,0,'R');
    $pdf->ln(7);

    $pdf->MultiCell(170,4.2,'Mohon kiranya Bapak/Ibu mencocokkan data yang tercantum dalam Polis dan mempelajari Syarat-syarat Umum Polis Asuransi Jiwa Perorangan yang tercantum di halaman dalam Polis yang merupakan bagian dan satu kesatuan yang tidak terpisahkan dari Polis.',0,'J','');
    $pdf->ln(3);

    $pdf->MultiCell(170,4.2,'Apabila dalam tenggang waktu 14 (empat belas) hari kalender sejak diterimanya surat ini, kami tidak menerima pemberitahuan dari Bapak/Ibu, maka kami menganggap dan menyatakan bahwa Bapak/Ibu memahami dan menyetujui segala sesuatu yang tercantum dalam Polis terlampir.',0,'J','');
    $pdf->ln(3);

    $pdf->MultiCell(170,4.2,'Mohon Bapak/Ibu simpan dan pelihara Polis ini dengan baik, dan jika hilang mohon segera diberitahukan kepada kami untuk dibuatkan Polis duplikat.',0,'J','');
    $pdf->ln(5);

    $pdf->Cell(15,5,'Catatan : ','LT',0,'L');
    $pdf->Cell(40,5,'Biaya Polis Duplikat I','T',0,'L');
    $pdf->Cell(8,5,'Rp','T',0,'L');
    $pdf->Cell(27,5,'100.000,00','TR',0,'L');
    $pdf->ln(5);

    $pdf->Cell(15,5,'','L',0,'L');
    $pdf->Cell(40,5,'Biaya Polis Duplikat II',0,0,'L');
    $pdf->Cell(8,5,'Rp',0,0,'L');
    $pdf->Cell(27,5,'200.000,00','R',0,'L');
    $pdf->ln(5);

    $pdf->Cell(15,5,'','LB',0,'L');
    $pdf->Cell(40,5,'Biaya Polis Duplikat III','B',0,'L');
    $pdf->Cell(8,5,'Rp','B',0,'L');
    $pdf->Cell(27,5,'300.000,00','RB',0,'L');
    $pdf->ln(5);

    $pdf->Cell(145,4,'----------------------------------------------------------------------------------------------------------------------------------------',0,0,'L');
    $pdf->SetFont('Arial','BI',9);
    $pdf->Cell(25,4,'gunting disini',0,0,'L');
    $pdf->ln(5);

    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(170,4,'TANDA TERIMA POLIS',0,0,'L');
    $pdf->ln(5);

    $pdf->SetFont('Arial','',9);
    $pdf->MultiCell(170,4.2,'Mohon Tanda Terima Polis ditandatangani dan dikirimkan ke PT. Asuransi Jiwa IFG terdekat atau ke PT. Asuransi Jiwa IFG Kantor Pusat dengan alamat :',0,'J','');
    $pdf->ln();

    $sql = "SELECT alamat01, alamat02, kodepos FROM $DBUser.tabel_001_kantor WHERE kdkantor = 'KP'";
    $DB->parse($sql);
    $DB->execute();
    $arr_ktr=$DB->nextrow();
	
	
	$x = $pdf->GetX();
	$y = $pdf->GetY();

    $pdf->MultiCell(77, 5, "PT. ASURANSI JIWA IFG\nKantor Pusat\n{$arr_ktr['ALAMAT01']} {$arr_ktr['ALAMAT02']} - {$arr_ktr['KODEPOS']}", 1, 'J');
	$pdf->SetXY($x + 77 + 8, $y);
	$pdf->MultiCell(85, 5, "Diterima dan disetujui\nPolis Nomor         :  {$arra['NOPOLBARU']}", 'LTR', 'J');

    $y = $pdf->GetY();
	$pdf->SetXY($x + 77 + 8, $y);
	
	$br = "\n\n";
	if(strlen($PER->namapemegangpolis) > 60){
		$br .= "\n";
	}

    $pdf->MultiCell(63, 5, "Pemegang Polis  : {$br}", 'L', 'J');

    $x = $pdf->GetX();
	$pdf->SetXY($x + 77 + 8 + 28, $y);
	$pdf->MultiCell(57, 5, $PER->namapemegangpolis, 'R', 'J');
	
	$y = $pdf->GetY();
	$pdf->SetXY($x + 77 + 8, $y);
	$pdf->MultiCell(85, 5, "\n...................................., tanggal .........../.........../..................\n\n\n\n\n   (                                                                                     )", 'LRB', 'LRB');

    /*
	$pdf->ln(55);
	
    $pdf->Cell(77,5,'PT. ASURANSI JIWA IFG','LTR',0,'L');
    $pdf->Cell(8,5,'',0,0,'L');
    $pdf->Cell(85,5,'Diterima dan disetujui','LTR',0,'L');
    $pdf->ln(5);

    $pdf->Cell(77,5,'Kantor Pusat','LR',0,'L');
    $pdf->Cell(8,5,'',0,0,'L');
    $pdf->Cell(25,5,'Polis Nomor','L',0,'L');
    $pdf->Cell(60,5,': './*$prefixpertanggungan.'-'.$nopertanggungan$arra['NOPOLBARU'],'R',0,'L');
    $pdf->ln(5);

    

    $pdf->Cell(77,5,$arr_ktr['ALAMAT01'],'LR',0,'L');
    $pdf->Cell(8,5,'',0,0,'L');
    $pdf->Cell(25,5,'Pemegang Polis','L',0,'L');
    $pdf->MultiCell(60,5,': '.$PER->namapemegangpolis, 0, 'J');
    $pdf->ln(5);

    $pdf->Cell(77,5,$arr_ktr['ALAMAT02'].' - '.$arr_ktr['KODEPOS'],'LRB',0,'L');
    $pdf->Cell(8,5,'',0,0,'L');
    $pdf->Cell(25,5,'.............................','L',0,'L');
    $pdf->Cell(60,5,', tanggal .........../.........../..................','R',0,'L');
    $pdf->ln(5);

    $pdf->Cell(85,20,'',0,0,'L');
    $pdf->Cell(85,20,'','LR',0,'L');
    $pdf->ln(15);

    $pdf->Cell(85,5,'',0,0,'L');
    $pdf->Cell(85,5,'   (                                                                                     )','LRB',0,'L');
    */
    
    $sql = "SELECT C.KDMAPPING, A.NOPOLBARU
            FROM $DBUser.TABEL_200_PERTANGGUNGAN A,
                $DBUser.TABEL_500_PENAGIH B,
                $DBUser.TABEL_001_KANTOR C
            WHERE A.NOPENAGIH = B.NOPENAGIH
                AND B.KDRAYONPENAGIH = C.KDKANTOR
                AND A.PREFIXPERTANGGUNGAN = '".$prefixpertanggungan."' 
                AND A.NOPERTANGGUNGAN = '".$nopertanggungan."'";
    $DB->parse($sql);
    $DB->execute();
    $arrd=$DB->nextrow();
    //$idbarcode = $prefixpertanggungan.$nopertanggungan;
	$idbarcode = $arrd['NOPOLBARU'];

    $pdf->SetFillColor(0,0,0);
    $code=$idbarcode;
    $pdf->Code39(21,35,$code,0.8,7);
    $pdf->SetFont('Times','',6);
    $pdf->SetXY(20,41);
    $pdf->Write(5,$code); 

    $pdf->output();
    //$namafile = $prefixpertanggungan.$nopertanggungan."-".$PER->produk."-TANDATERIMA.PDF";
    //$pdf->Output($namafile,'D');
?>