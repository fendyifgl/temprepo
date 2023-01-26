<?
   include "../../includes/session.php";
   include "../../includes/database.php";

   $conn = ocilogon($userid,$passwd,$DBName);
        
   $nama_hari = array(1=>"Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu", "Minggu");   
   
   $x= mktime(0, 0, 0, $row["BLN"], $row["TGL"],  $row["THN"]);
   $namahari=date("l", $x);
   if ($namahari == "Sunday") $namahari = "Minggu";
   else if ($namahari == "Monday") $namahari = "Senin";
   else if ($namahari == "Tuesday") $namahari = "Selasa";
   else if ($namahari == "Wednesday") $namahari = "Rabu";
   else if ($namahari == "Thursday") $namahari = "Kamis";
   else if ($namahari == "Friday") $namahari = "Jumat";
   else if ($namahari == "Saturday") $namahari = "Sabtu";
   
   $nama_bulan = array(1=>"JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI", "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER");   
   
   $DBX=new Database($userid,$passwd,$DBName);
   $sqlt="select $DBUser.terbilang (".$row["THN"].") bilangan from dual";
   $DBX->parse($sqlt);
   $DBX->execute();
   $arrt=$DBX->nextrow();
   $tahun=ucwords(strtolower(str_replace('RUPIAH','',$arrt["BILANGAN"])));
   
   $sqltgl="select $DBUser.terbilang (".$row["TGL"].") bilangan from dual";
   $DBX->parse($sqltgl);
   $DBX->execute();
   $arrtgl=$DBX->nextrow();
   $tanggal=ucwords(strtolower(str_replace('RUPIAH','',$arrtgl["BILANGAN"])));

   $sqlDetail = "
                  SELECT A.*,
                     TO_CHAR(A.TGLPENETAPAN,'DDMMYYYY') AS TGLBERLAKU,
                     TO_CHAR(A.TGL_PENGUNDURAN_DIRI,'DDMMYYYY') AS TGLRESIGN,
                     TO_CHAR(A.TGL_REKOMENDASI_SAM,'DDMMYYYY') AS TGLREKOMENDASISAM,
                     TO_CHAR(A.TGL_PERSETUJUAN_RAH,'DDMMYYYY') AS TGLPERSETUJUANRAH,
                     (SELECT H.NAMAKLIEN1 FROM $DBUser.TABEL_100_KLIEN H WHERE A.NOAGEN = H.NOKLIEN) AS NAMAAGEN,
                     (SELECT H.ALAMATTETAP01 FROM $DBUser.TABEL_100_KLIEN H WHERE A.NOAGEN = H.NOKLIEN) AS ALAMATAGEN,
                     (SELECT H.NOID FROM $DBUser.TABEL_100_KLIEN H WHERE A.NOAGEN = H.NOKLIEN) AS NOKTP,
                     B.TGLPKAJAGEN,
                     (SELECT F.NAMAJABATANAGEN FROM $DBUser.TABEL_413_JABATAN_AGEN F WHERE A.KDJABATANAGEN = F.KDJABATANAGEN) AS JABATAN_BARU,
                     (SELECT E.NAMAKLIEN1 FROM $DBUser.TABEL_100_KLIEN E WHERE A.ATASAN_BARU = E.NOKLIEN) AS ATASAN_BARU,
                     (SELECT M.NAMAKANTOR FROM $DBUser.TABEL_001_KANTOR M WHERE A.KDKANTOR = M.KDKANTOR) AS KANTOR,
                     (SELECT NAMA_TTD FROM $DBUser.TABEL_400_PENANDATANGANAN_PKAJ WHERE KODE_KANTOR = A.KDKANTOR AND JABATAN_AGEN = A.KDJABATANAGEN) AS NAMA_RAH,
                     (SELECT JABATAN_TTD FROM $DBUser.TABEL_400_PENANDATANGANAN_PKAJ WHERE KODE_KANTOR = A.KDKANTOR AND JABATAN_AGEN = A.KDJABATANAGEN) AS JABATAN_RAH
                  FROM $DBUser.TABEL_417_HISTORI_JABATAN A, $DBUser.TABEL_400_PKAJ_AGEN B, $DBUser.TABEL_400_AGEN C
                  WHERE A.KETERANGAN = '".$_GET['ket']."'
                       AND TO_CHAR(A.TGLJABATAN,'DDMMYYYY') = '".$_GET['tgljabatan']."'
                       AND A.NOAGEN = '".$_GET['noagen']."'
                       AND B.NOAGEN = A.NOAGEN
                       AND B.NOPKAJAGEN = A.NOPKAJAGEN
                       AND A.NOAGEN = C.NOAGEN
              ";
   //echo($sqlDetail);
    $detail=ociparse($conn, $sqlDetail);
    ociexecute($detail);
    ocifetch($detail);
    $bln='';
    $tglrekomendasisam = ociresult($detail,"TGLREKOMENDASISAM");
    $tglresign = ociresult($detail,"TGLRESIGN");
    $tglpersetujuanrah = ociresult($detail,"TGLPERSETUJUANRAH");
