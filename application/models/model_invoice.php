<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_invoice
 *
 * @author Bernovan Munte <bernovanmunte@gmail.com>
 */
class model_invoice extends MY_Model {

    public $table_name = "invoice";
    public $table_alias = "t";
    public $queryString = "
        select
                t.*,
                t2.order_id,
                t3.code currency_code,
                t4.name client_name,
                t4.company client_company_name,
                bank_account.account_number bank_account_number,bank_account.on_behalf_of,bank_account.bank_address,bank.name bank_name,bank.swift swift_code,c.common_name bank_country_name
        from invoice t
        left join proformainvoice t2 on t.proforma_invoice_id=t2.id
        left join currency t3 on t2.currency_id=t3.id
        left join client t4 on t2.client_id=t4.id
        left join bank_account on t.bank_account_id=bank_account.id
        join bank on bank_account.bankid=bank.id
        join country c on bank_account.countryid=c.id
        where true
        ";
    public $fieldMap = array();
    public $fieldKeyWordSearch = array();
    public $total = 0;

    public function __construct() {
        parent::__construct();
    }

}
