<?php
/**
 * Created by PhpStorm.
 * User: jian.song
 * Date: 15-4-9
 * Time: 下午1:28
 */
class MComments extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    public function addComments($data){
        $this->db->insert('comments',$data);
    }

    public function getCommentsByParttimeId($id){
        $this->db->order_by("create_time", "desc");
        $query = $this->db->get_where('comments', array('part_time_id'=>$id));
        return $query->result_array();
    }

    public function getTotalCommentsByParttimeId($id){
        $query = $this->db->get_where('comments', array('part_time_id'=>$id));
        return $query->num_rows();
    }

    public function getPageRecord($id,$offset,$pagesize){
        $this->db->where('part_time_id',$id);
        $this->db->limit($pagesize,$offset);
        $query = $this->db->get('comments');
        return $query->result_array();
    }

    public function delRecordById($id){
        $this->db->delete('comments', array('id' => $id));
    }
}