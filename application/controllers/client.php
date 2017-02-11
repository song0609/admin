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

    public function advertismentInfo(){
        $data = array();
        $this->load->model(array('MAdvertisment','MClient','MConsume'),'',TRUE);
        $client_name = $this ->session->userdata('username');
        $client = $this->MClient->getClientByUsername($client_name);
        $client_id = $client[0]['id'];
        //$client_id = $this->input->get('client_id');
        $putdate = $this->input->get('putdate');
        $clients = $this->MClient->getAdvertiserList(0,100);
        $data['clients'] = $clients;
        $count=0;
        if($client_id){
            $ads = $this->MAdvertisment->getAdvertismentList(0,100,array('client_id'=>$client_id));
            foreach($ads as $k=>$v){
                $sum = $this->MConsume->getCountConsume(array('client_id'=>$client_id,'ads_id'=>$v['id'],'type'=>2));
                $now = $this->getTodayConsume($client_id,$v['id']);
                $ads[$k]['sum_consume'] = !empty($sum)?$sum[0]['sum_consume']:0;
                $ads[$k]['sum_consume'] += $now;
                $count += $ads[$k]['sum_consume'];
            }
            $data['count'] = $count;
            $data['ads'] = $ads;
            $data['form']['client_id'] = $client_id;
            if($putdate){
                $data['form']['putdate'] = $putdate;
                $opts = array(
                    'stime'=>strtotime($putdate),
                    'etime'=>strtotime($putdate)+3600*24-1,
                    'client_id'=>$client_id,
                );
                $y_data = array();
                $yAxis = array();
                $x_data = array();
                $ads_id = array();
                $consumes = $this->MConsume->getConsumeData($opts);
                if($consumes){
                    foreach($consumes as $k=>$v){
                        $y_data[$v['ads_id']][] = floatval($v['consume']);
                        $x_data[$v['ads_id']][] = date('Y-m-d H:i',$v['time']);
                        if(!in_array($v['ads_id'],$ads_id)){
                            $ads_id[] = $v['ads_id'];
                        }
                    }
                    for($i=0;$i<count($x_data[$ads_id[0]]);$i++){
                        $yAxis[$i]=0;
                    }
                    //var_dump($y_data);exit;
                    $y = array();
                    foreach($ads_id as $id){
                        /*foreach($y_data[$id] as $k=>$y){
                            $yAxis[$k] += $y;
                        }*/
                        $y[] = array(
                            'data'=>$y_data[$id],
                            'name'=>$id,
                        );
                    }
                    $data['consume']['xAxis'] = json_encode($x_data[$ads_id[0]]);
                    //$data['consume']['yAxis'] = json_encode(array(array('data'=>$yAxis,'name'=>$putdate)));
                    $data['consume']['yAxis'] = json_encode($y);
                    //var_dump($data['consume']['yAxis']);exit;
                }

            }
        }
        $this->load->view('client/ads_info',$data);
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

    //获取当日某任务最新消耗
    private function getTodayConsume($client_id, $ads_id=0){
        $this->load->model('MConsume','',TRUE);
        $opts = array(
            'client_id'=>$client_id,
            'type'=>1,
            'stime'=>strtotime(date("Y-m-d")),
            'etime'=>strtotime(date("Y-m-d"))+24*3600-2,
        );
        !empty($ads_id)?$opts['ads_id']=$ads_id:'';
        $order = array(
            'key'=>'time',
            'value'=>'desc',
        );
        $consume_data = $this->MConsume->getConsumeData($opts,$order);
        if($consume_data){
            if(!empty($ads_id)){
                return $consume_data[0]['consume'];
            }else{
                $sum = 0;
                $aid = array();
                foreach($consume_data as $v){
                    if(!in_array($v['ads_id'],$aid)){
                        $sum += $v['consume'];
                        $aid[] = $v['ads_id'];
                    }
                }
                return $sum;
            }
        }
        return 0;
    }
}