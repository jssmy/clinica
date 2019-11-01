<?php
/**
 * Created by PhpStorm.
 * User: jmanihuariy
 * Date: 1/11/2019
 * Time: 10:27
 */

namespace App\Services;


class ApiService
{
    public static function post($data=array(),$URL,$header=array()){
        $curl = curl_init($URL);
        $header = empty($header)?array('Content-Type:application/json'):$header;
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt( $curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
             return response()->json(json_decode($info));
        }
        return response()->json($curl_response);
    }
    public static function  get($URL,$header=array())
    {
        $curl = curl_init($URL);
        $header = empty($header)?array('Content-Type:application/json'):$header;
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt( $curl, CURLOPT_HTTPHEADER, $header);
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            return response()->json($info);
        }

        return response()->json(json_decode($curl_response));
    }

}
