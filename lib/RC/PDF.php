<?php
/**
 * Created by PhpStorm.
 * User: amaton
 * Date: 9/16/15
 * Time: 18:55
 */

//load the tcpdf library
include_once BP . DS . 'lib' . DS . 'tcpdf' . DS . 'tcpdf.php';

//Extending TCPDF classs for autoload
class RC_PDF extends TCPDF
{

} 