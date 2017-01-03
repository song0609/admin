<?php
/**
 * Created by PhpStorm.
 * User: jian.song
 * Date: 15-4-16
 * Time: 下午4:10
 */
class MAdmin extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    function getAdminByUsername($username){
        $query = $this->db->get_where('admin', array('username'=>$username));
        return $query->result_array();
    }

    function isExistsUsername($username){
        $query = $this->db->get_where('admin', array('username'=>$username));
        $num = $query->num_rows();
        if(!$num){
            return FALSE;
        }else return TRUE;
    }

    function saveAdmin($data){
        $this->db->insert('admin',$data);
    }

    function updatePassword($data){
        $this->db->where('username', $data['username']);
        $this->db->update('admin', $data);
    }

}