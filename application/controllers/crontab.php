<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: jian.song
 * Date: 15-4-16
 * Time: 下午4:34
 */
class Crontab extends CI_Controller {

    public static $jusha_key = "37e531a64edde7eb424c33ec16522a4a";
    public static $third_platforms = array(
        'jusha'=>1,
    );

    public function jushaCrontab(){
        set_time_limit(0);
        $time = time();
        $min = date('i',$time);
        $stage = $this->_calStage($min);
        echo "Crontab jushaCrontab start---".date('Y-m-d H:i:s',$time).PHP_EOL;
        $this->load->model(array('MAdvertisment','MConsume'),'',TRUE);
        $ads = $this->MAdvertisment->getAdvertismentList(0,10000,array('third_platform'=>self::$third_platforms['jusha']));
        $login_url = "https://www.jusha.com/login.php";
        $select_url = "https://www.jusha.com/AdsMaster/public/getreportdata.php?action=earning_data&cycle=selectDate&App_OS=All&FeeTypeID=All&app=0&GameTypeID=All&historyToExcel=0";
        $date = date('Y-m-d',time());
        $select_url .= "&sdate=$date&edate=$date";
        foreach($ads as $v){
            echo "deal with client_id".$v['client_id'].PHP_EOL;
            $cookie = dirname(dirname(dirname(__FILE__))) . '/cookie/cookie_jusha_'.$v['client_id'].'.txt';
            $post = array(
                'nocode' => '1',
                'username' => $v['username'],
                'password' => $v['password'],
            );
            $this->login_post($login_url, $cookie, $post);
            $content = $this->get_content($select_url, $cookie);
            $content = json_decode($content,TRUE);
            $cost = $content['total']['Total'];
            $data = array(
                'third_platform'=>self::$third_platforms['jusha'],
                'client_id'=>$v['client_id'],
                'consume'=>$cost,
                'time'=>strtotime(date('Y-m-d H:i',$time)),
                'ads_id'=>$v['id'],
                'discount'=>$v['discount'],
                'real_consume'=>$cost*$v['discount'],
                'stage'=>$stage,
            );
            $this->MConsume->saveConsumeData($data);
        }
        echo "Crontab jushaCrontab end---".date('Y-m-d H:i:s',time()).PHP_EOL;
    }

    public function jushaCrontab2(){
        set_time_limit(0);
        $time = time();
        echo "Crontab jushaCrontab2 start---".date('Y-m-d H:i:s',$time).PHP_EOL;
        $this->load->model(array('MAdvertisment','MConsume'),'',TRUE);
        $ads = $this->MAdvertisment->getAdvertismentList(0,10000,array('third_platform'=>self::$third_platforms['jusha']));
        $login_url = "https://www.jusha.com/login.php";
        $select_url = "https://www.jusha.com/AdsMaster/public/getreportdata.php?action=earning_data&cycle=selectDate&App_OS=All&FeeTypeID=All&app=0&GameTypeID=All&historyToExcel=0";
        //$date = date('Y-m-d',time());
        $date = date("Y-m-d",strtotime("-1 day"));
        $select_url .= "&sdate=$date&edate=$date";
        foreach($ads as $v){
            echo "deal with client_id".$v['client_id'].PHP_EOL;
            $cookie = dirname(dirname(dirname(__FILE__))) . '/cookie/cookie_jusha_'.$v['client_id'].'.txt';
            $post = array(
                'nocode' => '1',
                'username' => $v['username'],
                'password' => $v['password'],
            );
            $this->login_post($login_url, $cookie, $post);
            $content = $this->get_content($select_url, $cookie);
            $content = json_decode($content,TRUE);
            $cost = $content['total']['Total'];
            $data = array(
                'third_platform'=>self::$third_platforms['jusha'],
                'client_id'=>$v['client_id'],
                'consume'=>$cost,
                'time'=>strtotime(date("Y-m-d"))-1,
                'ads_id'=>$v['id'],
                'type'=>2,
                'discount'=>$v['discount'],
                'real_consume'=>$cost*$v['discount'],
                'stage'=>1,
            );
            $this->MConsume->saveConsumeData($data);
        }
        echo "Crontab jushaCrontab2 end---".date('Y-m-d H:i:s',time()).PHP_EOL;
    }