?>
<table border="0" cellpadding="0" cellspacing="0" style="width:460.45pt;border-collapse:collapse;" width="614">
  <tbody>
    <tr>
      <td colspan="6" style="width: 460.45pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="100%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:center;"><strong><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">&nbsp;</span></strong></p>
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:center;"><strong><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">SURAT&nbsp;</span></strong><strong><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">PEMUTUSAN/PENGAKHIRAN</span></strong></p>
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:center;"><strong><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">PERJANJIAN KEAGENAN ASURANSI JIWA</span></strong></p>
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:center;"><strong><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">PT. ASURANSI JIWA IFG</span></strong><strong><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;"></span></strong></p>
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:center;"><strong><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">NOMOR : &nbsp;</span></strong><strong><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;"><?=$_GET["ket"];?></span></strong><strong><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">0120</span></strong></p>
      </td>
    </tr>
    <tr>
      <td colspan="6" style="width: 460.45pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="100%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">&nbsp;</span></p>
      </td>
    </tr>
    <tr>
      <td style="width: 19.35pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="4.234527687296417%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">1.</span></p>
      </td>
      <td colspan="5" style="width: 441.1pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="95.76547231270358%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">Berdasarkan :</span></p>
      </td>
    </tr>
    <tr>
      <td style="width: 19.35pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="4.227642276422764%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">&nbsp;</span></p>
      </td>
      <td colspan="2" style="width: 19.15pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="4.227642276422764%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">a</span><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">.</span></p>
      </td>
      <td colspan="3" style="width: 421.95pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="91.54471544715447%">
      <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">
