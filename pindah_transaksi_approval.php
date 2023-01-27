<html>
	<head>
		<title>Approval Transaksi</title>
		<style type="text/css">
		<!--
		.style1 {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
		}
		-->
		</style>
		<script language="JavaScript" type="text/javascript" src="include/window.js"></script>
		<script language="JavaScript"> 
			function Cekbok(doc) { 
				console.log(doc);
				if (doc == true) {
					checkedAll('getpremi', true);
					console.log("test true")
				} else {
					checkedAll('getpremi', false);
					console.log("test false")
				}
			} 
			function checkedAll (id, checked) {
				console.log(id);
				console.log(checked);
				var el = document.getElementById(id);
				console.log(el);
				for (var i = 0; i < el.elements.length; i++) {
					el.elements[i].checked = checked;
				}
			}
		</script>
	</head>
	<body>
		
		<?php
			include('../includes/config.conf.php');
			
			$tampilkan = 1;
			$no = 1;
			$db_ora = &ADONewConnection(DB_ORA_TYPE);
			$conn_ora = $db_ora->Connect(DB_ORA_HOST, DB_ORA_USER, DB_ORA_PWD, DB_ORA_DBNAME);
			if (!$conn_ora) {
				echo $db_ora->ErrorMsg();
				exit();
			}
			
			if($_POST['update']){
				$box=$_POST['box1'];
				$box_count=count($box);
				if (($box_count)<1) {
					echo "<script>alert('Tidak ada data yang dipilih!!')</script>";
					echo "<script> window.location.href = 'update_status_pht.php';</script>";
				} else { 
					foreach ($box as $dear) {
						$value = explode(',',$dear);
						// $query = "UPDATE $DBUser.temporary_import set status = '2', tanggal_penerimaan = SYSDATE
						// where no_polis = '$value[0]' AND kondisi_update = '$value[1]' AND status = '$value[2]'";
						// //echo $query;die;
						// $DB->parse($query);
			
						// if(!$DB->execute()) {
						// 	echo "<script>alert('Gagal Melakukan Approve!!')</script>";
						// 	echo "<script> window.location.href = 'update_status_pht.php';</script>";
						// }
						$no = $value[0];
						$tanggal = $value[1];
						$time = strtotime($tanggal);

						$newformat = date('d-m-Y',$time);

						$sql = "UPDATE jsadm.tabel_802_trvouc SET kdtrans = '$tanggal', tgl_trans = TO_DATE('$newformat', 'DD/MM/YYYY') WHERE no = '$no'";
						$db_ora->Execute($sql);
			
						$sqlx = "UPDATE jsadm.tabel_802_upload_temp SET (status) = ('2') where no='$no'";
						$db_ora->Execute($sqlx);
					}
					$tampilkan = 2;
				
					echo "berhasil melakukan Approval!";
				}
			}

			
			
			
				if($tampilkan == 1){
					$sql = "SELECT b.kdkantor, b.kdtrans, b.notrans, b.akun, b.ket, b.posted, b.kduniq, b.kd_detil, a.no, TO_CHAR(a.tanggal, 'yyyymmdd') tanggal, a.status
						FROM tabel_802_upload_temp a
						INNER JOIN tabel_802_trvouc b ON a.no = b.NO
						WHERE a.status = '1'";
				}else if($tampilkan == 2){
					$sql = "SELECT b.kdkantor, b.kdtrans, b.notrans, b.akun, b.ket, b.posted, b.kduniq, b.kd_detil, a.no, TO_CHAR(a.tanggal, 'yyyymmdd') tanggal, a.status
						FROM tabel_802_upload_temp a
						INNER JOIN tabel_802_trvouc b ON a.no = b.NO
						WHERE a.status = '2' order by a.tanggal desc";
				}
				
				$rs = $db_ora->Execute($sql);
				echo '<form name="getpremi" id="getpremi" action="'.$PHP_SELF.'" method="post" name="fupdate">';
				echo '<table class="style1" border="1" cellspacing="1" cellpadding="2" width="100%">';
				echo '<tr style="text-align:center;"><td>NO</td><td>KANTOR</td><td>KDTRANS</td>';
				if ($tampilkan == 1)
					echo '<td><b>NEW KDTRANS</b></td>';
				echo '<td>NOTRANS</td><td>AKUN</td><td>KET</td><td>POSTED</td><td>KDUNIQ</td><td>KDDETIL</td><td>NO</td><td><input type="checkbox" name="xx" onClick="Cekbok(this.form.xx.checked);" /></td></tr>';
				$i = 1;
				while($arr = $rs->FetchRow()) {
					echo "<tr><td>".$i++."</td><td align='center'>$arr[KDKANTOR]</td><td align='center'>$arr[KDTRANS]</td>";
					if ($tampilkan == 1)
						echo "<td align='center'><b>$arr[TANGGAL]</b></td>";
					echo "<td align='center'>$arr[NOTRANS]</td><td align='center'>$arr[AKUN]</td><td>$arr[KET]</td><td align='center'>$arr[POSTED]</td><td>$arr[KDUNIQ]</td><td>$arr[KD_DETIL]</td><td>$arr[NO]</td>";
					if ($arr['STATUS'] == 1) {
						echo "<td align='center' style='border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA'><input type='checkbox' name='box1[]' value='$arr[NO],$arr[TANGGAL]'></td>";
					} else {
						echo "<td align='center' style='border-left-width: 1; border-right-width: 1; border-top: 1px solid #D8E1FA; border-bottom: 1px solid #D8E1FA'>Approved</td>";
					}
					echo "</tr>";
					echo "<input type='hidden' name='no[]' value='$arr[NO]'>";
					$no++;
				}
				
				if ($no > 1 && $tampilkan == 1) {
					echo "<tr><td colspan='12' align='center'><input type='submit' name='update' value='Approval' /></td></tr>";
				} else {
					echo "<tr><td colspan='12' align='center'><input type='button' value='Close' onClick=\"javascript:window.close('','_parent','');\" /></td></tr>";
				}
				echo "</form>";
		?>
	</body>
</html>
