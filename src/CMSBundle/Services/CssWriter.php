<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2.4.2017 г.
 * Time: 13:15
 */

namespace CMSBundle\Services;


use CMSBundle\Entity\General;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

class CssWriter
{
    public function writeGeneralCss(General $gs)
    {
        $string = '#body {
    background-image: url("../Uploads/'.$gs->getBgImage().'");
    background-repeat: repeat-y;
    background-position: right top;
    background-size: 100% auto;
    background-attachment: fixed;
';

        if($gs->getBgColor()!=null){
            $string.='  background-color: '.$gs->getBgColor().';
';
        }
    $string.='
}';
    file_put_contents('CSS/general.css',$string);
    }
}