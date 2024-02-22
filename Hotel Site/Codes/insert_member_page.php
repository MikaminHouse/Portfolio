<!DOCTYPE html>
<html>
    <head>
        <title>会員登録ページ</title>
        <link href = "style.css" rel = "stylesheet">
        <script src="script.js"></script>
    </head>
    <body>
        <?php
            session_start();
            require("dbconnect.php");
        ?>
        <?php
            //  会員登録処理  //
            if($_GET['insert'] && (($_GET['tel_home1'] && $_GET['tel_home2'] && $_GET['tel_home3']) || ($_GET['tel_phone1'] && $_GET['tel_phone2'] && $_GET['tel_phone3'])) ){
                $_SESSION['insert_type'] = "all_member";  //管理者からの会員情報の登録処理を行うための識別変数
                require("insert.php");
            }
            else{
                echo '<p class = "error_text">携帯か自宅の電話番号を入力してください。</p>';
            }
            //  ホームページに移動  //
            if($_GET['back']){
                //  会員一覧ページに移動  //
                if($_SESSION['host_email']){
                    header("Location:all_member_page.php");
                }
                //  ログインページに移動  //
                else{
                    header("Location:login_page.php");
                }
            }
        ?>
        <h2>会員登録ページ</h2>
        <form method = "GET">
            <label for = "email">メールアドレス*</label>
            <input type = "email" name = "email" required>
            <br>
            <lable for = "pass">パスワード*</lable>
            <input type = "text" name = "pass" required>
            <br>
            <lable>氏名*</lable>
            苗字<input type = "text" name = "name1" required>
            名前<input type = "text" name = "name2" required>
            <br>
            <lable for = "year">生年月日*</lable>
            <select name = "year">
                <?php
                    for($i = 1923; $i < 2024;$i++){
                        echo '<option>'.$i.'</option>';
                    }
                ?>
                </select>年
                <select name = "month">
                <?php
                    for($i = 1; $i < 13;$i++){
                        echo '<option>'.$i.'</option>';
                    }
                ?>
                </select>月
                <select name = "day">
                <?php
                    for($i = 1; $i < 32;$i++){
                        echo '<option>'.$i.'</option>';
                    }
                ?>
            </select>日
            <br>
            <lable for = "age">年齢</lable>
            <input type = "text" name = "age">
            <br>
            <lable for = "gender">性別*</lable>
            <input type = "radio" name = "gender" value = "男性" required>男性
            <input type = "radio" name = "gender" value = "女性" required>女性
            <br>
            <lable for = "address">住所*</lable>
            <input type = "text" name = "address" required>
            <br>
            <lable for = "tel_home1">電話番号（自宅）*</lable>
            <input type = "tel" name = "tel_home1"> - <input type = "tel" name = "tel_home2"> - <input type = "tel" name = "tel_home3">
            <small>例）123-456-7890 ※半角数字</small>
            <br>
            <lable for = "tel_phone">電話番号（携帯）*</lable>
            <input type = "tel" name = "tel_phone1"> - <input type = "tel" name = "tel_phone2"> - <input type = "tel" name = "tel_phone3">
            <small>例）123-456-7890 ※半角数字</small>
            <br>
            <small>※*の付いている項目は入力必須の項目です。必ず入力してください</small>
            <br>
            <small>※電話番号は自宅か携帯のどちらかを必ず入力してください</small>
            <br>
            <input type = "submit" name = "insert" value = "会員登録する">
        </form>

        <form method = "GET" class = "back_form">
            <?php
                //  会員一覧ページに戻る  //
                if($_SESSION['gest_email']){
                    echo '<input type = "submit" name = "back" value = "会員一覧ページに戻る">';
                }
                //  ログインページに戻る  //
                else{
                    echo '<input type = "submit" name = "back" value = "ログインページに戻る">';
                }

            ?>
            
        </form>    
    </body>
</html>