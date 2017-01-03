<?php
/**
 * Created by PhpStorm.
 * User: jian.song
 * Date: 15-4-14
 * Time: 下午10:50
 */
class MFoundlostmessage extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    /**
     * @param $type_id 分类id
     * @return 符合条件的拾获信息
     */
    function getFoundMessageByType($type_id){
        $query = $this->db->get_where('foundlost_message', array('type_id'=>$type_id,'found_or_lost'=>1,'is_display'=>1));
        return $query->result_array();
    }

    /**
     * @param $type_id 分类id
     * @return 符合条件的寻物信息
     */
    function getLostMessageByType($type_id){
        $query = $this->db->get_where('foundlost_message', array('type_id'=>$type_id,'found_or_lost'=>0,'is_display'=>1));
        return $query->result_array();
    }

    /**
     * @param $data 表单数据
     */
    function addMessage($data){
        $this->db->insert('foundlost_message',$data);
    }

    function getFoundOrLostMessage($found_or_lost,$offset,$pagesize){
        $this->db->limit($pagesize,$offset);
        //$query = $this->db->get_where('foundlost_message', array('found_or_lost'=>$found_or_lost));
        $this->db->select('foundlost_message.*,type_name');
        $this->db->from('foundlost_message');
        $this->db->join('foundlost_type', 'foundlost_message.type_id = foundlost_type.id');
        $this->db->where('found_or_lost', $found_or_lost);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getTotalCount($found_or_lost){
        $query = $this->db->get_where('foundlost_message', array('found_or_lost'=>$found_or_lost));
        return $query->num_rows();
    }

    function updateDisplayState($id,$state){
        $data = array(
            'is_display'=>$state,
        );
        $this->db->where('id', $id);
        $this->db->update('foundlost_message', $data);
    }

    function delRecordById($id){
        $this->db->delete('foundlost_message', array('id' => $id));
    }

    function isTypeExists($type_id){
        $query = $this->db->get_where('foundlost_message', array('type_id'=>$type_id));
        return $query->num_rows();
    }
}