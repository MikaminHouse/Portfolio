<!DOCTYPE html>
<html>
    <head>
        <title>予約情報ページ</title>
        <link href = "style.css" rel = "stylesheet">
        <script src="script.js"></script>
    </head>
    <body id = "gest_promise_body">
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
                header("Location:room_page.php");
            }
            //  退会処理  //
            if($_GET['delete']){
                $_SESSION['delete_type'] = "gest_promise";  //予約の削除処理を行う
                $_SESSION['delete_number'] = $_GET['radio'];  //選択したラジオボタンの値を格納
                header("Location:delete_page.php");
            }

        ?>
        <h2>予約情報ページ</h2>
        <?php
            //  ログインしている会員の会員番号と一致する予約内容を抽出する  //
            $query = "SELECT 予約番号,予約日,予約時間,宿泊人数,部屋名,部屋タイプ名 FROM hotel_appointment INNER JOIN hotel_room ON 部屋 = 部屋番号 INNER JOIN hotel_roomtype ON 部屋タイプ = 部屋タイプ番号 WHERE ゲスト番号 = '".$_SESSION['gest0']."'";
            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_all($result);        
        ?>
        <form method = "GET">
            <table id = "promise_table">
                <tr>
                    <th></th><th>予約日</th><th>予約時間</th><th>宿泊人数</th><th>部屋名</th><th>部屋タイプ名</th>
                </tr>
                <?php
                    for($i = 0; $i < count($row); $i++){
                        echo '<tr>
                            <td><input type = "radio" name = "radio" value = "'.$row[$i][0].'"></td>';
                        for($j = 1; $j < count($row[$i]); $j++){
                            echo '<td>'.$row[$i][$j].'</td>';
                        }
                        echo '</tr>';
                    }
                ?>
            </table>
            <input type = "submit" name = "insert" value = "予約する"> 
            <input type = "submit" name = "delete" value = "削除する"> 
        </form>
        <form method = "GET" class = "back_form">
            <input type = "submit" name = "back" value = "トップページに戻る"> 
        </form>
    </body>
</html>