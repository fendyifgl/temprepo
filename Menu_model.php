<?php

class Menu_model extends CI_Model {

    //function getlistpopupimage
	function getDataPopImages(){
		$data = array();

        $q = $this->db
            ->query("SELECT IDPOPIMAGE, JUDUL, GAMBAR, DESKRIPSI, TO_CHAR(TGLAWAL,'DD/MM/YYYY') AS TGLAWAL, TO_CHAR(TGLAKHIR,'DD/MM/YYYY') AS TGLAKHIR, STATUS FROM jaim_000_popimage order by tglrekam desc");

        if ($q->num_rows() > 0) {
            $data = $q->result_array();
        }

        $q->free_result();

        return $data;
	}
	
	//func getlistdokumen
	function getDataDokumen(){
		$data = array();

        $q = $this->db
            ->query("SELECT * FROM jaim_000_ebook order by tglrekam desc");

        if ($q->num_rows() > 0) {
            $data = $q->result_array();
        }

        $q->free_result();

        return $data;
	}
	
	//func getlistvidio
	function getDataVidio(){
		$data = array();

        $q = $this->db
            ->query("SELECT * FROM jaim_000_video order by tglrekam desc");

        if ($q->num_rows() > 0) {
            $data = $q->result_array();
        }

        $q->free_result();

        return $data;
	}
	//function getmax idpopimage
	function getidmaxImage(){
		$data = array();

        $q = $this->db
            ->query("SELECT MAX(IDPOPIMAGE) ID FROM JAIM_000_POPIMAGE");

        if ($q->num_rows() > 0) {
            $data = $q->result_array();
        }

        $q->free_result();

        return $data;
	}
	
	//function getmax kdvidio
	function getidmaxVidio(){
		$data = array();

        $q = $this->db
            ->query("SELECT MAX(KDVIDEO) ID FROM JAIM_000_VIDEO");

        if ($q->num_rows() > 0) {
            $data = $q->result_array();
        }

        $q->free_result();

        return $data;
	}
	
	//function getmax kdEbook
	function getidmaxEbook(){
		$data = array();

        $q = $this->db
            ->query("SELECT MAX(KDEBOOK) ID FROM JAIM_000_EBOOK");

        if ($q->num_rows() > 0) {
            $data = $q->result_array();
        }

        $q->free_result();

        return $data;
	}
	
