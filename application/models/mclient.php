<?php
/**
 * Created by PhpStorm.
 * User: jian.song
 * Date: 15-4-16
 * Time: 下午4:10
 */
class MClient extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    function getClientByUsername($username){
        $query = $this->db->get_where('client', array('username'=>$username));
        echo $this->db->sql();exit;
        return $query->result_array();
    }


}