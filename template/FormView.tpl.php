<!DOCTYPE html>
<html>
<head>
    <title>内省くん</title>
    <meta charset="UTF-8">
</head>
<body>
    <h3>
        ★一日の一コマを記録
        <br />
        日時と出来事を入力してください
    </h3>
    <!--登録フォーム-->
    <form action="./MainController.php" method="post">
        <?php $row = $v->data; ?>
        <?php echo '<input type="hidden" name="' . StringDefines::COLUMN_NAME_ID
                . '" value="' . $row[StringDefines::COLUMN_NAME_ID] . '" />'; ?>
        日時：
        <?php echo '<input type="date" name="' . StringDefines::COLUMN_NAME_DATE
                . '" value="' . $row[StringDefines::COLUMN_NAME_DATE] . '" />'; ?>
        <br />
        出来事（100文字以上）：
        <br />
        <?php echo '<textarea name="' . StringDefines::COLUMN_NAME_CONTENTS
                . '" rows="50" cols="200">'
                . $row[StringDefines::COLUMN_NAME_CONTENTS] . '</textarea>'; ?>
        <br />
        <?php echo '<input type="hidden" name="' . StringDefines::TAG_NAME_OP_TYPE
                . '" value="' . $row[StringDefines::TAG_NAME_OP_TYPE] . '" />'; ?>
        <?php echo '<input type="submit" name="' . StringDefines::TAG_NAME_FORM_OK
                . '" value="確定" />'; ?>
        <?php echo '<input type="submit" name="' . StringDefines::TAG_NAME_FORM_CANCEL
                . '" value="キャンセル" />'; ?>
    </form>
</body>
</html>
