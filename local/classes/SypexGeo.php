<?php

namespace classes;
class SypexGeo
{
    protected $key = 'dxetl';
    protected $url = 'http://api.sypexgeo.net/dxetl/json/';

    public function get_info($ip){

        if($this->is_bot()){
            return false;
        }

        $info_json = $this->curl_post($this->url . $ip );

        $info = $info_json;

        if($info->error){
            return $info->error;
        }

        return $info;

    }

    /**
     * Простой POST на основе CURL
     * @param $url
     * @param array $arHeaders
     * @return mixed
     */

    protected function curl_post($url, $arHeaders = [])
    {
        $response = false;

        $ch = curl_init();

        if (!empty($url)) {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            if (!empty($arHeaders))
                curl_setopt($ch, CURLOPT_HTTPHEADER, $arHeaders);
            $response = curl_exec($ch);
            curl_close($ch);
        }
        return $response;

    }

    protected function is_bot(){
        return empty($_SERVER['HTTP_USER_AGENT']) || preg_match(
                "~(Google|Yahoo|Rambler|Bot|Yandex|Spider|Snoopy|Crawler|Finder|Mail|curl|request|Guzzle|Java)~i",
                $_SERVER['HTTP_USER_AGENT']
            );
    }
}