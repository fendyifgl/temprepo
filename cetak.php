<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak extends CI_Controller {
    
    function __construct() {
        parent::__construct();

        $this->load->model('modsimulasi');
    }
    
    function index() {
        $buildid = $this->input->get('bid');
		$buildid = $buildid ? $buildid : $this->input->get('buildid');
        $data = $this->modsimulasi->getHitung($buildid);
		$dataapi = @api_curl("/pos/agen/null/null/$buildid", 'GET')['message'];
        
        if ($data || $dataapi) {
            // Promapan new
            if($data['ID_PRODUK'] == 12) {
                redirect(base_url("jspromapannew_2019/cetakpdf?build_id=$buildid"));
            } 
			// Promapan (IFG Group)
			else if ($data['ID_PRODUK'] == '16') {
				redirect(base_url("jspromapannew_2019/cetakpdfifg?build_id=$buildid"));
			}
            // Promapan 2018
            else if ($data['ID_PRODUK'] == 1) {
                redirect(base_url("jspromapannew/cetakpdf?build_id=$buildid"));
            }
            // Smart Promapan
            else if ($data['ID_PRODUK'] == 13) {
                redirect(base_url("jssmartpromapan/cetakpdf?build_id=$buildid"));
            }
            /*/ Proidaman
            else if ($data['ID_PRODUK'] == 4) {
                redirect(base_url("jsproidaman_new/cetakpdf?build_id=$buildid"));
            }*/
            // Anuitas
            else if ($data['ID_PRODUK'] == 10) {
				redirect(base_url("jsanuitas_new/cetakpdf?build_id=$buildid"));
            }
			// Personal Accident
			else if (in_array($dataapi['KDPRODUK'], array('PAA', 'PAB'))) {
				redirect(base_url("personalaccident/cetak?buildid=$buildid"));
			}
			// Ultimate
			else if ($dataapi['KDPRODUK'] == 'JL4XN') {
				redirect(base_url("ultimate/cetak?buildid=$buildid"));
			}
            // Anuitas
            else if (in_array($dataapi['KDPRODUK'], array('APP65','APP75','APP85','APPSH'))) {
                redirect(base_url("annuitypremier/cetak?buildid=$buildid"));
            }
        } else {
            echo "Error not Found";
        }
    }
}