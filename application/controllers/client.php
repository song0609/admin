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

    public function getFinanceList(){
        $this->load->helper('page');
        $this->load->model(array('MFinance','MClient'),'',TRUE);
        $page = $this->input->get('per_page');
        $page = !empty($page)?$page:1;
        $username = $this->session->userdata('username');
        $client = $this->MClient->getClientByUsername($username);
        $client_id = $client[0]['id'];
        $total = $this->MFinance->getTotalCount(array('client_id'=>$client_id));
        $pagesize = 10;
        $offset = $pagesize*($page-1);
        $data = $this->MFinance->getFinanceList($offset,$pagesize,array('client_id'=>$client_id));
        $clients = $this->MClient->getAdvertiserList(0,100);
        $clients_arr = array();
        foreach($clients as $val){
            $clients_arr[$val['id']] = $val;
        }
        $arr['data'] = $data;
        $arr['clients'] = $clients_arr;
        $arr['pagination'] = pagination(site_url("c=admin&m=getFinanceList"),$pagesize,$total);
        $arr['total'] = $total;
        $this->load->view('client/finance_list',$arr);
    }

    public function editClientMessage(){
        $this->load->model(array('MClient'),'',TRUE);
        $username = $this->session->userdata('username');
        $client = $this->MClient->getClientByUsername($username);
        $client = $client[0];
        $data['form'] = $client;
        $this->load->view('client/adver_form',$data);
    }

    public function updateAdvertiser(){
        $this->load->model('MClient','',TRUE);
        $vo = array();
        $id = $this->security->xss_clean($this->input->post('id'));
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));
        $advertiser = $this->security->xss_clean($this->input->post('advertiser'));
        $linkman = $this->security->xss_clean($this->input->post('linkman'));
        $phone = $this->security->xss_clean($this->input->post('phone'));
        $email = $this->security->xss_clean($this->input->post('email'));
        $form = array(
            'id'=>$id,
            'username'=>$username,
            'password'=>$password,
            'advertiser'=>$advertiser,
            'linkman'=>$linkman,
            'phone'=>$phone,
            'email'=>$email,
        );
        if(empty($password)){
            $errors['password'] = "密码不能为空！";
            $this->load->view ('client/adver_form', array('errors'=>$errors,'form'=>$form));
            return;
        }
        $data = array(
            'password'=>md5($password),
            'advertiser'=>$advertiser,
            'linkman'=>$linkman,
            'phone'=>$phone,
            'email'=>$email,
        );
        $this->MClient->updateClient($id,$data);
        $vo['tips'] = "保存成功";
        $vo['form'] = $form;
        $this->load->view ('client/adver_form', $vo);
    }
}