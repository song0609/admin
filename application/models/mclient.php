<?php
/**
 * Created by PhpStorm.
 * User: jian.song
 * Date: 15-4-16
 * Time: 下午4:10
 */
class MClient extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    public function getClientByUsername($username){
        $query = $this->db->get_where('client', array('username'=>$username));
        return $query->result_array();
    }

    public function getTotalCount(){
        $query = $this->db->get_where('client', array());
        return $query->num_rows();
    }

    public function getAdvertiserList($offset,$pagesize){
        $this->db->limit($pagesize,$offset);
        $this->db->from('client');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function updateStatus($id,$status){
        $data = array(
            'status'=>$status,
        );
        $this->db->where('id', $id);
        $this->db->update('client', $data);
    }

    public function isExistsUsername($username){
        $query = $this->db->get_where('client', array('username'=>$username));
        $num = $query->num_rows();
        if(!$num){
            return FALSE;
        }else return TRUE;
    }

    public function saveClient($data){
        $this->db->insert('client',$data);
    }

    public function updateClient($id,$data){
        $this->db->where('id', $id);
        $this->db->update('client', $data);
    }


}