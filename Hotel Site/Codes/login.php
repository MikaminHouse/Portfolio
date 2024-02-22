<!DOCTYPE html>
<html>
    <head>
        <title>ログインページ</title>
        <link href = "style.css" rel = "stylesheet">
        <script src="script.js"></script>
    </head>
    <body>
        <?php
            session_start();
            require("dbconnect.php");
        ?>
        <?php
            // 利用者のログイン処理
            $query = "SELECT メールアドレス,パスワード FROM hotel_gest";
            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_all($result);
            for($i = 0; $i < count($row); $i++){
                for($j = 0; $j < count($row[$i]); $j++){
                    if($_GET['email'] == $row[$i][$j] and $_GET['pass'] == $row[$i][$j+1]){
                        $count = 1;
                    }
                }
            }
            // 管理者のログイン処理
            $query = "SELECT ID,パスワード FROM hotel_host";
            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_all($result);
            for($i = 0; $i < count($row); $i++){
                for($j = 0; $j < count($row[$i]); $j++){
                    if($_GET['email'] == $row[$i][$j] and $_GET['pass'] == $row[$i][$j+1]){
                        $count = 2;
                    }
                }
            }
            if($count == 0){
                echo '<p class = "error_text">メールアドレス、またはパスワードが間違っているか、存在していません</p>';
            }
            else if($count == 1){  //ログインできたら実行
                $_SESSION['gest_email'] = $_GET['email'];  //利用者用のメールアドレスを格納
                $_SESSION['gest_pass'] = $_GET['pass'];  //利用者用のパスワードを格納
                $_SESSION['session_type'] = "member_session";  //会員情報を保存する処理を行う為の数値
                require("information_session.php");  //会員情報を保存
                header("Location:top_page.php");  //トップページに移動
            }
            else if($count == 2){
                $_SESSION['host_email'] = $_GET['email'];  //利用者用のメールアドレスを格納
                $_SESSION['host_pass'] = $_GET['pass'];  //利用者用のパスワードを格納
                header("Location:top_page.php");  //トップページに移動
            }
            
        ?>
    </body>
</html>