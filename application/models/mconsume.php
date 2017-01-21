<?php

class MConsume extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    public function saveConsumeData($data){
        $this->db->insert('consume',$data);
    }
}