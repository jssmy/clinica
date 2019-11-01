<?php
/**
 * Created by PhpStorm.
 * User: jmanihuariy
 * Date: 31/10/2019
 * Time: 14:12
 */


function esFecha($fecha){
    return preg_match('/\d{4}-\d{2}-\d{2}/', $fecha);
}