	//function untuk post image, vidio, dokumen jaim
	function postDataPopUpImage($data){
		
		$id = $this->getidmaxImage();
		$idpopimg = $id[0]['ID'] + 1;
		
		$sukses = 0;
		
        $this->db->trans_begin();

        $this->db->query("INSERT INTO JAIM_000_POPIMAGE 
		(IDPOPIMAGE, JUDUL, DESKRIPSI, GAMBAR, TGLAWAL, TGLAKHIR, TGLREKAM, USERREKAM, STATUS) 
		VALUES ('$idpopimg', '".$data['judul']."', '".$data['deskripsi']."', '".$data['gambar']."', TO_DATE('".$data['tglawal']."','YYYY-MM-DD'), TO_DATE('".$data['tglakhir']."','YYYY-MM-DD'), sysdate , 'SUPER ADMIN', '".$data['kategori']."') ");
					 
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        }
        else {
            $sukses = $this->db->trans_commit();
        }

        return ($sukses ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
	}
	
	
	function postVidio($data){
		$id = $this->getidmaxVidio();
		$idvidio = $id[0]['ID'] + 1;
		
		$sukses = 0;
		
        $this->db->trans_begin();

        $this->db->query("INSERT INTO JAIM_000_VIDEO 
		(KDVIDEO, JUDUL, DESKRIPSI, URL, KDSTATUS, NOURUT, TGLREKAM, USERREKAM, KATEGORI) 
		VALUES ('$idvidio', '".$data['judul']."', '".$data['deskripsi']."', '".$data['vidio']."', '0', '".$data['nourut']."', sysdate , 'SUPER ADMIN', '".$data['kategori']."' ) ");
					 
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        }
        else {
            $sukses = $this->db->trans_commit();
        }

        return ($sukses ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
	}
	
	
	function postDokumen($data){
		$id = $this->getidmaxEbook();
		$idvidio = $id[0]['ID'] + 1;
		
		$sukses = 0;
		
        $this->db->trans_begin();

        $this->db->query("INSERT INTO JAIM_000_EBOOK 
		(KDEBOOK, NAMAEBOOK, KETERANGAN, EBOOK, STATUS, URUTAN, TGLREKAM, USERREKAM, KATEGORI) 
		VALUES ('$idvidio', '".$data['namabook']."', '".$data['deskripsi']."', '".$data['doc']."', '0', '".$data['nourut']."', sysdate , 'SUPER ADMIN',  '".$data['kategori']."') ");
					 
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        }
        else {
            $sukses = $this->db->trans_commit();
        }

        return ($sukses ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
	}

	//sampe disini untuk post image, vidio, dokumen jaim


	//function untuk delete image, dokumen, vidio
	function getImage($id){
		$data = array();

        $q = $this->db
            ->query("SELECT IDPOPIMAGE, JUDUL, GAMBAR, DESKRIPSI, TO_CHAR(TGLAWAL,'YYYY-MM-DD') AS TGLAWAL, TO_CHAR(TGLAKHIR,'YYYY-MM-DD') AS TGLAKHIR, STATUS  FROM JAIM_000_POPIMAGE where IDPOPIMAGE = '$id' ");

        if ($q->num_rows() > 0) {
            $data = $q->result_array();
        }

        $q->free_result();

        return $data;
	}
	
	function deleteImage($id){
		$sukses = 0;
		
        $this->db->trans_begin();

        $this->db->query("DELETE FROM JAIM_000_POPIMAGE WHERE IDPOPIMAGE = '$id'");
					 
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        }
        else {
            $sukses = $this->db->trans_commit();
        }

        return ($sukses ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
	}
	
	function getDokumen($id){
		$data = array();

        $q = $this->db
            ->query("SELECT * FROM JAIM_000_EBOOK where KDEBOOK = '$id' ");

        if ($q->num_rows() > 0) {
            $data = $q->result_array();
        }

        $q->free_result();

        return $data;
	}
	
	function deleteDokumen($id){
		$sukses = 0;
		
        $this->db->trans_begin();

        $this->db->query("DELETE FROM JAIM_000_EBOOK WHERE KDEBOOK = '$id'");
					 
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        }
        else {
            $sukses = $this->db->trans_commit();
        }

        return ($sukses ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
	}
	
	function getVidio($id){
		$data = array();

        $q = $this->db
            ->query("SELECT * FROM JAIM_000_VIDEO where KDVIDEO = '$id' ");

        if ($q->num_rows() > 0) {
            $data = $q->result_array();
        }

        $q->free_result();

        return $data;
	}
	
	function deleteVidio($id){
		$sukses = 0;
		
        $this->db->trans_begin();

        $this->db->query("DELETE FROM JAIM_000_VIDEO WHERE KDVIDEO = '$id'");
					 
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        }
        else {
            $sukses = $this->db->trans_commit();
        }

        return ($sukses ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
	}
	
	//sampe disini func model delete vidio doc image

	//function untuk edit image, dokumen, vidio
	function saveImage($data){
		$sukses = 0;
		
		$username = $this->session->USERNAME;
		
		
        $this->db->trans_begin();

        $this->db->query("UPDATE JAIM_000_POPIMAGE SET 
		judul = '".$data['judul']."', 
		deskripsi = '".$data['deskripsi']."', 
		tglawal = TO_DATE('".$data['tglawal']."','YYYY-MM-DD'),
		tglakhir = TO_DATE('".$data['tglakhir']."','YYYY-MM-DD'), 
		gambar = '".$data['gambar']."',
		tglrekam = sysdate,
		userrekam = '$username',
        status = '".$data['kategori']."'
		where IDPOPIMAGE = '".$data['idimage']."'");
					 
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        }
        else {
            $sukses = $this->db->trans_commit();
        }

        return ($sukses ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
	}
	
	function saveDataImage($data){
		$sukses = 0;
		
		$username = $this->session->USERNAME;
		
        $this->db->trans_begin();

        $this->db->query("UPDATE JAIM_000_POPIMAGE SET 
		judul = '".$data['judul']."', 
		deskripsi = '".$data['deskripsi']."', 
		tglawal = TO_DATE('".$data['tglawal']."','YYYY-MM-DD'),
		tglakhir = TO_DATE('".$data['tglakhir']."','YYYY-MM-DD'), 
		tglrekam = sysdate,
		userrekam = '$username',
        status = '".$data['kategori']."'
		where IDPOPIMAGE = '".$data['idimage']."'");
					 
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        }
        else {
            $sukses = $this->db->trans_commit();
        }

        return ($sukses ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
	}
	
	function saveVidio($data){
		$sukses = 0;
		
		$username = $this->session->USERNAME;
		
		
        $this->db->trans_begin();

        $this->db->query("UPDATE JAIM_000_VIDEO SET 
		judul = '".$data['judul']."', 
		deskripsi = '".$data['deskripsi']."', 
		nourut = '".$data['nourut']."',
		url = '".$data['vidio']."',
		kdstatus = '".$data['status']."',
		tglrekam = sysdate,
		userrekam = '$username',
        kategori = '".$data['kategori']."'
		where kdvideo = '".$data['idvidio']."'");
					 
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        }
        else {
            $sukses = $this->db->trans_commit();
        }

        return ($sukses ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
	}
	
	function saveDataVidio($data){
		$sukses = 0;
		
		$username = $this->session->USERNAME;
		
        $this->db->trans_begin();

        
        $this->db->query("UPDATE JAIM_000_VIDEO SET 
		judul = '".$data['judul']."', 
		deskripsi = '".$data['deskripsi']."', 
		nourut = '".$data['nourut']."',
		kdstatus = '".$data['status']."',
		tglrekam = sysdate,
		userrekam = '$username',
        kategori = '".$data['kategori']."'
		where kdvideo = '".$data['idvidio']."'");
					 
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        }
        else {
            $sukses = $this->db->trans_commit();
        }

        return ($sukses ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
	}
	
	function saveDokumen($data){
		$sukses = 0;
		
		$username = $this->session->USERNAME;
		
		
        $this->db->trans_begin();

        $this->db->query("UPDATE JAIM_000_EBOOK SET 
		NAMAEBOOK = '".$data['judul']."', 
		KETERANGAN = '".$data['deskripsi']."', 
		urutan = '".$data['nourut']."',
		ebook = '".$data['doc']."',
		status = '".$data['status']."',
		tglrekam = sysdate,
		userrekam = '$username',
        kategori = '".$data['kategori']."'
		where KDEBOOK = '".$data['iddoc']."'");
					 
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        }
        else {
            $sukses = $this->db->trans_commit();
        }

        return ($sukses ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
	}
	
	function saveDataDokumen($data){
		if(!$data['kategori'] == null){
			return C_STATUS_GAGAL_SIMPAN;
		}
		
		$sukses = 0;
		
		$username = $this->session->USERNAME;
		
        $this->db->trans_begin();

        
        $this->db->query("UPDATE JAIM_000_EBOOK SET 
		NAMAEBOOK = '".$data['judul']."', 
		KETERANGAN = '".$data['deskripsi']."', 
		urutan = '".$data['nourut']."',
		status = '".$data['status']."',
		tglrekam = sysdate,
		userrekam = '$username',
        kategori = '".$data['kategori']."'
		where KDEBOOK = '".$data['iddoc']."'");
					 
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        }
        else {
            $sukses = $this->db->trans_commit();
        }

        return ($sukses ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
	}

    /*====== daftar kategori menu =====*/
    function get_list_kategori_menu() {
        $data = array();

        $q = $this->db
            ->query("SELECT KDKATEGORI, NAMAKATEGORI
                     FROM JAIM_903_MENU_KATEGORI");

        if ($q->num_rows() > 0) {
            $data = $q->result_array();
        }

        $q->free_result();

        return $data;
    }


    /*===== data parent menu =====*/
    function get_list_parent_menu($filter) {
        $data = array();
        $idparent = empty($filter['ip']) ? "AND a.IDPARENT IS NULL" : "AND a.IDPARENT = '$filter[ip]'";

        $q = $this->db
            ->query("SELECT * FROM
        	(
        		SELECT tbl.*, rownum no
        		FROM
        		(
        		     SELECT a.KDMENU, a.MENU, a.URL, a.ICON, a.KDSTATUS, a.NOURUT, a.KETERANGAN, COUNT(b.KDMENU) JMLMENU
                     FROM JAIM_902_MENU a
                     LEFT OUTER JOIN JAIM_902_MENU b ON a.KDMENU = b.IDPARENT
                     WHERE a.KDKATEGORI LIKE '%$filter[kk]%' $idparent AND (
                         LOWER(a.KDMENU) LIKE '%$filter[s]%' OR LOWER(a.MENU) LIKE '%$filter[s]%' OR
                         LOWER(a.URL) LIKE '%$filter[s]%' OR LOWER(a.ICON) LIKE '%$filter[s]%'
                     )
                     GROUP BY a.KDMENU, a.MENU, a.URL, a.ICON, a.KDSTATUS, a.NOURUT, a.KETERANGAN
                     ORDER BY a.NOURUT
        		) tbl
        		WHERE rownum < ((".$filter['p']." * ".C_ROWS_PAGINATION.") + 1 )
        	)
        	WHERE no >= (((".$filter['p']."-1) * ".C_ROWS_PAGINATION.") + 1)");

        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }


    /*===== get total rows parent menu =====*/
    function get_total_parent_menu($filter) {
        $rows = 0;
        $idparent = empty($filter['ip']) ? "AND a.IDPARENT IS NULL" : "AND a.IDPARENT = '$filter[ip]'";

        $q = $this->db
            ->query("SELECT a.KDMENU, a.MENU, a.URL, a.ICON, a.KDSTATUS, a.NOURUT, a.KETERANGAN, COUNT(b.KDMENU) JMLMENU
                     FROM JAIM_902_MENU a
                     LEFT OUTER JOIN JAIM_902_MENU b ON a.KDMENU = b.IDPARENT
                     WHERE a.KDKATEGORI LIKE '%$filter[kk]%' $idparent AND (
                         LOWER(a.KDMENU) LIKE '%$filter[s]%' OR LOWER(a.MENU) LIKE '%$filter[s]%' OR
                         LOWER(a.URL) LIKE '%$filter[s]%' OR LOWER(a.ICON) LIKE '%$filter[s]%'
                     )
                     GROUP BY a.KDMENU, a.MENU, a.URL, a.ICON, a.KDSTATUS, a.NOURUT, a.KETERANGAN
                     ORDER BY a.NOURUT");;

        $rows = $q->num_rows();

        return $rows;
    }


    /*===== daftar menu =====*/
    /*function get_list_menu() {
        $data = array();

        $q = $this->db
            ->query("SELECT MENU, KDMENU, KETERANGAN
                     FROM JAIM_902_MENU
                     ORDER BY MENU");

        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }*/


    /*===== daftar role menu =====*/
    function get_list_role_menu($filter) {
        $data = array();
        $idparent = empty($filter['idparent']) ? " AND IDPARENT IS NULL" : " AND IDPARENT = '$filter[idparent]'";

        $q = $this->db
            ->query("SELECT a.KDMENU, MENU, a.KDKATEGORI
                     FROM JAIM_902_MENU a
                     INNER JOIN JAIM_904_ROLE_MENU b ON a.KDMENU = b.KDMENU
                     WHERE KDROLE = '$filter[kdrole]' $idparent
                         AND STATUS = 1 AND KDSTATUS = 1
                     ORDER BY a.NOURUT");

        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }


    /*===== get list all parent menu =====*/
    function get_list_all_parent_menu_by_id($kdrole) {
        $data = array();

        $q = $this->db
            ->query("SELECT COUNT(a.idparent) JMLMENU, b.MENU, b.KDKATEGORI, b.KDMENU
                     FROM JAIM_902_MENU a
                     INNER JOIN JAIM_902_MENU b ON a.IDPARENT = b.KDMENU
                     INNER JOIN JAIM_904_ROLE_MENU c ON b.KDMENU = c.KDMENU
                     WHERE KDROLE = '$kdrole'
                     GROUP BY b.MENU, b.KDKATEGORI, b.KDMENU
                     ORDER BY b.MENU");

        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }


    /*===== daftar menu by id =====*/
    function get_list_menu_by_id($kdkategori) {
        $data = array();

        $q = $this->db
            ->query("SELECT MENU, KDMENU, KETERANGAN
                     FROM JAIM_902_MENU
                     WHERE KDKATEGORI = '$kdkategori'
                     ORDER BY MENU");

        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }


    /*===== daftar role =====*/
    function get_list_role() {
        $data = array();

        $q = $this->db
            ->query("SELECT KDROLE, NAMAROLE, KDKATEGORI
                     FROM JAIM_901_ROLE
                     ORDER BY NOURUT");

        if ($q->num_rows() > 0)
            $data = $q->result_array();

        $q->free_result();

        return $data;
    }


    /*===== data menu by id =====*/
    function get_menu_by_id($kdmenu) {
        $data = array();

        $q = $this->db
            ->query("SELECT KDMENU, IDPARENT, KDKATEGORI, MENU, URL, ICON, KETERANGAN, KDSTATUS
                     FROM JAIM_902_MENU
                     WHERE KDMENU = '$kdmenu'");

        if ($q->num_rows() > 0) {
            $data = $q->row_array();
        }

        $q->free_result();

        return $data;
    }


    /*===== get last kd menu =====*/
    function get_last_kd_menu() {
        $lastno = null;

        $q = $this->db
            ->query("SELECT MAX(SUBSTR(KDMENU, 7, 4)) AS NO
                     FROM JAIM_902_MENU
                     WHERE SUBSTR(KDMENU, 3, 4) = TO_CHAR(SYSDATE, 'YYMM')");

        if ($q->num_rows() > 0) {
            $data = $q->row_array();
            $lastno = $data['NO'];
        }

        $q->free_result();

        return $lastno;
    }


    /*===== insert data menu =====*/
    function insert($data) {
        $sukses = 0;

        $this->db->trans_begin();

        $this->db
            ->query("INSERT INTO JAIM_902_MENU (KDMENU, IDPARENT, KDKATEGORI, KDSTATUS, MENU, URL, ICON,
                         KETERANGAN, TGLREKAM, USERREKAM)
                     VALUES ('$data[KDMENU]', '$data[IDPARENT]', '$data[KDKATEGORI]', '$data[KDSTATUS]', '$data[MENU]', '$data[URL]',
                         '$data[ICON]', '$data[KETERANGAN]', TO_DATE(TO_CHAR(SYSDATE, 'DD/MM/YYYY HH24:MI:SS'), 'DD/MM/YYYY HH24:MI:SS'), '".$this->session->USERNAME."')");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        }
        else {
            $sukses = $this->db->trans_commit();
        }

        return ($sukses ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
    }


    /*===== update data menu =====*/
    function update($data) {
        $sukses = 0;

        $this->db->trans_begin();

        $this->db
            ->query("UPDATE JAIM_902_MENU SET
                         IDPARENT = '$data[IDPARENT]',
                         KDKATEGORI = '$data[KDKATEGORI]',
                         KDSTATUS = '$data[KDSTATUS]',
                         MENU = '$data[MENU]',
                         URL = '$data[URL]',
                         ICON = '$data[ICON]',
                         KETERANGAN = '$data[KETERANGAN]',
                         TGLUBAH = TO_DATE(TO_CHAR(SYSDATE, 'DD/MM/YYYY HH24:MI:SS'), 'DD/MM/YYYY HH24:MI:SS'),
                         USERUBAH = '".$this->session->USERNAME."'
                     WHERE KDMENU = '$data[KDMENU]'");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        }
        else {
            $sukses = $this->db->trans_commit();
        }

        return ($sukses ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
    }


    /*===== update urutan menu =====*/
    function update_urutan($kd_menu, $data) {
        $status = 0;

        $status = $this->db->where("KDMENU", $kd_menu)
            ->update("JAIM_902_MENU", $data);

        return ($status ? C_STATUS_SUKSES_SIMPAN : C_STATUS_GAGAL_SIMPAN);
    }


    /*===== delete data menu =====*/
    function delete($kdmenu) {
        $sukses = 0;

        $this->db->trans_begin();

        $this->db
            ->query("DELETE FROM JAIM_902_MENU
                     WHERE KDMENU = '$kdmenu'");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        }
        else {
            $sukses = $this->db->trans_commit();
        }

        return ($sukses ? C_STATUS_SUKSES_HAPUS : C_STATUS_GAGAL_HAPUS);
    }
}