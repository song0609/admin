<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: jian.song
 * Date: 15-4-16
 * Time: 下午9:57
 */
class Admin_Controller extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        if (!$this ->session->userdata('username')
            &&($this->router->fetch_class() != 'login'
            || $this->router->fetch_method() != 'index')
        ){
            $redirect = $this->uri->uri_string();
            if ( $_SERVER['QUERY_STRING']){
                $redirect .= '?' . $_SERVER['QUERY_STRING'];
            }
            redirect('login/index?redirect='.$redirect);
        }
    }
}