<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_bank_account
 *
 * @author operational
 */
class model_bank_account extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function get($company_id = 0) {

        $query = "
            select bank_account.*,bank.code bank_code,bank.name bank_name,bank.swift,currency.code currency_code,company.name company_name
            from bank_account
            join bank on bank_account.bankid=bank.id
            join company on bank_account.companyid=company.id
            join currency on bank_account.currencyid=currency.id
            where true
        ";

        if ($company_id != 0) {
            $query .= " and bank_account.companyid=" . $company_id;
        }
        $query .= " order by bank_account.id desc ";

        //echo $query;

        $page = $this->input->post('page');
        $rows = $this->input->post('rows');
        $result = array();
        $data = "";
        if (!empty($page) && !empty($rows)) {
            $offset = ($page - 1) * $rows;
            $result['total'] = $this->db->query($query)->num_rows();
            $query .= " limit $rows offset $offset";
            $result = array_merge($result, array('rows' => $this->db->query($query)->result()));
            $data = json_encode($result);
        } else {
            $data = json_encode($this->db->query($query)->result());
        }
        return $data;
    }

    function selectAllResult() {
        return $this->db->get('bank_account')->result();
    }

    function insert($data) {
        return $this->db->insert('bank_account', $data);
    }

    function update($data, $where) {
        return $this->db->update('bank_account', $data, $where);
    }

    function delete($where) {
        return $this->db->delete('bank_account', $where);
    }

}
