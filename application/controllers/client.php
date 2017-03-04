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
        $this->load->model(array('MAdvertisment','MClient','MConsume','MThirdPlatform'),'',TRUE);
        $client_name = $this ->session->userdata('username');
        $client = $this->MClient->getClientByUsername($client_name);
        $client_id = $client[0]['id'];
        $sdate = $this->input->get('sdate');
        $edate = $this->input->get('edate');
        $aid = $this->input->get('ads');
        $count=0;  //总消耗
        $ads_info = array();
        $consume_list = array();
        if($client_id){
            $ads = $this->MAdvertisment->getAdvertismentList(0,100,array('client_id'=>$client_id));
            $total_count = $this->MThirdPlatform->getThirdPlatformList(0,1,array('client_id'=>$client_id));
            $total_count = empty($total_count)?0:$total_count[0]['total_account'];
            foreach($ads as $k=>$v){
                $sum = $this->MConsume->getCountConsume(array('client_id'=>$client_id,'ads_id'=>$v['id'],'type'=>2));
                $now = $this->getTodayConsume($client_id,$v['id']);
                $ads[$k]['sum_consume'] = !empty($sum)?$sum[0]['sum_consume']:0;
                $ads[$k]['sum_consume'] += $now;//每条任务的消耗
                $count += $ads[$k]['sum_consume'];
                $ads_info[$v['id']] = $v;
            }
            $data['count'] = $count;
            $data['ads'] = $ads;
            $data['form']['ads'] = $aid;
            $data['form']['sdate'] = $sdate;
            $data['form']['edate'] = $edate;
        }
        $today = $this->getHistoryDayConsume(date('Y-m-d'),$client_id,1);
        //$today = $this->getHistoryDayConsume('2017-01-21',$client_id,1);
        $lastday = $this->getHistoryDayConsume(date("Y-m-d",strtotime("-1 day")),$client_id,1);
        //$lastday = $this->getHistoryDayConsume('2017-01-21',$client_id,1);
        $xAxis = array();
        $yAxis = array();
        if(!empty($today)){
            $xAxis = $today['xAxis'];
            $y = array();
            for($i=0;$i<count($today['yAxis']);$i++){
                if($i==0){
                    $y[$i] =$today['yAxis'][$i];
                    continue;
                }
                $y[$i] = $today['yAxis'][$i] - $today['yAxis'][$i-1];
            }
            $yAxis[] = array(
                'data'=> $y,
                'name' => date('Y-m-d'),
            );
        }
        if(!empty($lastday)){
            count($xAxis)<count($lastday['xAxis'])?$xAxis = $lastday['xAxis']:'';
            $y = array();
            for($i=0;$i<count($lastday['yAxis']);$i++){
                if($i==0){
                    $y[$i] =$lastday['yAxis'][$i];
                    continue;
                }
                $y[$i] = $lastday['yAxis'][$i] - $lastday['yAxis'][$i-1];
            }
            $yAxis[] = array(
                'data'=> $y,
                'name' => date("Y-m-d",strtotime("-1 day")),
            );
        }
        if(!empty($sdate)&&!empty($edate)){
            if($edate<$sdate){
                $data['error'] = '结束日期大于开始日期';
            }else{
                $stime = strtotime($sdate);
                $etime = strtotime($edate)+3600*24-1;
                $is_today = false;
                if(time()>$stime && time()<$etime){
                    $is_today = true;
                }
                $opt = array(
                    'client_id'=>$client_id,
                    'type'=>2,
                    'stime'=>$stime,
                    'etime'=>$etime,
                );
                if($aid){ //查某条任务
                    $opt['ads_id'] = $aid;
                    $consume_list = $this->MConsume->getConsumeData($opt);
                    foreach($consume_list as $k=>$v){
                        $consume_list[$k]['time'] = date('Y-m-d',$v['time']);
                    }
                    if($is_today){
                        $today_data = $this->getTodayData($client_id,$aid);
                        $today_data['time'] = date('Y-m-d',$today_data['time']);
                        array_unshift($consume_list,$today_data);
                    }
                }else{
                    $list = $this->MConsume->getConsumeData($opt);
                    $consume_list = array();
                    foreach($list as $v){
                        $date = date('Y-m-d',$v['time']);
                        if(!isset($consume_list[$date])){
                            $consume_list[$date]['real_consume']=0;
                            $consume_list[$date]['pv']=0;
                            $consume_list[$date]['click']=0;
                        }
                        $consume_list[$date]['real_consume'] += $v['real_consume'];
                        $consume_list[$date]['pv'] += $v['pv'];
                        $consume_list[$date]['click'] += $v['click'];
                        $consume_list[$date]['time'] = $date;
                    }
                    if($is_today){
                        $today_data = $this->getTodayData($client_id,0);
                        $today_data['time'] = date('Y-m-d',$today_data['time']);
                        array_unshift($consume_list,$today_data);
                    }
                }
            }

        }
        $data['consume_list'] = $consume_list;
        $data['total_count'] = $total_count;
        $data['xAxis'] = $xAxis;
        $data['consume']['xAxis'] = json_encode($xAxis);
        $data['consume']['yAxis'] = json_encode($yAxis);
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
                return $consume_data[0]['real_consume'];
            }else{
                $sum = 0;
                $aid = array();
                foreach($consume_data as $v){
                    if(!in_array($v['ads_id'],$aid)){
                        $sum += $v['real_consume'];
                        $aid[] = $v['ads_id'];
                    }
                }
                return $sum;
            }
        }
        return 0;
    }

    public function getAdvertismentList(){
        $this->load->helper('page');
        $this->load->model(array('MAdvertisment','MClient','MConsume'),'',TRUE);
        $page = $this->input->get('per_page');
        $page = !empty($page)?$page:1;
        $client_name = $this ->session->userdata('username');
        $client = $this->MClient->getClientByUsername($client_name);
        $client_id = $client[0]['id'];
        $total = $this->MAdvertisment->getTotalCount(array('client_id'=>$client_id));
        $pagesize = 10;
        $offset = $pagesize*($page-1);
        $ads = $this->MAdvertisment->getAdvertismentList($offset,$pagesize,array('client_id'=>$client_id));
        //$count = 0;
        /*foreach($ads as $k=>$v){
            $sum = $this->MConsume->getCountConsume(array('client_id'=>$client_id,'ads_id'=>$v['id'],'type'=>2));
            $now = $this->getTodayConsume($client_id,$v['id']);
            $ads[$k]['sum_consume'] = !empty($sum)?$sum[0]['sum_consume']:0;
            $ads[$k]['sum_consume'] += $now;//每条任务的消耗
            //$count += $ads[$k]['sum_consume'];
        }*/
        $arr['data'] = $ads;
        $arr['pagination'] = pagination(site_url("c=client&m=getAdvertismentList"),$pagesize,$total);
        $arr['total'] = $total;
        $this->load->view('client/ads_list',$arr);
    }


    public function test(){
        $data = $this->getHistoryDayConsume('2017-01-21',1,1);
        echo json_encode($data);exit;
    }
    /**
     * 获取过去某一天的消耗明细(今天除外)
     * @param $day 2017-02-12
     * @param $client_id
     * @param int $ads_id
     */
    private function getHistoryDayConsume($day,$client_id,$stage=0,$ads_id=0){
        $this->load->model(array('MConsume'),'',TRUE);
        $opts = array(
            'stime'=>strtotime($day),
            'etime'=>strtotime($day)+3600*24-1,
            'client_id'=>$client_id,
            'stage'=>$stage,
        );
        $data = array();
        $y_data = array();//每个任务的y轴数据
        $yAxis = array();//y轴
        $x_data = array();//x轴
        $ads_id = array();
        $consumes = $this->MConsume->getConsumeData($opts);
        if($consumes){
            foreach($consumes as $k=>$v){
                $y_data[$v['ads_id']][] = $v['real_consume'];
                $x_data[$v['ads_id']][] = date('H:i',$v['time']);
                if(!in_array($v['ads_id'],$ads_id)){
                    $ads_id[] = $v['ads_id'];
                }
            }
            $max_x = 0;
            $max_x_ads = 0;
            foreach($ads_id as $v){
                if(count($x_data[$v])>$max_x) {
                    $max_x=count($x_data[$v]); //维度最多的任务为x轴
                    $max_x_ads = $v;
                }
            }
            for($i=0;$i<$max_x;$i++){
                $yAxis[$i]=0;
            }
            foreach($ads_id as $id){
                foreach($y_data[$id] as $k=>$y){
                    $yAxis[$k] += $y;
                }
            }
            $data['xAxis'] = $x_data[$max_x_ads];
            $data['yAxis'] = $yAxis;
        }
        return $data;
    }


    private function getTodayData($client_id, $ads_id=0){
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
                return $consume_data[0];
            }else{
                $sum = 0;
                $pv = 0;
                $click = 0;
                $aid = array();
                foreach($consume_data as $v){
                    if(!in_array($v['ads_id'],$aid)){
                        $sum += $v['real_consume'];
                        $pv += $v['pv'];
                        $click += $v['click'];
                        $aid[] = $v['ads_id'];
                    }
                }
                return array('pv'=>$pv,'click'=>$click,'real_consume'=>$sum,'time'=>strtotime(date('Y-m-d')));
            }
        }
        return array('pv'=>0,'click'=>0,'real_consume'=>0,'time'=>strtotime(date('Y-m-d')));
    }
}