Peraturan Direksi PT Asuransi Jiwa IFG Nomor 0016/PER-DIR/AJIFG/HKM/III/2021 tanggal 12 Maret 2021
      tentang Pedoman Sistem Keagenan Bisnis Ritel PT Asuransi Jiwa IFG</span></p>
      </td>
    </tr>
    <tr>
      <td style="width: 19.35pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="4.227642276422764%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">&nbsp;</span></p>
      </td>
      <td colspan="2" style="width: 19.15pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="4.227642276422764%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">b.</span></p>
      </td>
      <td colspan="3" style="width: 421.95pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="91.54471544715447%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">Perjanjian Keagenan Asuransi Jiwa &nbsp;nomor <?=$_GET["nopkaj"];?> tanggal <? if(substr($_GET["tglpkaj"],3,1) == 0) {$bln = substr($_GET["tglpkaj"],4,1);}else{$bln = substr($_GET["tglpkaj"],3,2);} echo substr($_GET["tglpkaj"],0,2)." ".ucwords(strtolower($nama_bulan[$bln]))." ".substr($_GET["tglpkaj"],-4);?> Pasal 10 ayat (1) huruf a&nbsp;</span></p>
      </td>
    </tr>
    <tr>
      <td colspan="6" style="width: 460.45pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="100%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">&nbsp;</span></p>
      </td>
    </tr>
    <tr>
      <td style="width: 19.35pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="4.234527687296417%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">2</span><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">.</span></p>
      </td>
      <td colspan="5" style="width: 441.1pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="95.76547231270358%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">Dengan Mempertimbangkan :</span></p>
      </td>
    </tr>
    <tr>
      <td style="width: 19.35pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="4.227642276422764%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">&nbsp;</span></p>
      </td>
      <td colspan="2" style="width: 19.15pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="4.227642276422764%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">a</span><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">.</span></p>
      </td>
      <td colspan="3" style="width: 421.95pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="91.54471544715447%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">Surat saudara/i tertanggal <? if(substr($tglresign,2,1) == 0) {$bln = substr($tglresign,3,1);}else{$bln = substr($tglresign,2,2);} echo substr($tglresign,0,2)." ".ucwords(strtolower($nama_bulan[$bln]))." ".substr($tglresign,-4);?> perihal <?=ociresult($detail,"PERIHAL_PENGUNDURAN_DIRI");?></span></p>
      </td>
    </tr>
    <tr>
      <td style="width: 19.35pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="4.227642276422764%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">&nbsp;</span></p>
      </td>
      <td colspan="2" style="width: 19.15pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="4.227642276422764%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">b.</span></p>
      </td>
      <td colspan="3" style="width: 421.95pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="91.54471544715447%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">Surat Rekomendasi Business Partner (BP) tanggal <? if(substr($tglrekomendasisam,2,1) == 0) {$bln = substr($tglrekomendasisam,3,1);}else{$bln = substr($tglrekomendasisam,2,2);} echo substr($tglrekomendasisam,0,2)." ".ucwords(strtolower($nama_bulan[$bln]))." ".substr($tglrekomendasisam,-4);?></span></p>
      </td>
    </tr>
    <tr>
      <td style="width: 19.35pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="4.227642276422764%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">&nbsp;</span></p>
      </td>
      <td colspan="2" style="width: 19.15pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="4.227642276422764%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">c.</span></p>
      </td>
      <td colspan="3" style="width: 421.95pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="91.54471544715447%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">Persetujuan dari Head of Agency Business tanggal <? if(substr($tglpersetujuanrah,2,1) == 0) {$bln = substr($tglpersetujuanrah,3,1);}else{$bln = substr($tglpersetujuanrah,2,2);} echo substr($tglpersetujuanrah,0,2)." ".ucwords(strtolower($nama_bulan[$bln]))." ".substr($tglpersetujuanrah,-4);?></span></p>
      </td>
    </tr>
    <tr>
      <td colspan="6" style="width: 460.45pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="100%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">&nbsp;</span></p>
      </td>
    </tr>
    <tr>
      <td colspan="6" style="width: 460.45pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="100%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">Dengan ini PT</span><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">&nbsp;</span><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">Asuransi Jiwa IFG memutuskan untuk mengakhiri P</span><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">erjanjian&nbsp;</span><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">K</span><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">eagenan&nbsp;</span><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">A</span><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">suransi&nbsp;</span><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">J</span><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">iwa (PKAJ)</span><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">&nbsp;:</span></p>
      </td>
    </tr>
    <tr>
      <td colspan="6" style="width: 460.45pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="100%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">&nbsp;</span></p>
      </td>
    </tr>
    <tr>
      <td colspan="2" style="width: 25.9pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="5.691056910569106%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">a.</span></p>
      </td>
      <td colspan="2" style="width: 122.95pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="26.666666666666668%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">Nama Agen</span></p>
      </td>
      <td style="width: 14.2pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="3.089430894308943%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">:</span></p>
      </td>
      <td style="width: 297.4pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="64.55284552845528%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;"><?=ucwords(strtolower(ociresult($detail,"NAMAAGEN")));?></span></p>
      </td>
    </tr>
    <tr>
      <td colspan="2" style="width: 25.9pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="5.691056910569106%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">b.</span></p>
      </td>
      <td colspan="2" style="width: 122.95pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="26.666666666666668%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">Nomor Agen</span></p>
      </td>
      <td style="width: 14.2pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="3.089430894308943%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">:</span></p>
      </td>
      <td style="width: 297.4pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="64.55284552845528%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;"><?=ucwords(strtolower(ociresult($detail,"NOAGEN")));?></span></p>
      </td>
    </tr>
    <tr>
      <td colspan="2" style="width: 25.9pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="5.691056910569106%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">c.</span></p>
      </td>
      <td colspan="2" style="width: 122.95pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="26.666666666666668%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">Nomor PKAJ</span></p>
      </td>
      <td style="width: 14.2pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="3.089430894308943%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">:</span></p>
      </td>
      <td style="width: 297.4pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="64.55284552845528%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;"><?=$_GET["nopkaj"];?>/EPKAJ/AGN/1218</span></p>
      </td>
    </tr>
    <tr>
      <td colspan="2" style="width: 25.9pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="5.691056910569106%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">d.</span></p>
      </td>
      <td colspan="2" style="width: 122.95pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="26.666666666666668%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">Jabatan Terakhir</span></p>
      </td>
      <td style="width: 14.2pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="3.089430894308943%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">:</span></p>
      </td>
      <td style="width: 297.4pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="64.55284552845528%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;"><?=ucwords(strtolower(ociresult($detail,"JABATAN_BARU")));?></span></p>
      </td>
    </tr>
    <tr>
      <td colspan="2" style="width: 25.9pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="5.691056910569106%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">e.</span></p>
      </td>
      <td colspan="2" style="width: 122.95pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="26.666666666666668%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">Alamat (sesuai KTP)</span></p>
      </td>
      <td style="width: 14.2pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="3.089430894308943%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">:</span></p>
      </td>
      <td style="width: 297.4pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="64.55284552845528%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;"><?=ucwords(strtolower(ociresult($detail,"ALAMATAGEN")));?></span></p>
      </td>
    </tr>
    <tr>
      <td colspan="2" style="width: 25.9pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="5.691056910569106%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">f.</span></p>
      </td>
      <td colspan="2" style="width: 122.95pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="26.666666666666668%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">No KTP</span></p>
      </td>
      <td style="width: 14.2pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="3.089430894308943%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">:</span></p>
      </td>
      <td style="width: 297.4pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="64.55284552845528%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;"><?=ucwords(strtolower(ociresult($detail,"NOKTP")));?></span></p>
      </td>
    </tr>
    <tr>
      <td colspan="2" style="width: 25.9pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="5.691056910569106%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">g.</span></p>
      </td>
      <td colspan="2" style="width: 122.95pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="26.666666666666668%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">Atasan Langsung</span></p>
      </td>
      <td style="width: 14.2pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="3.089430894308943%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">:</span></p>
      </td>
      <td style="width: 297.4pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="64.55284552845528%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;"><?=ucwords(strtolower(ociresult($detail,"ATASAN_BARU")));?></span></p>
      </td>
    </tr>
    <tr>
      <td colspan="2" style="width: 25.9pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="5.691056910569106%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">h.</span></p>
      </td>
      <td colspan="2" style="width: 122.95pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="26.666666666666668%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">Agency</span></p>
      </td>
      <td style="width: 14.2pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="3.089430894308943%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">:</span></p>
      </td>
      <td style="width: 297.4pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="64.55284552845528%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;"><?=ucwords(strtolower(ociresult($detail,"KANTOR")));?></span></p>
      </td>
    </tr>
    <tr>
      <td colspan="6" style="width: 460.45pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="100%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">&nbsp;</span></p>
      </td>
    </tr>
    <tr>
      <td colspan="6" style="width: 460.45pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="100%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">&nbsp;</span></p>
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">Dengan surat pemutusan/pengakhiran PKAJ ini maka hak dan kewajiban PARA PIHAK berdasarkan PKAJ No <?=$_GET["nopkaj"];?> tanggal <? if(substr($_GET["tglpkaj"],3,1) == 0) {$bln = substr($_GET["tglpkaj"],4,1);}else{$bln = substr($_GET["tglpkaj"],3,2);} echo substr($_GET["tglpkaj"],0,2)." ".ucwords(strtolower($nama_bulan[$bln]))." ".substr($_GET["tglpkaj"],-4);?> menjadi gugur dan tidak berlaku dan sebagai landasan yang sah terhadap pemutusan/pengakhiran PKAJ dimaksud.</span></p>
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">&nbsp;</span></p>
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">Demikian Surat Pemutusan/pengakhiran PKAJ ini dibuat dan mengucapkan terima kasih atas segala kerjasamanya selama menjadi mitra kerja.</span></p>
      </td>
    </tr>
    <tr>
      <td colspan="6" style="width: 460.45pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="100%">
        <br>
      </td>
    </tr>
    <tr>
      <td colspan="6" style="width: 460.45pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="100%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">&nbsp;</span></p>
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><strong><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">J</span></strong><strong><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">AKARTA</span></strong><strong><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">,&nbsp;</span></strong><strong><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;"><? if(substr($_GET["tgljabatan"],2,1) == 0) {$bln = substr($_GET["tgljabatan"],3,1);}else{$bln = substr($_GET["tgljabatan"],2,2);} echo substr($_GET["tgljabatan"],0,2)." ".$nama_bulan[$bln]." ".substr($_GET["tgljabatan"],-4);?></span></strong></p>
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><strong><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">PT. ASURANSI JIWA IFG</span></strong></p>
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><strong><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">AGENCY BUSINESS</span></strong></p>
      </td>
    </tr>
    <tr>
      <td colspan="6" style="width: 460.45pt;padding: 0mm 5.4pt;vertical-align: top;" valign="top" width="100%">
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">&nbsp;</span></p>
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">&nbsp;</span><img src="https://chart.googleapis.com/chart?chs=130x130&cht=qr&chl=<?=ociresult($detail,'NAMA_RAH');?>&choe=UTF-8&chld=H|0" /></p>
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:  justify;"><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;">&nbsp;</span></p>
        <p style="margin-top:0mm;margin-right:0mm;margin-bottom:.0001pt;margin-left:0mm;line-height:  normal;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;"><strong><span style="font-size:13px;font-family:&quot;Cambria&quot;,serif;"><?=ociresult($detail,"NAMA_RAH");?>
              <br><?=ociresult($detail,"JABATAN_RAH");?>&nbsp;
            </span></strong></p>
      </td>
    </tr>
  </tbody>
</table>