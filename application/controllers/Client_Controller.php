<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: jian.song
 * Date: 15-4-16
 * Time: 下午9:57
 */
class Client_Controller extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        if ((!$this ->session->userdata('username')
            &&($this->router->fetch_class() != 'login'
            || $this->router->fetch_method() != 'index'))
            ||$this ->session->userdata('type') !== '0'
        ){
            $c = $this->router->fetch_class();
            $m = $this->router->fetch_method();
            $redirect = $c.'/'.$m;
            redirect('c=login&m=index&redirect='.$redirect);
        }
    }
}