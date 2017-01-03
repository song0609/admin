<?php
/**
 * Created by PhpStorm.
 * User: jian.song
 * Date: 15-4-8
 * Time: 下午7:17
 */
class MParttime extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    function addParttime($data){
        $this->db->insert('parttime',$data);
    }

    function getRecord(){
        $this->db->where('is_display',1);
        $query = $this->db->get('parttime');
        return $query->result_array();
    }

    function getRecordById($id){
        $query = $this->db->get_where('parttime', array('id'=>$id));
        return $query->result_array();
    }

    function delRecordById($id){
        $this->db->delete('parttime', array('id' => $id));
    }

    function updateDisplayState($id,$is_display){
        $data = array(
            'is_display'=>$is_display,
        );
        $this->db->where('id', $id);
        $this->db->update('parttime', $data);
    }

    function getTotalCount(){
        return $this->db->count_all_results('parttime');
    }

    function getPageRecord($offset,$pagesize){
        $this->db->limit($pagesize,$offset);
        $query = $this->db->get('parttime');
        return $query->result_array();
    }
}