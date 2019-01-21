<?php

/**
 * 文字列定義用クラス
 */
class StringDefines
{
    // テンプレート名
    const TEMPLATE_NAME_CONFIRM = 'ConfirmView.tpl.php';
    const TEMPLATE_NAME_FORM = 'FormView.tpl.php';
    const TEMPLATE_NAME_HITOSHI_LIFE = 'ContentsView.tpl.php';
    
    // タグのname属性
    const TAG_NAME_FORM_CONTENTS = 'form-contents';
    const TAG_NAME_FORM_CONFIRM = 'form-confirm';
    const TAG_NAME_FORM_UPDATE = 'form-update';
    const TAG_NAME_FORM_INSERT = 'form-insert';
    const TAG_NAME_FORM_OK = 'form-ok';
    const TAG_NAME_FORM_CANCEL = 'form-cancel';
    const TAG_NAME_CONFIRM_OK = 'confirm-ok';
    const TAG_NAME_CONFIRM_CANCEL = 'confirm-cancel';
    const TAG_NAME_SELECTED_ID = 'selected-id';
    const TAG_NAME_DEKIGOTO = 'dekigoto';
    const TAG_NAME_OP_TYPE = 'op-type';
    
    // テーブル名
    const TABLE_NAME_CONTENTS_LIST = 'contents_list';
    
    // カラム名
    const COLUMN_NAME_ID = 'id';
    const COLUMN_NAME_DATE = 'date';
    const COLUMN_NAME_CONTENTS = 'contents';
    const COLUMN_NAME_RESULT = 'result';
    
    // 操作種別
    const OP_TYPE_INSERT = 'op-insert';
    const OP_TYPE_UPDATE = 'op-update';
    const OP_TYPE_DELETE = 'op-delete';
    
    // 日付フォーマット
    const DATE_FORMAT_YMD = 'Y-m-d';
    
    // 日付セパレータ
    const SEPARATOR_DATE = '-';
    
    // エラー文
    const ERROR_INVALID_DATE =
            '<font color="red">日付が不正です。</font><br />';
    const ERROR_DISTINCT_DATE =
            '<font color="red">すでに同じ日付の出来事が入力されています。</font><br />';
    const ERROR_EMPTY_CONTENTS =
            '<font color="red">出来事が未入力です。</font><br />';
    const ERROR_STRLEN_CONTENTS =
            '<font color="red">出来事の文字数が少なすぎます。</font><br />';
    
    // 確認画面　見出し文字
    const CONFIRM_VIEW_TITLE_INSERT = '以下の情報を追加してもよろしいでしょうか？';
    const CONFIRM_VIEW_TITLE_UPDATE = '以下の情報で更新してもよろしいでしょうか？';
    const CONFIRM_VIEW_TITLE_DELETE = '以下の情報を削除してもよろしいでしょうか？';
    
    // 感情
    const TONES = array(
        'Anger' => '怒り',
        'Fear' => '恐れ',
        'Joy' => '喜び',
        'Sadness' => '悲しみ',
        'Analytical' => '分析的',
        'Confident' => '自信あり',
        'Tentative' => '不確か'
    );
}

?>
