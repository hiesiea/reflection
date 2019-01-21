<!DOCTYPE html>
<html>
<head>
    <title>内省くん</title>
    <meta charset="utf-8">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    <h1>管理画面</h1>
    <a href="./index.html">TOPに戻る</a>
    <form action="./MainController.php" method="post">
        <?php echo '<input type="submit" name="'
                . StringDefines::TAG_NAME_FORM_UPDATE . '" value="編集" />'; ?>
        <?php echo '<input type="submit" name="'
                . StringDefines::TAG_NAME_FORM_CONFIRM . '" value="削除" />'; ?>
        <table border=1>
            <tr>
                <td>日時</td>
                <td>出来事</td>
                <td>解析結果</td>
                <td>選択</td>
            </tr>
            <?php
                $labels = array();
                $results = array();
                $row = $v->data;
                foreach ($row as $line) {
                    array_push($labels, $line[StringDefines::COLUMN_NAME_DATE]);
                    array_push($results, explode(" ", $line[StringDefines::COLUMN_NAME_RESULT]));
            ?>
            <tr>
                <td><?php echo $line[StringDefines::COLUMN_NAME_DATE]; ?></td>
                <td><?php echo $line[StringDefines::COLUMN_NAME_CONTENTS]; ?></td>
                <td><?php echo $line[StringDefines::COLUMN_NAME_RESULT]; ?></td>
                <td>
                    <?php
                    echo '<input type="radio" name="'
                            . StringDefines::TAG_NAME_SELECTED_ID . '" value="'
                            . $line[StringDefines::COLUMN_NAME_ID] . '" checked="checked" />';
                    ?>
                </td>
            </tr>
            <?php } ?>
        </table>
    </form>
    <script id="labels" src="./js/draw.js" data-param="<?php echo json_encode($labels); ?>;"></script>
    <script id="results" src="./js/draw.js" data-param="<?php echo json_encode($results); ?>;"></script>
    <!--描画領域 -->
    <canvas id="chart"></canvas>
    <script>
        // PHPからデータ受け取り
        let labels = <?php echo json_encode($labels); ?>;
        let results = <?php echo json_encode($results); ?>;
        
        // 各種感情のデータセット（感情をキーとした連想配列）
        let datasets = {
                '怒り': [],
                '恐れ': [],
                '喜び': [],
                '悲しみ': [],
                '分析的': [],
                '自信あり': [],
                '不確か': []
        };
        
        // データ格納
        for (let i = 0; i < results.length; i++) {
            let result = results[i];
            
            // 
            for (let j = 0; j < result.length - 1; j++) {
                let split = result[j].split(",");
                datasets[split[0]].push([split[1]]);
            }
            
            // 
            for (let key in datasets) {
                if (datasets[key].length <= i) {
                    datasets[key].push(0);
                }
            }
        }
        let ctx = document.getElementById('chart').getContext('2d');
        let chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: '怒り',
                    data: datasets['怒り'],
                    backgroundColor: "rgba(255, 0, 0, 0.5)"
                }, {
                    label: '恐れ',
                    data: datasets['恐れ'],
                    backgroundColor: "rgba(0, 255, 0, 0.5)"
                }, {
                    label: '喜び',
                    data: datasets['喜び'],
                    backgroundColor: "rgba(255, 255, 0, 0.5)"
                }, {
                    label: '悲しみ',
                    data: datasets['悲しみ'],
                    backgroundColor: "rgba(0, 0, 255, 0.5)"
                }, {
                    label: '分析的',
                    data: datasets['分析的'],
                    backgroundColor: "rgba(120, 120, 120, 0.5)"
                }, {
                    label: '自信あり',
                    data: datasets['自信あり'],
                    backgroundColor: "rgba(255, 165, 0, 0.5)"
                }, {
                    label: '不確か',
                    data: datasets['不確か'],
                    backgroundColor: "rgba(0, 0, 0, 0.5)"
                }]
            },
            options: {
                title: {
                    display: true,
                    text: '感情分析結果'
                }
            }
        });
    </script>
</body>
</html>
