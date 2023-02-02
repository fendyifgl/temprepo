<?php

class Master_model extends CI_Model {


    //function untuk ngecek histori POS
	function postPOS_login($username){
		$sukses = 0;
		$kdlog = 'POS'.date("dmY");
		$log = 'JAIM POS USER : '.$username;
		
        $this->db->trans_begin();

        $this->db->query("INSERT INTO JAIM_999_LOG (KDLOG, LOG, TGLREKAM, USERREKAM) VALUES ('$kdlog', '$log', sysdate, '$username')");
					 
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        }
        else {
            $sukses = $this->db->trans_commit();
        }

        return ($sukses ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
	}

    //model statistik untuk admin menampilkan data log perhari
	function getStatistikDay(){
		$data = array();

        $q = $this->db
            ->query("SELECT 
					 LOGIN_AIM.TOTAL AS TOTAL_LOGIN, 
					 SPAJ.TOTAL AS TOTAL_SPAJ,
					 POS.TOTAL AS TOTAL_POS
                     FROM 
					 (SELECT COUNT(KDLOG) TOTAL FROM JAIM_999_LOG WHERE KDLOG LIKE '%LOGIN%' and to_char(TGLREKAM,'ddmmyyyy') = TO_CHAR(sysdate,'ddmmyyyy')  ) LOGIN_AIM,
					 (SELECT COUNT(KDLOG) TOTAL FROM JAIM_999_LOG WHERE KDLOG LIKE '%SPAJ%' and to_char(TGLREKAM,'ddmmyyyy') = TO_CHAR(sysdate,'ddmmyyyy')  ) SPAJ,
					 (SELECT COUNT(KDLOG) TOTAL FROM JAIM_999_LOG WHERE KDLOG LIKE '%POS%' and to_char(TGLREKAM,'ddmmyyyy') = TO_CHAR(sysdate,'ddmmyyyy')  ) POS");

        if ($q->num_rows() > 0) {
            $data = $q->result_array();
        }

        $q->free_result();

        return $data;
	}
	
	//model statistik untuk admin menampilkan data log total
	function getStatistikTotal(){
		$data = array();

        $q = $this->db
            ->query("SELECT 
					 LOGIN_AIM.TOTAL AS TOTAL_LOGIN, 
					 SPAJ.TOTAL AS TOTAL_SPAJ,
					 POS.TOTAL AS TOTAL_POS
                     FROM 
					 (SELECT COUNT(KDLOG) TOTAL FROM JAIM_999_LOG WHERE KDLOG LIKE '%LOGIN%' AND TO_CHAR(TGLREKAM,'YYYY') = TO_CHAR(SYSDATE,'YYYY')) LOGIN_AIM,
					 (SELECT COUNT(KDLOG) TOTAL FROM JAIM_999_LOG WHERE KDLOG LIKE '%SPAJ%' AND TO_CHAR(TGLREKAM,'YYYY') = TO_CHAR(SYSDATE,'YYYY')) SPAJ, 
					 (SELECT COUNT(KDLOG) TOTAL FROM JAIM_999_LOG WHERE KDLOG LIKE '%POS%' AND TO_CHAR(TGLREKAM,'YYYY') = TO_CHAR(SYSDATE,'YYYY')) POS");

        if ($q->num_rows() > 0) {
            $data = $q->result_array();
        }

        $q->free_result();

        return $data;
	}

    /*===== daftar status proposal =====*/
    function get_list_status_proposal() {
        $data = array();

        $q = $this->db
            ->query("SELECT KDSTATUS, NAMASTATUS
                     FROM JAIM_201_STATUS_PROSPEK
                     WHERE KDGROUP = 3");

        if ($q->num_rows() > 0) {
            $data = $q->result_array();
        }

        $q->free_result();

        return $data;
    }

    //model untuk chart Tahun Berjalan
	function getDataChartTahun($noagen,$kdkantor,$kdjabatan){
		 $data = array();
		 $sqlktr = "";
			if($kdjabatan != '26'){
			  $sqlktr = "AND KDKANTOR = '$kdkantor'";
			}
		 $q = $this->db->query("SELECT 
						PENAWARAN.JML AS JML_PENAWARAN,
                        PENAWARAN.ANP AS ANP_PENAWARAN,
                        SPAJ.ANP AS ANP_SPAJ,
                        SPAJ.JML AS JML_SPAJ,
                        PROPOSAL.JML AS JML_PROPOSAL,
                        PROPOSAL.ANP AS ANP_PROPOSAL,
                        APPROVAL.JML AS JML_APPROVAL,
                        APPROVAL.ANP AS ANP_APPROVAL,
                        PELUNASAN.JML AS JML_PELUNASAN,
                        PELUNASAN.ANP AS ANP_PELUNASAN,
                        TERKIRIM.JML AS JML_TERKIRIM,
                        TERKIRIM.ANP AS ANP_TERKIRIM,
                         ( SELECT COUNT(NOAGEN) AS JML_SEBAWAH
                            FROM   TABEL_400_AGEN@jlindo 
                            WHERE   KDSTATUSAGEN = '01'
							$sqlktr
                            START WITH   ATASAN = '".$noagen."'
                            CONNECT BY nocycle PRIOR NOAGEN = ATASAN
                        ) AS AGEN_SEBAWAH
                     FROM( SELECT COUNT(a.ID_AGEN) as JML,
                                     NVL(SUM(
                                                CASE 
                                                    WHEN a.CARA_BAYAR IN ('Bulanan') THEN CAST(a.JUMLAH_PREMI AS int) * 12
                                                    WHEN a.CARA_BAYAR IN ('Kuartalan') THEN CAST(a.JUMLAH_PREMI AS int) * 4
                                                    WHEN a.CARA_BAYAR IN ('Semesteran') THEN CAST(a.JUMLAH_PREMI AS int) * 2
                                                    ELSE CAST(a.JUMLAH_PREMI AS int)
                                                END
                                        ),0) as ANP
                               FROM JAIM_300_HITUNG a
                               WHERE a.ID_AGEN IN ( (SELECT   NOAGEN
                                                       FROM   TABEL_400_AGEN@jlindo 
                                                       WHERE    KDSTATUSAGEN = '01'
														$sqlktr													   
                                                       START WITH   ATASAN = '$noagen' 
                                                       CONNECT BY   PRIOR NOAGEN = ATASAN
                                                       UNION ALL
                                                       SELECT   '$noagen'  FROM DUAL
                                                    )
                                                  )
                                    AND (a.TGL_REKAM BETWEEN TO_DATE('01/01/'||TO_CHAR(sysdate,'YYYY'), 'DD/MM/YYYY') AND TO_DATE('31/12/'||TO_CHAR(sysdate,'YYYY'), 'DD/MM/YYYY')
                                         OR 
										 a.BUILD_ID IN (  SELECT BUILDID 
                                                            FROM TABEL_SPAJ_ONLINE@jlindo b,TABEL_200_PERTANGGUNGAN@jlindo c 
                                                            WHERE b.NOSPAJ = c.NOSP
                                                                  AND c.KDPERTANGGUNGAN IN ('1', '2')
                                                                  AND c.KDSTATUSEMAIL = '1'
                                                                  AND c.MULAS BETWEEN TO_DATE('01/01/'||TO_CHAR(sysdate,'YYYY'), 'DD/MM/YYYY') AND TO_DATE('31/12/'||TO_CHAR(sysdate,'YYYY'), 'DD/MM/YYYY') 
                                                          )
                                        )
                            ) PENAWARAN,
                            (   SELECT NVL (
                                          SUM (
                                             CASE
                                                WHEN a.BUILD_ID = b.BUILDID 
                                                THEN
                                                    CASE 
                                                        WHEN a.CARA_BAYAR IN ('Bulanan') THEN CAST(a.JUMLAH_PREMI AS int) * 12
                                                        WHEN a.CARA_BAYAR IN ('Kuartalan') THEN CAST(a.JUMLAH_PREMI AS int) * 4
                                                        WHEN a.CARA_BAYAR IN ('Semesteran') THEN CAST(a.JUMLAH_PREMI AS int) * 2
                                                        ELSE CAST(a.JUMLAH_PREMI AS int)
                                                    END
                                                ELSE 0
                                             END),
                                        0) as ANP,
                                    COUNT(b.KODEAGEN) as JML
                                FROM
                                    JAIM_300_HITUNG a, TABEL_SPAJ_ONLINE@jlindo b
                                WHERE
                                    a.BUILD_ID = b.BUILDID
                                    AND
                                    b.KODEAGEN IN ( (SELECT   NOAGEN
                                                       FROM   TABEL_400_AGEN@jlindo 
                                                       WHERE    KDSTATUSAGEN = '01'
                                                       $sqlktr          
                                                       START WITH   ATASAN = '$noagen' 
                                                       CONNECT BY   PRIOR NOAGEN = ATASAN
                                                       UNION ALL
                                                       SELECT   '$noagen'  FROM DUAL
                                                    )
                                                  )
                                    AND (b.TANGGALREKAM BETWEEN TO_DATE('01/01/'||TO_CHAR(sysdate,'YYYY'), 'DD/MM/YYYY') AND TO_DATE('31/12/'||TO_CHAR(sysdate,'YYYY'), 'DD/MM/YYYY')
                                         OR 
										 b.NOSPAJ IN (   SELECT NOSP 
                                                            FROM TABEL_200_PERTANGGUNGAN@jlindo c 
                                                            WHERE c.KDPERTANGGUNGAN IN ('1', '2')
                                                                  AND c.KDSTATUSEMAIL = '1'
                                                                  AND c.MULAS BETWEEN TO_DATE('01/01/'||TO_CHAR(sysdate,'YYYY'), 'DD/MM/YYYY') AND TO_DATE('31/12/'||TO_CHAR(sysdate,'YYYY'), 'DD/MM/YYYY') 
                                                        )
                                        )

                            ) SPAJ,
                            (
                                SELECT
                                    COUNT(c.NOAGEN) as JML,
                                    NVL(SUM(
                                                CASE 
                                                    WHEN c.KDCARABAYAR IN ('1','M') THEN c.premi1 * 12
                                                    WHEN c.KDCARABAYAR IN ('2','Q') THEN c.premi1 * 4
                                                    WHEN c.KDCARABAYAR IN ('3','H') THEN c.premi1 * 2
                                                    ELSE c.premi1
                                                END
                                        ),0) as ANP
                                FROM TABEL_200_PERTANGGUNGAN@jlindo c
                                WHERE c.KDPERTANGGUNGAN IN ('1', '2')
                                    AND c.KDSTATUSEMAIL = '1' 
                                    AND c.NOAGEN IN ( (SELECT   NOAGEN
                                                       FROM   TABEL_400_AGEN@jlindo 
                                                       WHERE    KDSTATUSAGEN = '01'
                                                       $sqlktr          
                                                       START WITH   ATASAN = '$noagen' 
                                                       CONNECT BY   PRIOR NOAGEN = ATASAN
                                                       UNION ALL
                                                       SELECT   '$noagen'  FROM DUAL
                                                    )
                                                  )
                                    AND c.MULAS BETWEEN TO_DATE('01/01/'||TO_CHAR(sysdate,'YYYY'), 'DD/MM/YYYY') AND TO_DATE('31/12/'||TO_CHAR(sysdate,'YYYY'), 'DD/MM/YYYY') 
                            ) PROPOSAL,
                            (   SELECT
                                    COUNT(d.NOPERTANGGUNGAN) as JML,
                                    NVL (
                                          SUM (
                                             CASE
                                                WHEN c.NOPERTANGGUNGAN = d.NOPERTANGGUNGAN
                                                THEN
                                                    CASE 
                                                        WHEN c.KDCARABAYAR IN ('1','M') THEN c.premi1 * 12
                                                        WHEN c.KDCARABAYAR IN ('2','Q') THEN c.premi1 * 4
                                                        WHEN c.KDCARABAYAR IN ('3','H') THEN c.premi1 * 2
                                                        ELSE c.premi1
                                                    END
                                                ELSE 0
                                             END),
                                        0) as ANP
                                FROM TABEL_214_APPROVAL_PROPOSAL@jlindo d, TABEL_200_PERTANGGUNGAN@jlindo c
                                WHERE c.NOPERTANGGUNGAN = d.NOPERTANGGUNGAN 
                                    AND c.PREFIXPERTANGGUNGAN = d.PREFIXPERTANGGUNGAN
                                    AND c.KDPERTANGGUNGAN IN ('1', '2')
                                    AND c.KDSTATUSEMAIL = '1'
                                    AND c.NOAGEN IN ( (SELECT   NOAGEN
                                                       FROM   TABEL_400_AGEN@jlindo 
                                                       WHERE    KDSTATUSAGEN = '01'
                                                        $sqlktr         
                                                       START WITH   ATASAN = '$noagen' 
                                                       CONNECT BY   PRIOR NOAGEN = ATASAN
                                                       UNION ALL
                                                       SELECT   '$noagen'  FROM DUAL
                                                    )
                                                  )
                                    AND c.MULAS BETWEEN TO_DATE('01/01/'||TO_CHAR(sysdate,'YYYY'), 'DD/MM/YYYY') AND TO_DATE('31/12/'||TO_CHAR(sysdate,'YYYY'), 'DD/MM/YYYY') 
                            ) APPROVAL,
                            (
                                SELECT
                                    COUNT(e.NOPERTANGGUNGAN) as JML,
                                    NVL (
                                          SUM (
                                              CASE 
                                                    WHEN e.KDCARABAYAR IN ('1','M') THEN e.premi1 * 12
                                                    WHEN e.KDCARABAYAR IN ('2','Q') THEN e.premi1 * 4
                                                    WHEN e.KDCARABAYAR IN ('3','H') THEN e.premi1 * 2
                                                    ELSE e.premi1
                                              END),
                                        0) as ANP
                                FROM TABEL_200_PERTANGGUNGAN@jlindo e 
                                WHERE e.KDSTATUSFILE NOT IN ('X','C')
                                    AND e.KDPERTANGGUNGAN = '2'
                                    AND e.NOAGEN IN ( (SELECT   NOAGEN
                                                       FROM   TABEL_400_AGEN@jlindo 
                                                       WHERE    KDSTATUSAGEN IN ('01','02','03','04','05')
                                                        $sqlktr         
                                                       START WITH   ATASAN = '$noagen' 
                                                       CONNECT BY   PRIOR NOAGEN = ATASAN
                                                       UNION ALL
                                                       SELECT   '$noagen'  FROM DUAL
                                                    )
                                                  )
                                    AND e.MULAS BETWEEN TO_DATE('01/01/'||TO_CHAR(sysdate,'YYYY'), 'DD/MM/YYYY') AND TO_DATE('31/12/'||TO_CHAR(sysdate,'YYYY'), 'DD/MM/YYYY')
                            ) PELUNASAN,
                            (
                                SELECT
                                    COUNT(f.NOPERTANGGUNGAN) as JML,
                                    NVL (
                                          SUM (
                                             CASE
                                                WHEN e.NOPERTANGGUNGAN = f.NOPERTANGGUNGAN
                                                THEN
                                                    CASE 
                                                        WHEN e.KDCARABAYAR IN ('1','M') THEN e.premi1 * 12
                                                        WHEN e.KDCARABAYAR IN ('2','Q') THEN e.premi1 * 4
                                                        WHEN e.KDCARABAYAR IN ('3','H') THEN e.premi1 * 2
                                                        ELSE e.premi1
                                                    END
                                                ELSE 0
                                             END),
                                        0) as ANP
                                    FROM TABEL_200_PERTANGGUNGAN@jlindo e, TABEL_214_VERIFY_CETAK_POLIS@jlindo f 
                                    WHERE e.NOPERTANGGUNGAN = f.NOPERTANGGUNGAN
                                          AND e.PREFIXPERTANGGUNGAN = f.PREFIXPERTANGGUNGAN
                                          AND f.KDKIRIM = '1'
                                          AND f.TGLKIRIM IS NOT NULL 
                                          AND e.NOAGEN IN ( (SELECT   NOAGEN
                                                       FROM   TABEL_400_AGEN@jlindo 
                                                       WHERE    KDSTATUSAGEN = '01'
                                                       $sqlktr          
                                                       START WITH   ATASAN = '$noagen' 
                                                       CONNECT BY   PRIOR NOAGEN = ATASAN
                                                       UNION ALL
                                                       SELECT   '$noagen'  FROM DUAL
                                                    )
                                                  )
                                          AND e.MULAS BETWEEN TO_DATE('01/01/'||TO_CHAR(sysdate,'YYYY'), 'DD/MM/YYYY') AND TO_DATE('31/12/'||TO_CHAR(sysdate,'YYYY'), 'DD/MM/YYYY') 
                            ) TERKIRIM");
		
        if ($q->num_rows() > 0)
          $data = $q->result();

        $q->free_result();

        return $data;						
							
	}
	
	//model untuk chart Bulan Berjalan
	function getDataChartBulan($noagen,$kdkantor,$kdjabatan){
		 $data = array();
		 $sqlktr = "";
			if($kdjabatan != '26'){
			  $sqlktr = "AND KDKANTOR = '$kdkantor'";
			}
		 $q = $this->db->query("SELECT 
						PENAWARAN.JML AS JML_PENAWARAN,
                        PENAWARAN.ANP AS ANP_PENAWARAN,
                        SPAJ.ANP AS ANP_SPAJ,
                        SPAJ.JML AS JML_SPAJ,
                        PROPOSAL.JML AS JML_PROPOSAL,
                        PROPOSAL.ANP AS ANP_PROPOSAL,
                        APPROVAL.JML AS JML_APPROVAL,
                        APPROVAL.ANP AS ANP_APPROVAL,
                        PELUNASAN.JML AS JML_PELUNASAN,
                        PELUNASAN.ANP AS ANP_PELUNASAN,
                        TERKIRIM.JML AS JML_TERKIRIM,
                        TERKIRIM.ANP AS ANP_TERKIRIM,
                         ( SELECT COUNT(NOAGEN) AS JML_SEBAWAH
                            FROM   TABEL_400_AGEN@jlindo 
                            WHERE   KDSTATUSAGEN = '01'
							$sqlktr
                            START WITH   ATASAN = '".$noagen."'
                            CONNECT BY nocycle PRIOR NOAGEN = ATASAN
                        ) AS AGEN_SEBAWAH
                     FROM( SELECT COUNT(a.ID_AGEN) as JML,
                                     NVL(SUM(
                                                CASE 
                                                    WHEN a.CARA_BAYAR IN ('Bulanan') THEN CAST(a.JUMLAH_PREMI AS int) * 12
                                                    WHEN a.CARA_BAYAR IN ('Kuartalan') THEN CAST(a.JUMLAH_PREMI AS int) * 4
                                                    WHEN a.CARA_BAYAR IN ('Semesteran') THEN CAST(a.JUMLAH_PREMI AS int) * 2
                                                    ELSE CAST(a.JUMLAH_PREMI AS int)
                                                END
                                        ),0) as ANP
                               FROM JAIM_300_HITUNG a
                               WHERE a.ID_AGEN IN ( (SELECT   NOAGEN
                                                       FROM   TABEL_400_AGEN@jlindo 
                                                       WHERE    KDSTATUSAGEN = '01'
														$sqlktr													   
                                                       START WITH   ATASAN = '$noagen' 
                                                       CONNECT BY   PRIOR NOAGEN = ATASAN
                                                       UNION ALL
                                                       SELECT   '$noagen'  FROM DUAL
                                                    )
                                                  )
                                    AND (a.TGL_REKAM BETWEEN TRUNC(TO_DATE (sysdate, 'dd/mm/yyyy'),'mm') AND LAST_DAY(TO_DATE (sysdate, 'dd/mm/yyyy'))
                                         OR 
										 a.BUILD_ID IN (  SELECT BUILDID 
                                                            FROM TABEL_SPAJ_ONLINE@jlindo b,TABEL_200_PERTANGGUNGAN@jlindo c 
                                                            WHERE b.NOSPAJ = c.NOSP
                                                                  AND c.KDPERTANGGUNGAN IN ('1', '2')
                                                                  AND c.KDSTATUSEMAIL = '1'
                                                                  AND c.MULAS BETWEEN TRUNC(TO_DATE (sysdate, 'dd/mm/yyyy'),'mm') AND LAST_DAY(TO_DATE (sysdate, 'dd/mm/yyyy')) 
                                                          )
                                        )
                            ) PENAWARAN,
                            (   SELECT NVL (
                                          SUM (
                                             CASE
                                                WHEN a.BUILD_ID = b.BUILDID 
                                                THEN
                                                    CASE 
                                                        WHEN a.CARA_BAYAR IN ('Bulanan') THEN CAST(a.JUMLAH_PREMI AS int) * 12
                                                        WHEN a.CARA_BAYAR IN ('Kuartalan') THEN CAST(a.JUMLAH_PREMI AS int) * 4
                                                        WHEN a.CARA_BAYAR IN ('Semesteran') THEN CAST(a.JUMLAH_PREMI AS int) * 2
                                                        ELSE CAST(a.JUMLAH_PREMI AS int)
                                                    END
                                                ELSE 0
                                             END),
                                        0) as ANP,
                                    COUNT(b.KODEAGEN) as JML
                                FROM
                                    JAIM_300_HITUNG a, TABEL_SPAJ_ONLINE@jlindo b
                                WHERE
                                    a.BUILD_ID = b.BUILDID
                                    AND
                                    b.KODEAGEN IN ( (SELECT   NOAGEN
                                                       FROM   TABEL_400_AGEN@jlindo 
                                                       WHERE    KDSTATUSAGEN = '01'
                                                       $sqlktr          
                                                       START WITH   ATASAN = '$noagen' 
                                                       CONNECT BY   PRIOR NOAGEN = ATASAN
                                                       UNION ALL
                                                       SELECT   '$noagen'  FROM DUAL
                                                    )
                                                  )
                                    AND (b.TANGGALREKAM BETWEEN TRUNC(TO_DATE (sysdate, 'dd/mm/yyyy'),'mm') AND LAST_DAY(TO_DATE (sysdate, 'dd/mm/yyyy'))
                                         OR 
										 b.NOSPAJ IN (   SELECT NOSP 
                                                            FROM TABEL_200_PERTANGGUNGAN@jlindo c 
                                                            WHERE c.KDPERTANGGUNGAN IN ('1', '2')
                                                                  AND c.KDSTATUSEMAIL = '1'
                                                                  AND c.MULAS BETWEEN TRUNC(TO_DATE (sysdate, 'dd/mm/yyyy'),'mm') AND LAST_DAY(TO_DATE (sysdate, 'dd/mm/yyyy')) 
                                                        )
                                        )

                            ) SPAJ,
                            (
                                SELECT
                                    COUNT(c.NOAGEN) as JML,
                                    NVL(SUM(
                                                CASE 
                                                    WHEN c.KDCARABAYAR IN ('1','M') THEN c.premi1 * 12
                                                    WHEN c.KDCARABAYAR IN ('2','Q') THEN c.premi1 * 4
                                                    WHEN c.KDCARABAYAR IN ('3','H') THEN c.premi1 * 2
                                                    ELSE c.premi1
                                                END
                                        ),0) as ANP
                                FROM TABEL_200_PERTANGGUNGAN@jlindo c
                                WHERE c.KDPERTANGGUNGAN IN ('1', '2')
                                    AND c.KDSTATUSEMAIL = '1' 
                                    AND c.NOAGEN IN ( (SELECT   NOAGEN
                                                       FROM   TABEL_400_AGEN@jlindo 
                                                       WHERE    KDSTATUSAGEN = '01'
                                                       $sqlktr          
                                                       START WITH   ATASAN = '$noagen' 
                                                       CONNECT BY   PRIOR NOAGEN = ATASAN
                                                       UNION ALL
                                                       SELECT   '$noagen'  FROM DUAL
                                                    )
                                                  )
                                    AND c.MULAS BETWEEN TRUNC(TO_DATE (sysdate, 'dd/mm/yyyy'),'mm') AND LAST_DAY(TO_DATE (sysdate, 'dd/mm/yyyy')) 
                            ) PROPOSAL,
                            (   SELECT
                                    COUNT(d.NOPERTANGGUNGAN) as JML,
                                    NVL (
                                          SUM (
                                             CASE
                                                WHEN c.NOPERTANGGUNGAN = d.NOPERTANGGUNGAN
                                                THEN
                                                    CASE 
                                                        WHEN c.KDCARABAYAR IN ('1','M') THEN c.premi1 * 12
                                                        WHEN c.KDCARABAYAR IN ('2','Q') THEN c.premi1 * 4
                                                        WHEN c.KDCARABAYAR IN ('3','H') THEN c.premi1 * 2
                                                        ELSE c.premi1
                                                    END
                                                ELSE 0
                                             END),
                                        0) as ANP
                                FROM TABEL_214_APPROVAL_PROPOSAL@jlindo d, TABEL_200_PERTANGGUNGAN@jlindo c
                                WHERE c.NOPERTANGGUNGAN = d.NOPERTANGGUNGAN 
                                    AND c.PREFIXPERTANGGUNGAN = d.PREFIXPERTANGGUNGAN
                                    AND c.KDPERTANGGUNGAN IN ('1', '2')
                                    AND c.KDSTATUSEMAIL = '1'
                                    AND c.NOAGEN IN ( (SELECT   NOAGEN
                                                       FROM   TABEL_400_AGEN@jlindo 
                                                       WHERE    KDSTATUSAGEN = '01'
                                                        $sqlktr         
                                                       START WITH   ATASAN = '$noagen' 
                                                       CONNECT BY   PRIOR NOAGEN = ATASAN
                                                       UNION ALL
                                                       SELECT   '$noagen'  FROM DUAL
                                                    )
                                                  )
                                    AND c.MULAS BETWEEN TRUNC(TO_DATE (sysdate, 'dd/mm/yyyy'),'mm') AND LAST_DAY(TO_DATE (sysdate, 'dd/mm/yyyy')) 
                            ) APPROVAL,
                            (
                                SELECT
                                    COUNT(e.NOPERTANGGUNGAN) as JML,
                                    NVL (
                                          SUM (
                                              CASE 
                                                    WHEN e.KDCARABAYAR IN ('1','M') THEN e.premi1 * 12
                                                    WHEN e.KDCARABAYAR IN ('2','Q') THEN e.premi1 * 4
                                                    WHEN e.KDCARABAYAR IN ('3','H') THEN e.premi1 * 2
                                                    ELSE e.premi1
                                              END),
                                        0) as ANP
                                FROM TABEL_200_PERTANGGUNGAN@jlindo e 
                                WHERE e.KDSTATUSFILE NOT IN ('X','C')
                                    AND e.KDPERTANGGUNGAN = '2'
                                    AND e.NOAGEN IN ( (SELECT   NOAGEN
                                                       FROM   TABEL_400_AGEN@jlindo 
                                                       WHERE    KDSTATUSAGEN IN ('01','02','03','04','05')
                                                        $sqlktr         
                                                       START WITH   ATASAN = '$noagen' 
                                                       CONNECT BY   PRIOR NOAGEN = ATASAN
                                                       UNION ALL
                                                       SELECT   '$noagen'  FROM DUAL
                                                    )
                                                  )
                                    AND e.MULAS BETWEEN TRUNC(TO_DATE (sysdate, 'dd/mm/yyyy'),'mm') AND LAST_DAY(TO_DATE (sysdate, 'dd/mm/yyyy'))
                            ) PELUNASAN,
                            (
                                SELECT
                                    COUNT(f.NOPERTANGGUNGAN) as JML,
                                    NVL (
                                          SUM (
                                             CASE
                                                WHEN e.NOPERTANGGUNGAN = f.NOPERTANGGUNGAN
                                                THEN
                                                    CASE 
                                                        WHEN e.KDCARABAYAR IN ('1','M') THEN e.premi1 * 12
                                                        WHEN e.KDCARABAYAR IN ('2','Q') THEN e.premi1 * 4
                                                        WHEN e.KDCARABAYAR IN ('3','H') THEN e.premi1 * 2
                                                        ELSE e.premi1
                                                    END
                                                ELSE 0
                                             END),
                                        0) as ANP
                                    FROM TABEL_200_PERTANGGUNGAN@jlindo e, TABEL_214_VERIFY_CETAK_POLIS@jlindo f 
                                    WHERE e.NOPERTANGGUNGAN = f.NOPERTANGGUNGAN
                                          AND e.PREFIXPERTANGGUNGAN = f.PREFIXPERTANGGUNGAN
                                          AND f.KDKIRIM = '1'
                                          AND f.TGLKIRIM IS NOT NULL 
                                          AND e.NOAGEN IN ( (SELECT   NOAGEN
                                                       FROM   TABEL_400_AGEN@jlindo 
                                                       WHERE    KDSTATUSAGEN = '01'
                                                       $sqlktr          
                                                       START WITH   ATASAN = '$noagen' 
                                                       CONNECT BY   PRIOR NOAGEN = ATASAN
                                                       UNION ALL
                                                       SELECT   '$noagen'  FROM DUAL
                                                    )
                                                  )
                                          AND e.MULAS BETWEEN TRUNC(TO_DATE (sysdate, 'dd/mm/yyyy'),'mm') AND LAST_DAY(TO_DATE (sysdate, 'dd/mm/yyyy')) 
                            ) TERKIRIM");
		
        if ($q->num_rows() > 0)
          $data = $q->result();

        $q->free_result();

        return $data;						
							
	}

    /*===== daftar provinsi =====*/
    function get_list_provinsi() {
        $data = array();

        $q = $this->db
            ->query("SELECT KDPROVINSI, NAMAPROVINSI
                     FROM JAIM_001_PROVINSI
                     ORDER BY NAMAPROVINSI");

        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }

    /*===== daftar jenis pekerjaan =====*/
    function get_list_pekerjaan() {
        $data = array();

        $q = $this->db
            ->query("SELECT KDJENISPEKERJAAN, NAMAPEKERJAAN
                     FROM JAIM_400_JENIS_PEKERJAAN
                     ORDER BY NAMAPEKERJAAN");

        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }
	
	/*===== daftar hobi =====*/
    function get_list_hobi() {
        $data = array();

        $q = $this->db
            ->query("SELECT KDHOBI, NAMAHOBI
                     FROM JAIM_400_HOBI
                     ORDER BY NAMAHOBI");

        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }
	
	function get_list_kotamadya() {
        $data = array();

        $q = $this->db
            ->query("");

        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }


    /*===== daftar slideshow =====*/
    function get_list_slideshow() {
        $data = array();

        $q = $this->db
            ->query("SELECT JUDUL, GAMBAR, SINOPSIS
                     FROM JAIM_000_SLIDESHOW
                     WHERE KDSTATUS = 1
                     ORDER BY URUTAN");

        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }


    /*===== daftar tour =====*/
    function get_list_tour() {
        $data = array();

        $q = $this->db
            ->query("SELECT *
                     FROM (
                         SELECT JUDUL, SINOPSIS, GAMBAR, JMLPOINMIN, JMLPOINMAX
                         FROM JAIM_000_TOUR
                         WHERE KDSTATUS = 1
                         ORDER BY URUTAN
                     )
                     WHERE ROWNUM <= 5");

        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }


    /*===== daftar berita terbaru (NOT USE) =====*/
    function get_list_berita_terbaru() {
        $data = array();

        $db = $this->load->database('mysql_81', true);
        $q = $db->query("SELECT node.title AS node_title, node.nid AS nid, node.language AS node_language, field_data_body.body_value AS field_data_body_body_value, field_data_field_sumber.field_sumber_value AS field_data_field_sumber_field_sumber_value, file_managed_file_usage.uri AS file_managed_file_usage_uri, node.created AS node_created, MIN(node.nid) AS nid_1, 'node' AS field_data_body_node_entity_type, 'node' AS field_data_field_sumber_node_entity_type, 'node' AS field_data_field_image_node_entity_type
			FROM node node
			LEFT JOIN file_usage file_usage ON node.nid = file_usage.id AND file_usage.type = 'node'
			LEFT JOIN file_managed file_managed_file_usage ON file_usage.fid = file_managed_file_usage.fid
			LEFT JOIN field_data_field_tipe_article field_data_field_tipe_article ON node.nid = field_data_field_tipe_article.entity_id AND field_data_field_tipe_article.field_tipe_article_tid = '58'
			LEFT JOIN field_data_body field_data_body ON node.nid = field_data_body.entity_id AND (field_data_body.entity_type = 'node' AND field_data_body.deleted = '0')
			LEFT JOIN field_data_field_sumber field_data_field_sumber ON node.nid = field_data_field_sumber.entity_id AND (field_data_field_sumber.entity_type = 'node' AND field_data_field_sumber.deleted = '0')
			LEFT JOIN field_data_field_image field_data_field_image ON node.nid = field_data_field_image.entity_id AND (field_data_field_image.entity_type = 'node' AND field_data_field_image.deleted = '0')
			WHERE (( (node.status = '1') AND (node.type IN  ('article')) AND (field_data_field_tipe_article.field_tipe_article_tid IS NULL ) ))
			GROUP BY node_title, nid, node_language, field_data_body_node_entity_type, field_data_body_body_value, field_data_field_sumber_node_entity_type, field_data_field_sumber_field_sumber_value, field_data_field_image_node_entity_type, file_managed_file_usage_uri, node_created
			ORDER BY node_created DESC LIMIT 0,3");

        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }


    /*===== daftar ebook =====*/
    function get_list_ebook($filter) {
        $data = array();

        $kdrole = $this->session->KDROLE;
        $kategori = '';

        if($kdrole == '29'){
          $kategori = 'AND KATEGORI IN (0,2)';
        }elseif ($kdrole == '1') {
          $kategori = 'AND KATEGORI IN (0,1)';
        }elseif ($kdrole == '31') {
          $kategori = 'AND KATEGORI IN (0,4)';
        }elseif (in_array($kdrole, array('32','33','34','35','36','37','38'))) {
          $kategori = 'AND KATEGORI IN (0,3)';
        }
		

        $q = $this->db
            ->query("SELECT * FROM
        	(
        		SELECT tbl.*, rownum no
        		FROM
        		(
        		     SELECT KDEBOOK, NAMAEBOOK, KETERANGAN, EBOOK, TO_CHAR(TGLREKAM, 'DD/MM/YYYY') TGLREKAM
                     FROM JAIM_000_EBOOK
                     WHERE STATUS = 1 AND (
                         LOWER(NAMAEBOOK) LIKE '%$filter[s]%' OR
                         LOWER(KETERANGAN) LIKE '%$filter[s]%' OR
                         TO_CHAR(TGLREKAM, 'DD/MM/YYYY') LIKE '%$filter[s]%'
                     )
                     $kategori
        			 ORDER BY URUTAN
        		) tbl
        		WHERE rownum < ((".$filter['p']." * ".C_ROWS_PAGINATION.") + 1 )
        	)
        	WHERE no >= (((".$filter['p']."-1) * ".C_ROWS_PAGINATION.") + 1)");

        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }


    /*===== daftar bod message =====*/
    function get_list_bodmsg($filter) {
        $data = array();

        $q = $this->db
            ->query("SELECT * FROM
        	(
        		SELECT tbl.*, rownum no
        		FROM
        		(
        		     SELECT IDBODMSG, JUDUL, PESAN, KDSTATUS, NAMA
        		     FROM JAIM_000_BOD_MSG
                     WHERE LOWER(JUDUL) LIKE '%$filter[s]%' OR
                         LOWER(PESAN) LIKE '%$filter[s]%' OR
                         LOWER(NAMA) LIKE '%$filter[s]%'
        			 ORDER BY KDSTATUS DESC, TGLREKAM DESC NULLS LAST
        		) tbl
        		WHERE rownum < ((".$filter['p']." * ".C_ROWS_PAGINATION.") + 1 )
        	)
        	WHERE no >= (((".$filter['p']."-1) * ".C_ROWS_PAGINATION.") + 1)");

        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }


    /*===== daftar agent of the month =====*/
    function get_list_aotm($filter) {
        $data = array();

        $q = $this->db
            ->query("SELECT * FROM
        	(
        		SELECT tbl.*, rownum no
        		FROM
        		(
        		     SELECT IDAGENMONTH, NAMA, PRAKATA, NARASI, NAMAKANTOR, BULAN, TAHUN, KDSTATUS
        		     FROM JAIM_000_AGEN_MONTH
                     WHERE LOWER(NAMA) LIKE '%$filter[s]%' OR
                         LOWER(PRAKATA) LIKE '%$filter[s]%' OR
                         LOWER(NARASI) LIKE '%$filter[s]%' OR
                         LOWER(NAMAKANTOR) LIKE '%$filter[s]%'
        			 ORDER BY TO_NUMBER(TAHUN) DESC, TO_NUMBER(BULAN) DESC, TGLREKAM DESC NULLS LAST
        		) tbl
        		WHERE rownum < ((".$filter['p']." * ".C_ROWS_PAGINATION.") + 1 )
        	)
        	WHERE no >= (((".$filter['p']."-1) * ".C_ROWS_PAGINATION.") + 1)");

        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }


    /*===== daftar notifikasi ======*/
    function get_list_notifikasi() {
        $data = array();

        $q = $this->db
            ->query("SELECT idnotifikasi, icon, notifikasi, kdstatus, urutan, TO_CHAR(tglrekam, 'dd/mm/yyyy') tglrekam,
                         userrekam
                     FROM jaim_000_notifikasi
                     ORDER BY urutan");

        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }


    /*===== daftar popup images =====*/
    function get_list_popimages() {
        $data = array();
	    // permintaan dwi nur prasetya
	    $where = in_array($this->session->KDKANTOR, array('MG','QD','QE','AC','AE','AF','QB','BI','QC')) ? "" : " AND idpopimage != '12'";

       // UAT 24012023
        $kdrole = $this->session->KDROLE;
        $filter = '';

        if($kdrole == '29'){
          $filter = 'AND status = 2';
        }elseif ($kdrole == '1') {
          $filter = 'AND status = 1';
        }elseif ($kdrole == '31') {
          $filter = 'AND status = 4';
        }elseif (in_array($kdrole, array('32','33','34','35','36','37','38'))) {
          $filter = 'AND status = 3';
        }
		
		$filter .= ' OR status = 0';

        $q = $this->db
            ->query("SELECT idpopimage, judul, deskripsi, gambar, TO_CHAR(tglakhir,'dd/mm/yyyy') tglakhir
                     FROM jaim_000_popimage
                     WHERE sysdate BETWEEN tglawal AND tglakhir
		              $where
                      $filter
                     ORDER BY tglakhir");

        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }
	
	
	/*===== daftar produk simulasi =====*/
	function get_list_produk() {
		$data = array();
		
		$q = $this->db
			 ->query("SELECT *
					  FROM jaim_301_produk
					  WHERE kdstatus = '1'");
		
		if ($q->num_rows() > 0)
			$data = $q->result_array();
		
		$q->free_result();
		
		return $data;
	}


    /*===== data bod message =====*/
    function get_bodmsg($id = null, $aktif = true) {
        $data = array();
        $where = $id ? " IDBODMSG = '$id'" : ($aktif ? " KDSTATUS = 1" : null);

        $q = $this->db
            ->query("SELECT JUDUL, NAMA, PESAN, GAMBAR, TEMPAT, TO_CHAR(TGLREKAM, 'DD/MM/YYYY') TGLREKAM, IDBODMSG, KDSTATUS,
                         TRIM(TO_CHAR(TGLREKAM, 'fmDay')) || ', ' || TRIM(TO_CHAR(TGLREKAM, 'DD')) || ' ' || INITCAP(TRIM(TO_CHAR(TGLREKAM, 'MONTH'))) || ' ' || TRIM(TO_CHAR(TGLREKAM, 'YYYY')) TGLREKAMID
                     FROM JAIM_000_BOD_MSG
                     WHERE $where");

        if ($q->num_rows() > 0)
            $data = $q->row_array();

        $q->free_result();

        return $data;
    }


    /*===== data aotm message =====*/
    function get_aotm($id = null) {
        $data = array();

        $q = $this->db
            ->query("SELECT NAMA, PRAKATA, NARASI, GAMBAR, NAMAKANTOR, TAHUN, NOAGEN, BULAN NBULAN, KDSTATUS,
                         TO_CHAR(TO_DATE('01/' || BULAN || '/1970', 'DD/MM/YYYY'), 'MONTH') BULAN, IDAGENMONTH,
                         TRIM(TO_CHAR(TGLREKAM, 'fmDay')) || ', ' || TRIM(TO_CHAR(TGLREKAM, 'DD')) || ' ' || INITCAP(TRIM(TO_CHAR(TGLREKAM, 'MONTH'))) || ' ' || TRIM(TO_CHAR(TGLREKAM, 'YYYY')) TGLREKAMID
                     FROM JAIM_000_AGEN_MONTH
                     WHERE IDAGENMONTH LIKE '%$id%'");

        if ($q->num_rows() > 0)
            $data = $q->row_array();

        $q->free_result();

        return $data;
    }


    /*===== get total rows ebook =====*/
    function get_total_ebook($filter) {
        $rows = 0;
        $kdrole = $this->session->KDROLE;
        $kategori = '';

        if($kdrole == '29'){
          $kategori = 'AND KATEGORI =2';
        }elseif ($kdrole == '1') {
          $kategori = 'AND KATEGORI = 1';
        }elseif ($kdrole == '31') {
          $kategori = 'AND KATEGORI = 4';
        }elseif (in_array($kdrole, array('32','33','34','35','36','37','38'))) {
          $kategori = 'AND KATEGORI = 3';
        }
		
		$kategori = ' OR KATEGORI = 0';

        $q = $this->db
            ->query("SELECT KDEBOOK, NAMAEBOOK, KETERANGAN, EBOOK, TO_CHAR(TGLREKAM, 'DD/MM/YYYY') TGLREKAM
                     FROM JAIM_000_EBOOK
                     WHERE STATUS = 1 AND (
                         LOWER(NAMAEBOOK) LIKE '%$filter[s]%' OR
                         LOWER(KETERANGAN) LIKE '%$filter[s]%' OR
                         TO_CHAR(TGLREKAM, 'DD/MM/YYYY') LIKE '%$filter[s]%'
                     )
                     $kategori
        			 ORDER BY URUTAN");;

        $rows = $q->num_rows();

        return $rows;
    }


    /*===== get total rows bod message =====*/
    function get_total_bodmsg($filter) {
        $rows = 0;

        $q = $this->db
            ->query("SELECT IDBODMSG, JUDUL, PESAN, KDSTATUS, NAMA
        		     FROM JAIM_000_BOD_MSG
                     WHERE LOWER(JUDUL) LIKE '%$filter[s]%' OR
                         LOWER(PESAN) LIKE '%$filter[s]%' OR
                         LOWER(NAMA) LIKE '%$filter[s]%'
        			 ORDER BY KDSTATUS DESC, TGLREKAM DESC NULLS LAST");;

        $rows = $q->num_rows();

        return $rows;
    }


    /*===== get total rows aotm message =====*/
    function get_total_aotm($filter) {
        $rows = 0;

        $q = $this->db
            ->query("SELECT IDAGENMONTH, NAMA, PRAKATA, NARASI, NAMAKANTOR, BULAN, TAHUN, KDSTATUS
        		     FROM JAIM_000_AGEN_MONTH
                     WHERE LOWER(NAMA) LIKE '%$filter[s]%' OR
                         LOWER(PRAKATA) LIKE '%$filter[s]%' OR
                         LOWER(NARASI) LIKE '%$filter[s]%' OR
                         LOWER(NAMAKANTOR) LIKE '%$filter[s]%'
        			 ORDER BY TO_NUMBER(TAHUN) DESC, TO_NUMBER(BULAN) DESC, TGLREKAM DESC NULLS LAST");

        $rows = $q->num_rows();

        return $rows;
    }


    /*===== data video =====*/
    function get_list_video($filter) {
        $data = array();

        $kdrole = $this->session->KDROLE;
        $kategori = '';
		/*
        if($kdrole == '29'){
          $kategori = 'AND KATEGORI != 1';
        }elseif ($kdrole == '1') {
          $kategori = 'AND KATEGORI != 2';
        }
		*/
		if($kdrole == '29'){
          $kategori = 'AND KATEGORI =2';
        }elseif ($kdrole == '1') {
          $kategori = 'AND KATEGORI = 1';
        }elseif ($kdrole == '31') {
          $kategori = 'AND KATEGORI = 4';
        }elseif (in_array($kdrole, array('32','33','34','35','36','37','38'))) {
          $kategori = 'AND KATEGORI = 3';
        }
		
		$kategori = ' OR KATEGORI = 0';
		
        $q = $this->db
            ->query("SELECT * FROM
        	(
        		SELECT tbl.*, rownum no
        		FROM
        		(
        		     SELECT KDVIDEO, JUDUL, DESKRIPSI, URL, TO_CHAR(TGLREKAM, 'DD/MM/YYYY') TGLREKAM
                     FROM JAIM_000_VIDEO
                     WHERE KDSTATUS = 1 AND (
                         LOWER(JUDUL) LIKE '%$filter[s]%' OR
                         LOWER(DESKRIPSI) LIKE '%$filter[s]%' OR
                         TO_CHAR(TGLREKAM, 'DD/MM/YYYY') LIKE '%$filter[s]%'
                     )
                     $kategori
        			 ORDER BY NOURUT DESC
        		) tbl
        		WHERE rownum < ((".$filter['p']." * ".C_ROWS_PAGINATION.") + 1 )
        	)
        	WHERE no >= (((".$filter['p']."-1) * ".C_ROWS_PAGINATION.") + 1)");

        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }


    /*===== get total rows video =====*/
    function get_total_video($filter) {
        $rows = 0;
        $kdrole = $this->session->KDROLE;
        $kategori = '';

        if($kdrole == '29'){
          $kategori = 'AND KATEGORI =2';
        }elseif ($kdrole == '1') {
          $kategori = 'AND KATEGORI = 1';
        }elseif ($kdrole == '31') {
          $kategori = 'AND KATEGORI = 4';
        }elseif (in_array($kdrole, array('32','33','34','35','36','37','38'))) {
          $kategori = 'AND KATEGORI = 3';
        }
		
		$kategori = ' OR KATEGORI = 0';

        $q = $this->db
            ->query("SELECT KDVIDEO, JUDUL, DESKRIPSI, URL, TO_CHAR(TGLREKAM, 'DD/MM/YYYY') TGLREKAM
                     FROM JAIM_000_VIDEO
                     WHERE KDSTATUS = 1 AND (
                         LOWER(JUDUL) LIKE '%$filter[s]%' OR
                         LOWER(DESKRIPSI) LIKE '%$filter[s]%' OR
                         TO_CHAR(TGLREKAM, 'DD/MM/YYYY') LIKE '%$filter[s]%'
                     )
                     $kategori
        			 ORDER BY TGLREKAM DESC");;

        $rows = $q->num_rows();

        return $rows;
    }

	
    /*==== data e-sertifikat =====*/
    function get_list_esertifikat($filter) {
        $data = array();
        
        $q = $this->db
            ->query("SELECT * FROM
        	(
                    SELECT tbl.*, rownum no
                    FROM
                    (
                        SELECT c.jenispelatihan, b.namapelatihan, TO_CHAR(b.tglpelaksanaanawal, 'dd/mm/yyyy') tglpelaksanaanawal,
                            TO_CHAR(b.tglpelaksanaanakhir, 'dd/mm/yyyy') tglpelaksanaanakhir, a.userotorisasi,
                            TO_CHAR(a.tglotorisasi, 'dd/mm/yyyy') tglotorisasi, a.nopelatihan, a.noagen
                        FROM tabel_400_peserta_pelatihan@jlindo a
                        INNER JOIN tabel_400_pelatihan_agen@jlindo b ON a.nopelatihan = b.nopelatihan
                        INNER JOIN tabel_401_jenis_pelatihan@jlindo c ON b.kdjenis = c.kdjenis
                        WHERE a.noagen = '".$this->session->USERNAME."'
                            AND a.tglotorisasi IS NOT NULL
                            AND (
                                LOWER(c.jenispelatihan) LIKE '%$filter[s]%' OR
                                LOWER(b.namapelatihan) LIKE '%$filter[s]%' OR
                                TO_CHAR(b.tglpelaksanaanawal, 'DD/MM/YYYY') LIKE '%$filter[s]%' OR
                                TO_CHAR(b.tglpelaksanaanakhir, 'DD/MM/YYYY') LIKE '%$filter[s]%' OR
                                LOWER(a.userotorisasi) LIKE '%$filter[s]%' OR
                                TO_CHAR(a.tglotorisasi, 'DD/MM/YYYY') LIKE '%$filter[s]%'
                            )
                        ORDER BY b.tglpelaksanaanawal DESC
                    ) tbl
                    WHERE rownum < ((".$filter['p']." * ".C_ROWS_PAGINATION.") + 1 )
        	)
        	WHERE no >= (((".$filter['p']."-1) * ".C_ROWS_PAGINATION.") + 1)");
		
        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }

	
	/*===== get total rows e-sertifikat =====*/
    function get_total_esertifikat($filter) {
        $q = $this->db
            ->query("SELECT c.jenispelatihan, b.namapelatihan, TO_CHAR(b.tglpelaksanaanawal, 'dd/mm/yyyy') tglpelaksanaanawal,
                        TO_CHAR(b.tglpelaksanaanakhir, 'dd/mm/yyyy') tglpelaksanaanakhir, a.userotorisasi,
                        TO_CHAR(a.tglotorisasi, 'dd/mm/yyyy') tglotorisasi, a.nopelatihan, a.noagen
                    FROM tabel_400_peserta_pelatihan@jlindo a
                    INNER JOIN tabel_400_pelatihan_agen@jlindo b ON a.nopelatihan = b.nopelatihan
                    INNER JOIN tabel_401_jenis_pelatihan@jlindo c ON b.kdjenis = c.kdjenis
                    WHERE a.noagen = '".$this->session->USERNAME."'
                        AND a.tglotorisasi IS NOT NULL
                        AND (
                            LOWER(c.jenispelatihan) LIKE '%$filter[s]%' OR
                            LOWER(b.namapelatihan) LIKE '%$filter[s]%' OR
                            TO_CHAR(b.tglpelaksanaanawal, 'DD/MM/YYYY') LIKE '%$filter[s]%' OR
                            TO_CHAR(b.tglpelaksanaanakhir, 'DD/MM/YYYY') LIKE '%$filter[s]%' OR
                            LOWER(a.userotorisasi) LIKE '%$filter[s]%' OR
                            TO_CHAR(a.tglotorisasi, 'DD/MM/YYYY') LIKE '%$filter[s]%'
                        )
                    ORDER BY b.tglpelaksanaanawal DESC");

        $rows = $q->num_rows();

        return $rows;
    }
    
    /*==== data e-sertifikat by no agen dan no pelatihan =====*/
    function get_esertifikat($nopelatihan, $noagen) {
        $data = array();
        
        $q = $this->db
            ->query("SELECT 'No. ' || a.nopelatihan || '/Jiwasraya/ARC-LPPA/' || TO_CHAR(a.tglcetak,' mmyy') no,
                            b.namaklien1, INITCAP(d.alamat02) alamat02, UPPER(e.namapelatihan) namapelatihan, 
                            TRIM(TO_CHAR(a.tglcetak, 'dd') || ' ' || TRIM(TO_CHAR(a.tglcetak, 'Month')) || ' '  || TO_CHAR(a.tglcetak, 'yyyy')) tglcetak,
                            CASE 
                                    WHEN e.tglpelaksanaanawal = e.tglpelaksanaanakhir THEN 
                                            TO_CHAR(e.tglpelaksanaanakhir, 'dd') || ' ' || TRIM(TO_CHAR(e.tglpelaksanaanakhir, 'Month')) || ', '  || TO_CHAR(e.tglpelaksanaanakhir, 'yyyy')
                                    WHEN TO_CHAR(e.tglpelaksanaanawal, 'mmyyyy') = TO_CHAR(e.tglpelaksanaanakhir, 'mmyyyy') THEN
                                            TO_CHAR(e.tglpelaksanaanawal, 'dd') || ' - ' || TO_CHAR(e.tglpelaksanaanakhir, 'dd') || ' ' || TRIM(TO_CHAR(e.tglpelaksanaanakhir, 'Month')) || ', '  || TO_CHAR(e.tglpelaksanaanakhir, 'yyyy')
                                    WHEN TO_CHAR(e.tglpelaksanaanawal, 'yyyy') = TO_CHAR(e.tglpelaksanaanakhir, 'yyyy') THEN
                                            TO_CHAR(e.tglpelaksanaanawal, 'dd') || ' ' || TRIM(TO_CHAR(e.tglpelaksanaanawal, 'Month')) || ' - ' || TO_CHAR(e.tglpelaksanaanakhir, 'dd') || ' ' || TRIM(TO_CHAR(e.tglpelaksanaanakhir, 'Month')) || ', ' || TO_CHAR(e.tglpelaksanaanawal, 'yyyy')
                                    ELSE
                                            TO_CHAR(e.tglpelaksanaanawal, 'dd') || ' ' || TRIM(TO_CHAR(e.tglpelaksanaanawal, 'Month')) || ' ' || TO_CHAR(e.tglpelaksanaanawal, 'yyyy') || ' - ' || TO_CHAR(e.tglpelaksanaanakhir, 'dd') || ' ' || TRIM(TO_CHAR(e.tglpelaksanaanakhir, 'Month')) || ' ' || TO_CHAR(e.tglpelaksanaanakhir, 'yyyy')
                            END tglpelaksanaan,
                            (SELECT namapejabat FROM tabel_002_pejabat@jlindo WHERE kdkantor = 'KP' AND kdorganisasi = '102') namapejabat,
                            (SELECT namajabatan FROM tabel_002_pejabat@jlindo WHERE kdkantor = 'KP' AND kdorganisasi = '102') namajabatan
                    FROM tabel_400_peserta_pelatihan@jlindo a
                    INNER JOIN tabel_100_klien@jlindo b ON a.noagen = b.noklien
                    INNER JOIN tabel_400_agen@jlindo c ON a.noagen = c.noagen
                    LEFT OUTER JOIN tabel_001_kantor@jlindo d ON c.kdkantor = d.kdkantor
                    INNER JOIN tabel_400_pelatihan_agen@jlindo e ON a.nopelatihan = e.nopelatihan
                    WHERE a.nopelatihan = '$nopelatihan'
                        AND a.noagen = '$noagen'");
        
        if ($q->num_rows() > 0)
            $data = $q->row_array();

        $q->free_result();

        return $data;
    }
	
	
    /*===== daftar agent of the month =====*/
    function get_agent_of_the_month() {
        $data = array();

        $q = $this->db
            ->query("SELECT IDAGENMONTH, NAMA, PRAKATA, NARASI, GAMBAR, TO_CHAR(TO_DATE('01/' || TO_CHAR(BULAN, '09') || '1970', 'DD/MM/YYYY'), 'MONTH') BULAN,
                         NAMAKANTOR, TO_CHAR(TGLREKAM, 'DD/MM/YYYY') TGLREKAM
                     FROM JAIM_000_AGEN_MONTH
                     WHERE KDSTATUS = 1 AND BULAN = LTRIM(TO_CHAR(SYSDATE, 'MM'), '0') AND
                         TAHUN = TO_CHAR(SYSDATE, 'YYYY')");

        if ($q->num_rows() > 0)
            $data = $q->row_array();

        $q->free_result();

        return $data;
    }


    /*===== daftar popup images =====*/
    function get_popimages() {
        $kdrole = $this->session->KDROLE;
        $filter = '';

        if($kdrole == '29'){
          $filter = 'AND status = 2';
        }elseif ($kdrole == '1') {
          $filter = 'AND status = 1';
        }elseif ($kdrole == '31') {
          $filter = 'AND status = 4';
        }elseif (in_array($kdrole, array('32','33','34','35','36','37','38'))) {
          $filter = 'AND status = 3';
        }
		
		$filter .= ' OR status = 0';

        $data = array();

        $q = $this->db
            ->query("SELECT idpopimage, judul, deskripsi, gambar, status
                     FROM (
                         SELECT *
                         FROM jaim_000_popimage
                         WHERE sysdate BETWEEN tglawal AND tglakhir
                         $filter
                         ORDER BY DBMS_RANDOM.VALUE)
                     WHERE  rownum < 2");

        if ($q->num_rows() > 0)
            $data = $q->row_array();

        $q->free_result();

        return $data;
    }


    /*===== simpan data bod message =====*/
    function insert_bodmsg($data) {
        try {
            $this->db->trans_begin();

            $this->db->insert("JAIM_000_BOD_MSG", $data);
            $this->db->set('TGLREKAM', 'SYSDATE', FALSE)->where('IDBODMSG', $data['IDBODMSG'])->update('JAIM_000_BOD_MSG');

            if ($data['KDSTATUS'] == 1)
                $this->db->set('KDSTATUS', 0)->where_not_in('IDBODMSG', $data['IDBODMSG'])->update("JAIM_000_BOD_MSG");

            $status = $this->db->trans_commit();
        }
        catch (Exception $e) {
            $this->db->trans_rollback();

            $status = 0;
        }

        return ($status ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
    }


    /*===== simpan data agent of the month =====*/
    function insert_aotm($data) {
        try {
            $this->db->trans_begin();

            $this->db->insert("JAIM_000_AGEN_MONTH", $data);
            $this->db->set('TGLREKAM', 'SYSDATE', FALSE)->where('IDAGENMONTH', $data['IDAGENMONTH'])->update('JAIM_000_AGEN_MONTH');

            $status = $this->db->trans_commit();
        }
        catch (Exception $e) {
            $this->db->trans_rollback();

            $status = 0;
        }

        return ($status ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
    }


    /*===== update data bod message =====*/
    function update_bodmsg($data) {
        try {
            $this->db->trans_begin();

            $this->db->where('IDBODMSG', $data['IDBODMSG'])->update('JAIM_000_BOD_MSG', $data);
            $this->db->set('TGLREKAM', 'SYSDATE', FALSE)->where('IDBODMSG', $data['IDBODMSG'])->update('JAIM_000_BOD_MSG');

            if ($data['KDSTATUS'] == 1)
                $this->db->set('KDSTATUS', 0)->where_not_in('IDBODMSG', $data['IDBODMSG'])->update("JAIM_000_BOD_MSG");

            $status = $this->db->trans_commit();
        }
        catch (Exception $e) {
            $this->db->trans_rollback();

            $status = 0;
        }

        return ($status ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
    }


    /*===== update data agen of the month =====*/
    function update_aotm($data) {
        try {
            $this->db->trans_begin();

            $this->db->where('IDAGENMONTH', $data['IDAGENMONTH'])->update('JAIM_000_AGEN_MONTH', $data);
            $this->db->set('TGLREKAM', 'SYSDATE', FALSE)->where('IDAGENMONTH', $data['IDAGENMONTH'])->update('JAIM_000_AGEN_MONTH');

            $status = $this->db->trans_commit();
        }
        catch (Exception $e) {
            $this->db->trans_rollback();

            $status = 0;
        }

        return ($status ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
    }


    /*===== delete data bod message =====*/
    function delete_bodmsg($id) {
        try {
            $this->db->trans_begin();

            $this->db->where('IDBODMSG', $id)->delete('JAIM_000_BOD_MSG');

            $status = $this->db->trans_commit();
        }
        catch (Exception $e) {
            $this->db->trans_rollback();

            $status = 0;
        }

        return ($status ? C_STATUS_SUKSES_HAPUS : C_STATUS_GAGAL_HAPUS);
    }


    /*===== delete data agen of the month =====*/
    function delete_aotm($id) {
        try {
            $this->db->trans_begin();

            $this->db->where('IDAGENMONTH', $id)->delete('JAIM_000_AGEN_MONTH');

            $status = $this->db->trans_commit();
        }
        catch (Exception $e) {
            $this->db->trans_rollback();

            $status = 0;
        }

        return ($status ? C_STATUS_SUKSES_HAPUS : C_STATUS_GAGAL_HAPUS);
    }
}