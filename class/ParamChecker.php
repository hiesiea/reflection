<?php

/**
 * パラメータチェック用クラス
 */
class ParamChecker
{
    /**
     * 日付チェック
     * @param type $date
     * @return type
     */
    public static function isValidDate($date)
    {
        // 日付を細かく分割
        list($year, $month, $day) = explode(StringDefines::SEPARATOR_DATE, $date);
        
        // 日付と時間それぞれをチェック
        return (checkdate($month, $day, $year));
    }
    
    /**
     * 文字列が空白でないかどうかチェック
     * @param type $str
     * @return type
     */
    public static function isNotEmpty($str)
    {
        return !empty($str);
    }
    
    /**
     * 文字数チェック
     * @param type $str
     * @return boolean
     */
    public static function checkStrlen($str)
    {
        if (mb_strlen($str, "UTF-8") >= 100) {
            return true;
        } else {
            return false;
        }
    }
}

?>
