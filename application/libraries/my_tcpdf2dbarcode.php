<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once dirname(__FILE__) . '/tcpdf/2dbarcodes.php';

class my_tcpdf2dbarcode extends TCPDF2DBarcode {

    //put your code here
    function __construct() {
        parent::__construct();
    }

}
