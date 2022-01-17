<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portfolio_model extends CI_Model {


    public function fetchAll()
    {
        $this->db->select('
            tbl_portfolio.id,
            tbl_portfolio.name,
            tbl_portfolio.type_id,
            tbl_portfolio.create_date,
            tbl_portfolio.is_active,
            tbl_type.id AS t_id,
            tbl_type.name AS t_name
        ');
        $this->db->from('tbl_portfolio');
        $this->db->join('tbl_type', 'tbl_portfolio.type_id = tbl_type.id', 'inner');
        $query = $this->db->get();
        return $query->result_array();
    }
    // type_id=1=portfolio,type_id=2=review
    public function fetchPortfolio()
    {
        $this->db->select('*');
        $this->db->from('tbl_portfolio');
        $this->db->where('type_id', '1');
        $this->db->where('is_active', '1');
        $query = $this->db->get();
        return $query->result_array();
    }
    // type_id=1=portfolio,type_id=2=review
    public function fetchReview()
    {
        $this->db->select('*');
        $this->db->from('tbl_portfolio');
        $this->db->where('type_id', '2');
        $this->db->where('is_active', '1');
        $query = $this->db->get();
        return $query->result_array();
    }

    // ex $id=1
    public function getDetail($id)
    {
        // sql proceduce  SELECT * from tbl_portfolio where id=$id
        $this->db->select('*');
        $this->db->from('tbl_portfolio');  // table name
        $this->db->where('id', $id);  // conditon

        $query = $this->db->get();
        return $query->result_array();  // return data array to controller

    }

    public function update_isactive($p_id,$p_st)
    {
        date_default_timezone_set("Asia/Bangkok");
        $cur_date = date("Y-m-d H:i:s");
        
        $data = array(
            'is_active'     => $p_st,
            'update_date'   => $cur_date
        );

        $this->db->where('id', $p_id);
        $this->db->update('tbl_portfolio', $data);
        return $this->db->affected_rows(); 
    }
    public function update($name,$id)
    {
        // field name => value
            $data = array(
            'name'          => $name
            );

        $this->db->where('id', $id);
        $this->db->update('tbl_portfolio', $data);
        return $this->db->affected_rows();  // success true=1, error false=0
    }

    // update image file by id
    public function updatefileUpload($dataArr)
    {
        date_default_timezone_set("Asia/Bangkok");
        $cur_date = date("Y-m-d H:i:s");
        
        $data = array(
            'img_cover'     => $dataArr['image_cover'],
            'update_date'   => $cur_date
        );
        $this->db->where('id', $dataArr['port_id']);
        $this->db->update('tbl_portfolio', $data);
        return $this->db->affected_rows();  // true=1, false=0
    }
}
?>