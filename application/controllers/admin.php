<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: jian.song
 * Date: 15-4-16
 * Time: 下午4:34
 */
require('Admin_Controller.php');
class Admin extends Admin_Controller {

    public static $third_platforms = array(
        '1'=>'巨鲨',
    );
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
        $this->load->model(array('MAdvertisment','MClient'),'',TRUE);
        $page = $this->input->get('per_page');
        $page = !empty($page)?$page:1;
        $total = $this->MAdvertisment->getTotalCount();
        $pagesize = 10;
        $offset = $pagesize*($page-1);
        $data = $this->MAdvertisment->getAdvertismentList($offset,$pagesize);
        $clients = $this->MClient->getAdvertiserList(0,100);
        $clients_arr = array();
        foreach($clients as $val){
            $clients_arr[$val['id']] = $val;
        }
        $arr['data'] = $data;
        $arr['clients'] = $clients_arr;
        $arr['pagination'] = pagination(site_url("c=admin&m=getAdvertismentList"),$pagesize,$total);
        $arr['total'] = $total;
        $this->load->view('admin/ads_list',$arr);
    }

    public function addAdvertisment(){
        $data['form'] = array();
        $this->load->model(array('MClient'),'',TRUE);
        $clients = $this->MClient->getAdvertiserList(0,100);
        $data['clients'] = $clients;
        $data['platforms'] = self::$third_platforms;
        $this->load->view('admin/ads_form',$data);
    }

    public function saveAdvertisment(){
        $this->load->model('MAdvertisment','',TRUE);
        $vo = array();
        $param = array('id','client_id','ads_name','ads_type','platform','price','ads_url','ads_status','discount','third_platform','username','password');
        $param_data = array();
        foreach($param as $v){
            $param_data[$v] = $this->security->xss_clean($this->input->post($v));
        }
        $form = $param_data;
        if(empty($param_data['username'])||empty($param_data['password'])){
            $errors['password'] = "账号密码为必填";
            $this->load->model(array('MClient'),'',TRUE);
            $clients = $this->MClient->getAdvertiserList(0,100);
            $data['clients'] = $clients;
            $data['platforms'] = self::$third_platforms;
            $data['errors'] = $errors;
            $data['form'] = $form;
            $this->load->view ('admin/ads_form', $data);
            return;
        }
        if(!$form['id']){
            $this->MAdvertisment->saveAdvertisment($param_data);
        }else{
            $this->MAdvertisment->updateAdvertisment($param_data,$param_data['id']);
        }
        $vo['tips'] = "保存成功";
        redirect('c=admin&m=getAdvertismentList');
    }

    public function editAdvertisment(){
        $data['form'] = array();
        $this->load->model(array('MClient','MAdvertisment'),'',TRUE);
        $id = $this->input->get('id');
        $clients = $this->MClient->getAdvertiserList(0,100);
        $data['clients'] = $clients;
        $data['platforms'] = self::$third_platforms;
        $res = $this->MAdvertisment->getAdvertismentList(0,1,array('id'=>$id));
        if(empty($res[0])){
            echo "<script>不存在该广告记录！</script>";
            exit;
        }
        $data['form'] = $res[0];
        $this->load->view('admin/ads_form',$data);
    }

    public function advertismentInfo(){
        $data = array();
        $client_id = $this->input->get('client_id');
        $putdate = $this->input->get('putdate');
        $this->load->model(array('MAdvertisment','MClient','MConsume','MThirdPlatform'),'',TRUE);
        $clients = $this->MClient->getAdvertiserList(0,100);
        $data['clients'] = $clients;
        $count=0;
        if($client_id){
            $ads = $this->MAdvertisment->getAdvertismentList(0,100,array('client_id'=>$client_id));
            $total_count = $this->MThirdPlatform->getThirdPlatformList(0,1,array('client_id'=>$client_id));
            $total_count = empty($total_count)?0:$total_count[0]['total_account'];
            foreach($ads as $k=>$v){
                $sum = $this->MConsume->getCountConsume(array('client_id'=>$client_id,'ads_id'=>$v['id'],'type'=>2));
                $now = $this->getTodayConsume($client_id,$v['id']);
                $ads[$k]['sum_consume'] = !empty($sum)?$sum[0]['sum_consume']:0;
                $ads[$k]['sum_consume'] += $now;
                $count += $ads[$k]['sum_consume'];
            }
            $data['total_count'] = $total_count;
            $data['count'] = $count;
            $data['ads'] = $ads;
            $data['form']['client_id'] = $client_id;
            if($putdate){
                $data['form']['putdate'] = $putdate;
                $pdate = $this->getHistoryDayConsume($putdate,$client_id,1);
                $xAxis = array();
                $yAxis = array();
                if(!empty($pdate)){
                    $xAxis = $pdate['xAxis'];
                    $y = array();
                    for($i=0;$i<count($pdate['yAxis']);$i++){
                        if($i==0){
                            $y[$i] =$pdate['yAxis'][$i];
                            continue;
                        }
                        $y[$i] = $pdate['yAxis'][$i] - $pdate['yAxis'][$i-1];
                    }
                    $yAxis[] = array(
                        'data'=> $y,
                        'name' => $putdate,
                    );
                }
                $data['consume']['xAxis'] = json_encode($xAxis);
                $data['consume']['yAxis'] = json_encode($yAxis);
            }
        }
        $this->load->view('admin/ads_info',$data);
    }

    public function getFinanceList(){
        $this->load->helper('page');
        $this->load->model(array('MFinance','MClient'),'',TRUE);
        $page = $this->input->get('per_page');
        $page = !empty($page)?$page:1;
        $total = $this->MFinance->getTotalCount(1);
        $pagesize = 10;
        $offset = $pagesize*($page-1);
        $data = $this->MFinance->getFinanceList($offset,$pagesize);
        $clients = $this->MClient->getAdvertiserList(0,100);
        $clients_arr = array();
        foreach($clients as $val){
            $clients_arr[$val['id']] = $val;
        }
        $arr['data'] = $data;
        $arr['clients'] = $clients_arr;
        $arr['pagination'] = pagination(site_url("c=admin&m=getFinanceList"),$pagesize,$total);
        $arr['total'] = $total;
        $this->load->view('admin/finance_list',$arr);
    }

    public function addFinance(){
        $data['form'] = array();
        $this->load->model(array('MClient'),'',TRUE);
        $clients = $this->MClient->getAdvertiserList(0,100);
        $data['clients'] = $clients;
        //$data['platforms'] = self::$third_platforms;
        $this->load->view('admin/finance_form',$data);
    }

    public function saveFinance(){
        $this->load->model('MFinance','',TRUE);
        $vo = array();
        $param = array('client_id','note','money');
        $param_data = array();
        foreach($param as $v){
            $param_data[$v] = $this->security->xss_clean($this->input->post($v));
        }
        $param_data['time'] = time();
        $form = $param_data;
        if(empty($param_data['money'])){
            $errors['money'] = "充值金额为必填";
            $this->load->model(array('MClient'),'',TRUE);
            $clients = $this->MClient->getAdvertiserList(0,100);
            $data['clients'] = $clients;
            $data['platforms'] = self::$third_platforms;
            $data['errors'] = $errors;
            $data['form'] = $form;
            $this->load->view ('admin/finance_form', $data);
            return;
        }
        $this->MFinance->saveFinance($param_data);
        $vo['tips'] = "保存成功";
        redirect('c=admin&m=getFinanceList');
    }

    //获取消耗总额
    public function getConsumeTotal(){
        $this->load->model(array('MConsume','MThirdPlatform'),'',TRUE);
        $client_id = $this->input->get('client_id');
        if($client_id){
            $res = 0;
            $total_count = $this->MThirdPlatform->getThirdPlatformList(0,1,array('client_id'=>$client_id));
            $total_count = empty($total_count)?0:$total_count[0]['total_account'];
            $total = $this->MConsume->getCountConsume(array('client_id'=>$client_id,'type'=>2));
            $now = $this->getTodayConsume($client_id);
            !empty($total[0]['sum_consume'])?$res = $total[0]['sum_consume']:0;
            $res += $now;
            $total_count = round($total_count-$res,2);
            echo json_encode(array('status'=>200,'consume'=>$res,'total_count'=>$total_count));
            exit;
        }
        echo json_encode(array('status'=>500,'consume'=>'','total_count'=>0));
        exit;
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

}