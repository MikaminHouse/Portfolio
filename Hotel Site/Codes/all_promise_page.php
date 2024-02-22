<!DOCTYPE html>
<html>
    <head>
        <title>予約一覧ページ</title>
        <link href = "style.css" rel = "stylesheet">
        <script src="script.js"></script>
    </head>
    <body class = "all_body">
        <?php
            session_start();
            require("dbconnect.php");
        ?>
        <?php
            //  トップページに移動  //
            if($_GET['back']){
                header("Location:top_page.php");
            }
            //  部屋情報ページに移動  //
            if($_GET['insert']){
                $_SESSION['room_back'] = "all_promise";
                header("Location:room_page.php");
            }
            if($_GET['update']){
                $_SESSION['update_number'] = $_GET['select_number'];
                $_SESSION['session_type'] = "promise_session";  //予約情報を保存する処理を行う為の数値
                require("information_session.php");  //予約情報を保存
                header("Location:update_promise_page.php");
            }
            //  退会ページに移動  //
            if($_GET['delete']){
                $_SESSION['delete_type'] = "all_promise";
                $_SESSION['delete_number'] = $_GET['select_number'];  //選択したドロップダウンリストの値(予約番号)を格納
                header("Location:delete_page.php");
            }
        ?>
        <form method = "GET">
            予約番号
            <select name = "select_number">
                <?php
                    $query = "SELECT * FROM hotel_appointment";
                    $result = mysqli_query($db, $query);
                    $row = mysqli_fetch_all($result);
                    for($i = 0; $i < count($row); $i++){
                        echo '<option>'.$row[$i][0].'</option>';
                    }
                ?>
            </select>
            <input type = "submit" name = "insert" value = "登録する">
            <input type = "submit" name = "update" value = "編集する">
            <input type = "submit" name = "delete" value = "削除する">
        </form>
        <h2>予約一覧ページ</h2>
        <?php
            //  ログインしている会員の会員番号と一致する予約内容を抽出する  //
            $query = "SELECT 予約番号,会員番号,予約日,予約時間,宿泊人数,メールアドレス,苗字,住所,電話番号（自宅）,電話番号（携帯）,部屋名,部屋タイプ名 FROM hotel_appointment INNER JOIN hotel_gest ON ゲスト番号 = 会員番号 INNER JOIN hotel_room ON 部屋 = 部屋番号 INNER JOIN hotel_roomtype ON 部屋タイプ = 部屋タイプ番号";
            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_all($result);        
        ?>
        <form method = "GET">
            <table>
                <tr>
                    <th>予約番号</th><th>会員番号</th><th>予約日</th><th>予約時間</th><th>宿泊人数</th><th>メールアドレス</th><th>苗字</th><th>住所</th><th>電話番号（自宅）</th><th>電話番号（携帯）</th><th>部屋名</th><th>部屋タイプ名</th>
                </tr>
                <?php
                    for($i = 0; $i < count($row); $i++){
                        echo '<tr>';
                        for($j = 0; $j < count($row[$i]); $j++){
                            echo '<td>'.$row[$i][$j].'</td>';
                        }
                        echo '</tr>';
                    }
                ?>
            </table>
        </form>
        <form method = "GET" class = "back_form">
            <input type = "submit" name = "back" value = "トップページに戻る"> 
        </form>
    </body>
</html>