<?php
/**
 * Created by PhpStorm.
 * User: jian.song
 * Date: 15-4-14
 * Time: 下午10:50
 */
class MFoundlosttype extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    function getAllType(){
        $query = $this->db->get('foundlost_type');
        return $query->result_array();
    }

    function getTotalCount(){
        $query = $this->db->get_where('foundlost_type');
        return $query->num_rows();
    }

    function addType($type_name){
        $this->db->insert('foundlost_type',array('type_name'=>$type_name));
    }

    function delType($id){
        $this->db->delete('foundlost_type', array('id' => $id));
    }
}