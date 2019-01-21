<?php

/**
 * Curl実行用ラッパークラス
 */
class CurlWrapper
{
    /**
     * Curlコマンド実行
     * @param type $url
     * @param type $username
     * @param type $password
     * @param type $header
     * @param type $data
     * @return type
     */
    public static function execCurl($url, $username, $password, $header, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
        $result = curl_exec($ch);
        curl_close($ch);
        
        return $result;
    }
}

?>
