<?php

defined('BASEPATH') OR exit('No direct script access allowed.');

$config = array(
    'useragent' => 'PHPMailer',
    'protocol' => 'smtp',
    'smtp_host' => 'ssl://smtp.googlemail.com',
    'smtp_port' => 465,
    'smtp_user' => 'crm.boxliving@gmail.com', // here goes your mail 
    'smtp_pass' => 'b0xl1v1ng', // here goes your mail password 
    'mailtype' => 'html',
    'charset' => 'iso-8859-1',
    'wordwrap' => TRUE,
    'newline' => "\r\n"
);
