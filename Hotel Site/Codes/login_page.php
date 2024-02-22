<!DOCTYPE html>
<html>
    <head>
        <title>ログインページ</title>
        <link href = "style.css" rel = "stylesheet">
        <script src="script.js"></script>
    </head>
    <body id = "login_body">
        <?php
            //  ログイン処理  //
            if($_GET['login']){
                require("login.php");
            }
            //  会員登録ページに移動  //
            if($_GET['insert_page']){
                header("Location:insert_member_page.php");
            }
            //  ホームページに移動  //
            if($_GET['back']){
                header("Location:index.php");
            }
        ?>
        <h2>ログインページ</h2>
        <form method = "GET">
            <div id = "login_form">
                <label for = "email">Eメール</label><input type = "text" name = "email" class = "email_text">
                <label for = "pass">パスワード</label><input type = "text" name = "pass" class = "pass_text">
            </div>
            <div id = "login_button">
                <input type = "submit" name = "login" value = "ログイン">
                <input type = "submit" name = "insert_page" value = "会員登録ページ">
            </div>
            <input type = "submit" name = "back" value = "ホームページに戻る"> 
        </form>
    </body>
</html>