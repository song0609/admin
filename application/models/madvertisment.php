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

    public function getAdvertismentList($offset,$pagesize){
        $this->db->limit($pagesize,$offset);
        $this->db->from('advertisment');
        $query = $this->db->get();
        return $query->result_array();
    }
}