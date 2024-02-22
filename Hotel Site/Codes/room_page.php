<!DOCTYPE html>
<html>
    <head>
        <title>ルームページ</title>
        <link href = "style.css" rel = "stylesheet">
        <script src="script.js"></script>
    </head>
    <body id = "room_page">
        <?php
            session_start();
            require("dbconnect.php");
        ?>
        <?php
            if($_GET['insert']){
                $_SESSION['room_number'] = $_GET['room_number'];
                header("Location:insert_promise_page.php");
            }
            if($_GET['back']){
                //  ログインしていたらトップページに戻る  //
                if($_SESSION['gest_email'] || $_SESSION['host_email']){
                    if($_SESSION['room_back'] == "all_promise"){
                        header("Location:all_promise_page.php");
                    }
                    else if($_SESSION['room_back'] == "gest_promise"){
                        header("Location:gest_promise_page.php");
                    }
                    else{
                        header("Location:top_page.php");
                    }
                }
                //  ログインしていなかったらホームページに戻る  //
                else{
                    header("Location:index.php");
                }
            }
        ?>
        <h2>ルームページ</h2>
        <?php
            // 部屋情報のデータベースを取得して部屋情報を表示 //
            $query = "SELECT 部屋名,案内文,宿泊料金,部屋タイプ名,最大宿泊人数 FROM hotel_room INNER JOIN hotel_roomtype ON 部屋タイプ = 部屋タイプ番号";
            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_all($result);
            // 部屋情報のデータベースを取得して部屋情報を表示 //
            $img_query = "SELECT 部屋画像メイン,部屋画像1,部屋画像2,部屋画像3 FROM hotel_room";
            $img_result = mysqli_query($db, $img_query);
            $img = mysqli_fetch_all($img_result);

            $query = "SELECT 部屋番号 FROM hotel_room";
            $result = mysqli_query($db, $query);
            $num = mysqli_fetch_all($result);
        ?>
        <form method = "GET">
            <?php
                for($i = 0; $i < count($row); $i++){
                    echo '<h2>'.$row[$i][0].'</h2>';
                    echo '<p>'.$row[$i][1].'</p>';
                    for($j = 0; $j < count($img[$i]); $j++){
                        //  メイン画像のみ大きいサイズで表示する  //
                        if($j == 0){
                            echo '<img src = "'.$img[$i][$j].'" width = "500" height = "350"><br>';
                        }
                        //  画像のパスがある場合だけ画像を表示  //
                        else if($img[$i][$j] != ""){
                            echo '<img src = "'.$img[$i][$j].'" width = "200" height = "150">';
                        }
                    }
                    echo '<p>・宿泊料金：'.$row[$i][2].'</p>';
                    echo '<p>・部屋タイプ名：'.$row[$i][3].'</p>';
                    echo '<p>・最大宿泊人数：'.$row[$i][4].'</p>';
                    // $num = $i + 1;  //部屋番号と同じ数値をhiddenのvalueに格納する
                    echo '<input type = "hidden" name = "room_number" value = "'.$num[$i][0].'">';
                    echo '<input type = "submit" name = "insert" value = "予約する">';
                }
            ?>
        </form>



        <form method = "GET" class = "back_form">
            <?php
                //  ログインしていたらトップページへのリンクボタンにする  //
                if($_SESSION['gest_email'] || $_SESSION['host_email']){
                    if($_SESSION['room_back'] == "all_promise"){
                        echo '<input type = "submit" name = "back" value = "部屋一覧ページに戻る">';
                    }
                    else if($_SESSION['room_back'] == "gest_promise"){
                        echo '<input type = "submit" name = "back" value = "部屋情報ページに戻る">';
                    }
                    else{
                        echo '<input type = "submit" name = "back" value = "トップページに戻る">';
                    }
                }
                //  ログインしていなかったらホームページへのリンクボタンにする  //
                else{
                    echo '<input type = "submit" name = "back" value = "ホームページに戻る">';
                }
            ?>
        </form>
    </body>
</html>