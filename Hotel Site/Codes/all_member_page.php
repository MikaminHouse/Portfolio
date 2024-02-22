<!DOCTYPE html>
<html>
    <head>
        <title>会員一覧ページ</title>
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
            //  会員情報登録ページに移動  //
            if($_GET['insert']){
                header("Location:insert_member_page.php");
            }
            //  会員情報変更ページに移動  //
            if($_GET['update']){
                $_SESSION['update_number'] = $_GET['select_number'];  //選択したドロップダウンリストの値(会員番号)を格納
                $_SESSION['session_type'] = "member_session";  //会員情報を保存する処理を行う為の数値
                require("information_session.php");  //会員情報の保存処理
                header("Location:update_member_page.php");
            }
            //  退会ページに移動  //
            if($_GET['delete']){
                $_SESSION['delete_type'] = "all_member";
                $_SESSION['delete_number'] = $_GET['select_number'];  //選択したドロップダウンリストの値(会員番号)を格納
                header("Location:delete_page.php");
            }
            // //  検索処理  //
            // if($_GET['search']){
            //     require("search.php");
            // }
        ?>
        <!-- <form method = "GET">
            <label for = "target_number">会員番号</label>
            <input type = "text" name = "target_number">
            <label for = "target_email">メールアドレス</label>
            <input type = "text" name = "target_email">
            <label for = "target_pass">パスワード</label>
            <input type = "text" name = "target_pass">
            <label for = "target_name1">苗字</label>
            <input type = "text" name = "target_name1">
            <label for = "target_name2">名前</label>
            <input type = "text" name = "target_name2">
            <label for = "target_address">住所</label>
            <input type = "text" name = "target_address">
            <input type = "submit" name = "search" value = "検索する">
        </form> -->
        <form method = "GET">
            会員番号
            <select name = "select_number">
                <?php
                    $query = "SELECT * FROM hotel_gest";
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
        <h2>会員一覧ページ</h2>
        <?php
            $query = "SELECT * FROM hotel_gest";
            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_all($result);        
        ?>
        <form method = "GET">
            <table>
                <tr>
                    <th>会員番号</th><th>メールアドレス</th><th>パスワード</th><th>苗字</th><th>名前</th><th>生年月日</th><th>年齢</th><th>性別</th><th>住所</th><th>電話番号（自宅）</th><th>電話番号（携帯）</th>
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