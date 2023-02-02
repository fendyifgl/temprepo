<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pkajonline extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('prospek_model');
        $this->load->model('master_model');
        $this->load->model('Pkaj_model');

        check_session_user();
        check_kuesioner();
        $this->url = base_url('pkajonline');
    }


    /*===== daftar pkaj online =====*/
    function list_pkajonline() {
        check_user_role_menu(C_MENU_PROSPEK_SAYA); 

        $filter['s'] = strtolower(trim($this->input->get('s')));
        $filter['p'] = $this->input->get('per_page') ? $this->input->get('per_page') : 1;
        $filter['NOAGEN'] = $this->session->USERNAME;
        $data['pkaj'] = $this->Pkaj_model->get_list_pkajonline($filter);

        // print_r($filter['NOAGEN']);

        $this->load->library('pagination');
        $config['base_url'] = "$this->url/list-pkajonline";
        $config['total_rows'] = $this->Pkaj_model->get_total_pkajonline($filter['NOAGEN']);
        $this->pagination->initialize($config);

        $data['status'] = $this->session->flashdata('status');

        // print_r($data);

        $this->template->title = 'Pkajonline';
        $this->template->content->view("pkajonline/list_pkajonline", $data);
        $this->template->publish();
    }

	//untuk crf pkaj 2022
    /*===== term and condition pkaj online =====*/
    function term_pkajonline() {
        check_user_role_menu(C_MENU_PROSPEK_SAYA);

        $filter['NOAGEN']=$this->input->get('noagen');
        $filter['TGLPKAJAGEN']=$this->input->get('tglpkaj');
		$filter['STATUS'] = 0;

        $this->Pkaj_model->insert_history_sign('Document viewed', $this->input->get('name'), $this->input->get('noagen'), $this->input->get('nopkaj'), 'PDF', 'TESTING');
        $this->Pkaj_model->update_history_sign('Viewed', $this->input->get('nopkaj'));

        $datas = $this->Pkaj_model->data_pkajonline($filter);
        foreach($datas as $i => $d) { 
            $nopkaj = $d['NOPKAJAGEN'];
            $kdkantor = $d['KDKANTOR'];
            $noagenbm = $d['NOAGENBM'];
            $namabm = $d['NAMABM'];
            $noagen = $d['NOAGEN'];
            $jabatanbm = $d['JABATANBM'];
            $nipbm = $d['NIPBM'];
            $alamatktr = $d['ALAMATKTR'];
            $telponktr = $d['TELPONKTR'];
            $faxktr = $d['FAXKTR'];  
            $noidagen = $d['NOMORIDAGEN'];
            $alamatagen = $d['ALAMATAGEN'];
            $notelponagen = $d['NOTELPONAGEN'];
            $namaklien = $d['NAMAKLIEN1'];
            $tgl = $d['TGL'];
            $bln = $d['BLN'];
            $thn = $d['THN'];
            $tmptlhr = $d['TEMPATLAHIR'];
            $tgllhr = $d['TGLLAHIR'];    
            $jnskel = $d['JENISKELAMIN'];
            $tglpkaj = $d['TGLPKAJAGEN'];  
            $status = $d['STATUS'];       
        }

        $bulan = array(
            '1'=>'Januari',
            '2'=>'Februari',
            '3'=>'Maret',
            '4'=>'April',
            '5'=>'Mei',
            '6'=>'Juni',
            '7'=>'Juli',
            '8'=>'Agustus',
            '9'=>'September',
            '10'=>'Oktober',
            '11'=>'November',
            '12'=>'Desember'
        );

        $hari = array(
            'Monday'=>'Senin',
            'Tuesday'=>'Selasa',
            'Wednesday'=>'Rabu',
            'Thursday'=>'Kamis',
            'Friday'=>'Jumat',
            'Saturday'=>'Sabtu',
            'Sunday'=>'Minggu'
        );

        $x = mktime(0, 0, 0, $bln, $tgl, $thn);

        $data['TANGGAL'] = date("d", $x);
        $data['BULAN'] = $bulan[date("n", $x)];
        $data['TAHUN'] = date("Y", $x);
        $data['HARI'] = $hari[date("l", $x)];
        

        $filter['s'] = strtolower(trim($this->input->get('s')));
        $filter['p'] = $this->input->get('per_page') ? $this->input->get('per_page') : 1;
        $filter['noagen'] = $this->session->USERNAME;
		$filter['STATUS'] = 0;
        $data['pkaj'] = $this->Pkaj_model->data_pkajonline($filter);

        $this->load->library('pagination');
        $config['base_url'] = "$this->url/preview_pkajonline";
        $config['total_rows'] = $this->Pkaj_model->get_total_pkajonline($filter['noagen']);
        $this->pagination->initialize($config);

        $data['status'] = $this->session->flashdata('status');


        $this->load->model('master_model');

        $data['noagen'] = $this->input->get('noagen');
        $data['nopkaj'] = $this->input->get('nopkaj');
        $data['urlback'] = "pkajonline";

		$datas = $this->Pkaj_model->cek_pkajonline($data['noagen'], $data['nopkaj']);

        $kodeJabatanAgen=array('32','33','34','35','36','37','38'); 

        foreach($datas as $i => $v) {
			
			if ($v['USERREKAM'] == 'MIGRASI' OR $v['KDJABATANAGEN'] == '26') {
				$filepkaj = "term_pkajonline_migrasi";		
			} else if ($v['KDJABATANAGEN'] == '29') {
				$filepkaj = "term_pkajonline_lpa";
			} else if ($v['KDJABATANAGEN'] == '31') {
                $filepkaj = "term_pkajonline_ws";
            } else if (in_array($v['KDJABATANAGEN'], $kodeJabatanAgen)) {
                $filepkaj = "term_pkajonline_bas";
            } else{
				$filepkaj = "term_pkajonline_umum";
			}
			//$filepkaj = "term_pkajonline_lpa";
        }
		
        $this->template->title = "Cetak PKAJ Agen $filter[NOAGEN]";
		$this->template->content->view("pkajonline/$filepkaj", $data);
		$this->template->publish();
    }

	//untuk crf pkaj 2022
    /*===== cetak pkaj online =====*/
    function cetak_pkajonline() {
        check_user_role_menu(C_MENU_PROSPEK_SAYA);

        $filter['NOAGEN']=$this->input->get('noagen');
        $filter['TGLPKAJAGEN']=$this->input->get('tglpkaj');
		$filter['STATUS'] = 1;
        $datas = $this->Pkaj_model->data_pkajonline($filter);
        foreach($datas as $i => $d) { 
            $nopkaj = $d['NOPKAJAGEN'];
            $kdkantor = $d['KDKANTOR'];
            $noagenbm = $d['NOAGENBM'];
            $namabm = $d['NAMABM'];
            $noagen = $d['NOAGEN'];
            $jabatanbm = $d['JABATANBM'];
            $nipbm = $d['NIPBM'];
            $alamatktr = $d['ALAMATKTR'];
            $telponktr = $d['TELPONKTR'];
            $faxktr = $d['FAXKTR'];  
            $noidagen = $d['NOMORIDAGEN'];
            $alamatagen = $d['ALAMATAGEN'];
            $notelponagen = $d['NOTELPONAGEN'];
            $namaklien = $d['NAMAKLIEN1'];
            $tgl = $d['TGL'];
            $bln = $d['BLN'];
            $thn = $d['THN'];
            $tmptlhr = $d['TEMPATLAHIR'];
            $tgllhr = $d['TGLLAHIR'];    
            $jnskel = $d['JENISKELAMIN'];
            $tglpkaj = $d['TGLPKAJAGEN'];        
        }

        $bulan = array(
            '1'=>'Januari',
            '2'=>'Februari',
            '3'=>'Maret',
            '4'=>'April',
            '5'=>'Mei',
            '6'=>'Juni',
            '7'=>'Juli',
            '8'=>'Agustus',
            '9'=>'September',
            '10'=>'Oktober',
            '11'=>'November',
            '12'=>'Desember'
        );

        $hari = array(
            'Monday'=>'Senin',
            'Tuesday'=>'Selasa',
            'Wednesday'=>'Rabu',
            'Thursday'=>'Kamis',
            'Friday'=>'Jumat',
            'Saturday'=>'Sabtu',
            'Sunday'=>'Minggu'
        );

        $x = mktime(0, 0, 0, $bln, $tgl, $thn);

        $data['TANGGAL'] = date("d", $x);
        $data['BULAN'] = $bulan[date("n", $x)];
        $data['TAHUN'] = date("Y", $x);
        $data['HARI'] = $hari[date("l", $x)];


        $filter['s'] = strtolower(trim($this->input->get('s')));
        $filter['p'] = $this->input->get('per_page') ? $this->input->get('per_page') : 1;

        $filter['noagen']=$this->input->get('noagen');
        $filter['nopkaj']=$this->input->get('nopkaj');
        $filter['tglpkaj']=$this->input->get('tglpkaj');
          
        $data['pkaj'] = $this->Pkaj_model->pkajonline($filter);
			//var_dump($data['pkaj']);die;
        $this->load->library('pagination');
        $config['base_url'] = "$this->url/";
        $config['total_rows'] = $this->Pkaj_model->get_total_pkajonline($filter['noagen']);
        $this->pagination->initialize($config);

        $data['status'] = $this->session->flashdata('status');

        $datas = $this->Pkaj_model->cek_pkajonline($filter['noagen'], $filter['nopkaj']);

        $kodeJabatanAgen=array('32','33','34','35','36','37','38'); 
		
        foreach($datas as $i => $v) {
			if ($v['PERIODE'] == '1' ) {
				if ($v['USERREKAM'] == 'MIGRASI' OR $v['KDJABATANAGEN'] == '26') {
					
					$filepkaj = "cetak_epkaj_migrasi";	
					
				} else if ($v['KDJABATANAGEN'] == '29') {
					
					$filepkaj = "cetak_epkaj_lpa";
				} else if ($v['KDJABATANAGEN'] == '31') {
                    $filepkaj = "cetak_epkaj_ws2023";
                } else if (in_array($v['KDJABATANAGEN'], $kodeJabatanAgen)) {
                    $filepkaj = "cetak_epkaj_bas2023";
                } else {
					$filepkaj = "cetak_epkaj";
				}
			} else {
				if ($v['TGLSUBMIT'] == '1') {
					if ($v['USERREKAM'] == 'MIGRASI' OR $v['KDJABATANAGEN'] == '26') {
						$filepkaj = "cetak_epkaj_migrasi";
					} else if ($v['KDJABATANAGEN'] == '29') {
						$filepkaj = "cetak_epkaj_lpa";		
					} else if ($v['KDJABATANAGEN'] == '31') {
                        $filepkaj = "cetak_epkaj_ws2023";
                    } else if (in_array($v['KDJABATANAGEN'], $kodeJabatanAgen)) {
                        $filepkaj = "cetak_epkaj_bas2023";
                    } else { 	
						$filepkaj = "cetak_epkaj";
					}
				} else {
					if ($v['USERREKAM'] == 'MIGRASI' OR $v['KDJABATANAGEN'] == '26') {	
						$filepkaj = "cetak_epkaj_migrasi_2021";		
					} else if ($v['KDJABATANAGEN'] == '29') {	
						$filepkaj = "cetak_epkaj_lpa";		
					} else if ($v['KDJABATANAGEN'] == '31') {
                        $filepkaj = "cetak_epkaj_ws2023";
                    } else if (in_array($v['KDJABATANAGEN'], $kodeJabatanAgen)) {
                        $filepkaj = "cetak_epkaj_bas2023";
                    } else {		
						$filepkaj = "cetak_epkaj_2021";
					}
				}
			}
			
			/*if ($v['USERREKAM'] == 'MIGRASI' OR $v['KDJABATANAGEN'] == '26') {
					
					$filepkaj = "cetak_epkaj_migrasi";	
					
				} else if ($v['KDJABATANAGEN'] == '29') {
					
					$filepkaj = "cetak_epkaj_lpa";
					
				} else {
					$filepkaj = "cetak_epkaj";
				}*/
			
		}
		
		$this->template->title = "Cetak PKAJ Agen $filter[noagen]";
		$this->template->content->view("pkajonline/$filepkaj", $data);
		$this->template->publish();
    }


    /*===== cek otp pkaj online =====*/
    function otp_pkajonline() {        
        //include 'RundomString.php';

        check_user_role_menu(C_MENU_PROSPEK_SAYA);

        $filter['s'] = strtolower(trim($this->input->get('s')));
        $filter['p'] = $this->input->get('per_page') ? $this->input->get('per_page') : 1;
        $noagen = $this->input->get('noagen');

        $filter['NOAGEN'] = $this->input->get('noagen');
        $filter['NMAGEN'] = $this->input->get('nmagen');
        $filter['NOPKAJ'] = $this->input->get('nopkaj'); 
        $filter['TGLPKAJAGEN'] = $this->input->get('tglpkaj');   
		$filter['STATUS'] = 0;     
        $result = $this->Pkaj_model->dataotp_pkajonline($filter);

            if($result>0){
                foreach ($result as $key => $value) {
					$notlp      = $value['NOTELPONAGEN'];
					$kantor     = $value['KDKANTOR'];
					$nopkaj     = $value['NOPKAJAGEN'];
					
					// Ambil data OTP
					$getotp = $this->Pkaj_model->get_sendOtp($notlp, $kantor, $nopkaj);
					
					if (!$getotp || @$getotp->ISEXPIRED) {
						// kirim OTP
						//$new_otp    = RandomString(4);
						$rand		= rand(900009,999999);
						$new_otp 	= $this->addspaces((string)$rand);
						$nmagen     = $filter['NMAGEN'];
						
						$message = "Konfirmasi untuk EPKAJ Anda adalah $new_otp Mohon Jaga kerahasiaannya.";

						if ($this->Pkaj_model->sendOtp($kantor, $nopkaj, $notlp, $message, $rand, $nmagen)) {
							$curl = curl_init();
							curl_setopt_array($curl, array(
								CURLOPT_RETURNTRANSFER => 1,
								CURLOPT_URL => C_URL_API_OTP."/send.otp.php?msisdn=".rawurlencode($notlp)."&message=".urlencode($message),
								CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36'
							));
							$resp = curl_exec($curl);
							curl_close($curl);
						}
					}
					
                    //redirect ke halaman step 2
                    if($nopkaj){
                        $data['otp'] = $this->Pkaj_model->get_sendOtp($notlp, $kantor, $nopkaj);
                        $data['pkaj'] = $this->Pkaj_model->data_pkajonline($filter);
                        $data['keterangan'] = "KODE OTP SUDAH DIKIRIM KE NO HP ANDA " . $notlp;
                        $this->Pkaj_model->insert_history_sign('Otp', $this->input->get('name'), $this->input->get('noagen'), $this->input->get('nopkaj'), 'PDF', 'TESTING');
                        $this->Pkaj_model->update_history_sign('Otp', $this->input->get('nopkaj'));
                    }              
                }

                // print_r( $data['otp']);
            }else{
            
            echo "gagal";
        }

        $this->load->library('pagination');
        $config['base_url'] = "$this->url/otp_pkajonline";
        $config['total_rows'] = $this->Pkaj_model->get_total_pkajonline($noagen);
        $this->pagination->initialize($config);

        $data['status'] = $this->session->flashdata('status');
 
        $this->template->title = 'Verifikasi OTP';
        $this->template->content->view("pkajonline/cek_otp", $data);
        $this->template->publish();
    }


    /*===== insert pkaj online =====*/
    function insert_pkajonline() {
        check_user_role_menu(C_MENU_PROSPEK_SAYA);

        $filter['s'] = strtolower(trim($this->input->get('s')));
        $filter['p'] = $this->input->get('per_page') ? $this->input->get('per_page') : 1;
        $filter['noagen'] = $this->session->USERNAME;

        $cdata['NOAGEN']            = isset($_POST['noagen']) ? trim($this->input->post('noagen', true)) : null;  
        $cdata['NOPKAJAGEN']        = isset($_POST['nopkaj']) ? trim($this->input->post('nopkaj', true)) : null; 
        $cdata['TGLPKAJAGEN']       = isset($_POST['tglpkaj']) ? trim($this->input->post('tglpkaj', true)) : null; 
        $cdata['KDKANTOR']          = isset($_POST['kdkantor']) ? trim($this->input->post('kdkantor', true)) : null; 
        $cdata['NOTELPONAGEN']      = isset($_POST['notlp']) ? trim($this->input->post('notlp', true)) : null; 
        $cdata['SMS_OTP']           = isset($_POST['sms_otp']) ? trim($this->input->post('sms_otp', true)) : null;
		$cdata['STATUS'] 			= 0;

        $data = $this->Pkaj_model->get_sendOtp($cdata['NOTELPONAGEN'], $cdata['KDKANTOR'], $cdata['NOPKAJAGEN']);
        
        $data = $this->Pkaj_model->data_pkajonline($cdata);

        $now = date('d-m-Y H:i:s');

        foreach($data as $i => $d) { 
            $nopkaj = $d['NOPKAJAGEN'];
            $kdkantor = $d['KDKANTOR'];
            $noagenbm = $d['NOAGENBM'];
            $namabm = $d['NAMABM'];
            $noagen = $d['NOAGEN'];
            $jabatanbm = $d['JABATANBM'];
            $nipbm = $d['NIPBM'];
            $alamatktr = $d['ALAMATKTR'];
            $telponktr = $d['TELPONKTR'];
            $faxktr = $d['FAXKTR'];  
            $noidagen = $d['NOMORIDAGEN'];
            $alamatagen = $d['ALAMATAGEN'];
            $notelponagen = $d['NOTELPONAGEN'];
            $namaklien = $d['NAMAKLIEN1'];
            $tgl = $d['TGL'];
            $bln = $d['BLN'];
            $thn = $d['THN'];
            $tmptlhr = $d['TEMPATLAHIR'];
            $tgllhr = $d['TGLLAHIR'];    
            $jnskel = $d['JENISKELAMIN'];
            $tglpkaj = $d['TGLPKAJAGEN'];
            
            $this->Pkaj_model->insert_history_sign('Document signed', $namaklien, $d['NOAGEN'], $nopkaj, 'PDF', 'TESTING');
            $this->Pkaj_model->insert_history_sign('Document signed', $namabm, $d['NOAGEN'], $nopkaj, 'PDF', 'TESTING');
            $this->Pkaj_model->update_history_sign('Signed', $nopkaj);
        }

        /*$this->load->library('ciqrcode'); //pemanggilan library QR CODE

        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = ''; //string, the default is application/cache/
        $config['errorlog']     = ''; //string, the default is application/logs/
        $config['imagedir']     = '/asset/images_qrcode/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        $image_qragen='EPKAJ-'.$nopkaj.'_'.$noagen.'.png'; //buat name dari qr code sesuai dengan nim

        $qragen['data'] = 'EPKAJ-'.$nopkaj.' / '.$noagen.' / '.$namaklien.' / '.$now; //data yang akan di jadikan QR CODE
        $qragen['level'] = 'H'; //H=High
        $qragen['size'] = 3;
        $qragen['savename'] = FCPATH.$config['imagedir'].$image_qragen; //simpan image QR CODE ke folder assets/images_qrcode/
        $this->ciqrcode->generate($qragen); // fungsi untuk generate QR CODE

        $image_noagenbm='EPKAJ-'.$nopkaj.'_'.$noagenbm.'.png'; //buat name dari qr code sesuai dengan nim

        $qrkancab['data'] = 'EPKAJ-'.$nopkaj.' / '.$noagenbm.' / '.$namabm.' / '.$now; //data yang akan di jadikan QR CODE
        $qrkancab['level'] = 'H'; //H=High
        $qrkancab['size'] = 3; 
        $qrkancab['savename'] = FCPATH.$config['imagedir'].$image_noagenbm; //simpan image QR CODE ke folder assets/images_qrcode/
        $this->ciqrcode->generate($qrkancab); // fungsi untuk generate QR CODE*/
        
        $qragen = 'EPKAJ-'.$nopkaj.' / '.$noagen.' / '.$namaklien.' / '.$now;
        //$qrperusahaan = 'EPKAJ-'.$nopkaj.' / '.($noagenbm ? $noagenbm : '0000000000').' / '.$namabm.' / '.$now;
        $qrperusahaan = 'EPKAJ-'.$nopkaj.' / '.($nipbm).' / '.$namabm.' / '.$now;

        //$result = $this->Pkaj_model->insert_pkajonline($nopkaj,$kdkantor,$noagenbm,$namabm,$noagen,$jabatanbm,$nipbm,$alamatktr,$telponktr,$faxktr,$noidagen,$alamatagen,$notelponagen,$namaklien,$tgl,$bln,$thn,$tmptlhr,$tgllhr,$jnskel,$tglpkaj,$image_qragen,$image_noagenbm); //simpan ke database
        $result = $this->Pkaj_model->update_pkajonline($kdkantor, $noagen, $tglpkaj, $qragen, $qrperusahaan);

        $this->Pkaj_model->insert_history_sign('Agreement completed', $namaklien, $d['NOAGEN'], $nopkaj, 'PDF', 'TESTING');

        json_encode($result); 
    }

	private function addspaces( $str ) {
		$temp = array();
		for ( $i = 0; $i < strlen( $str ); $i++ ) {
			$temp[$i] = $str[$i].' ';
		}
		$temp = implode( '', $temp );
		$temp = str_replace( ' ', ' ', $temp );
		return $temp;
	}
}