<?php
/**
 * Created by PhpStorm.
 * User: jian.song
 * Date: 15-4-16
 * Time: 下午4:10
 */
class MAdvertisment extends CI_Model{
    public function __construct(){
        parent::__construct();
    }


    public function getTotalCount(){
        $query = $this->db->get_where('advertisment', array());
        return $query->num_rows();
    }

    public function getAdvertismentList($offset,$pagesize,$opts=array()){
        $this->db->limit($pagesize,$offset);
        if(!empty($opts['id'])){
            $this->db->where('id',$opts['id']);
        }
        if(!empty($opts['client_id'])){
            $this->db->where('client_id',$opts['client_id']);
        }
        if(!empty($opts['third_platform'])){
            $this->db->where('third_platform',$opts['third_platform']);
        }
        $this->db->from('advertisment');
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        return $query->result_array();
    }

    public function saveAdvertisment($data){
        $this->db->insert('advertisment',$data);
    }

    public function updateAdvertisment($data,$id){
        $param = array('client_id','ads_name','ads_type','platform','price','ads_url','ads_status','discount','third_platform','username','password');
        unset($data['id']);
        $this->db->where('id', $id);
        $this->db->update('advertisment', $data);
    }
}