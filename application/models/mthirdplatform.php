<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 17-1-21
 * Time: 下午3:18
 */

class MThirdPlatform extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    public function saveThirdPlatform($data){
        $this->db->insert('third_platform',$data);
    }

    public function updateThirdPlatform($data,$opts=array()){
        if(!empty($opts['id'])){
            $this->db->where('id',$opts['id']);
        }
        if(!empty($opts['client_id'])){
            $this->db->where('client_id',$opts['client_id']);
        }
        if(!empty($opts['third_platform'])){
            $this->db->where('third_platform',$opts['third_platform']);
        }
        $this->db->update('third_platform', $data);
    }

    public function getTotalCount($opts=array()){
        if(!empty($opts['id'])){
            $this->db->where('id',$opts['id']);
        }
        if(!empty($opts['client_id'])){
            $this->db->where('client_id',$opts['client_id']);
        }
        if(!empty($opts['third_platform'])){
            $this->db->where('third_platform',$opts['third_platform']);
        }
        $query = $this->db->get_where('third_platform', array());
        return $query->num_rows();
    }

    public function getThirdPlatformList($offset,$pagesize,$opts=array()){
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
        $this->db->from('third_platform');
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        return $query->result_array();
    }
} 