<html>
    <head>
        <title>データベース接続処理ページ</title>
        <link href = "style.css" rel = "stylesheet">
        <script src="script.js"></script>
    </head>
    <body>

        <?php
            $localhost = 'localhost';  //ホスト名
            $user = 'a2211013hi';  //ユーザー名
            $user_pass = '445Hi470';  //パスワード
            $db_name = 'a2211013hi';  //データベース名
            // MySQLサーバーに接続する
            $db = mysqli_connect($localhost, $user, $user_pass);
            // "a2211013hi"データベースに接続する
            mysqli_select_db($db, $db_name);
        ?>
    </body>
</html>
            