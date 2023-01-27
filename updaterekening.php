<?php
    include "../../includes/session.php";
    include "../../includes/database.php";
	include "../../cron/BANKSWIFT.php";
	$DB = New Database($userid,$passwd,$DBName);
	$user_master = in_array($modul, array('DMS','ALL','POS','ITC'));
	$user_klaim = in_array($modul, array('KLM', 'ALL','ITC'));
	$user_view = in_array($modul, array('CUS','ITC'));
	$listbankcheck = !in_array($kdbank, array('014'));
	$tombolmanual = false;
	
	$sql = "SELECT code, description, utl_raw.cast_to_varchar2(request) request, accountname, accountnumber, kdbank, remark,
				CASE WHEN kdbank = '002' THEN REPLACE(REPLACE(UTL_RAW.CAST_TO_VARCHAR2(request), '{\"accountNo\":\"', ''), '\"}', '')
					WHEN kdbank <> '014' THEN REPLACE(REPLACE(SUBSTR(UTL_RAW.CAST_TO_VARCHAR2(request), INSTR(UTL_RAW.CAST_TO_VARCHAR2(request), 'beneficiaryAccountNumber')), 'beneficiaryAccountNumber\":\"', ''), '\"}', '')
				END norekening
			FROM $DBUser.tabel_100_klien_rekening_api
			WHERE prefixpertanggungan = '$prefix'
				AND nopertanggungan = '$noper'
				AND kdbank = '$kdbank'
				AND utl_raw.cast_to_varchar2(request) LIKE '%$norekening%'
				/*AND TRUNC(tglbatch) = TRUNC(sysdate)*/
			ORDER BY tglbatch DESC";
	$DB->parse($sql);
	$DB->execute();
	$arr = $DB->nextrow();
	
	if ($submitapi) {
		// Jika nomor rekening kosong dan masuk dalam list bank api
		if (empty($norekening) && $listbankcheck) {
			echo "<font face='Verdana' size='2' color='red'><u><b>Pengecekan Gagal, Nomor Rekening tidak boleh kosong!</b></u></font><br /><br />";
		} else if (!empty($norekening) && $listbankcheck) {
			// Jika no rekening sama
			if (@$arr['NOREKENING'] == $norekening) {
				$manual = @$arr['REMARK'] == 'MANUAL' ? 'MANUAL' : '';

				echo "<font face='Verdana' size='2' color='red'>APIDB : ".@$arr['DESCRIPTION'].' '.$manual."</font><br /><br />";
				
				$atasnama = $arr['ACCOUNTNAME'];
				//changes for blank response code
				if (in_array(@$arr['CODE'], array('','CORP-02-013','0103','CORP-00-003')) || in_array(@$arr['DESCRIPTION'], array('Anda Tidak Berhak','Transaksi anda tidak dapat diproses','Unknown Account Type','beneficiary_bank_code tidak valid'))) {
					$tombolmanual = true;
				}
				if (@$arr['CODE']!= '0000' && in_array(@$arr['kdbank'], array('212', '125','BTN','126'))) {
					$tombolmanual = true;
				}
			} else {
				$response = checkapi($prefix, $noper, $kdbank, $norekening, $swifts, $DB, $HTTP_HOST_PG_BRI, $HTTP_HOST_PG_BBCA,$atasnama);

				//changes for blank response code
			$responseCode = $response[0]; 
			$responseDesc = $response[1]; 
				if (in_array($responseCode, array('','CORP-02-013','0103','CORP-00-003')) || in_array($responseDesc, array('Anda Tidak Berhak','Transaksi anda tidak dapat diproses','Unknown Account Type','beneficiary_bank_code tidak valid'))) {
					$tombolmanual = true;
				}
				if ($responseCode!= '0000' && in_array($kdbank, array('212', '125','BTN','126'))) {
					$tombolmanual = true;
				}
			}
		}
	}
	
	if ($submitmanual) {
		if(@$arr['ACCOUNTNUMBER'] == $norekening && @$arr['KDBANK'] == $kdbank){
			@$arr['CODE'] == '0000';

			if ($listbankcheck) {
				$listbankcheck = !$listbankcheck;
			}
			$submitmaster = true;
		} else {
			echo "<font face='Verdana' size='2' color='red'><u><b>Gagal, Silahkan lakukan Cek via API terlebih dahulu!</b></u></font><br /><br />";
		}
	}
    if ($submitmaster) {
        if(empty($norekening)){
			echo "<font face='Verdana' size='2' color='red'><u><b>Gagal, Nomor Rekening tidak boleh kosong!</b></u></font><br /><br />";
        } else if (@$arr['NOREKENING'] != $norekening && $listbankcheck) {
			echo "<font face='Verdana' size='2' color='red'><u><b>Gagal, Silahkan lakukan Cek via API terlebih dahulu!</b></u></font><br /><br />";
		} else {
			// Jika response dari API rek valid bisa insert
			if (@$arr['CODE'] != '0000' && $listbankcheck) {
				echo "<font face='Verdana' size='2' color='red'><u><b>Gagal, Rekening tidak dapat di update karena $arr[DESCRIPTION]!</b></u></font><br /><br />";
			} else {
				//update tabel_100_klien_rekening_api ke status sukses
				if ($submitmanual) {
					$sql = "SELECT count(*) ada 
							FROM $DBUser.TABEL_100_KLIEN_REKENING_TMP
							WHERE prefixpertanggungan = '$prefix'
								AND nopertanggungan = '$noper'
								AND trunc(tglrekam) = trunc(sysdate)
								AND STATUS = '0'";
					$DB->parse($sql);
					$DB->execute();
					$data=$DB->nextrow();
					if ($data['ADA'] == 0) {
						//cek data hari ini kalau tidak ada
						$sql = "INSERT INTO $DBUser.TABEL_100_KLIEN_REKENING_TMP
								VALUES ('$prefix','$noper','$kdbank','$cabangbank','$norekening','" . str_replace("'", "`", $atasnama) . "',0,trunc(sysdate),'$userid','','')";
						$DB->parse($sql);
						$DB->execute();
					} else {
						//cek data hari ini kalau ada
						$sql = "UPDATE $DBUser.TABEL_100_KLIEN_REKENING_TMP
								SET KDBANK = '$kdbank',
									CABANGBANK = '$cabangbank', NOREKENING = '$norekening', ATASNAMA = '" . str_replace("'", "`", $atasnama) . "', 
									TGLREKAM = TRUNC(SYSDATE), USERREKAM = '$userid'
								WHERE prefixpertanggungan = '$prefix'
								AND nopertanggungan = '$noper'";
						$DB->parse($sql);
						$DB->execute();
					}
					if ($DB->errormessage) {
						echo "<font face='Verdana' size='2' color='red'>Gagal, error : $DB->errorstring</font><br /><br />";
					} else {
						echo "<font face='Verdana' size='2' color='green'><u><b>Sukses, request update rekening MANUAL!</b></u></font><br /><br />";
					}
					
				} else {
					if ($action == 'insert') {
						$sql = "INSERT INTO $DBUser.tabel_100_klien_rekening (prefixpertanggungan, nopertanggungan, kdbank, 
									cabangbank, norekening, atasnama, tglrekam, userrekam, status)
								VALUES ('$prefix', '$noper', '$kdbank', '$cabangbank', 
									'$norekening', '".str_replace("'", "`", $atasnama)."', sysdate, '$userid', 0)";
					} else {
						$sql = "UPDATE $DBUser.tabel_100_klien_rekening SET KDBANK = '$kdbank',
									CABANGBANK = '$cabangbank', NOREKENING = '$norekening', ATASNAMA = '".str_replace("'", "`", $atasnama)."', 
									TGLUPDATED = SYSDATE, USERUPDATED = '$userid'
								WHERE PREFIXPERTANGGUNGAN = '$prefix' AND NOPERTANGGUNGAN = '$noper'";
					}
					$DB->parse($sql);
					$DB->execute();
					if ($DB->errormessage) {
						echo "<font face='Verdana' size='2' color='red'>Gagal, error : $DB->errorstring</font><br /><br />";
					} else {
						echo "<font face='Verdana' size='2' color='green'><u><b>Sukses, rekening master berhasil diupdate!</b></u></font><br /><br />";
					}
				}
			}
        }
    }
	
	if ($submitklaim) {
		if (empty($norekening)) {
			echo "<h3><font face='Verdana' color='red'><u>Nomor Rekening tidak boleh kosong!</u></font></h3>";
		} else if (@$arr['NOREKENING'] != $norekening) {
			echo "<font face='Verdana' size='2' color='red'><u><b>Gagal, Silahkan lakukan Cek via API terlebih dahulu!</b></u></font><br /><br />";
		} else {
			$sql = "UPDATE $DBUser.tabel_901_pengajuan_klaim SET 
						namabank = (SELECT alias FROM $DBUser.tabel_399_bank WHERE kdbank = '$kdbank'),
						cabangbank = '$cabangbank',
						norekeningbank = '$norekening',
						penerimasip = '".str_replace("'", "`", $atasnama)."'
					WHERE prefixpertanggungan = '$prefix'
						AND nopertanggungan = '$noper'
						AND kdklaim = '$kdklaim'
						AND TO_CHAR(tglpengajuan, 'dd/mm/yyyy') = '$tglpengajuan'";
			$DB->parse($sql);
			$DB->execute();
			
			if ($DB->errormessage) {
				echo "<font face='Verdana' size='2' color='red'>Gagal, error : $DB->errorstring</font><br /><br />";
			} else {
				echo "<font face='Verdana' size='2' color='green'><u><b>Sukses, rekening klaim 901 berhasil diupdate!</b></u></font><br /><br />";
			}
			
			$sql = "UPDATE $DBUser.tabel_900_klaim_pusat SET
						namabank = (SELECT alias FROM $DBUser.tabel_399_bank WHERE kdbank = '$kdbank'),
						cabangbank = '$cabangbank',
						norekeningbank = '$norekening',
						penerimasip = '".str_replace("'", "`", $atasnama)."'
					WHERE prefixpertanggungan = '$prefix'
						AND nopertanggungan = '$noper'
						AND kdklaim = '$kdklaim'
						AND TO_CHAR(tglpengajuan, 'dd/mm/yyyy') = '$tglpengajuan'";
			$DB->parse($sql);
			$DB->execute();
			
			if ($DB->errormessage) {
				echo "<font face='Verdana' size='2' color='red'>Gagal, error : $DB->errorstring</font><br /><br />";
			} else {
				echo "<font face='Verdana' size='2' color='green'><u><b>Sukses, rekening klaim 900 berhasil diupdate!</b></u></font><br /><br />";
			}
		}
	}

	if ($recheckapi) {
		$sql = "DELETE FROM $DBUser.tabel_100_klien_rekening_api 
				WHERE prefixpertanggungan = '$prefix' 
					AND nopertanggungan = '$noper' 
					AND kdbank = '$kdbank'
					AND utl_raw.cast_to_varchar2(request) LIKE '%$norekening%'";
		$DB->parse($sql);
		$DB->execute();

		if ($listbankcheck) {
			$response = checkapi($prefix, $noper, $kdbank, $norekening, $swifts, $DB, $HTTP_HOST_PG_BRI, $HTTP_HOST_PG_BBCA,$atasnama);

			echo "<script>window.location.href='?nopolis=$prefix$noper&prefix=$prefix&noper=$noper&kdklaim=$kdklaim&tglpengajuan=$tglpengajuan'</script>";
		}
	}


	// Checking API
	function checkapi($prefix, $noper, $kdbank, $norekening, $swifts, $DB, $HTTP_HOST_PG_BRI, $HTTP_HOST_PG_BBCA,$atasnama) { //ini
		$curl = curl_init();

		/*=============== Khusus BRI ===============*/
		if ($kdbank == '002') {
			$request = '{"accountNo":"'.$norekening.'"}';

			curl_setopt_array($curl, array(
				CURLOPT_URL => $HTTP_HOST_PG_BRI,
				CURLOPT_SSL_VERIFYHOST => 0,
				CURLOPT_SSL_VERIFYPEER => 0,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_CONNECTTIMEOUT => 0,
				CURLOPT_TIMEOUT => 3000,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $request,
				CURLOPT_HTTPHEADER => array(
					'Content-Type: text/plain'
				),
			));

			$response = curl_exec($curl);
			$data = json_decode($response, true);
			$respdescription = $data['responseDescription'];
			$respcode = $data['responseCode'];
			$respremark = @$data['data']['remark2'];
			$respaccountname = @$data['data']['accountName'];
			$respaccountnumber = @$data['data']['accountNumber'];
			$respcurrency = @$data['data']['acctCur'];
			$respstatus = @$data['data']['status'];
		}
		/*=============== Akhir Khusus BRI ===============*/

		/*=============== Khusus Bank Lain (Kecuali BCA) ===============*/
		else {
			$request = array('beneficiaryBankCode' => $swifts[$kdbank], 'beneficiaryAccountNumber' => $norekening);

			curl_setopt_array($curl, array(
				CURLOPT_URL => $HTTP_HOST_PG_BBCA,
				CURLOPT_SSL_VERIFYHOST => 0,
				CURLOPT_SSL_VERIFYPEER => 0,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_CONNECTTIMEOUT => 0,
				CURLOPT_TIMEOUT => 3000,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $request
			));
			
			$response = curl_exec($curl);
			$data = json_decode($response, true);
			$request = json_encode($request);
			$respaccountname = @$data['beneficiary_account_name'];
			$respdescription = $respaccountname ? "Inquiry Success" : @$data['error_message']['indonesian'];
			$respcode = $respaccountname ? "0000" : @$data['error_code'];
			$respremark = "";
			$respaccountnumber = @$data['beneficiary_account_number'];
			$respcurrency = "";
			$respstatus = $respaccountname ? "Active" : "";
		}
		/*=============== Akhir Khusus Bank Lain ===============*/

		curl_close($curl);

		if (count($data) > 0 && (!in_array($respcode, array('','CORP-02-013','0103','CORP-00-003') || !in_array($respdescription, array('Anda Tidak Berhak','Transaksi anda tidak dapat diproses','Unknown Account Type','beneficiary_bank_code tidak valid')))) {
			$sql = "INSERT INTO nadm.tabel_100_klien_rekening_api (batch, prefixpertanggungan, nopertanggungan,
						kdbank, tglrequest, request, response, code, description, remark, accountname, accountnumber, 
						currency, status, tglbatch)
					VALUES (TO_CHAR(sysdate, 'yyyymmddhh24mmss'), '$prefix', '$noper', '$kdbank', sysdate,
						utl_raw.cast_to_raw('$request'), utl_raw.cast_to_raw('".str_replace("'", "`", $response)."'), '$respcode', 
						'$respdescription', '$respremark', '".str_replace("'", "`", $respaccountname)."', '$respaccountnumber', '$respcurrency', 
						'$respstatus', sysdate)";
			$DB->parse($sql);
			$DB->execute();
		} else { //ini
			$respcode = '';
			$respremark ='';
			$respaccountname = $atasnama;
			$respaccountnumber = $norekening;
			$respcurrency ='IDR';
			$respstatus ='Active';
			$sql = "INSERT INTO nadm.tabel_100_klien_rekening_api (batch, prefixpertanggungan, nopertanggungan,
							kdbank, tglrequest, request, response, code, description, remark, accountname, accountnumber, 
							currency, status, tglbatch)
						VALUES (TO_CHAR(sysdate, 'yyyymmddhh24mmss'), '$prefix', '$noper', '$kdbank', trunc(sysdate),
							utl_raw.cast_to_raw('$request'), '', '$respcode', 
							'$respdescription', '$respremark', '".str_replace("'", "`", $respaccountname)."', '$respaccountnumber', '$respcurrency', 
							'$respstatus', trunc(sysdate))";
			$DB->parse($sql);
			$DB->execute();
		}

		echo "<font face='Verdana' size='2' color='red'>API : $respdescription</font><br /><br />";

		//changes for blank response code
		return array($respcode,$respdescription);
	}
?>

<html>
    <head>
        <link type="text/css" href="../../includes/jws.css" rel="stylesheet" />
        <link type="text/css" href="../../jquery/demos.css" rel="stylesheet" />
        <script language="JavaScript" type="text/javascript" src="../../includes/window.js" ></script>
        <title>Update Rekening</title>
    </head>
    <body>
		<?php
		    $sql = "SELECT a.prefixpertanggungan, a.nopertanggungan, b.kdbank, d.alias, NVL(d.namabank, b.namabank) namabank, b.cabangbank, b.norekening, 
						b.atasnama, c.namabank namabankklaim, c.cabangbank cabangbankklaim, c.norekeningbank norekeningklaim, 
						c.penerimasip atasnamaklaim, e.statusbayarho, c.kdklaim, TO_CHAR(c.tglpengajuan, 'dd/mm/yyyy') tglpengajuan, 
						b.userrekam, TO_CHAR(sysdate, 'yyyymmddhh24mmss') AS batch, TO_CHAR(g.tglrequest, 'dd-mm-yyyy hh24:mi:ss') tglrequestapi, 
						h.alias namabankapi, g.description descriptionapi, g.status statusapi, g.accountname accountnameapi, 
						g.accountnumber accountnumberapi
					FROM $DBUser.tabel_200_pertanggungan a
					LEFT OUTER JOIN $DBUser.tabel_100_klien_rekening b ON a.prefixpertanggungan = b.prefixpertanggungan
						AND a.nopertanggungan = b.nopertanggungan
					LEFT OUTER JOIN $DBUser.tabel_901_pengajuan_klaim c ON a.prefixpertanggungan = c.prefixpertanggungan
						AND a.nopertanggungan = c.nopertanggungan
						AND c.kdklaim = '$kdklaim'
						AND TO_CHAR(c.tglpengajuan, 'dd/mm/yyyy') = '$tglpengajuan'
					LEFT OUTER JOIN $DBUser.tabel_399_bank d ON b.kdbank = d.kdbank
					LEFT OUTER JOIN $DBUser.tabel_900_klaim_pusat e ON a.prefixpertanggungan = e.prefixpertanggungan
						AND a.nopertanggungan = e.nopertanggungan
						AND c.kdklaim = e.kdklaim
						AND c.tglpengajuan = e.tglpengajuan
					LEFT OUTER JOIN (
						SELECT MAX(batch) batch, prefixpertanggungan, nopertanggungan, 
							UTL_RAW.CAST_TO_VARCHAR2(request) request
						FROM $DBUser.tabel_100_klien_rekening_api
						GROUP BY prefixpertanggungan, nopertanggungan, UTL_RAW.CAST_TO_VARCHAR2(request)
					) f ON a.prefixpertanggungan = f.prefixpertanggungan
						AND a.nopertanggungan = f.nopertanggungan
						AND f.request LIKE ('%' || NVL(c.norekeningbank, b.norekening) || '%')
					LEFT OUTER JOIN $DBUser.tabel_100_klien_rekening_api g ON f.batch = g.batch
						AND f.prefixpertanggungan = g.prefixpertanggungan
						AND f.nopertanggungan = g.nopertanggungan
					LEFT OUTER JOIN $DBUser.tabel_399_bank h ON g.kdbank = h.kdbank
					WHERE (a.prefixpertanggungan = '$prefix' AND a.nopertanggungan = '$noper')
						OR a.nopol = '$nopolis'
						OR a.nopolbaru = '$nopolis'";
			$DB->parse($sql);
			$DB->execute();
			$arr=$DB->nextrow();
			
			$kdbank = $kdbank ? $kdbank : $arr['KDBANK'];
			$cabangbank = $cabangbank ? $cabangbank : $arr['CABANGBANK'];
			$norekening = $norekening ? $norekening : $arr['NOREKENING'];
			$atasnama = $atasnama ? $atasnama : $arr['ATASNAMA'];
			$nopolis = $nopolis ? $nopolis : "$arr[PREFIXPERTANGGUNGAN]$arr[NOPERTANGGUNGAN]";
		?>
	
        <font face="Verdana" size="2"><b>Informasi Rekening <?="$nopolis"?></b>
			<ul style="margin-top:0px;margin-bottom:0px;">
				<li>Master : Rekening utama peserta yang digunakan sebagai referensi</li>

				<?php if ($user_master || ($user_klaim && !empty($kdklaim))) { ?>
					<li>Klaim : Rekening untuk pembayaran klaim <?=$arr['KDKLAIM']?> tanggal <?=$arr['TGLPENGAJUAN']?></li>
				<?php } ?>
			</ul>
		</font>
        <hr size=1>
		
		<?php if ($user_master) { ?>
		<form name="prop" action="<?=$PHP_SELF?>" method="get">
			<table border="1" width="600" cellspacing="0" cellpadding="6" style='font-family: verdana; font-size: 12px' >
				<tr>
					<td colspan="3" align="center" bgcolor="#627EB5">
						<font color="#fff"><b>POLIS</b></font>
					</td>
				</tr>
				<tr>
					<td>No Polis</td>
					<td>
						: <input type="text" size="40" name="nopolis" value="<?=$nopolis?>">
						<input type="submit" name="cari" value="Cari" />
					</td>
				</tr>
			</table>
		</form>
		<br />
		<?php } ?>
		

		<table border="1" width="600" cellspacing="0" cellpadding="6" style='font-family: verdana; font-size: 12px' >
			<tr>
				<td colspan="4" align="center" bgcolor="#627EB5">
					<font color="#fff"><b>INFORMASI REKENING</b></font>
				</td>
			</tr>
			<tr>
				<td align="center" bgcolor="#627EB5"></td>
				<td align="center" bgcolor="#627EB5">
					<font color="#fff"><b>MASTER</b></font>
				</td>
				<?php if ($user_master || ($user_klaim && !empty($kdklaim))) { ?>
					<td align="center" bgcolor="#627EB5">
						<font color="#fff"><b>KLAIM</b></font>
					</td>	
				<?php } ?>
				<td align="center" bgcolor="#627EB5">
					<font color="#fff"><b>HASIL API</b></font>
				</td>
			</tr>
			<tr>
				<td width ='100'>Nama Bank</td>
				<td><?=$arr['NAMABANK']?$arr['NAMABANK']:$arr['ALIAS']?></td>
				<?php if ($user_master || ($user_klaim && !empty($kdklaim))) { ?><td><?=$arr['NAMABANKKLAIM']?></td><?php } ?>
				<td align="center" rowspan="2">
					<?="$arr[NAMABANKAPI]<br><font style='font-size:10px;font-style:italic'>".$arr['DESCRIPTIONAPI'].' '.($arr['STATUSAPI'] ? '(' : '').$arr['STATUSAPI'].($arr['STATUSAPI'] ? ')' : '').
					"<br>".$arr['TGLREQUESTAPI']."</font>"?>
					<?php if (($user_master || $user_klaim) && (@count($arr) > 0 || @count($data) > 0)) { ?>
						<br><input type="button" value="Recheck API" onclick='window.location.href="?recheckapi=1&prefix=<?=$prefix?>&noper=<?=$noper?>&kdklaim=<?=$kdklaim?>&tglpengajuan=<?=$tglpengajuan?>&kdbank=<?=$kdbank?>&norekening=<?=$norekening?>";' style="width:100%" />
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td>Cabang</td>
				<td><?=$arr['CABANGBANK']?></td>
				<?php if ($user_master || ($user_klaim && !empty($kdklaim))) { ?><td><?=$arr['CABANGBANKKLAIM']?></td><?php } ?>
			</tr>
			<tr>
				<td>Nomor Rekening</td>
				<td><?=$arr['NOREKENING']?></td>
				<?php if ($user_master || ($user_klaim && !empty($kdklaim))) { ?><td><?=$arr['NOREKENINGKLAIM']?></td><?php } ?>
				<td><?=$arr['ACCOUNTNUMBERAPI']?></td>
			</tr>
			<tr>
				<td>Atas Nama</td>
				<td><?=$arr['ATASNAMA']?></td>
				<?php if ($user_master || ($user_klaim && !empty($kdklaim))) { ?><td><?=$arr['ATASNAMAKLAIM']?></td><?php } ?>
				<td><?=$arr['ACCOUNTNAMEAPI']?></td>
			</tr>
		</table>
		
		<br />

		<?php if ($user_master || ($user_klaim && !empty($kdklaim))) { ?>
			<form name="prop" action="<?=$PHP_SELF?>" method="get">
				<input type="hidden" name="nopolis" value="<?=$nopolis;?>" />
	            <input type="hidden" name="prefix" value="<?=$arr['PREFIXPERTANGGUNGAN'];?>" />
	            <input type="hidden" name="noper" value="<?=$arr['NOPERTANGGUNGAN'];?>" />
				<input type="hidden" name="kdklaim" value="<?=$arr['KDKLAIM'];?>" />
	            <input type="hidden" name="tglpengajuan" value="<?=$arr['TGLPENGAJUAN'];?>" />
				<input type="hidden" name="batch" value="<?=$arr['BATCH'];?>" />
				<input type="hidden" name="action" value="<?=$arr['NOREKENING']?'update':'insert';?>" />
	            <table border="1" width="600" cellspacing="0" cellpadding="6" style='border:1px solid #006699; font-family: verdana; font-size: 12px' >
	                <tr>
	                    <td align="center" bgcolor="#627EB5" colspan="2">
	                        <font color="#fff"><b>UPDATE NOMOR REKENING</b></font>
	                    </td>
	                </tr>
	                <tr>
	                    <td width='120'>Nama Bank</td>
	                    <td>: 
							<select name="kdbank">
								<option value="">-- Silahkan Pilih --</option>
								<?php
								$sql = "SELECT kdbank, namabank, alias
										FROM $DBUser.tabel_399_bank
										WHERE KDSTATUS = '1'
										ORDER BY namabank";
								$DB->parse($sql);
								$DB->execute();
								while ($r = $DB->nextrow()) {
									$selected = $kdbank == $r['KDBANK'] ? 'selected' : '';
									echo "<option value='$r[KDBANK]' $selected>$r[NAMABANK]</option>";
								} ?>
							</select>
						</td>
	                </tr>

	                <tr>
	                    <td>Cabang</td>
	                    <td>: <input type="text" size="40" name="cabangbank" value="<?=$cabangbank?>"></td>
	                </tr>

	                <tr>
	                    <td>Nomor Rekening</td>
	                    <td>: <input type="text" size="40" name="norekening" value="<?=$norekening?>">
							<input type="submit" value="Cek via API" name="submitapi" style="font-size: 8pt; font-family: Verdana" /> 
						</td>
	                </tr>

	                <tr>
	                    <td>Atas Nama</td>
	                    <td>: <input type="text" size="40" name="atasnama" value="<?=$atasnama?>"></td>
	                </tr>
	                <tr>
	                    <td align="center" bgcolor="#E4E4E4" colspan="2">
							<!-- changes for blank response code -->
							<?php if ($tombolmanual) {
								?>
								<input type="submit" value="UPDATE MANUAL" name="submitmanual" style="font-size: 8pt; font-family: Verdana" onclick="return confirm('Apakah Anda yakin UPDATE MANUAL <?= $userid ?>?')"> 
							<?php } if ($user_master) { ?>
								<input type="submit" value="UPDATE MASTER" name="submitmaster" style="font-size: 8pt; font-family: Verdana" onclick="return confirm('Apakah Anda yakin <?=$userid?>?')"> 
							<?php } if ($user_klaim) { ?>
								<input type="submit" value="UPDATE KLAIM" name="submitklaim" style="font-size: 8pt; font-family: Verdana" onclick="return confirm('Apakah Anda yakin <?=$userid?>?')" <?=$arr['STATUSBAYARHO']=='2'?'disabled':''?>> 
							<?php } ?>
	                    </td>
	                </tr>
					<tr>
						<td colspan="2"><input type="button" value="KEMBALI" onclick="window.opener.updateForm();window.close();" style="width:100%" /></td>
					</tr>
	            </table>
	        </form>
		<?php } ?>
        
		<?php if ($arr['STATUSBAYARHO'] == '2') {
			echo "<font size='2' style='background-color:yellow;'>*Rekening Klaim tidak dapat diupdate karena pembayaran sedang/telah dilakukan</font>";
		} ?>
    </body>
</html>
