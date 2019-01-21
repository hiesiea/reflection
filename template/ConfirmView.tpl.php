<!DOCTYPE html>
<html>
<head>
    <title>内省くん</title>
    <meta charset="UTF-8">
</head>
<body>
    <?php
    $row = $v->data;
    
    // 確認画面の見出し文字を表示
    switch ($row[StringDefines::TAG_NAME_OP_TYPE]) {
        case StringDefines::OP_TYPE_INSERT:
            echo '<h3>' . StringDefines::CONFIRM_VIEW_TITLE_INSERT . '</h3>';
            break;
        case StringDefines::OP_TYPE_UPDATE:
            echo '<h3>' . StringDefines::CONFIRM_VIEW_TITLE_UPDATE . '</h3>';
            break;
        case StringDefines::OP_TYPE_DELETE:
            echo '<h3>' . StringDefines::CONFIRM_VIEW_TITLE_DELETE . '</h3>';
            break;
        default :
            break;
    }
    ?>

    <!--登録フォーム-->
    <form action="./MainController.php" method="post">
        日時：<?php echo $row[StringDefines::COLUMN_NAME_DATE]; ?>
        <br />
        出来事：<?php echo $row[StringDefines::COLUMN_NAME_CONTENTS]; ?>
        <br />
        <?php echo '<input type="hidden" name="'
                . StringDefines::COLUMN_NAME_ID . '" value="'
                . $row[StringDefines::COLUMN_NAME_ID] . '" />'; ?>
        <?php echo '<input type="hidden" name="'
                . StringDefines::COLUMN_NAME_DATE . '" value="'
                . $row[StringDefines::COLUMN_NAME_DATE] . '" />'; ?>
        <?php echo '<input type="hidden" name="'
                . StringDefines::COLUMN_NAME_CONTENTS . '" value="'
                . $row[StringDefines::COLUMN_NAME_CONTENTS] . '" />'; ?>
        <?php echo '<input type="hidden" name="'
                . StringDefines::TAG_NAME_OP_TYPE . '" value="'
                . $row[StringDefines::TAG_NAME_OP_TYPE] . '" />'; ?>
        <?php echo '<input type="submit" name="'
                . StringDefines::TAG_NAME_CONFIRM_OK . '" value="確定" />'; ?>
        <?php echo '<input type="submit" name="'
                . StringDefines::TAG_NAME_CONFIRM_CANCEL . '" value="キャンセル" />'; ?>
    </form>
</body>
</html>
