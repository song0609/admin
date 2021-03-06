<?php
/**
 * Created by PhpStorm.
 * User: jian.song
 * Date: 15-4-16
 * Time: 下午4:10
 */
class MFinance extends CI_Model{
    public function __construct(){
        parent::__construct();
    }


    public function getTotalCount($opts=array()){
        if(!empty($opts['id'])){
            $this->db->where('id',$opts['id']);
        }
        if(!empty($opts['client_id'])){
            $this->db->where('client_id',$opts['client_id']);
        }
        $query = $this->db->get_where('finance', array());
        return $query->num_rows();
    }

    public function getFinanceList($offset,$pagesize,$opts=array()){
        $this->db->limit($pagesize,$offset);
        if(!empty($opts['id'])){
            $this->db->where('id',$opts['id']);
        }
        if(!empty($opts['client_id'])){
            $this->db->where('client_id',$opts['client_id']);
        }
        $this->db->from('finance');
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        return $query->result_array();
    }

    public function saveFinance($data){
        $this->db->insert('finance',$data);
        $this->load->model(array('MThirdPlatform'),'',TRUE);
        $opts = array(
            'client_id'=>$data['client_id'],
            'third_platform'=>$data['third_platform'],
        );
        $p_data = array(
            'client_id'=>$data['client_id'],
            //'third_platform'=>$data['third_platform'],
            'total_account'=>$data['money'],
        );
        $record = $this->MThirdPlatform->getThirdPlatformList(0,1,$opts);
        if($record){
            $p_data['total_account'] = $record[0]['total_account'] + $data['money'];
            $this->MThirdPlatform->updateThirdPlatform($p_data);
        }else{
            $this->MThirdPlatform->saveThirdPlatform($p_data);
        }
    }

    public function updateFinance($data,$id){
        $this->db->where('id', $id);
        $this->db->update('finance', $data);
    }
}