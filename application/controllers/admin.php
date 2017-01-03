<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: jian.song
 * Date: 15-4-16
 * Time: 下午4:34
 */
require('Admin_Controller.php');
class Admin extends Admin_Controller {
    public function index(){
        $arr['username'] = $this ->session->userdata('username');
        $this->load->view('admin/index',$arr);
    }

    public function welcome(){
        $arr['username'] = $this ->session->userdata('username');
        $this->load->view('admin/welcome',$arr);
    }

    public function parttime(){
        $this->load->helper('page');
        $this->load->model('MParttime','',TRUE);
        $page = $this->uri->segment(4);
        $page = !empty($page)?$page:1;
        $total = $this->MParttime->getTotalCount();
        $pagesize = 10;
        $offset = $pagesize*($page-1);
        $data = $this->MParttime->getPageRecord($offset,$pagesize);
        $arr['data'] = $data;
        $arr['pagination'] = pagination(site_url('admin/parttime/page'),$pagesize,$total,4);
        $arr['total'] = $total;
        $this->load->view('admin/parttime_list',$arr);
    }

    public function delparttime(){
        $id = $this->uri->segment(3);
        $this->load->model('MParttime','',TRUE);
        $this->MParttime->delRecordById($id);
        redirect('c=admin&m=parttime');
    }

    public function displayparttime(){
        $id = $this->input->get('id');
        $state = $this->input->get('state');
        if($state==='false'){
            $is_display = 0;
        }else $is_display = 1;
        $this->load->model('MParttime','',TRUE);
        $this->MParttime->updateDisplayState($id,$is_display);
        log_message('info','change status');
    }

    public function comments(){
        $this->load->helper('page');
        $this->load->model('MComments','',TRUE);
        $id = $this->uri->segment(4);
        $page = $this->uri->segment(6);
        $page = !empty($page)?$page:1;
        $total = $this->MComments->getTotalCommentsByParttimeId($id);
        $pagesize = 20;
        $offset = $pagesize*($page-1);
        $data = $this->MComments->getPageRecord($id,$offset,$pagesize);
        $arr['data'] = $data;
        $arr['pagination'] = pagination(site_url("admin/comments/id/$id/page"),$pagesize,$total,6);
        $arr['total'] = $total;
        $this->load->view('admin/comments_list',$arr);
    }

    public function delcomments(){
        $id = $_GET['id'];
        $this->load->model('MComments','',TRUE);
        $this->MComments->delRecordById($id);
    }

    public function lost(){
        $this->load->helper('page');
        $this->load->model('MFoundlostmessage','',TRUE);
        $page = $this->uri->segment(4);
        $page = !empty($page)?$page:1;
        $total = $this->MFoundlostmessage->getTotalCount(0);
        $pagesize = 20;
        $offset = $pagesize*($page-1);
        $data = $this->MFoundlostmessage->getFoundOrLostMessage(0,$offset,$pagesize);
        $arr['data'] = $data;
        $arr['pagination'] = pagination(site_url("admin/lost/page"),$pagesize,$total,4);
        $arr['total'] = $total;
        $this->load->view('admin/lost_list',$arr);
    }

    public function found(){
        $this->load->helper('page');
        $this->load->model('MFoundlostmessage','',TRUE);
        $page = $this->uri->segment(4);
        $page = !empty($page)?$page:1;
        $total = $this->MFoundlostmessage->getTotalCount(1);
        $pagesize = 20;
        $offset = $pagesize*($page-1);
        $data = $this->MFoundlostmessage->getFoundOrLostMessage(1,$offset,$pagesize);
        $arr['data'] = $data;
        $arr['pagination'] = pagination(site_url("admin/found/page"),$pagesize,$total,4);
        $arr['total'] = $total;
        $this->load->view('admin/lost_list',$arr);
    }

    public function delfoundlost(){
        $id = $_GET['id'];
        $this->load->model('MFoundlostmessage','',TRUE);
        $this->MFoundlostmessage->delRecordById($id);
    }

    public function displayfoundlost(){
        $id = $_GET['id'];
        $state = $_GET['state'];
        if($state==='false'){
            $is_display = 0;
        }else $is_display = 1;
        $this->load->model('MFoundlostmessage','',TRUE);
        $this->MFoundlostmessage->updateDisplayState($id,$is_display);
    }

    public function foundlosttype(){
        $this->load->model('MFoundlosttype','',TRUE);
        $data = $this->MFoundlosttype->getAllType();
        $arr['total'] = $this->MFoundlosttype->getTotalCount();
        $arr['data'] = $data;
        $this->load->view('admin/type_list',$arr);
    }

    public function deltype(){
        $id = $_GET['id'];
        $this->load->model('MFoundlosttype','',TRUE);
        $this->MFoundlosttype->delType($id);
    }

    public function istypeuse(){
        $id = $_GET['id'];
        $this->load->model('MFoundlostmessage','',TRUE);
        $num = $this->MFoundlostmessage->isTypeExists($id);
        echo $num;
    }

    public function addtype(){
        $this->load->model('MFoundlosttype','',TRUE);
        $type_name = $this->security->xss_clean($this->input->post('type_name'));
        if(!empty($type_name)){
            $this->MFoundlosttype->addType($type_name);
        }
        redirect('c=admin&m=foundlosttype');
    }

    public function logout(){
        $this->session->unset_userdata('username');
        redirect('c=login&m=index');
    }

    public function addadmin(){
        $this->load->view('c=admin&m=admin_form');
    }

    public function isexitsname(){
        $username = $_GET['username'];
        $this->load->model('MAdmin','',TRUE);
        $bool = $this->MAdmin->isExistsUsername($username);
        if($bool){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function saveadmin(){
        $this->load->model('MAdmin','',TRUE);
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));
        $data = array(
            'username'=>$username,
            'password'=>md5($password),
        );
        $this->MAdmin->saveAdmin($data);
        redirect('c=admin&m=addadmin');
    }

    public function password(){
        $this->load->view('admin/password_form');
    }

    public function updatepassword(){
        $username = $this ->session->userdata('username');
        $password = $this->security->xss_clean($this->input->post('password'));
        $data = array(
            'username'=>$username,
            'password'=>md5($password),
        );
        $this->load->model('MAdmin','',TRUE);
        $this->MAdmin->updatePassword($data);
        redirect('c=admin&m=password');
    }

    public function isoldpassword(){
        $username = $this ->session->userdata('username');
        $password = $this->security->xss_clean($this->input->post('password'));
        $this->load->model('MAdmin','',TRUE);
        $result = $this->MAdmin->getAdminByUsername($username);
        if(md5($password)==$result[0]['password']){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function test(){
        $this->load->helper('captcha');
        $vals = array(
            'word' => rand(1000, 10000),
            'img_path' => './captcha/',
            'img_url' => 'http://localhost/admin/captcha/',
            //'font_path' => './path/to/fonts/texb.ttf',
            'img_width' => '150',
            'img_height' => 30,
            'expiration' => 7200
        );
        $cap = create_captcha($vals);
        echo $cap['image'];
    }
}