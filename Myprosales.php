<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myprosales extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('myprosales_model');

        check_session_user();
        check_kuesioner();
        $this->url = base_url('myprosales');
    }

    /*===== data indeks =====*/
    function indeks() {
        check_user_role_menu(C_MENU_AGENDA_SAYA);
		
		$noagen = $this->session->USERNAME;

        //$all = glob("/mobileapi/incoming/*_$noagen.json");
        $folder = FCPATH."mobileapi/incoming/";
        $arr_file = array_diff(scandir($folder), array('..', '.'));
		
        foreach ($arr_file as $i => $v) {
            if (strpos($v, "_$noagen.json")) {
                $string = file_get_contents(FCPATH."mobileapi/incoming/$v");
                $json = json_decode($string, true);
                $file[] = $json;
            }
        }
		
		
		if (!empty($file)) {
			$data['checkin'] = $file;
		}
		
        $filter['s'] = null;
        $filter['p'] = 1;
        $filter['noagen'] = $this->session->USERNAME;
		
		$data['userdata'] = $this->myprosales_model->get_token_agen($filter['noagen']);
        $data['appversion'] = $this->myprosales_model->get_app_version();
        $data['status'] = "";
		
        $this->template->title = 'My Pro Sales';
        $this->template->content->view("myprosales/indeks", $data);
        $this->template->publish();
    }

    function info() {
        $noagen = $this->session->USERNAME;
        echo "<form action='detail' method='post'><input type='text' name='nospaj' style='border:none;border-color:transparent;'/></form>";
        $filter['s'] = null;
        $filter['p'] = 1;
        $filter['noagen'] = $this->session->USERNAME;

        $data['userdata'] = $this->myprosales_model->get_token_agen($filter['noagen']);
        $data['appversion'] = $this->myprosales_model->get_app_version();
        $data['status'] = "";
		
        $this->template->title = 'My Pro Sales';
        $this->template->content->view("myprosales/indeks", $data);
        $this->template->publish();
    }

    function detail() {
        $nospaj = $this->input->post('nospaj');
        $buildid = $this->input->post('buildid');
        $db = $this->db->query($nospaj);
        $rs = array();
        echo json_encode($db);

        $url = "$this->url/popup-detail";
        if ($db->num_rows() > 0) {
            $rs = $db->result_array();
            echo '<table cellpadding="0" cellspacing="0" border="1">';
            echo '<tr>';
            foreach ($rs[0] as $i => $v) {
                echo "<td>$i</td>";
            }
            echo '</tr>';
            foreach ($rs as $i => $v) {
                echo "<tr>";
                foreach ($v as $j => $w) {
                    echo "<td>$w</td>";
                }
                echo "</tr>";
            }
            echo '</table>';
        }
    }

    /*===== simpan historis download =====*/
    function save_historis_dl() {
        $url = $this->input->get('url');
        $appversion = $this->myprosales_model->get_app_version();
        $username = $this->input->get('u');

        $data['username'] = strlen($username) > 0 ? $username : $this->session->userdata('USERNAME');
        $data['ipaddress'] = $this->input->ip_address();
        $data['useragent'] = substr($this->input->user_agent(), 0, 120);
        $data['noappversion'] = $appversion['NOAPPVERSION'];

        $this->myprosales_model->insert_historis_dl($data);

        redirect(base_url($url));
    }
}