<?php

class MConsume extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    public function saveConsumeData($data){
        $this->db->insert('consume',$data);
    }

    public function getConsumeData($opts=array(),$order=array()){
        if(!empty($opts['client_id'])){
            $this->db->where('client_id',$opts['client_id']);
        }
        if(!empty($opts['third_platform'])){
            $this->db->where('third_platform',$opts['third_platform']);
        }
        if(!empty($opts['ads_id'])){
            $this->db->where('ads_id',$opts['ads_id']);
        }
        if(!empty($opts['type'])){
            $this->db->where('type',$opts['type']);
        }
        if(!empty($opts['stime'])){
            $this->db->where('time >=',$opts['stime']);
        }
        if(!empty($opts['etime'])){
            $this->db->where('time <=',$opts['etime']);
        }
        if(!empty($opts['stage'])){
            $this->db->where('stage',$opts['stage']);
        }
        $this->db->from('consume');
        if(!$order){
            $this->db->order_by('time', 'ASC');
            $this->db->order_by('ads_id', 'ASC');
        }else{
            $this->db->order_by($order['key'], $order['value']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCountConsume($opts=array()){
        if(!empty($opts['client_id'])){
            $this->db->where('client_id',$opts['client_id']);
        }
        if(!empty($opts['third_platform'])){
            $this->db->where('third_platform',$opts['third_platform']);
        }
        if(!empty($opts['ads_id'])){
            $this->db->where('ads_id',$opts['ads_id']);
        }
        if(!empty($opts['type'])){
            $this->db->where('type',$opts['type']);
        }
        if(!empty($opts['stime'])){
            $this->db->where('time >=',$opts['stime']);
        }
        if(!empty($opts['etime'])){
            $this->db->where('time <=',$opts['etime']);
        }
        $this->db->select('sum(consume) as sum_consume');
        $query = $this->db->get('consume');
        return $query->result_array();
    }
}