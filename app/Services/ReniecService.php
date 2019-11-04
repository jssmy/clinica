<?php
/**
 * Created by PhpStorm.
 * User: jmanihuariy
 * Date: 1/11/2019
 * Time: 10:22
 */

namespace App\Services;
use App\Services\ApiService as api;

class ReniecService
{
    const API_URL="http://api.ateneaperu.com/api/Reniec/Dni?sNroDocumento=";

    public static function getPersona( $numero_documento){
        return api::get(SELF::API_URL.$numero_documento);
    }


}
