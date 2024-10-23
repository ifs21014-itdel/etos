<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


if (!function_exists('match_search')) {

    function match_search($prefix, $data) {
        $str = "";

        foreach ($data as $dt) {
            if ($dt->op == 'contains') {
                $str .= " and " . $prefix . $dt->field . " ilike '%" . $dt->value . "%'";
            }
        }
        return $str;
    }

}

if (!function_exists('empty_to_null')) {

    function empty_to_null($param) {
        return empty($param) ? null : $param;
    }

}

if (!function_exists('result_json_encode_parse')) {

    function result_json_encode_parse($total, $result) {
        return json_encode(
                array(
                    "total" => $total,
                    "rows" => $result
                )
        );
    }

}
?>
