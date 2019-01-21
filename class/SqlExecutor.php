<?php

/**
 * SQL実行用クラス
 */
class SqlExecutor
{
    private $dbObj;
    
    public function __construct($dbObj)
    {
        $this->dbObj = $dbObj;
    }
    
    /**
     * IDに該当するものを取得
     * @param type $id
     * @return type
     */
    public function selectById($id)
    {
        $stmt = $this->dbObj->prepare("SELECT * FROM "
                . StringDefines::TABLE_NAME_CONTENTS_LIST . " WHERE "
                . StringDefines::COLUMN_NAME_ID . " = :"
                . StringDefines::COLUMN_NAME_ID);
        $stmt->bindParam(':' . StringDefines::COLUMN_NAME_ID, $id,
                PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * 同じ日付のデータを取得
     * @param type $date
     * @return type
     */
    public function selectByDate($date)
    {
        $stmt = $this->dbObj->prepare("SELECT * FROM "
                . StringDefines::TABLE_NAME_CONTENTS_LIST . " where "
                . StringDefines::COLUMN_NAME_DATE . " = :"
                . StringDefines::COLUMN_NAME_DATE);
        $stmt->bindParam(':' . StringDefines::COLUMN_NAME_DATE, $date,
                PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * 全て取得
     * @return type
     */
    public function selectAll()
    {
        return $this->dbObj->query("SELECT * FROM "
                . StringDefines::TABLE_NAME_CONTENTS_LIST
                . " ORDER BY " . StringDefines::COLUMN_NAME_DATE . " ASC");
    }
    
    /**
     * タイプ指定によるSQL実行
     * @param type $opType
     * @param type $id
     * @param type $date
     * @param type $contents
     * @param type $result
     */
    public function executeByOpType($opType, $id, $date, $contents, $result)
    {
        switch ($opType) {

            // 更新処理
            case StringDefines::OP_TYPE_UPDATE:
                $this->update($id, $date, $contents, $result);
                break;
        
            // 挿入処理
            case StringDefines::OP_TYPE_INSERT:
                $this->insert($date, $contents, $result);
                break;
        
            // 削除処理
            case StringDefines::OP_TYPE_DELETE:
                $this->delete($id);
                break;
            default :
                break;
        }
    }
    
    private function insert($date, $contents, $result)
    {
        $stmt = $this->dbObj->prepare(
                "INSERT INTO " . StringDefines::TABLE_NAME_CONTENTS_LIST . " ("
                . StringDefines::COLUMN_NAME_DATE . ", "
                . StringDefines::COLUMN_NAME_CONTENTS . ", "
                . StringDefines::COLUMN_NAME_RESULT . ") VALUES (:"
                . StringDefines::COLUMN_NAME_DATE . ", :"
                . StringDefines::COLUMN_NAME_CONTENTS . ", :"
                . StringDefines::COLUMN_NAME_RESULT . ")");
        $stmt->bindParam(':' . StringDefines::COLUMN_NAME_DATE, $date,
                PDO::PARAM_STR);
        $stmt->bindParam(':' . StringDefines::COLUMN_NAME_CONTENTS, $contents,
                PDO::PARAM_STR);
        $stmt->bindParam(':' . StringDefines::COLUMN_NAME_RESULT, $result,
                PDO::PARAM_STR);
        $stmt->execute();
    }
    
    private function update($id, $date, $contents, $result)
    {
        $stmt = $this->dbObj->prepare(
                "UPDATE " . StringDefines::TABLE_NAME_CONTENTS_LIST . " SET "
                . StringDefines::COLUMN_NAME_DATE . " = :"
                . StringDefines::COLUMN_NAME_DATE . ", "
                . StringDefines::COLUMN_NAME_CONTENTS . " = :"
                . StringDefines::COLUMN_NAME_CONTENTS . ", "
                . StringDefines::COLUMN_NAME_RESULT . " = :"
                . StringDefines::COLUMN_NAME_RESULT . " WHERE "
                . StringDefines::COLUMN_NAME_ID . " = :"
                . StringDefines::COLUMN_NAME_ID);
        $stmt->bindParam(':' . StringDefines::COLUMN_NAME_ID, $id,
                PDO::PARAM_INT);
        $stmt->bindParam(':' . StringDefines::COLUMN_NAME_DATE, $date,
                PDO::PARAM_STR);
        $stmt->bindParam(':' . StringDefines::COLUMN_NAME_CONTENTS, $contents,
                PDO::PARAM_STR);
        $stmt->bindParam(':' . StringDefines::COLUMN_NAME_RESULT, $result,
                PDO::PARAM_STR);
        $stmt->execute();
    }
    
    private function delete($id)
    {
        $stmt = $this->dbObj->prepare("DELETE FROM "
                . StringDefines::TABLE_NAME_CONTENTS_LIST . " WHERE "
                . StringDefines::COLUMN_NAME_ID . " = :"
                . StringDefines::COLUMN_NAME_ID);
        $stmt->bindParam(':' . StringDefines::COLUMN_NAME_ID, $id,
                PDO::PARAM_INT);
        $stmt->execute();
    }
}

?>
