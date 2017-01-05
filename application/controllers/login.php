<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: jian.song
 * Date: 15-4-16
 * Time: 下午3:45
 */
class Login extends CI_Controller{
    public function __construct() {
        parent::__construct ();
        $this->load->helper (array('form','url'));
        $this->load->library('session');
    }
    public function index() {
        $redirect = isset($_GET['redirect'])?$_GET['redirect']:'admin/index';
        $arr['redirect'] = $redirect;
        $this->load->view ('admin/login',$arr);
    }
    public function formsubmit() {
        header("Content-type:text/html;charset=utf-8");
        $this->load->model(array('MAdmin','MClient'),'',TRUE);
        $this->load->library ( 'form_validation' );
        $redirect = isset($_GET['redirect'])?$_GET['redirect']:'admin/index';
        $this->form_validation->set_rules ( 'username', '用户名', 'required' , array('required' => '用户名不能为空'));
        $this->form_validation->set_rules ( 'password', '密码', 'required',array('required' => '密码不能为空'));
        $this->form_validation->set_message("required", "请输入%s");
        if ($this->form_validation->run () == FALSE) {
            $this->load->view ('admin/login');
        } else {
            if (isset ( $_POST ['submit'] ) && ! empty ( $_POST ['submit'] )) {
                $data = array (
                    'user' => $_POST ['username'],
                    'pass' => md5($_POST ['password']),
                    'type' => $_POST['user_type'],
                );
                $newdata = array(
                    'username'  =>  $data ['user'] ,
                    'userip'     => $_SERVER['REMOTE_ADDR'],
                    'luptime'   =>time()
                );
                if($data['type'] == 1 ){
                    $query = $this->MAdmin->getAdminByUsername($data ['user']);
                }else{
                    $query = $this->MClient->getClientByUsername($data ['user']);
                }
                if(!$query){
                    echo "<script>alert('用户不存在!');</script>";
                    $arr['redirect'] = $redirect;
                    $this->load->view('admin/login',$arr);

                }else{
                    foreach ( $query as $row ) {
                        $pass = $row['password'];
                    }
                    if ($pass == $data ['pass']) {
                        $this->session->set_userdata($newdata);
                        $route = explode('/',$redirect);
                        if(!empty($route[0]) && !empty($route[1])){
                            redirect('c='.$route[0].'&m='.$route[1]);
                        }else{
                            redirect('c=admin&m=index');
                        }
                    }else{
                        echo "<script>alert('密码错误!');</script>";
                        $arr['redirect'] = $redirect;
                        $this->load->view('admin/login',$arr);
                    }
                }
            }
        }
    }
}