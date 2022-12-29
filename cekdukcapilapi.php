<?php
	include "../includes/common.php";
	include "../includes/database.php";

    $DB = new database($DBUser, $DBPass, $DBName);
    $limit = 19001;
    $val1 = 'KP';
    $val2 = 'CEK.DUKCAPIL';
    $val3 = '0';

    $sql = "SELECT prefixpertanggungan, nopertanggungan, keterangan,
                (SELECT COUNT(*) FROM tabel_100_klien_api WHERE TRUNC(tglrequest) = TRUNC(sysdate)) jmlpengecekan
			FROM $DBUser.rpt_prefix_noper_restru
			WHERE prefixpertanggungan = '$val1' 
				AND nopertanggungan = '$val2'";
	$DB->parse($sql);
	$DB->execute();
	$arr = $DB->nextrow();

    if (!$arr) {
        $sql = "INSERT INTO $DBUser.rpt_prefix_noper_restru (prefixpertanggungan, nopertanggungan, keterangan) VALUES ('$val1', '$val2', '$val3')";
        $DB->parse($sql);
        $DB->execute();
    } else {
        if($arr['KETERANGAN'] == '0' && $arr['JMLPENGECEKAN'] < $limit) {
            echo "[".date('d-m-Y H:i:s')."] ##### Mulai proses cek rekening via API ##### \n";

            $sql = "SELECT noklien, noid, namaklien1, TO_CHAR(tgllahir, 'dd-mm-yyyy') tgllahir, alamattetap01, tempatlahir,
                        b.namaagama, a.namaibukand, NVL(c.namakotamadya, d.namakotamadya) namakotamadya, f.namakecamatan, 
                        e.namakelurahan, NVL(g.namapropinsi, h.namapropinsi) namapropinsi, 
                        CASE a.jeniskelamin WHEN 'P' THEN 'Perempuan' ELSE 'Laki-laki' END jeniskelamin, i.namapekerjaan,
                        CASE a.meritalstatus WHEN 'K' THEN 'Kawin' WHEN 'L' THEN 'Belum Kawin' END meritalstatus,
                        TO_CHAR(sysdate, 'yyyymmddhh24mmss') AS batch
                    FROM $DBUser.tabel_100_klien a
                    LEFT OUTER JOIN $DBUser.tabel_102_agama b ON a.kdagama = b.kdagama
                    LEFT OUTER JOIN $DBUser.tabel_109_kotamadya c ON a.kdkotamadyaktp = c.kdkotamadya
                        AND a.kdpropinsiktp = c.kdpropinsi
                    LEFT OUTER JOIN $DBUser.tabel_109_kotamadya d ON a.kdkotamadyatetap = d.kdkotamadya
                        AND a.kdpropinsitetap = d.kdpropinsi
                    LEFT OUTER JOIN $DBUser.tabel_111_kelurahan e ON a.kdkelurahantetap = e.kdkelurahan
                    LEFT OUTER JOIN $DBUser.tabel_110_kecamatan f ON e.kdkecamatan = f.kdkecamatan
                    LEFT OUTER JOIN $DBUser.tabel_108_propinsi g ON a.kdpropinsiktp = g.kdpropinsi
                    LEFT OUTER JOIN $DBUser.tabel_108_propinsi h ON a.kdpropinsitetap = h.kdpropinsi
                    LEFT OUTER JOIN $DBUser.tabel_105_pekerjaan i ON a.kdpekerjaan = i.kdpekerjaan
                    WHERE noid IS NOT NULL
                        AND (noklien, noid) NOT IN (
                            SELECT noklien, noid
                            FROM $DBUser.tabel_100_klien_api
                        )
                        /*AND ROWNUM < 1001*/
                        AND ROWNUM < 2
                        AND noid <> 'XXX'";
            $DB->parse($sql);
            $DB->execute();
            $result = $DB->result();

		    foreach ($result as $i => $arr) {
                if($i == 0) {
                    echo "> Update keterangan menjadi - 1 \n";
                    
                    $sql = "UPDATE rpt_prefix_noper_restru SET keterangan = '1'
                            WHERE prefixpertanggungan = 'KP' 
                                AND nopertanggungan = 'CEK.REK' 
                                AND keterangan = '0'";
                    $DB->parse($sql);
                    $DB->execute();
                }

                echo ">>> No : ".($i+1);

                $curl = curl_init();
                $request = '{
                    "channel": "ONE-BY-IFG",
                    "action": "VALIDATE_IDENTITY",
                    "identityCardNumber": "'.$arr['NOID'].'",
                    "name": "'.$arr['NAMAKLIEN1'].'",
                    "dateOfBirth": "'.$arr['TGLLAHIR'].'",
                    "address": "'.$arr['ALAMATTETAP01'].'",
                    "placeOfBirth": "'.$arr['TEMPATLAHIR'].'",
                    "familyCardNumber": "",
                    "religion": "'.$arr['NAMAAGAMA'].'",
                    "motherName": "'.$arr['NAMAIBUKAND'].'",
                    "districtName": "'.$arr['NAMAKOTAMADYA'].'",
                    "subDistrictName": "'.$arr['NAMAKECAMATAN'].'",
                    "villageName": "'.$arr['NAMAKELURAHAN'].'",
                    "provinceName": "'.$arr['NAMAPROPINSI'].'",
                    "neighborhood": "",
                    "hamlet": "",
                    "gender": "'.$arr['JENISKELAMIN'].'",
                    "occupation": "'.$arr['NAMAPEKERJAAN'].'",
                    "maritalStatus": "'.$arr['MERITALSTATUS'].'"
                }';

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $HTTP_HOST_PG_DUKCAPIL,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
				    CURLOPT_CONNECTTIMEOUT => 0,
                    CURLOPT_TIMEOUT => 3000,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT'],
                    CURLOPT_SSL_VERIFYHOST => false,
		            CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $request,
                    CURLOPT_HTTPHEADER => array(
                        'apiKey: zdjH2GuOX4DZJyke5piaWSnDuM44SCSC',
                        'Content-Type: text/plain'
                    ),
                ));

                $response = curl_exec($curl);
                $data = json_decode($response, true);

                curl_close($curl);
                
                echo " | $arr[NOKLIEN] | $arr[NOID] | response : $data[responseDesc] \n";

                $sql = "INSERT INTO $DBUser.tabel_100_klien_api (batch, noklien, noid, tglrequest, request, response,
                            code, description, remark, address, placeofbirth, maritalstatus, mothername, name,
                            provincename, districtname, subdistrictname, hamlet, occupation, neighborhood, villagename,
                            dateofbirth, gender, tglbatch)
                        VALUES ('$arr[BATCH]', '$arr[NOKLIEN]', '$arr[NOID]', sysdate,
                            utl_raw.cast_to_raw('$request'), utl_raw.cast_to_raw('$response'), '$data[responseCode]', 
                            '$data[responseDesc]', '".$data['response']."', '".@$data['address']."', 
                            '".@$data['placeOfBirth']."', '".@$data['maritalStatus']."', '".@$data['motherName']."', 
                            '".@$data['name']."', '".@$data['provinceName']."', '".@$data['districtName']."', 
                            '".@$data['subDistrictName']."', '".@$data['hamlet']."', '".@$data['occupation']."', 
                            '".@$data['neighborhood']."', '".@$data['villageName']."', '".@$data['dateOfBirth']."', 
                            '".@$data['gender']."', TO_DATE('$arr[BATCH]', 'yyyymmddhh24miss'))";
                $DB->parse($sql);
                $DB->execute();
            }

            echo "> Update keterangan menjadi - 0 \n";

            $sql = "UPDATE rpt_prefix_noper_restru SET keterangan = '0' 
                    WHERE prefixpertanggungan = '$val1' 
                        AND nopertanggungan = '$val2' 
                        AND keterangan = '1'";
            $DB->parse($sql);
            $DB->execute();

            echo "[".date('d-m-Y H:i:s')."] ##### Akhir proses cek rekening via API ##### \n\n";
        } else {
            echo "[".date('d-m-Y H:i:s')."] ##### Cek Rekening API masih running ##### \n\n";
        }
    }