    public function login_post($url, $cookie, $post) {
        $curl = curl_init();//初始化curl模块
        curl_setopt($curl, CURLOPT_URL, $url);//登录提交的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, 0);//是否显示头信息
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);//是否自动显示返回的信息
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie); //设置Cookie信息保存在指定的文件中
        curl_setopt($curl, CURLOPT_POST, 1);//post方式提交
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));//要提交的信息
        if(curl_exec($curl) === false){
            echo 'Curl error: ' . curl_error($curl);
        }
        curl_close($curl);//关闭cURL资源，并且释放系统资源
    }


    //登录成功后获取数据
    public function get_content($url, $cookie=null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if($cookie){
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie); //读取cookie
        }
        $rs = curl_exec($ch); //执行cURL抓取页面内容
        curl_close($ch);
        return $rs;
    }

    //判断分钟数的阶段0-15:1,15-30:2,30-45:3,45-59:4
    private function _calStage($min){
        if($min<15){
            return 1;
        }elseif($min<30){
            return 2;
        }elseif($min<45){
            return 3;
        }elseif($min>=45){
            return 4;
        }
        return 0;
    }

    public function jushaCrontabNew(){
        set_time_limit(0);
        $time = time();
        $min = date('i',$time);
        $stage = $this->_calStage($min);
        echo "Crontab jushaCrontabNew start---".date('Y-m-d H:i:s',$time).PHP_EOL;
        $this->load->model(array('MAdvertisment','MConsume'),'',TRUE);
        $ads = $this->MAdvertisment->getAdvertismentList(0,10000,array('third_platform'=>self::$third_platforms['jusha']));
        //$api_url = "http://localhost/test.php";
        $api_url = "https://www.jusha.com/client/shunwang.php";
        $date = date('Y-m-d',time());
        $ads_arr = array();
        foreach($ads as $v){
            $ads_arr[] = $v['id'];
        }
        if(empty($ads_arr)){
            echo "no ads deal with".PHP_EOL;
            return;
        }
        $sdate = $date;
        $edate = $date;
        $ads_str = implode(",",$ads_arr);
        $sign = md5($sdate.$edate.$ads_str);
        $api_url .= "?advid=".$ads_str."&sdate=".$sdate."&edate=".$edate."&sign=".$sign;
        $res = $this->get_content($api_url, null);
        $res = json_decode($res,true);

        if($res['code'] != 0){
            echo "jusha api error:".$res['msg'].PHP_EOL;
            return;
        }
        $res_data = $res['data'][$date];
        foreach($ads as $v){
            $jusha_data = empty($res_data[$v['id']])?array():$res_data[$v['id']];
            $data = array(
                'third_platform'=>self::$third_platforms['jusha'],
                'client_id'=>$v['client_id'],
                'consume'=>empty($jusha_data)?0:$jusha_data['Money'],
                'time'=>strtotime(date('Y-m-d H:i',$time)),
                'ads_id'=>$v['id'],
                'discount'=>$v['discount'],
                'real_consume'=>empty($jusha_data)?0:$jusha_data['Money']*$v['discount'],
                'stage'=>$stage,
                'pv'=>empty($jusha_data)?0:$jusha_data['Pv'],
                'click'=>empty($jusha_data)?0:$jusha_data['Click'],
                'effective'=>empty($jusha_data)?0:$jusha_data['Effective'],
                'click_rate'=>empty($jusha_data)?0:$jusha_data['Click_Rate'],
            );
            $this->MConsume->saveConsumeData($data);
        }
        echo "Crontab jushaCrontabNew end---".date('Y-m-d H:i:s',time()).PHP_EOL;
    }

    public function jushaCrontabNew2(){
        set_time_limit(0);
        $time = time();
        echo "Crontab jushaCrontabNew2 start---".date('Y-m-d H:i:s',$time).PHP_EOL;
        $this->load->model(array('MAdvertisment','MConsume'),'',TRUE);
        $ads = $this->MAdvertisment->getAdvertismentList(0,10000,array('third_platform'=>self::$third_platforms['jusha']));
        $api_url = "https://www.jusha.com/client/xxx.php";
        $date = date("Y-m-d",strtotime("-1 day"));
        $ads_arr = array();
        foreach($ads as $v){
            $ads_arr[] = $v['id'];
        }
        if(empty($ads_arr)){
            echo "no ads deal with".PHP_EOL;
            return;
        }
        $sdate = $date;
        $edate = $date;
        $ads_str = implode(",",$ads_arr);
        $sign = md5($sdate.$edate.$ads_str);
        $api_url .= "?advid=".$ads_str."&sdate=".$sdate."&edate=".$edate."&sign=".$sign;
        $res = $this->get_content($api_url, null);
        $res = json_decode($res,true);
        if($res['code'] != 0){
            echo "jusha api error:".$res['msg'].PHP_EOL;
            return;
        }
        $res_data = $res['data'][$date];
        foreach($ads as $v){
            $jusha_data = empty($res_data[$v['id']])?array():$res_data[$v['id']];
            $data = array(
                'third_platform'=>self::$third_platforms['jusha'],
                'client_id'=>$v['client_id'],
                'consume'=>empty($jusha_data)?0:$jusha_data['Money'],
                'time'=>strtotime(date("Y-m-d"))-1,
                'ads_id'=>$v['id'],
                'discount'=>$v['discount'],
                'real_consume'=>empty($jusha_data)?0:$jusha_data['Money']*$v['discount'],
                'stage'=>1,
                'pv'=>empty($jusha_data)?0:$jusha_data['Pv'],
                'click'=>empty($jusha_data)?0:$jusha_data['Click'],
                'effective'=>empty($jusha_data)?0:$jusha_data['Effective'],
                'click_rate'=>empty($jusha_data)?0:$jusha_data['Click_Rate'],
                'type'=>2,
            );
            $this->MConsume->saveConsumeData($data);
        }
        echo "Crontab jushaCrontabNew2 end---".date('Y-m-d H:i:s',time()).PHP_EOL;
    }
}