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

    public function logout(){
        $this->session->unset_userdata('username');
        redirect('c=login&m=admin_index');
    }

    public function addadmin(){
        $data['form'] = array();
        $this->load->view('admin/admin_form',$data);
    }

    public function saveadmin(){
        $this->load->model('MAdmin','',TRUE);
        $vo = array();
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));
        $bool = $this->MAdmin->isExistsUsername($username);
        if($bool){
            $errors['username'] = "该用户名已注册";
            $form['username'] = $username;
            $form['password'] = $password;
            $this->load->view ('admin/admin_form', array('errors'=>$errors,'form'=>$form));
            return;
        }
        $data = array(
            'username'=>$username,
            'password'=>md5($password),
        );
        $this->MAdmin->saveAdmin($data);
        $vo['tips'] = "保存成功";
        $this->load->view ('admin/admin_form', $vo);
    }

    public function password(){
        $vo = array();
        $this->load->view('admin/password_form',$vo);
    }

    public function updatepassword(){
        $vo = array();
        $username = $this ->session->userdata('username');
        $password = $this->security->xss_clean($this->input->post('password'));
        $this->load->model('MAdmin','',TRUE);
        $result = $this->MAdmin->getAdminByUsername($username);
        if(md5($password)!=$result[0]['password']){
            $vo['errors'] = "原密码错误";
            $this->load->view('admin/password_form',$vo);
            return;
        }
        $data = array(
            'username'=>$username,
            'password'=>md5($password),
        );
        $this->MAdmin->updatePassword($data);
        $vo['tips'] = "保存成功";
        $this->load->view ('admin/password_form', $vo);
    }

    public function test(){
        echo "test";exit;
    }

    public function getAdvertiserList(){
        $this->load->helper('page');
        $this->load->model('MClient','',TRUE);
        $page = $this->input->get('per_page');
        $page = !empty($page)?$page:1;
        $total = $this->MClient->getTotalCount(1);
        $pagesize = 10;
        $offset = $pagesize*($page-1);
        $data = $this->MClient->getAdvertiserList($offset,$pagesize);
        $arr['data'] = $data;
        $arr['pagination'] = pagination(site_url("c=admin&m=getAdvertiserList"),$pagesize,$total);
        $arr['total'] = $total;
        $this->load->view('admin/adver_list',$arr);
    }

    public function statusAdvertiser(){
        $id = $this->input->get('id');
        $status = $this->input->get('status');
        if($status==='false'){
            $status = 0;
        }else $status = 1;
        $this->load->model('mclient','',TRUE);
        $this->mclient->updateStatus($id,$status);
    }

    public function addAdvertiser(){
        $data['form'] = array();
        $this->load->view('admin/adver_form',$data);
    }

    public function saveAdvertiser(){
        $this->load->model('MClient','',TRUE);
        $vo = array();
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));
        $advertiser = $this->security->xss_clean($this->input->post('advertiser'));
        $linkman = $this->security->xss_clean($this->input->post('linkman'));
        $phone = $this->security->xss_clean($this->input->post('phone'));
        $email = $this->security->xss_clean($this->input->post('email'));
        $bool = $this->MClient->isExistsUsername($username);
        $form = array(
            'username'=>$username,
            'password'=>$password,
            'advertiser'=>$advertiser,
            'linkman'=>$linkman,
            'phone'=>$phone,
            'email'=>$email,
        );
        if($bool){
            $errors['username'] = "该广告主用户名已存在";
            $this->load->view ('admin/adver_form', array('errors'=>$errors,'form'=>$form));
            return;
        }
        if(empty($username)||empty($password)){
            $errors['username'] = "账号密码为必填";
            $this->load->view ('admin/adver_form', array('errors'=>$errors,'form'=>$form));
            return;
        }
        $data = array(
            'username'=>$username,
            'password'=>md5($password),
            'advertiser'=>$advertiser,
            'linkman'=>$linkman,
            'phone'=>$phone,
            'email'=>$email,
        );
        $this->MClient->saveClient($data);
        $vo['tips'] = "保存成功";
        $this->load->view ('admin/adver_form', $vo);
    }

    public function getAdvertismentList(){
        $this->load->helper('page');
        $this->load->model('MAdvertisment','',TRUE);
        $page = $this->input->get('per_page');
        $page = !empty($page)?$page:1;
        $total = $this->MAdvertisment->getTotalCount(1);
        $pagesize = 10;
        $offset = $pagesize*($page-1);
        $data = $this->MAdvertisment->getAdvertismentList($offset,$pagesize);
        $arr['data'] = $data;
        $arr['pagination'] = pagination(site_url("c=admin&m=getAdvertismentList"),$pagesize,$total);
        $arr['total'] = $total;
        $this->load->view('admin/ads_list',$arr);
    }


}