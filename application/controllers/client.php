<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: jian.song
 * Date: 15-4-16
 * Time: 下午4:34
 */
require('Client_Controller.php');
class Client extends Client_Controller {
    public function index(){
        $arr['username'] = $this ->session->userdata('username');
        $this->load->view('client/index',$arr);
    }

    public function logout(){
        $this->session->unset_userdata('username');
        redirect('c=login&m=index');
    }

    public function test(){
        echo "1111";exit;
    }
}