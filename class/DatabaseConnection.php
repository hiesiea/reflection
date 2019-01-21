<?php

class DatabaseConnection
{
    private $db;

    public function __construct()
    {
        $this->db = null;
    }

    /**
     * DBオブジェクトの取得
     * @param type $iniArray
     * @return type
     */
    public function getDbObject($iniArray)
    {
        try {

            //使用するDB名を取得
            $useDb = $iniArray['select_db'];

            // 設定ファイルの内容から、DSNの生成
            $dsn = $this->generateDsn($iniArray[$useDb]);

            $this->db = new PDO($dsn, $iniArray[$useDb]['username'],
                    $iniArray[$useDb]['passwd']);

            // テーブルが無ければ作る
            $this->createTableIfNotExists($iniArray[$useDb]['driver']);
            return $this->db;
        } catch(PDOException $e) {
            echo "データベースにアクセスできません" . $e->getMessage();
            exit;
        }
    }

    /**
     * DBクローズ
     */
    public function close()
    {
        $this->db = null;
    }

    private function generateDsn($useDb)
    {
        switch ($useDb['driver']) {
            case 'sqlite':
                return $useDb['driver'] . ':' . $useDb['dbname'];
            case 'mysql':
                return $useDb['driver'] . ':host=' . $useDb['host'] . ';dbname='
                    . $useDb['dbname'] .';port=' . $useDb['port'] . ';charset='
                    . $useDb['charset'];
            default :
                return '';
        }
    }

    private function createTableIfNotExists($driver)
    {
        // ドライバの種類によってCREATE文が違うので分岐
        switch ($driver) {
            case 'sqlite':
                $this->db->query(
                        "CREATE TABLE IF NOT EXISTS `"
                        . StringDefines::TABLE_NAME_CONTENTS_LIST
                        . "` ( `" . StringDefines::COLUMN_NAME_ID
                        . "` INTEGER primary key autoincrement, `"
                        . StringDefines::COLUMN_NAME_DATE . "` TEXT NOT NULL, `"
                        . StringDefines::COLUMN_NAME_CONTENTS . "` TEXT NOT NULL, `"
                        . StringDefines::COLUMN_NAME_RESULT . "` TEXT NOT NULL)"
                );
                break;
            case 'mysql':
                $this->db->query(
                        "CREATE TABLE IF NOT EXISTS `" .
                        StringDefines::TABLE_NAME_CONTENTS_LIST
                        . "` ( `" . StringDefines::COLUMN_NAME_ID
                        . "` INTEGER primary key auto_increment, `"
                        . StringDefines::COLUMN_NAME_DATE . "` TEXT NOT NULL, `"
                        . StringDefines::COLUMN_NAME_CONTENTS . "` TEXT NOT NULL, `"
                        . StringDefines::COLUMN_NAME_RESULT . "` TEXT NOT NULL)"
                );
                break;
            default :
                break;
        }
    }
}

?>
