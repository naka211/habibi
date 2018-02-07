<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    function getNumUser(){
        $CI = &get_instance();
        $CI->load->database();
        $query = $CI->db->select('*')->from('user')->get()->num_rows();
        return $query;
    }
    function getNumContent(){
        $CI = &get_instance();
        $CI->load->database();
        $query = $CI->db->select('*')->from('content_content')->get()->num_rows();
        return $query;
    }
    function getNumContentStatic(){
        $CI = &get_instance();
        $CI->load->database();
        $query = $CI->db->select('*')->from('content_static')->get()->num_rows();
        return $query;
    }
    function getNumProduct(){
        $CI = &get_instance();
        $CI->load->database();
        $query = $CI->db->select('*')->from('product_product')->get()->num_rows();
        return $query;
    }
    function priceFormat($price,$symbol='DKK'){
    	$decimalPlace = 2;
        $decimalPoint = ',';
        $thousandPoint = '.';
    	$string = number_format(round($price, (int)$decimalPlace), (int)$decimalPlace, $decimalPoint, $thousandPoint);
        $string = str_replace(',00',',-',$string);
    	if($symbol){
      		$string = $string." ".$symbol;
    	}
    	return $string;
    }
?>