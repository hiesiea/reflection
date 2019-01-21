<?php

/**
 * 画面遷移用クラス
 */
class ScreenTransitioner
{
    private $template;
    
    public function __construct($template)
    {
        $this->template = $template;
    }
    
    /**
     * 画面遷移
     * @param type $data
     * @param type $tplFile
     */
    public function transitionScreen($data, $tplFile)
    {
        $this->template->data = $data;
        $this->template->show($tplFile);
    }
}

?>
