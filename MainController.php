<?php

// クラスファイルを読み込み(MAC、LINUXの場合は「\」ではなく「/」であることに注意）
include(dirname(__FILE__) . '//class//ViewTemplate.php');
include(dirname(__FILE__) . '//class//DatabaseConnection.php');
include(dirname(__FILE__) . '//class//SqlExecutor.php');
include(dirname(__FILE__) . '//class//ScreenTransitioner.php');
include(dirname(__FILE__) . '//class//StringDefines.php');
include(dirname(__FILE__) . '//class//ParamChecker.php');
include(dirname(__FILE__) . '//class//CurlWrapper.php');

// 設定ファイル読み込み
$iniArray = parse_ini_file('./config/config.ini', true);

// SQL実行用のクラスのインスタンスを生成
$db = new DatabaseConnection();
$executor = new SqlExecutor($db->getDbObject($iniArray));

// 画面遷移用クラスのインスタンスを生成
$trasitioner = new ScreenTransitioner(new ViewTemplate());

// 確認画面
if (isset(
        $_POST[StringDefines::TAG_NAME_FORM_CONFIRM],
        $_POST[StringDefines::TAG_NAME_SELECTED_ID])) {
    
    // 選択されたIDから情報を取得
    $result = $executor->selectById($_POST[StringDefines::TAG_NAME_SELECTED_ID]);
    $result[StringDefines::TAG_NAME_OP_TYPE] = StringDefines::OP_TYPE_DELETE;
    $trasitioner->transitionScreen($result, StringDefines::TEMPLATE_NAME_CONFIRM);

// 確認OK
} else if (isset(
        $_POST[StringDefines::TAG_NAME_CONFIRM_OK],
        $_POST[StringDefines::COLUMN_NAME_ID],
        $_POST[StringDefines::COLUMN_NAME_DATE],
        $_POST[StringDefines::COLUMN_NAME_CONTENTS],
        $_POST[StringDefines::TAG_NAME_OP_TYPE])) {
    
    // 新規作成時と更新時にToneAnalyzerを実行する
    $result = "";
    if (strcmp($_POST[StringDefines::TAG_NAME_OP_TYPE],
            StringDefines::OP_TYPE_INSERT) === 0
            || strcmp($_POST[StringDefines::TAG_NAME_OP_TYPE],
                    StringDefines::OP_TYPE_UPDATE) === 0) {

        // 内容を英語に翻訳（Tone Analyzerが英語のみ対応しているため）
        $lt = $iniArray['language_translator'];
        $lt_result = CurlWrapper::execCurl(
                $lt['url'],
                $lt['username'],
                $lt['password'],
                array('Accept: application/json'),
                json_encode(
                    array(
                        'text' => $_POST[StringDefines::COLUMN_NAME_CONTENTS],
                        'source' => 'ja',
                        'target' => 'en'
                ))
        );

        // 感情診断
        $ta = $iniArray['tone_analyzer'];
        $ta_result = CurlWrapper::execCurl(
                $ta['url'],
                $ta['username'],
                $ta['password'],
                array('Content-Type: application/json'),
                json_encode(
                    array(
                        'text' => json_decode(
                                $lt_result, true)["translations"][0]["translation"]
                ))
        );
        
        foreach (json_decode($ta_result, true)["document_tone"]["tones"] as $tone) {
            $result .= StringDefines::TONES[$tone["tone_name"]]
                    . ',' . $tone["score"] . " ";
        }
    }

    // DB処理
    $executor->executeByOpType(
            $_POST[StringDefines::TAG_NAME_OP_TYPE],
            $_POST[StringDefines::COLUMN_NAME_ID],
            $_POST[StringDefines::COLUMN_NAME_DATE],
            $_POST[StringDefines::COLUMN_NAME_CONTENTS],
            $result);
    
    // 処理内容を反映
    $trasitioner->transitionScreen($executor->selectAll(),
            StringDefines::TEMPLATE_NAME_HITOSHI_LIFE);
    
// フォーム画面(編集)
} else if (isset(
        $_POST[StringDefines::TAG_NAME_FORM_UPDATE],
        $_POST[StringDefines::TAG_NAME_SELECTED_ID])) {
    
    // 選択された情報を取得
    $result = $executor->selectById($_POST[StringDefines::TAG_NAME_SELECTED_ID]);
    $result[StringDefines::TAG_NAME_OP_TYPE] = StringDefines::OP_TYPE_UPDATE;
    $trasitioner->transitionScreen($result, StringDefines::TEMPLATE_NAME_FORM);

// フォーム画面(新規登録)
} else if (isset($_POST[StringDefines::TAG_NAME_FORM_INSERT])) {
    
    $data = array(
            StringDefines::COLUMN_NAME_ID => '',
            StringDefines::COLUMN_NAME_DATE => date(StringDefines::DATE_FORMAT_YMD),
            StringDefines::COLUMN_NAME_CONTENTS => '',
            StringDefines::TAG_NAME_OP_TYPE => StringDefines::OP_TYPE_INSERT);
    $trasitioner->transitionScreen($data, StringDefines::TEMPLATE_NAME_FORM);

// フォームOK
} else if (isset(
        $_POST[StringDefines::TAG_NAME_FORM_OK],
        $_POST[StringDefines::COLUMN_NAME_ID],
        $_POST[StringDefines::COLUMN_NAME_DATE],
        $_POST[StringDefines::COLUMN_NAME_CONTENTS],
        $_POST[StringDefines::TAG_NAME_OP_TYPE])) {
    
    // 次の遷移先
    $nextScreen = StringDefines::TEMPLATE_NAME_CONFIRM;
    
    // 日付をチェックし、チェックに引っかかればフォーム画面に戻る
    if (ParamChecker::isValidDate($_POST[StringDefines::COLUMN_NAME_DATE]) === false) {
        echo StringDefines::ERROR_INVALID_DATE;
        $nextScreen = StringDefines::TEMPLATE_NAME_FORM;
    }
    
    // 新規作成モードで、過去に同日付のデータが登録されていればフォーム画面に戻る
    if ($_POST[StringDefines::TAG_NAME_OP_TYPE] === StringDefines::OP_TYPE_INSERT
            && $executor->selectByDate($_POST[StringDefines::COLUMN_NAME_DATE]) != false) {
        echo StringDefines::ERROR_DISTINCT_DATE;
        $nextScreen = StringDefines::TEMPLATE_NAME_FORM;
    }

    // コンテンツが未入力であれば、フォーム画面に戻る
    if (ParamChecker::isNotEmpty($_POST[StringDefines::COLUMN_NAME_CONTENTS]) === false) {
        echo StringDefines::ERROR_EMPTY_CONTENTS;
        $nextScreen = StringDefines::TEMPLATE_NAME_FORM;
    }
    
    // コンテンツの文字数が足りなければ、フォーム画面に戻る
    if (ParamChecker::checkStrlen($_POST[StringDefines::COLUMN_NAME_CONTENTS]) === false) {
        echo StringDefines::ERROR_STRLEN_CONTENTS;
        $nextScreen = StringDefines::TEMPLATE_NAME_FORM;
    }
    
    $data = array(
            StringDefines::COLUMN_NAME_ID => $_POST[StringDefines::COLUMN_NAME_ID],
            StringDefines::COLUMN_NAME_DATE => $_POST[StringDefines::COLUMN_NAME_DATE],
            StringDefines::COLUMN_NAME_CONTENTS => $_POST[StringDefines::COLUMN_NAME_CONTENTS],
            StringDefines::TAG_NAME_OP_TYPE => $_POST[StringDefines::TAG_NAME_OP_TYPE]);
    $trasitioner->transitionScreen($data, $nextScreen);

// 管理
} else if (isset(
        $_POST[StringDefines::TAG_NAME_FORM_CONTENTS])) {
    $trasitioner->transitionScreen($executor->selectAll(),
            StringDefines::TEMPLATE_NAME_HITOSHI_LIFE);
} else {
    header('location: index.html');
}

// DBクローズ
$db->close();
$db = null;

?>
