<div class="container">
    <!-- BEGIN PAGE BREADCRUMB -->
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="<?=base_url()?>">Beranda</a><i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="javascript:;">Workbook</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="<?="$this->url/pkajonline"?>">Pkaj Online</a>
            <i class="fa fa-circle"></i>
        </li>
        <li class="active">
            <?=$this->template->title?>
        </li>
    </ul>
    <!-- END PAGE BREADCRUMB -->

    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row margin-top-10">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE TABLE PORTLET-->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-file-text-o font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp bold uppercase">Cetak PKAJ</span>
                    </div>
                </div>
                <form id="form_epkaj" name="form_epkaj" class="" action="#" />
                <?php foreach($pkaj as $i => $row) { ?>
                    <input type="hidden" value="<?=$row["NOAGEN"];?>" id="noagen" name="noagen">
                    <input type="hidden" value="<?=$row["NOPKAJAGEN"];?>" id="nopkaj" name="nopkaj">
                    <input type="hidden" value="<?=$row["TGLPKAJAGEN"];?>" id="tglpkaj" name="tglpkaj">
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-bordered table-hover" style="font-size: 12px;">
                              <body>
                                 <table class="MsoTableGrid" border="0" cellspacing="0" cellpadding="0" width="80%" align="center" style="border-collapse: collapse; border: medium none">
                                    <tr>
										<td>
										
										<?php
										$namahari = $HARI;
										$tanggal = $TANGGAL;
										$x = mktime(0, 0, 0, $row["BLN"], $row["TGL"],  $row["THN"]);
										$nama_bulan = array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
										$tahun = $TAHUN;
										?>
										
										<table class="MsoTableGrid" border="0" cellspacing="0" cellpadding="0" width="615" style="border-collapse: collapse; border: medium none">
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center"><b>
												<span lang="FI" style="font-family: Arial,sans-serif">PERJANJIAN 
												KEAGENAN ASURANSI JIWA</span></b></td>
											</tr>
											<tr style="height: 23.25pt">
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; height: 23.25pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center">
												<span lang="FI" style="font-family: Arial,sans-serif">NOMOR :
														  <?=$row["NOPKAJAGEN"];?>
														  /EPKAJ-<? if($row["THN"] >= 2020){
															echo ("KP - ".
															$row["BLN"]." ".
															substr($row["THN"],-2));
														  }else{
															echo ($row["KDKANTOR"]." - ".
															$row["BLN"]." ".
															$row["THN"]);
														  }
														  ?>
															
														  </span></p>
												<p class="MsoNormal" align="center" style="text-align: center"><b>
												<span lang="FI" style="font-family: Arial,sans-serif">&nbsp;</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span style="font-family: Arial,sans-serif">Pada 
														  hari ini
														  <?=$namahari;?>
														  tanggal
										  <?=$tanggal;?>
														  bulan
										  <?=$nama_bulan[date("n", $x)];?>
														  tahun
										  <?=$tahun;?>
														  ,kami yang bertanda tangan 
														  di bawah ini :</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="FI" style="font-family: Arial,sans-serif">I.</span></td>
												<td colspan="7" valign="top" style="width: 192px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif">Nama</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="FI" style="font-family: Arial,sans-serif">:</span></td>
												<td width="392" colspan="2" valign="top" style="width: 294.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif"> <?=$row["NAMABM"];?></span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="FI" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="7" valign="top" style="width: 192px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif">Nomor Kepegawaian/ 
												Agen</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="FI" style="font-family: Arial,sans-serif">:</span></td>
												<td width="392" colspan="2" valign="top" style="width: 294.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif"><? if (strlen($row["NIPBM"])<2){ echo $row["NOAGENBM"];} else{echo $row["NIPBM"];}?></span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="FI" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="7" valign="top" style="width: 192px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif">Jabatan&nbsp; </span>		</td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="FI" style="font-family: Arial,sans-serif">:</span></td>
												<td width="392" colspan="2" valign="top" style="width: 294.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif"><?=$row["JABATANBM"];?></span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="FI" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="7" valign="top" style="width: 192px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif">Alamat Kantor</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="FI" style="font-family: Arial,sans-serif">:</span></td>
												<td width="392" colspan="2" valign="top" style="width: 294.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif"><?=$row["ALAMATKTR"];?></span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="FI" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="7" valign="top" style="width: 192px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif">Nomor 
												Telepon&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="FI" style="font-family: Arial,sans-serif">:</span></td>
												<td width="392" colspan="2" valign="top" style="width: 294.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif"><?=$row["TELPONKTR"];?></span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span style="font-family: Arial,sans-serif">
													<!--<?php if ($row["NIPBM"] == '1210129') {
														echo "bertindak dalam jabatannya tersebut berdasarkan Surat Keputusan PT Asuransi Jiwa IFG Nomor 042/SK-DIR/AJIFG/P/HCG/VIII/2021 tanggal 27 Agustus 2021 dan karenanya berwenang bertindak untuk dan atas nama PT Asuransi Jiwa IFG, berkedudukan dan berkantor di Jakarta Selatan sesuai dengan Anggaran Dasar PT Asuransi Jiwa IFG yang termuat dalam Akta No. 39 tanggal 22 Oktober 2020 yang dibuat dihadapan Notaris Hadijah, S.H., yang telah disahkan oleh Kementerian Hukum dan Hak Asasi Manusia Republik Indonesia melalui Surat Keputusan No. AHU-0055113.AH.01.01.TAHUN 2020 tanggal 22 Oktober 2020, selanjutnya disebut:";
													} else if ($row["NIPBM"] == '2210003') {
														echo "bertindak dalam jabatannya tersebut berdasarkan Akta Pernyataan Keputusan Pemegang Saham PT Asuransi Jiwa IFG, Notaris Hadijah, S.H., Nomor 35 tanggal 29 Juli 2021 yang telah diterima dan dicatat di dalam Sistem Administrasi Badan Hukum Kementerian Hukum dan Hak Asasi Manusia sebagaimana tercantum dalam Surat Penerimaan Pemberitahuan Perubahan Data Perseroan Nomor AHU-AH.01.03-0432668 tanggal 29 Juli 2021, dan karenanya berwenang bertindak untuk dan atas nama PT Asuransi Jiwa IFG, berkedudukan dan berkantor di Jakarta Selatan sesuai dengan Anggaran Dasar PT Asuransi Jiwa IFG yang termuat dalam Akta No. 39 tanggal              22 Oktober 2020 yang dibuat dihadapan Notaris Hadijah, S.H., yang telah disahkan oleh Kementerian Hukum dan Hak Asasi Manusia Republik Indonesia melalui Surat Keputusan No. AHU-0055113.AH.01.01.TAHUN 2020 tanggal 22 Oktober 2020, selanjutnya disebut:";
													} ?> -->
													<?php if(($row["PERIODE_PEMBERITAHUAN"] == '1' || $row["PERIODE_PEMBERITAHUAN2"] == '1') && $row["KDJABATANAGEN"] != '26' ) { ?>
														bertindak dalam jabatannya tersebut berdasarkan Surat Kuasa PT Asuransi Jiwa IFG, Nomor 
														240/SKU/AJIFG/U/VI/2022 tanggal 15 Juni 2022, dan karenanya berwenang bertindak untuk dan atas 
														nama PT Asuransi Jiwa IFG, berkedudukan dan berkantor di Jakarta Selatan sesuai dengan Anggaran 
														Dasar PT Asuransi Jiwa IFG yang termuat dalam Akta Nomor 39 tanggal 22 Oktober 2020 yang dibuat 
														dihadapan Notaris Hadijah, S.H., yang telah disahkan oleh Kementerian Hukum dan Hak Asasi 
														Manusia Republik Indonesia melalui Surat Keputusan Nomor AHU-0055113.AH.01.01.TAHUN 2020 
														tanggal 22 Oktober 2020, sebagaimana telah diubah terakhir dengan Akta Pernyataan Keputusan 
														Para Pemegang Saham PT Asuransi Jiwa IFG Nomor 36 tanggal 16 November 2021 dan telah dicatat  
														dalam Keputusan Menteri Hukum dan Hak Asasi Manusia Republik Indonesia sesuai Surat Nomor 
														AHU-0067149.AH.01.02.TAHUN 2021 tanggal 25 November 2021, selanjutnya disebut:
													<?php } else if($row["KDJABATANAGEN"] != '26') { ?>
														bertindak dalam jabatannya tersebut berdasarkan Surat Kuasa PT Asuransi Jiwa IFG, Nomor 209/SKU/AJIFG/U/IV/2022 tanggal 01 April 2022, dan karenanya berwenang bertindak untuk dan atas nama PT Asuransi Jiwa IFG, berkedudukan dan berkantor di Jakarta Selatan sesuai dengan Anggaran Dasar PT Asuransi Jiwa IFG yang termuat dalam Akta Nomor 39 tanggal 22 Oktober 2020 yang dibuat dihadapan Notaris Hadijah, S.H., yang telah disahkan oleh Kementerian Hukum dan Hak Asasi Manusia Republik Indonesia melalui Surat Keputusan Nomor AHU-0055113.AH.01.01.TAHUN 2020 tanggal 22 Oktober 2020, sebagaimana telah diubah terakhir dengan Akta Pernyataan Keputusan Para Pemegang Saham PT Asuransi Jiwa IFG Nomor 36 tanggal 16 November 2021 dan telah dicatat dalam Keputusan Menteri Hukum dan Hak Asasi Manusia Republik Indonesia sesuai Surat Nomor AHU-0067149.AH.01.02.TAHUN 2021 tanggal 25 November 2021, selanjutnya disebut: 
													<?php } else { ?>
														bertindak dalam jabatannya tersebut berdasarkan Akta Pernyataan Keputusan Pemegang Saham PT 
														Asuransi Jiwa IFG, Notaris Hadijah, S.H., Nomor 10 tanggal 07 Januari 2022 yang telah diterima dan 
														dicatat di dalam Sistem Administrasi Badan Hukum Kementerian Hukum dan Hak Asasi Manusia 
														sebagaimana tercantum dalam Surat Penerimaan Pemberitahuan Perubahan Data Perseroan Nomor 
														AHU-AH.01.03-0020386 tanggal 11 Januari 2022, dan karenanya berwenang bertindak untuk dan 
														atas nama PT Asuransi Jiwa IFG, berkedudukan dan berkantor di Jakarta Selatan sesuai dengan 
														Anggaran Dasar PT Asuransi Jiwa IFG yang termuat dalam Akta No. 39 tanggal 22 Oktober 
														2020 yang dibuat dihadapan Notaris Hadijah, S.H., yang telah disahkan oleh Kementerian Hukum dan 
														Hak Asasi Manusia Republik Indonesia melalui Surat Keputusan No. AHU-0055113.AH.01.01.TAHUN 
														2020 tanggal 22 Oktober 2020, selanjutnya disebut:
													<?php } ?>
												</span></td>
											</tr>
											<tr style="height: 5.25pt">
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; height: 5.25pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: center; margin-right: -5.4pt;">
													<span lang="FI" style="font-family: Arial,sans-serif">&nbsp;</span><span style="font-family: Arial,sans-serif;">----------------------------------------------<b>PERUSAHAAN</b>---------------------------------------------</span>
													<br/><br/></td>
												</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">II.</span></td>
												<td colspan="7" valign="top" style="width: 192px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif">Nama (sesuai 
												KTP)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">:</span></td>
												<td width="392" colspan="2" valign="top" style="width: 294.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif"><?=$row["NAMAKLIEN1"];?></span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="7" valign="top" style="width: 192px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif">No. Agen</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">:</span></td>
												<td width="392" colspan="2" valign="top" style="width: 294.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif"><?=$row["NOAGEN"];?></span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="7" valign="top" style="width: 192px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif">Tempat/Tgl Lahir</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">:</span></td>
												<td width="392" colspan="2" valign="top" style="width: 294.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												  <p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt"><span style="font-family: Arial,sans-serif"><?=$row["TEMPATLAHIR"];?>, <?=$row["TGLLAHIR"];?></span>
												</td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="7" valign="top" style="width: 192px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif">Jenis Kelamin</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">:</span></td>
												<td width="392" colspan="2" valign="top" style="width: 294.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif">
												<?=$row["JENISKELAMIN"];?> </span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="7" valign="top" style="width: 192px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif">Alamat (sesuai 
												KTP)</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">:</span></td>
												<td width="392" colspan="2" valign="top" style="width: 294.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif"><?=$row["ALAMATAGEN"];?></span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="7" valign="top" style="width: 192px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif">Nomor KTP/SIM</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">:</span></td>
												<td width="392" colspan="2" valign="top" style="width: 294.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif"><?=$row["NOMORIDAGEN"];?></span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="7" valign="top" style="width: 192px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif">Nomor Telepon 
												Rumah/Hp</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">:</span></td>
												<td width="392" colspan="2" valign="top" style="width: 294.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif"><?=$row["NOTELPONAGEN"];?></span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="7" valign="top" style="width: 192px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif">Alamat Email&nbsp;&nbsp;&nbsp;&nbsp;		</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">:</span></td>
												<td width="392" colspan="2" valign="top" style="width: 294.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif"><?=$row["EMAILTETAP"];?></span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="FI" style="font-family: Arial,sans-serif">yang dalam hal ini 
												bertindak</span><span style="font-family: Arial,sans-serif"> untuk dan 
												atas nama diri sendiri, yang selanjutnya disebut :</span></td>
											</tr>
											<tr style="height: 9.75pt">
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; height: 9.75pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span style="font-family: Arial,sans-serif">&nbsp;<span lang="FI">-----------------------------------------------------<b>AGEN</b>----------------------------------------------------</span></span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
													<span style="font-family: Arial,sans-serif">
														PERUSAHAAN  dan  AGEN  secara  bersama-sama  selanjutnya  disebut  "PARA  PIHAK"  dan  secara  sendiri-sendiri  disebut 
														"PIHAK", terlebih dahulu menerangkan bahwa: 
														<ol type="A">
															<li>AGEN merupakan pihak yang pernah melakukan kerja sama dengan JIWASRAYA dalam melakukan pemasaran dan 
																penjualan Produk asuransi milik JIWASRAYA, dimana hubungan kerja sama, hak, dan kewajiban antara 
																AGEN dengan JIWASRAYA telah berakhir. </li>
															<li>PERUSAHAAN adalah badan usaha yang bergerak di bidang asuransi jiwa yang bekerja sama dengan AGEN 
																dengan tujuan ingin meningkatkan pemasaran dan pelayanan asuransi jiwa dan kesehatan untuk masyarakat 
																melalui pelayanan yang baik, mudah, dan efisien sesuai ketentuan peraturan perundang-undangan yang berlaku.</li>
															<li>AGEN menurut PKAJ ini merupakan AGEN yang berasal dari JIWASRAYA berdasarkan pengalihan agen 
																yang telah menandatangani Berita Acara Kesepakatan Migrasi Agen Nomor <?=$row["NOBERITAACARA"];?> tanggal 06 September 2021, 
																untuk itu AGEN tidak berhak menuntut hak dan kewajiban yang belum diselesaikan oleh JIWASRAYA kepada PERUSAHAAN.</li>
															<li>AGEN menerima penunjukan menjadi AGEN perorangan di PERUSAHAAN sesuai kapasitasnya bertindak sebagai 
																AGEN untuk menawarkan, menjual Produk asuransi PERUSAHAAN, memberikan pelayanan kepada masyarakat 
																serta mengembangkan pasar berdasarkan Peraturan Perundang-undangan yang berlaku.</li>
														</ol>
														<br/><br/>
													</span>
												</td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span style="font-family: Arial,sans-serif">PARA PIHAK telah bersepakat untuk mengadakan Perjanjian Keagenan Asuransi Jiwa yang selanjutnya disebut <b>"PKAJ"</b>, berdasarkan syarat-syarat dan ketentuan-ketentuan sebagaimana diatur dalam pasal-pasal di bawah ini :</span></td>
											</tr>
											<tr style="height: 40pt;border:0px solid #000;">
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; height: 13.05pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-right: -5.4pt">
												<span style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr style="height: 7.5pt">
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; height: 7.5pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center"><b>
												<span lang="IN" style="font-family: Arial,sans-serif">PASAL&nbsp;&nbsp; 1</span></b></td>
											</tr>
											<tr style="height: 12.15pt">
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; height: 12.15pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">ARTI DARI 
												BEBERAPA ISTILAH</span></b></td>
											</tr>
											<tr style="height: 9.75pt">
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; height: 9.75pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="margin-right: -5.4pt"><b>
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Di dalam PKAJ ini 
												yang dimaksud dengan : </span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">1.</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">PKAJ</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">:</span></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah Perjanjian Keagenan Asuransi Jiwa beserta lampiran dan perubahan-perubahannya yang menguraikan hak dan kewajiban PARA PIHAK yang harus dipatuhi dan dilaksanakan agar mencapai bisnis perasuransian yang saling menguntungkan.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">2.</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Surat Penetapan Agen (SPA)</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">:</span></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah surat yang diterbitkan oleh PERUSAHAAN untuk AGEN yang berisikan tentang penetapan administrasi keagenan sesuai ketentuan yang berlaku di PERUSAHAAN. Apabila diperlukan, surat ini dapat diubah sewaktu-waktu oleh PERUSAHAAN sesuai kebutuhan.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">3.</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Agen </span>		</td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">:</span></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah mitra perorangan dari PERUSAHAAN yang bertindak untuk dan atas nama PERUSAHAAN, yang kegiatannya memberikan jasa dalam menawarkan, menjual, dan memasarkan Produk asuransi milik PERUSAHAAN yang terdaftar dan memiliki sertifikasi keagenan dari Asosiasi Asuransi Jiwa Indonesia (AAJI).</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">4.</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Pedoman Sistem Keagenan Bisnis Ritel</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span style="font-family: Arial,sans-serif">:</span></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah regulasi yang mengatur dan menjelaskan mengenai ketentuan dalam rangka mengelola sistem keagenan bisnis ritel sesuai dengan tata kelola perusahaan yang baik untuk melaksanakan tugas dan kewajiban AGEN sebagai tenaga pemasar PERUSAHAAN.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">5.</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">Jabatan</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">:</span></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah kedudukan atau posisi AGEN berdasarkan struktur keagenan yang berlaku sebagaimana ditetapkan dalam Surat Penetapan Agen (SPA) oleh PERUSAHAAN selama berlakunya PKAJ ini.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">6.</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">Promosi </span>		</td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">:</span></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah kenaikan jabatan AGEN berdasarkan hasil evaluasi yang dilakukan oleh PERUSAHAAN.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">7.</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">Degradasi </span>		</td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">:</span></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah penurunan jabatan AGEN berdasarkan hasil evaluasi yang dilakukan oleh PERUSAHAAN.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">8.</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">Jenjang Tetap </span>		</td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">:</span></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah Jabatan AGEN yang sama dengan Jabatan sebelumnya berdasarkan hasil Validasi.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">9.</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">Validasi </span>		</td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">:</span></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">atau Jenjang Tetap adalah proses evaluasi untuk AGEN tetap berada pada level atau jenjang keagenannya saat ini, dimana acuannya adalah pencapaian kinerja AGEN sesuai standar yang telah ditentukan PERUSAHAAN.</span></p>
												<p class="MsoNormal" style="text-align: justify; line-height: 7.0pt; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">10.</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">Produk </span>		</td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">:</span></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah program asuransi jiwa milik PERUSAHAAN yang meliputi informasi tentang polis, syarat-syarat umum polis, tata cara pembayaran premi, penyelesaian klaim serta ketentuan lainnya maupun produk yang berafiliasi/beraliansi dengan perusahaan lain serta memiliki izin dari Otoritas Jasa Keuangan.</span></p>
												<p class="MsoNormal" style="text-align: justify; line-height: 7.0pt; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">11</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">Fungsi Pemasaran		</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">:</span></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah fungsi untuk memasarkan, menjual, dan memberikan penjelasan kepada Calon Pemegang Polis dan/atau Calon Tertanggung dan melakukan hal-hal yang dianggap perlu dalam memasarkan produk, yang harus dilakukan oleh AGEN berdasarkan PKAJ ini.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">12</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">Calon Pemegang Polis		</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">:</span></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah subyek hukum yang memiliki insurable interest dengan Tertanggung yang akan mengadakan perjanjian asuransi dengan PERUSAHAAN.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">13</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">Calon Tertanggung		</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">:</span></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah orang yang atas jiwanya akan diadakan perjanjian asuransi dengan PERUSAHAAN.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">14</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">Pemegang Polis</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">:</span></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah pihak yang mengadakan perjanjian asuransi atau penggantinya menurut hukum dengan Penanggung.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">15</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">Tertanggung</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">:</span></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah orang yang atas jiwanya diadakan perjanjian asuransi jiwa, di mana jenis perjanjian asuransinya diuraikan dalam Polis.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">16</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">JIWASRAYA</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">:</span></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah PT Asuransi Jiwasraya (Persero).</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">17</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif"><i>Field Underwriting</i></span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">:</span></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah kewajiban AGEN melakukan verifikasi terhadap kebenaran, kelengkapan dan akurasi data-data/informasi, termasuk sumber dana dari Calon Pemegang Polis dan/atau Calon Tertanggung sebagaimana isian pada Surat Permintaan Asuransi Jiwa (SPAJ) serta memberikan informasi penting lainnya kepada PERUSAHAAN tentang kondisi Calon Pemegang Polis dan/atau Calon Tertanggung yang dapat mempengaruhi PERUSAHAAN dalam memutuskan penerimaan/penolakan penutupan asuransi.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">18</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">Kode Etik Keagenan</span></p>
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify"><b>
												<span lang="IN" style="font-family: Arial,sans-serif">:</span></b></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah ketentuan yang ditetapkan oleh Asosiasi Asuransi Jiwa Indonesia (AAJI) yang mengatur tata-cara, perilaku, larangan, dan sanksi kepada agen asuransi jiwa, termasuk kepada AGEN berdasarkan PKAJ ini.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify">
														<span lang="IN" style="font-family: Arial,sans-serif">19</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify">
														<span lang="IN" style="font-family: Arial,sans-serif"><i>Pooling</i></span></p>
													<p class="MsoNormal" style="text-align: justify">
														<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify"><b>
															<span lang="IN" style="font-family: Arial,sans-serif">:</span></b></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah tindakan mengalihkan penjualan produk asuransi yang 
												telah dilakukan oleh AGEN kepada pihak lainnya. AGEN harus menolak namanya dicantumkan dalam dokumen surat 
												permohonan penutupan asuransi apabila dirinya tidak melakukan 
												prospek atau penjualan produk asuransi kepada Calon Pemegang Polis dan/atau Calon Tertanggung.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify">
														<span lang="IN" style="font-family: Arial,sans-serif">20</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify">
														<span lang="IN" style="font-family: Arial,sans-serif"><i>Twisting</i></span></p>
													<p class="MsoNormal" style="text-align: justify">
														<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify"><b>
															<span lang="IN" style="font-family: Arial,sans-serif">:</span></b></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah larangan terhadap AGEN untuk membujuk dan/ atau mempengaruhi Pemegang Polis untuk merubah spesifikasi polis yang ada atau mengganti polis yang ada dengan polis yang baru pada Perusahaan Asuransi Jiwa lainnya, dan/ atau membeli polis baru dengan menggunakan dana yang berasal dari polis yang masih aktif pada suatu Perusahaan Asuransi Jiwa lainnya dalam waktu 6 (enam) bulan sebelum dan sesudah tanggal polis baru di Perusahaan Asuransi Jiwa lain diterbitkan.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify">
														<span lang="IN" style="font-family: Arial,sans-serif">21</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify">
														<span lang="IN" style="font-family: Arial,sans-serif"><i>Churning</i></span></p>
													<p class="MsoNormal" style="text-align: justify">
														<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify"><b>
															<span lang="IN" style="font-family: Arial,sans-serif">:</span></b></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah tindakan membujuk dan mempengaruhi Pemegang Polis untuk mengubah spesifikasi polis yang ada atau mengganti polis yang ada dengan polis yang baru pada PERUSAHAAN, dan/ atau membeli polis baru dengan menggunakan dana yang berasal dari polis yang masih aktif dari PERUSAHAAN tanpa penjelasan terlebih dahulu kepada Pemegang Polis mengenai kerugian yang dapat diderita oleh pemegang polis akibat perubahan/ penggantian tersebut.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify">
														<span lang="IN" style="font-family: Arial,sans-serif">22</span></td>
												<td colspan="4" valign="top" style="width: 140px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify">
														<span lang="IN" style="font-family: Arial,sans-serif"><i>Rebating</i></span></p>
													<p class="MsoNormal" style="text-align: justify">
														<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td width="16" valign="top" style="width: 12.0pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify"><b>
															<span lang="IN" style="font-family: Arial,sans-serif">:</span></b></td>
												<td width="432" colspan="5" valign="top" style="width: 324.1pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">adalah potongan premi yang diberikan AGEN kepada Calon Pemegang Polis dan/atau Calon Tertanggung yang diperhitungkan dari komisi AGEN yang akan didapatnya jika berhasil menjual produk kepada Calon Pemegang Polis/Calon Tertanggung tersebut.</span></td>
											</tr>
											<tr style="height: 17.25pt">
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; height: 17.25pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-right: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">PASAL&nbsp; 2</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">HUBUNGAN HUKUM</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Hubungan hukum 
												antara PERUSAHAAN dengan AGEN menurut PKAJ ini&nbsp; adalah hubungan antara 
												mitra kerja dan karenanya bukan merupakan hubungan hukum antara 
												pengusaha dan pekerja sekaligus tidak ada satupun dari syarat dan 
												ketentuan yang berlaku dalam PKAJ ini dapat diartikan atau ditafsirkan 
												sebagai suatu hubungan ketenagakerjaan sebagaimana dimaksud dan diatur 
												dalam perundangan tentang&nbsp; Ketenagakerjaan yang berlaku.</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">PASAL&nbsp;&nbsp; 3</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">HAK DAN 
												KEWAJIBAN PERUSAHAAN</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">(1)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Selama 
												berlangsungnya PKAJ ini, PERUSAHAAN berhak untuk :</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">menetapkan secara periodik Pedoman Sistem Keagenan Bisnis Ritel di PERUSAHAAN dan/atau mengubahnya jika diperlukan;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">b.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">menunjuk dan menetapkan AGEN untuk memasarkan Produk di wilayah operasional PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">menetapkan Jabatan AGEN berdasarkan penilaian PERUSAHAAN dengan Surat Penetapan Agen (SPA);</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">d.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">menerima hasil penjualan Produk dari AGEN melalui sarana pembayaran yang ditetapkan oleh PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">e.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">menetapkan hak dan kewajiban AGEN berdasarkan Pedoman Sistem Keagenan Bisnis Ritel serta ketentuan lain yang berlaku di PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">f.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">mengakhiri PKAJ secara sepihak sesuai Pasal 10 ayat (1) PKAJ ini atau berdasarkan kebijakan yang dipandang perlu oleh PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">g.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">memperoleh informasi yang benar, tepat, dan akurat mengenai pemasaran Produk yang telah dilakukan AGEN, termasuk informasi lainnya apabila diperlukan; dan</span><br><br><br></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">h.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">melakukan pengawasan terhadap pelaksanaan kewajiban-kewajiban AGEN.</span><br><br><br></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(2)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">PERUSAHAAN 
												berkewajiban untuk :</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">membayarkan hak AGEN berdasarkan Pedoman Sistem Keagenan Bisnis Ritel serta ketentuan lain yang berlaku di PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">b.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">memberikan informasi atau data atas penjualan yang telah dihasilkan oleh AGEN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">melakukan pemotongan dari penghasilan yang diterima oleh AGEN atas beban pajak yang ditetapkan undang-undang dan/atau sesuai ketentuan perpajakan yang berlaku;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">d.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">menyelenggarakan pendidikan dan pelatihan untuk AGEN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">e.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">menyediakan pusat informasi yang memuat penjelasan-penjelasan tentang Fungsi Pemasaran yang diperlukan AGEN; dan</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">f.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">menyediakan sarana sumber daya kerja yang dapat mendukung AGEN dalam melaksanakan Fungsi Pemasaran.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">PASAL&nbsp;&nbsp; 4</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">HAK DAN 
												KEWAJIBAN AGEN</span></b></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">&nbsp;</td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">&nbsp;</td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(1)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Selama 
												berlangsungnya PKAJ ini, AGEN berhak :</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">menerima hak-hak AGEN sesuai dengan Pedoman Sistem Keagenan Bisnis Ritel serta ketentuan lain yang berlaku di PERUSAHAAN; dan</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">b.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">mendapatkan informasi dari PERUSAHAAN baik secara lisan maupun tertulis yang terkait dengan hak dan kewajiban AGEN.</span></p>
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(2)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Selama 
												berlangsungnya PKAJ ini, AGEN berkewajiban:</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">memiliki sertifikasi keagenan dari Asosiasi Asuransi Jiwa Indonesia (AAJI);</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">b.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">mematuhi dan melaksanakan ketentuan-ketentuan yang ditetapkan di dalam PKAJ ini, Kode Etik Keagenan dari Asosiasi Asuransi Jjiwa Indonesia (AAJI) dan/atau Pedoman Sistem Keagenan Bisnis Ritel serta ketentuan lain yang diatur dalam peraturan perundang-undangan yang berlaku;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">melakukan manajemen aktivitas penjualan Produk;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify">
														<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
														<span lang="IN" style="font-family: Arial,sans-serif">d.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">menjelaskan seluruh hak dan kewajiban Calon Pemegang Polis dan/atau Calon Tertanggung, termasuk dan tidak terbatas pada manfaat asuransi, proses pengajuan klaim, dan hal-hal lain yang terkait Produk yang ditawarkan kepada Calon Pemegang Polis dan/atau Calon Tertanggung; </span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">e.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">menerapkan prinsip itikad baik (Utmost Good Faith) yang berlaku di industri perasuransian kepada Calon Pemegang Polis dan/atau Calon Tertanggung sehubungan dengan pemasaran dan/atau penjualan Produk;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">f.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">melaporkan hasil-hasil pekerjaannya kepada pihak yang ditunjuk sesuai dengan struktur yang telah ditetapkan PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">g.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">menjaga nama baik PERUSAHAAN dengan tidak melakukan perbuatan-perbuatan yang dilarang sebagaimana tercantum pada Pasal 7 PKAJ ini, maupun pelanggaran terhadap peraturan perundang-undangan yang berlaku;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">h.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">melakukan penawaran dan penjualan serta penutupan polis asuransi jiwa yang merupakan Produk untuk kepentingan dan atas nama PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">i.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">melakukan prospecting, yaitu mencari, mengumpulkan, mencatat nama, beserta data-data Calon Pemegang Polis dan/atau Calon Tertanggung;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">j.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">memberikan layanan purna jual kepada pemegang polis/tertanggung, termasuk mempersiapkan dokumen dan laporan yang dibutuhkan tidak terbatas pada dokumen-dokumen sehubungan dengan pengajuan atau perubahan Polis dari pemegang polis/tertanggung;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">k.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">melakukan kunjungan penjualan kepada Calon Pemegang Polis dan/atau Calon Tertanggung, melaporkan hasil kunjungan serta mencatat data aktivitas penjualan dengan menggunakan media yang ditentukan PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">l.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">mencapai sasaran yang ditetapkan PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">m.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">melakukan Field Underwriting terhadap penjualan dan/atau pemasaran Produk;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">n.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">membantu Calon Pemegang Polis dan/atau Calon Tertanggung dalam proses permintaan asuransi jiwa yang dipilihnya;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">o.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">memastikan bahwa Calon Pemegang Polis dan/atau Calon Tertanggung telah memberikan dokumen yang sesuai dengan aslinya sehubungan dengan penutupan asuransi, termasuk tanda tangan yang tertera dalam Surat Permintaan Asuransi Jiwa (SPAJ) merupakan tanda tangan asli dari Calon Pemegang Polis dan/atau Calon Tertanggung yang bersangkutan;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">p.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">memastikan bahwa Calon Pemegang Polis dan/atau Calon Tertanggung telah mengisi dan menandatangani Surat Permintaan Asuransi Jiwa (SPAJ) dengan lengkap dan benar, serta memberikan keterangan kesehatan yang sesuai dengan kondisi yang sebenarnya pada saat penutupan asuransi;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">q.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">memastikan bahwa dokumen Surat Permintaan Asuransi Jiwa (SPAJ) dan/atau dokumen lainnya yang terkait dengan proses penutupan asuransi telah tersampaikan kepada PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">r.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">berpartisipasi dalam setiap pelatihan, sosialisasi Produk, dan program lain yang ditetapkan PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">s.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">mempertahankan dan menjaga persistensi polis sesuai dengan target yang telah ditetapkan PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">t.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">memberikan pelayanan kepada semua pihak yang didasari dengan prinsip itikad baik, jujur, dan berintegritas;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">u.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">memelihara hubungan baik antar semua pihak, termasuk kepada agen lain di PERUSAHAAN maupun antara pemegang polis/tertanggung dengan PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">v.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">menjaga untuk tidak merusak reputasi dan nama baik PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">w.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">mengembalikan setiap komisi yang telah diperolehnya terkait dengan pengembalian premi dari PERUSAHAAN kepada pemegang polis dengan alasan apapun;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">x.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">mengganti segala kerugian PERUSAHAAN dan/atau pemegang polis/tertanggung sebagai akibat dari:</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">x.1</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">kelalaian/kesalahan AGEN dalam memenuhi kewajiban dan tanggung jawab AGEN sebagaimana disebut dalam Pasal ini; atau</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">x.2</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">pelanggaran yang dilakukan oleh AGEN sesuai yang disebutkan dalam Pasal 7 PKAJ ini.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">y</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">segera menyerahkan kepada PERUSAHAAN seluruh fasilitas dan/atau harta kekayaan PERUSAHAAN yang berada dalam penguasaan AGEN dalam keadaan rapi, baik dan lengkap termasuk dokumen yang berkaitan dengan kegiatan usaha PERUSAHAAN apabila Perjanjian ini berakhir tanpa perlu adanya permintaan terlebih dahulu oleh PERUSAHAAN.</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">PASAL 5</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">TARGET AGEN</span></b></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">&nbsp;</td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">&nbsp;</td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Dalam melaksanakan kewajibannya menurut ketentuan Pasal 4 ayat (2) PKAJ ini, AGEN diberikan target sesuai dengan Pedoman Sistem Keagenan Bisnis Ritel yang berlaku dan target lainnya yang ditentukan PERUSAHAAN.</span></td>
											</tr>
											<!--tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(1)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Dalam melaksanakan 
												kewajibannya menurut ketentuan Pasal <span style="color: blue">4</span> 
												ayat (2) PKAJ ini, AGEN diberikan target berupa;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Pencapaian Premi;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">b.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Pencapaian Polis;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Pencapaian Persistensi Polis; 
												dan</span></p>
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Target lain yang 
												ditetapkan oleh PERUSAHAAN,</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">dalam kurun waktu 
												satu tahun terhitung mulai Januari s.d Desember dalam setiap tahun 
												berjalan atau dalam kurun waktu tertentu yang ditetapkan oleh PERUSAHAAN.</span></p>
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(2)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Target AGEN sebagaimana dimaksud dalam ayat (1) 
												Pasal ini ditetapkan PERUSAHAAN dalam masing-masing 
												Surat Penetapan Agen (SPA) dan dicantumkan dalam Pedoman 
												Sistem Keagenan Bisnis Ritel yang berlaku. </span></td>
											</tr-->
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">&nbsp;</td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">PASAL&nbsp;&nbsp; 6</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">PROMOSI, DEGRADASI, DAN JENJANG TETAP</span></b></td>
											</tr>
											<tr style="height: 12.75pt">
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; height: 12.75pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Untuk keperluan Promosi, Degradasi, dan Jenjang Tetap, PERUSAHAN akan mengadakan Validasi terhadap AGEN sebagaimana diatur dalam Pedoman Sistem Keagenan Bisnis Ritel yang berlaku.</span></td>
											</tr>
											<!--tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(1)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Untuk keperluan Promosi, Degradasi, dan Jenjang Tetap, 
												PERUSAHAN akan mengadakan Validasi terhadap AGEN 
												sebagaimana diatur dalam Pedoman Sistem Keagenan Bisnis Ritel yang berlaku. </span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(2)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Hasil Validasi yang dilakukan PERUSAHAAN terhadap AGEN 
												adalah mutlak dan tidak dapat diganggu gugat kecuali 
												terdapat kesalahan yang nyata. </span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(3)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">IFG Life tidak bertanggung jawab atas hak-hak Agen Pemasar 
												yang timbul selama di JIWASRAYA dan tidak akan 
												melakukan tuntutan apapun terkait dengan hak-hak tersebut. </span></td>
											</tr-->
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">PASAL&nbsp;&nbsp; 7</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">PELANGGARAN</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(1)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Selama PKAJ ini 
												berlangsung, AGEN dilarang melakukan hal-hal sebagai <br/> berikut :</span></p>
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Pelanggaran Ringan</span></td>
											</tr>
											<!-- perubahan pelanggaran -->
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.1</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">tidak melaporkan hasil-hasil pekerjaannya kepada pihak yang ditunjuk sesuai dengan struktur yang telah ditetapkan PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.2</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">tidak memberikan pelayanan purna jual kepada pemegang polis/tertanggung;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.3</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">tidak melakukan manajemen aktivitas penjualan kepada Calon Pemegang Polis dan/atau Calon Tertanggung;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.4</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">tidak melaksanakan tugas dan tanggung jawab sesuai dengan jenjang jabatannya sebagai AGEN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.5</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Tidak melaporkan perubahan data diri agen.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">b.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Pelanggaran Sedang</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">b.1</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Tidak melakukan perpanjangan lisensi keagenan yang sudah tidak aktif.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">b.2</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Tidak menjelaskan seluruh hak dan kewajiban Calon Pemegang Polis.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">b.3</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Tidak melakukan pencatatan data aktivitas penjualan pada sistem aplikasi yang disediakan Perusahaan.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">b.4</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Tidak memenuhi syarat performa, kinerja, dan/atau target produksi yang ditetapkan Perusahaan.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">b.5</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Tidak melakukan field underwriting  terhadap Calon Pemegang Polis/Calon Tertanggung.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">b.6</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Tidak ikut berpartisipasi dalam setiap pelatihan, sosialisasi produk dan program-program kepatuhan, baik yang diadakan oleh Perusahaan maupun pihak lain yang ditetapkan oleh Perusahaan.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">b.7</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Tidak mempertahankan dan menjaga persistensi polis sesuai dengan target yang telah ditetapkan oleh Perusahaan.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">b.8</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Tidak mengembalikan setiap komisi yang telah diperolehnya terkait dengan pengembalian premi dari Perusahaan kepada Pemegang Polis.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Pelanggaran Berat</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.1</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">tidak memberikan penjelasan tentang Produk kepada Calon Pemegang Polis dan/atau Calon Tertanggung;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.2</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">tidak menjaga reputasi dan nama baik PERUSAHAAN dengan melakukan perbuatan-perbuatan yang tidak sesuai dengan ketentuan PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.3</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">mengadakan perjanjian dan/atau hubungan kerja keagenan asuransi secara langsung dengan perusahaan asuransi lain;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.4</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">melakukan pelanggaran terhadap Kode Etik Keagenan dan ketentuan perundang-undangan yang berlaku;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.5</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">merekomendasikan pemegang polis/tertanggung untuk membatalkan polis atas dasar kepentingan pribadi;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.6</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">memberikan data/dokumen yang tidak sesuai dengan data diri AGEN kepada PERUSAHAAN maupun pemegang polis/tertanggung;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.7</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">membebankan premi tambahan dan biaya tambahan dalam bentuk apapun juga kepada pemegang polis/tertanggung;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.8</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">memberikan potongan premi kepada pemegang polis/tertanggung dalam bentuk apapun, kecuali potongan premi tersebut merupakan program PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.9</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">menerima setoran premi secara tunai dari Calon Pemegang Polis/Pemegang Polis dan/atau Calon Tertanggung/Tertanggung;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.10</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">memanipulasi, memalsukan dan/atau memberikan keterangan terkait polis/surat/dokumen palsu kepada PERUSAHAAN atau kepada pihak lain yang dapat mengakibatkan kerugian bagi PERUSAHAAN atau pihak lain yang terkait dengan PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.11</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Memberikan informasi yang bersifat rahasia yang berkaitan dengan strategi, kebijakan, program dan Produk kepada perusahaan asuransi lain dan/atau pihak-pihak lain;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.12</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">mengajak atau menganjurkan sesuatu yang diketahui atau patut diduga akan menimbulkan kerugian PERUSAHAAN dan/atau pemegang polis/tertanggung;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.13</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">melakukan kegiatan bersama-sama dengan teman sejawat dan/atau orang lain di dalam maupun di luar lingkungan PERUSAHAAN dengan tujuan untuk keuntungan pribadi, golongan atau pihak lain yang secara langsung merugikan PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.14</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">mengadakan perjanjian dalam bentuk apapun dan/atau memberikan janji-janji kepada pihak ketiga yang mengikat PERUSAHAAN tanpa mendapat persetujuan terlebih dahulu dari PERUSAHAAN;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.15</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">melakukan segala perbuatan yang merugikan PERUSAHAAN baik secara materiil maupun immateriil termasuk namun tidak terbatas pada perbuatan-perbuatan penyalahgunaan uang PERUSAHAAN dan pemegang polis/tertanggung;
												<br>Melakukan tindakan Pooling, Twisting, Churning, dan Rebating untuk kepentingan pribadi yang dapat merugikan PERUSAHAAN.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(2)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Atas pelanggaran 
												terhadap ketentuan dimaksud pada ayat (1) pasal ini,&nbsp; AGEN menyatakan
												bertanggungjawab sepenuhnya dan karenanya AGEN membebaskan PERUSAHAAN 
												dari segala tuntutan hukum baik pidana maupun perdata atau dalam bentuk
												apapun dari pihak lain,&nbsp; yang timbul sebagai akibat dari pelanggaran dimaksud
												serta bersedia untuk mengganti seluruh kerugian yang diderita PERUSAHAAN
												atas perbuatan pelanggaran dan/atau larangan yang dilakukan dan bersedia dituntut
												oleh PERUSAHAAN sesuai ketentuan hukum yang berlaku.</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">PASAL&nbsp; 8</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">SANKSI</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(1)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Apabila AGEN 
												terbukti melakukan salah satu pelanggaran dimaksud 
												dalam&nbsp; Pasal 7 ayat (1) PKAJ ini, maka sesuai dengan bobot 
												pelanggarannya PERUSAHAAN berhak menjatuhkan sanksi, berupa:</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Sanksi Pelanggaran Ringan terdiri dari :	</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.1</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">teguran lisan;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.2</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">peringatan tertulis I;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.3</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">peringatan tertulis II; dan</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.4</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">peringatan tertulis III.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">b.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Apabila peringatan tertulis III tidak dipatuhi, maka kepada yang bersangkutan dapat dijatuhi sanksi pelanggaran sedang.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Sanksi Pelanggaran Sedang terdiri dari :</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.1</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Degradasi; dan</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">c.2</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">pembekuan PKAJ, sekurang-kurangnya 1 bulan dan maksimal sampai dengan 6 bulan.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">d.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Apabila setelah menjalani sanksi pelanggaran sedang, ternyata AGEN yang melakukan pelanggaran masih melakukan pelanggaran yang sifatnya sama, maka yang bersangkutan dapat dijatuhi sanksi pelanggaran berat, berupa: </span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">d.1</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">pembekuan PKAJ, sekurang-kurangnya 6 bulan dan maksimal sampai dengan 12 bulan; dan</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">d.2</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">pemutusan PKAJ.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(2)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Sanksi sebagaimana ayat (1) Pasal ini, dapat dikenakan secara bersamaan dan/ atau tidak harus berurutan.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(3)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Apabila pelanggaran yang dilakukan oleh AGEN mengandung unsur-unsur tindak pidana, maka selain sanksi dimaksud dalam Pasal ini, PERUSAHAAN dapat melaporkan AGEN kepada pihak yang berwajib untuk menyelesaikan pelanggaran melalui jalur hukum dan AGEN bersedia untuk mempertanggungjawabkan segala perbuatan yang sudah dilakukan terhadap PERUSAHAAN.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(4)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">PERUSAHAAN dapat menunda dan/atau tidak membayarkan komisi jika AGEN menerima sanksi pelanggaran sedang dan/atau pelanggaran berat sebagaimana yang disebutkan pada Pasal 7 PKAJ ini.</span></td>
											</tr>
											<tr style="height: 0px;border:0px solid #000;">
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></p>
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">Pasal 9</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">PEMBEKUAN 
												SEMENTARA PKAJ</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(1)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">PERUSAHAAN dapat melakukan pembekuan sementara PKAJ terhadap hubungan kemitraan dengan AGEN, apabila AGEN terindikasi dan/atau sedang menjalani pemeriksaan internal maupun eksternal akibat perbuatan AGEN yang termasuk dalam pelanggaran sedang dan/atau pelanggaran berat sesuai Pasal 7 PKAJ ini.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(2)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Dalam hal AGEN dikenai Pembekuan Sementara PKAJ, maka PERUSAHAAN 
												akan mengeluarkan surat pembekuan berdasarkan ketentuan yang ditetapkan PERUSAHAAN dan segala hak-hak keagenan akan ditangguhkan.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(3)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Dalam hal AGEN dinyatakan terbukti tidak bersalah, maka PERUSAHAAN akan mencabut pembekuan sementara PKAJ dan PERUSAHAAN akan membayarkan hak-hak AGEN yang telah ditangguhkan, sebaliknya apabila terbukti bersalah maka PERUSAHAAN berhak menjatuhkan sanksi sebagaimana disebutkan dalam Pasal 8 PKAJ ini.</span></td>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">PASAL 10</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">BERAKHIRNYA PERJANJIAN KEAGENAN</span></b></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">&nbsp;</td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">&nbsp;</td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(1)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Berakhirnya PKAJ ini :</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.</span></td>
												<td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Secara seketika berakhir dalam hal AGEN :</span></td>
											</tr>
											<!-- penambahan -->
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.1</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Meninggal dunia;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.2</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Mengundurkan diri;</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.3</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">memperoleh putusan bersalah dari pengadilan yang telah berkekuatan hukum tetap; dan</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
												<td valign="top" style="width: 38px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">a.4</span></td>
												<td colspan="7" valign="top" style="width: 487px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">termasuk ke dalam daftar hitam (blacklist) PERUSAHAAN maupun AAJI karena perbuatan yang merugikan PERUSAHAAN ataupun nasabah/Pemegang Polis.</span></td>
											</tr>
											<tr>
											  <td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">&nbsp;</td>
											  <td colspan="2" valign="top" style="width: 20px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in"><p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt">
											  <span lang="IN" style="font-family: Arial,sans-serif">b.</span></td>
											  <td colspan="8" valign="top" style="width: 538px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">PERUSAHAAN dapat secara sepihak mengakhiri PKAJ, apabila AGEN melakukan salah satu pelanggaran berat yang sebagaimana tercantum pada PASAL 7 ayat (1) dan/ atau berdasarkan kebijakan dan hal-hal lainnya yang dianggap perlu dan berguna oleh PERUSAHAAN.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(2)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">AGEN dapat mengakhiri PKAJ ini dengan pemberitahuan tertulis kepada PERUSAHAAN, setelah menyelesaikan segala kewajibannya dan menerima Surat Pemutusan PKAJ dari PERUSAHAAN.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(3)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Pemutusan PKAJ ini tidak membebaskan AGEN dari segala tanggung jawabnya terhadap PERUSAHAAN, termasuk segala permasalahan hukum yang mungkin timbul sebagai akibat pelanggaran terhadap PKAJ ini, oleh karenanya AGEN tetap terikat dengan segala kewajiban-kewajibannya tersebut sampai semua terpenuhi/ terselesaikan, termasuk pengembalian dokumen, data, imbal jasa, dan aset lainnya milik PERUSAHAAN baik terhadap barang bergerak dan tidak bergerak.</span></td>
											</tr>
											<tr>
												<td valign="top" style="width: 15px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(4)</span></td>
												<td colspan="10" valign="top" style="width: 572px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Apabila PERUSAHAAN bermaksud untuk mengakhiri PKAJ ini karena di luar sebab-sebab yang tercantum menurut Pasal ini, maka PERUSAHAAN akan memberitahukan secara tertulis kepada AGEN tentang maksud pemutusan tersebut dan serta merta PKAJ menjadi berakhir.</span></td>
											</tr>
											<tr style="height: 3.5pt">
												<td valign="top" style="width: 15px; height: 3.5pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify">
												<span lang="IN" style="font-family: Arial,sans-serif">(5)</span></td>
												<td colspan="10" valign="top" style="width: 572px; height: 3.5pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-right: -5.4pt">
												<span lang="IN" style="font-family: Arial,sans-serif">PARA PIHAK sepakat untuk mengesampingkan ketentuan Pasal 1266 KUHPerdata berkenaan dengan pengakhiran/ berakhirnya PKAJ ini, sehingga pengakhiran Perjanjian ini tidak memerlukan keputusan dari Pengadilan.</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif; color: black">
												PASAL 11</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif; color: black">
												PENYELESAIAN PERSELISIHAN</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Apabila terjadi 
												perselisihan dalam pelaksanaan PKAJ ini, PARA PIHAK sepakat&nbsp; 
												menyelesaikan secara musyawarah untuk mencapai mufakat, namun dalam hal&nbsp; 
												tidak tercapai permufakatan dalam musyawarah tersebut, maka PARA PIHAK 
												sepakat menyerahkan perselisihan tersebut melalui pengadilan dan untuk 
												itu PARA PIHAK sepakat memilih tempat kediaman/domisili hukum yang umum 
												dan tetap di kantor Kepaniteraan Pengadilan Negeri Jakarta Pusat.</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif; color: black">
												PASAL 12</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif; color: black">
												LAMPIRAN</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif; color: black">&nbsp;</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Lampiran-lampiran 
												PKAJ tersebut dibawah ini merupakan bagian yang tidak terpisahkan dalam 
												PKAJ ini :</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="567" style="border-collapse: collapse; margin-left: 5.4pt">
													<tr style="height: 14.75pt">
														<td valign="top" style="width: 24px; height: 14.75pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
														<p class="MsoBodyTextIndent2" style="line-height: normal; margin-left: 0in; margin-right: 0in; margin-top: 0in; margin-bottom: .0001pt">
														<a name="_Hlk197755084">
														<span lang="IN" style="font-family: Arial,sans-serif; color: black">
														a.</span></a></td>
														<td valign="top" style="width: 126px; height: 14.75pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
														<p class="MsoBodyTextIndent2" style="line-height: normal; margin-left: 0in; margin-right: 0in; margin-top: 0in; margin-bottom: .0001pt">
														<span lang="IN" style="font-family: Arial,sans-serif; color: black">
														Lampiran 1</span></td>
														<td valign="top" style="width: 5px; height: 14.75pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
														<p class="MsoBodyTextIndent2" style="line-height: normal; margin-left: 0in; margin-right: 0in; margin-top: 0in; margin-bottom: .0001pt">
														<span lang="IN" style="font-family: Arial,sans-serif; color: black">
														:</span></td>
														<td valign="top" style="width: 358px; height: 14.75pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
														<p class="MsoBodyTextIndent2" style="line-height: normal; margin-left: 0in; margin-right: 0in; margin-top: 0in; margin-bottom: .0001pt">
														<span lang="IN" style="font-family: Arial,sans-serif; color: black">
														Kode Etik Keagenan</span></td>
													</tr>
													<tr>
														<td valign="top" style="width: 24px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
														<p class="MsoBodyTextIndent2" style="line-height: normal; margin-left: 0in; margin-right: 0in; margin-top: 0in; margin-bottom: .0001pt">
														<span lang="IN" style="font-family: Arial,sans-serif; color: black">
														b.</span></td>
														<td valign="top" style="width: 126px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
														<p class="MsoBodyTextIndent2" style="line-height: normal; margin-left: 0in; margin-right: 0in; margin-top: 0in; margin-bottom: .0001pt">
														<span lang="IN" style="font-family: Arial,sans-serif; color: black">
														Lampiran 2</span></td>
														<td valign="top" style="width: 5px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
														<p class="MsoBodyTextIndent2" style="line-height: normal; margin-left: 0in; margin-right: 0in; margin-top: 0in; margin-bottom: .0001pt">
														<span lang="IN" style="font-family: Arial,sans-serif; color: black">
														:</span></td>
														<td valign="top" style="width: 358px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
														<p class="MsoBodyTextIndent2" style="line-height: normal; margin-left: 0in; margin-right: 0in; margin-top: 0in; margin-bottom: .0001pt">
														<span lang="IN" style="font-family: Arial,sans-serif; color: black">
														Pakta Integritas AGEN</span></td>
													</tr>
													<tr>
														<td valign="top" style="width: 24px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
														<p class="MsoBodyTextIndent2" style="line-height: normal; margin-left: 0in; margin-right: 0in; margin-top: 0in; margin-bottom: .0001pt">
														<span lang="IN" style="font-family: Arial,sans-serif; color: black">
														c.</span></td>
														<td valign="top" style="width: 126px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
														<p class="MsoBodyTextIndent2" style="line-height: normal; margin-left: 0in; margin-right: 0in; margin-top: 0in; margin-bottom: .0001pt">
														<span lang="IN" style="font-family: Arial,sans-serif; color: black">
														Lampiran 3</span></td>
														<td valign="top" style="width: 5px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
														<p class="MsoBodyTextIndent2" style="line-height: normal; margin-left: 0in; margin-right: 0in; margin-top: 0in; margin-bottom: .0001pt">
														<span lang="IN" style="font-family: Arial,sans-serif; color: black">
														:</span></td>
														<td valign="top" style="width: 358px; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
														<p class="MsoBodyTextIndent2" style="line-height: normal; margin-left: 0in; margin-right: 0in; margin-top: 0in; margin-bottom: .0001pt">
														<span lang="IN" style="font-family: Arial,sans-serif; color: black">
														Surat Penetapan Agen (SPA)</span></td>
													</tr>
												</table>
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt"></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">PASAL 13</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">JANGKA WAKTU</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td width="39" colspan="2" valign="top" style="width: 29.25pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">(1)</span></td>
												<td width="576" colspan="9" valign="top" style="width: 432.15pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">PKAJ ini mulai berlaku sejak tanggal ditandatangani oleh PARA PIHAK untuk jangka waktu yang tidak ditentukan.</span></td>
											</tr>
											<tr>
												<td width="39" colspan="2" valign="top" style="width: 29.25pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
														<span lang="IN" style="font-family: Arial,sans-serif">(2)</span></td>
												<td width="576" colspan="9" valign="top" style="width: 432.15pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
													<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
														<span lang="IN" style="font-family: Arial,sans-serif">PKAJ ini dapat berakhir berdasarkan ketentuan-ketentuan sebagaimana ditetapkan dalam Pasal 10 PKAJ ini dan/atau dapat berakhir berdasarkan kebijakan PERUSAHAAN.</span></td>
											</tr>
											<!-- PENAMBAHAN -->
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">PASAL 14</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<b><span lang="IN" style="font-family: Arial,sans-serif">KETENTUAN PENUTUP</span></b></td>
											</tr>
											<tr>
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">&nbsp;</span></td>
											</tr>
											<tr>
												<td width="39" colspan="2" valign="top" style="width: 29.25pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">(1)</span></td>
												<td width="576" colspan="9" valign="top" style="width: 432.15pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">PKAJ ini menggantikan dan/atau mengakhiri semua perikatan antara AGEN dengan JIWASRAYA.</span></td>
											</tr>
											<tr>
												<td width="39" colspan="2" valign="top" style="width: 29.25pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" align="center" style="text-align: center; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">(2)</span></td>
												<td width="576" colspan="9" valign="top" style="width: 432.15pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoNormal" style="text-align: justify; margin-left: -5.4pt; margin-right: -5.4pt; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">Dalam hal terdapat perubahan terhadap PKAJ ini, maka PERUSAHAAN akan menginformasikan kepada AGEN atas perubahan tersebut, yang diatur secara tersendiri dalam bentuk instrumen tertulis lainnya, yang merupakan satu kesatuan atau bagian yang tidak dapat dipisahkan dengan PKAJ ini.</span></td>
											</tr>
											
											<!--tr style="height: 17.55pt">
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; height: 17.55pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoBodyTextIndent2" style="text-align: justify; text-indent: -.25in; line-height: normal; margin-left: .25in; margin-right: 0in; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">1.<span style="font-style: normal; font-variant: normal; font-weight: normal; font-size: 7.0pt; font-family: Times New Roman">&nbsp;&nbsp;&nbsp;&nbsp;
												</span>Untuk Kantor Cabang bermeterai (PKAJ dengan tanda tangan AGEN di atas meterai)</span></td>
											</tr>
											<tr style="height: 17.55pt">
												<td width="615" colspan="11" valign="top" style="width: 461.4pt; height: 17.55pt; padding-left: 5.4pt; padding-right: 5.4pt; padding-top: 0in; padding-bottom: 0in">
												<p class="MsoBodyTextIndent2" style="text-align: justify; text-indent: -.25in; line-height: normal; margin-left: .25in; margin-right: 0in; margin-top: 0in; margin-bottom: .0001pt">
												<span lang="IN" style="font-family: Arial,sans-serif">2.<span style="font-style: normal; font-variant: normal; font-weight: normal; font-size: 7.0pt; font-family: Times New Roman">&nbsp;&nbsp;&nbsp;&nbsp;
												</span>Untuk AGEN yang bersangkutan bermaterai (PKAJ dengan tanda tangan Kepala Cabang di atas meterai)</span></td>
											</tr-->
											<tr height="0">
												<td width="29" style="border: medium none">&nbsp;</td>
												<td width="29" style="border: medium none">&nbsp;</td>
												<td width="4" style="border: medium none">&nbsp;</td>
												<td width="52" style="border: medium none">&nbsp;</td>
												<td width="80" style="border: medium none">&nbsp;</td>
												<td width="18" style="border: medium none">&nbsp;</td>
												<td width="22" style="border: medium none">&nbsp;</td>
												<td width="2" style="border: medium none"></td>
												<td width="18" style="border: medium none">&nbsp;</td>
												<td width="182" style="border: medium none">&nbsp;</td>
												<td width="205" style="border: medium none">&nbsp;</td>
											</tr>
										</table>
                                        <table width="780" border="0" cellspacing="0" cellpadding="0">
                                                     <tr>
                                                        <td width="256">

                                                        </td>
                                                        <td width="208">
                                                           <div align="center"></div>
                                                        </td>
                                                        <td width="316">
                                                            
                                                        </td>
                                                     </tr>
                                                     <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                     </tr>
                                                     <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                     </tr>
                                                     <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                     </tr>
                                                     <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                     </tr>
                                                     <tr>
                                                        <td style="width:70%">
                                                            <div align="justify">
                                                                <input type="checkbox" id="s_epaj" name="s_epaj" value="1">
                                                                <span style="font-size: 10.0pt; font-family: Arial, sans-serif; color: black">
                                                                    Dengan ini Saya menyatakan setuju untuk melakukan penandatanganan EPKAJ   
                                                                    <br>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                           <div align="center"></div>
                                                        </td>
                                                        <td>
                                                            <div align="center">
                                                                <span style="font-size: 10.0pt; font-family: Arial, sans-serif; color: black">
                                                                    <button type="button" onclick="otp_epkaj(event);" class="btn btn-primary waves-effect waves-light  pull-right">
                                                                        Submit
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </td>
                                                     </tr>
                                                     <tr>
                                                        <td>
                                                            <div align="center">
                                                                <span style="font-size: 10.0pt; font-family: Arial, sans-serif; color: black"></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                           <div align="center"></div>
                                                        </td>
                                                        <td>

                                                        </td>
                                                     </tr>
                                                  </table>
                                                  </BR>
                                                  </BR>
                                                  <p style="font-size: 10.0pt; font-family: Arial, sans-serif; color: black">Catatan : </br>
                                                  </p>
                                                  <p style="font-size: 10.0pt; font-family: Arial, sans-serif; color: black">
							Dokumen Elektronik ini dinyatakan sah walaupun tanpa tanda tangan basah dari Para Pihak. Validasi terhadap data dalam Dokumen Elektronik ini dapat dilakukan melalui URL pada QR Qode yang tercetak.
							Sesuai nama yang tercantum di bawahnya sebagai Para Pihak yang menyetujui atas PKAJ ini. </br>
                                                  </p>
                                                  <p>&nbsp;</p>
                                               </td>
                                            </tr>
                                         </table>
                                         <p>&nbsp;</p>
                                         <p class="MsoNormal" align="center" style="text-align: center">&nbsp;</p>
                                         <p class="MsoNormal" style="text-align: justify">
                                            <span lang="ES" style="font-family: Arial,sans-serif; color: black">&nbsp;</span>
                                         </p>
                                         <p class="MsoNormal" align="center" style="text-align: center">&nbsp;</p>
                                         <p class="MsoNormal" style="text-align: justify">
                                            <span lang="IN" style="font-family: Arial,sans-serif; color: black">&nbsp;</span>
                                         </p>
                                         <p class="MsoNormal" align="center" style="text-align: center">&nbsp;</p>       
                                </body>
                            </table>
                        </div>
                    <?php } ?>
                    </form>
                    <div class="text-center">
                        <?=$this->pagination->create_links();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function otp_epkaj(event){
        event.preventDefault();

        if($('#s_epaj').prop('checked') == false){
          alert('Harap mencentang kotak dialog pernyataan bahwa anda setuju untuk melakukan penandatanganan digital');
          return false;
        }

        var noagen = $("#noagen").val();
        var nmagen = $("#nmagen").val();
        var nopkaj = $("#nopkaj").val();
        var tglpkaj = $("#tglpkaj").val();

        var contentForm = {};
        $("#form_epkaj").serializeArray().map(
            function(x){contentForm[x.name] = x.value;});
            console.log(contentForm);

        $.ajax({
            method: "POST",
            url: "<?= base_url(); ?>" +"index.php/Pkajonline/otp_pkajonline",
            cache: false,
            data: contentForm,
            success: function(msg){

                window.location.href = "<?= base_url(); ?>" +"Pkajonline/otp_pkajonline?noagen=" + noagen +"&nopkaj=" + nopkaj +"&tglpkaj=" + tglpkaj +"&nmagen=" + nmagen + "&name=" + "<?= $this->session->NAMALENGKAP; ?>" + "&iduser=" + "<?= $this->session->IDUSER; ?>";

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert('msg');
                // console.log('error ' + errorThrown);
                console.log(XMLHttpRequest);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    }
</script>