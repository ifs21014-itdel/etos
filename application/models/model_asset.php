<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_asset
 *
 * @author Bernovan Munte <bernovanmunte@gmail.com>
 */
class model_asset extends MY_Model {

    public $table_name = "asset";
    public $table_alias = "t";
    public $queryString = "
        select
                t.*
        from asset t
        where true
        ";
    public $fieldMap = array();
    public $fieldKeyWordSearch = array();
    public $total = 0;

    public function __construct() {
        parent::__construct();
    }

}
