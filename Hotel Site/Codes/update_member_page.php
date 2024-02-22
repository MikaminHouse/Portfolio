<!DOCTYPE html>
<html>
    <head>
        <title>会員情報ページ</title>
        <link href = "style.css" rel = "stylesheet">
        <script src="script.js"></script>
    </head>
    <body>
        <?php
            session_start();
            require("dbconnect.php");
        ?>
        <?php
            //  トップページに移動  //
            if($_GET['back']){
                if($_SESSION['host_email']){
                    header("Location:all_member_page.php");
                }
                else{
                    header("Location:top_page.php");
                }
            }
            //  変更処理  //
            if($_GET['update']){
                if($_SESSION['gest_email']){
                    $_SESSION['update_type'] = "gest_member";
                }
                else if($_SESSION['host_email']){
                    $_SESSION['update_type'] = "host_member";
                }
                require("update.php");
            }
            //  退会ページに移動  //
            if($_GET['delete']){
                $_SESSION['delete_type'] = "gest_member";
                header("Location:delete_page.php");
            }

        ?>
        <h2>会員情報ページ</h2>
        <?php
            if($_SESSION['gest_email']){
                $query = "SELECT メールアドレス,パスワード,苗字,名前,生年月日,年齢,性別,住所,電話番号（自宅）,電話番号（携帯） FROM hotel_gest WHERE メールアドレス = '".$_SESSION['gest_email']."'";
            }
            if($_SESSION['host_email']){
                $query = "SELECT メールアドレス,パスワード,苗字,名前,生年月日,年齢,性別,住所,電話番号（自宅）,電話番号（携帯） FROM hotel_gest WHERE 会員番号 = '".$_SESSION['update_number']."'";
            }
            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_all($result);        
        ?>
        <table>
            <tr>
                <th>メールアドレス</th><th>パスワード</th><th>苗字</th><th>名前</th><th>生年月日</th><th>年齢</th><th>性別</th><th>住所</th><th>電話番号（自宅）</th><th>電話番号（携帯）</th>
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
        <br>
        <br>
        <form method = "GET" id = "member_form">
            <lable for = "email">メールアドレス</lable>
            <input type = "email" name = "email" value = <?php echo $_SESSION['gest1'];?>>
            <br>
            <lable for = "pass">パスワード</lable>
            <input type = "text" name = "pass" value = <?php echo $_SESSION['gest2'];?>>
            <br>
            <lable>苗字</lable>
            <input type = "text" name = "name1" value = <?php echo $_SESSION['gest3'];?>>
            <br>
            <lable>名前</lable>
            <input type = "text" name = "name2" value = <?php echo $_SESSION['gest4'];?>>
            <br>
            <lable for = "birth">生年月日</lable>
            <input type = "text" name = "birth" value = <?php echo $_SESSION['gest5'];?>>
            <br>
            <lable for = "age">年齢</lable>
            <input type = "text" name = "age" value = <?php echo $_SESSION['gest6'];?>>
            <br>
            <lable for = "gender">性別</lable>
            <input type = "text" name = "gender" value = <?php echo $_SESSION['gest7'];?>>
            <br>
            <lable for = "address">住所</lable>
            <input type = "text" name = "address" value = <?php echo $_SESSION['gest8'];?>>
            <br>
            <lable for = "tel_home1">電話番号（自宅）</lable>
            <input type = "tel" name = "tel_home" value = <?php echo $_SESSION['gest9'];?>>
            <small>例）123-456-7890 ※半角数字</small>
            <br>
            <lable for = "tel_phone">電話番号（携帯）</lable>
            <input type = "tel" name = "tel_phone" value = <?php echo $_SESSION['gest10'];?>>
            <small>例）123-456-7890 ※半角数字</small>
            <br>
            <input type = "submit" name = "update" value = "変更する">
            <?php
                //  管理者がログインしている時は表示しない  //
                if($_SESSION['host_email']){
                    ;
                }
                else if($_SESSION['gest_email']){
                    echo '<input type = "submit" name = "delete" value = "退会する">';
                }
            ?>
        </form>
        <form method = "GET" class = "back_form">
            <?php
                if($_SESSION['host_email']){
                    echo '<input type = "submit" name = "back" value = "会員一覧ページに戻る">';
                }
                else{
                    echo '<input type = "submit" name = "back" value = "トップページに戻る">';
                }
            ?>
            
        </form>
    </body>
</html>