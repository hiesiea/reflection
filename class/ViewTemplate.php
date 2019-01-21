<?php

class ViewTemplate
{
    /**
     * テンプレート表示
     * @param type $tplFile
     */
    public function show($tplFile)
    {
    	// 擬似変数
        $v = $this;
        include(dirname(__FILE__) . "./../template/{$tplFile}");
    }
}

?>
