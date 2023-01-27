<html>
	<head>
		<title>Upload file</title>
		<style type="text/css">
		<!--
		.style1 {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
		}
		-->
		</style>
	</head>
	<body>
		<form action="<?php echo $PHP_SELF;?>" method="post" enctype="multipart/form-data" name="getcal">
		<table>
			<tr>
				<td colspan="2" style="text-align:center;">Pastikan Format File yang Anda Upload telah sesuai</td>
			</tr>
			<tr>
				<td><span class="style1">Upload File</span></td>
				<td>
					<input type="file" name="ffilename" size="20" value=""><br />
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="apply" value="SUBMIT" class="but"></td>
			</tr>
		</table>
		</form>
		
		<?php
			include('../includes/config.conf.php');
			
			$tampilkan = 0;
			$no = 1;
			$db_ora = &ADONewConnection(DB_ORA_TYPE);
			$conn_ora = $db_ora->Connect(DB_ORA_HOST, DB_ORA_USER, DB_ORA_PWD, DB_ORA_DBNAME);
			if (!$conn_ora) {
				echo $db_ora->ErrorMsg();
				exit();
			}
			
			if(isset($_POST["apply"])) { 
				require "include/fileupload.class.php";
				if ($ffilename!="none") {
					$folder = "files/file/";
					$mode = 1; //   1 = overwrite mode; 2 = create new with incremental extention; 3 = do nothing if exists
					$my_uploader = new uploader;
					$my_uploader->max_filesize(600000000);
					$my_uploader->max_image_size(3000000, 3000000);
					$my_uploader->upload("ffilename", "", ".txt");
					$my_uploader->save_file($folder, $mode);
					
					if ($my_uploader->error) {
						echo  $errmeg .= "Upload file gagal! ".$my_uploader->error . "<br>";
					} else {
						$file_name = $my_uploader->file['name'];
						$updatefile = ",NAMA_FILE='$file_name'";
						//=============upload=============
						//echo $_FILES[ffilename][name];
						$fcontents = file (@$folder.@$_FILES['ffilename']['name']); 
						
						if (sizeof($fcontents) > 0) {
							// Delete dulu datanya jika direupload //
							$sql = "DELETE FROM jsadm.tabel_802_upload_temp WHERE userid = '$_COOKIE[namauser]'";
							$db_ora->Execute($sql);
						}

						for($i=0; $i<sizeof($fcontents); $i++) { 
							$line = trim($fcontents[$i]); 
							$line1=str_replace("'","",$line);
							$arrinput = explode(";", $line1);
							
							if(!empty($arrinput[1])) {
								$sqltrvouc = "SELECT KDTRANS, TGL_TRANS FROM jsadm.tabel_802_trvouc WHERE no = '$arrinput[0]'";
								$rs = $db_ora->Execute($sqltrvouc);
								while($arr = $rs->FetchRow()) {
									if (empty($arr[KDTRANS])){
										$errorMessageNo .= "<br> - " . $arrinput[0] . " tidak ada di tabel_802_trvouc ";
										$errorNo = true;
									} else {
										$kdtransString = $arr[KDTRANS];
									}
								}
								$stringDate = strtotime($arrinput[1]);
								
								$stringAkhir = strtotime($kdtransString);

								$newFormat = date('Y-m-d',$stringDate);
								
								$newFormatAkhir = date('Y-m-d',$stringAkhir);

								$awal  = date_create($newFormat);
								$akhir = date_create($newFormatAkhir);
								$diff  = date_diff( $awal, $akhir );

								if ($diff->days <= 7) {
									if (!empty($arrinput[1]) && !empty($_COOKIE[namauser])) {
										$sql = "INSERT INTO jsadm.tabel_802_upload_temp (no, tanggal, userid, status) VALUES ('$arrinput[0]', TO_DATE('$arrinput[1]', 'yyyymmdd'), '$_COOKIE[namauser]', '0')";
										$db_ora->Execute($sql);
									}
								} else {
									$errorMessage .= "<br> - " . $arrinput[0] . " lebih dari " . $diff->days . " hari ( " . date('Y-m-d',$stringAkhir) . "),";
									$error = true;
								}
							}
						}
						if($error == true && $errorNo == true) {
							print(" Gagal Melakukan Import Data, Berikut NO nya : $errorMessage $errorMessageNo");
						} else if ($error) {
							print(" Gagal Melakukan Import Data, karena tidak bisa ganti hari lebih dari 7 hari dan kurang dari 7 hari Berikut NO nya : $errorMessage");
						} else if ($errorNo) {
							print(" Gagal Melakukan Import Data, karena : $errorMessageNo");
						} else {
							print($file_name . " berhasil di-upload!<br><br>");
							$tampilkan = 1;
						}
						
						unlink($folder.$file_name);
					}
				} else {
					echo "Anda belum memilih files";
				}
			}
			
			if ($_POST['get_approval']) {
				
				$no = array();
				$no = $_POST['no'];
				
				foreach($no as $no){
					$sql = "UPDATE jsadm.tabel_802_upload_temp SET (status) = ('1') where no='$no' and userid = '$_COOKIE[namauser]'";
					$db_ora->Execute($sql);
				}
				
				echo "berhasil mengajukan Approval!";
				
			}
			
			
			
			if ($tampilkan) {
				$sql = "SELECT b.kdkantor, b.kdtrans, b.notrans, b.akun, b.ket, b.posted, b.kduniq, b.kd_detil, a.no, TO_CHAR(a.tanggal, 'yyyymmdd') tanggal
						FROM jsadm.tabel_802_upload_temp a
						INNER JOIN tabel_802_trvouc b ON a.no = b.NO
						WHERE a.userid = '$_COOKIE[namauser]'";
				$rs = $db_ora->Execute($sql);
				echo '<form action="'.$PHP_SELF.'" method="post" name="fupdate">';
				echo '<table class="style1" border="1" cellspacing="1" cellpadding="2" width="100%">';
				echo '<tr style="text-align:center;"><td>NO</td><td>KANTOR</td><td>KDTRANS</td>';
				if ($tampilkan == 1)
					echo '<td><b>NEW KDTRANS</b></td>';
				echo '<td>NOTRANS</td><td>AKUN</td><td>KET</td><td>POSTED</td><td>KDUNIQ</td><td>KDDETIL</td><td>NO</td></tr>';
				$i = 1;
				while($arr = $rs->FetchRow()) {
					echo "<tr><td>".$i++."</td><td align='center'>$arr[KDKANTOR]</td><td align='center'>$arr[KDTRANS]</td>";
					if ($tampilkan == 1)
						echo "<td align='center'><b>$arr[TANGGAL]</b></td>";
					echo "<td align='center'>$arr[NOTRANS]</td><td align='center'>$arr[AKUN]</td><td>$arr[KET]</td><td align='center'>$arr[POSTED]</td><td>$arr[KDUNIQ]</td><td>$arr[KD_DETIL]</td><td>$arr[NO]</td></tr>";
					echo "<input type='hidden' name='no[]' value='$arr[NO]'>";
					$no++;
				}
				
				//if ($no > 1 && $tampilkan == 1) {
					//echo "<tr><td colspan='11' align='center'><input type='submit' name='approval' value='Send Approval' /></td></tr>";
				//} else {
					//echo "<tr><td colspan='11' align='center'><input type='button' value='Send Approval' onClick=\"javascript:window.close('','_parent','');\" /></td></tr>";
				//}
				
				//echo "<tr><td colspan='11' align='center'><input type='button' name='get_approval' value='Send Approval' onClick=\"javascript:window.close('','_parent','');\" /></td></tr>";
				echo "<tr><td colspan='11' align='center'><input type='submit' name='get_approval' value='Send Approval' /></td></tr>";
				echo "</form>";
			}
		?>
	</body>
</html>
