<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link href="style.css" rel="stylesheet">
        <title>福引き</title>
    </head>
    <body>
        <main>
            <img id="tree" src="images/tree.png">
            <audio id="glass">
                <source src="audios/茂みガサガサ.mp3" type="audio/mp3">
            </audio>
            <audio id="bell">
                <source src="audios/クリスマスの鈴.mp3" type="audio/mp3">
            </audio>
            <audio id="dram">
                <source src="audios/ドラムロール.mp3" type="audio/mp3">
            </audio>
            <audio id="end">
                <source src="audios/ジャジャーン.mp3" type="audio/mp3">
            </audio>

            <script>
                var bell;
                let tree = document.getElementById("tree");
                let isLotteryDone = false; // 一度だけ実行されるようにフラグを追加
                var ball; //ボールを表示するimgを格納する
                var h1; //当選差を表示するh1を格納する
                var star; //星を表示するimgを格納する
                var treeType = 0; //クリスマスツリーが動いているかを判断する（0：動いていない　1：動いている）
                var name = "ななし";

                //  変更点  //
                var cancel;  //時間経過で初期状態に戻す処理を格納する
                var canEnter = true;  //エンターキーの操作を有効にする
                var keyCount = 0; //エンターキーを押された回数を格納
                // 原因：3回目以降にクリスマスツリーのアニメーションが止まらない
                //////////////

                window.addEventListener('keydown', Tree); //キー入力を取得

                //  雪のアニメーション  //
                Snow1();

                function Snow1() {
                    var body = document.body.style.backgroundImage = "url('images/snow1.gif')";
                    setTimeout(Snow2, 4500);
                }

                function Snow2() {
                    var body = document.body.style.backgroundImage = "url('images/snow2.gif')";
                }
                
                //  クリスマスツリーのアニメーション  //
                function Tree(e) {
                    if(e.key === "Enter" && treeType == 0 && canEnter == true) {
                        //  変更点  //
                        document.getElementById("glass").play();
                        document.getElementById("glass").loop = true;
                        document.getElementById("bell").play();
                        document.getElementById("bell").loop = true;
                        if(cancel) clearTimeout(cancel);
                        //////////////
                        tree.src = "images/tree.gif";
                        if (ball != null) {
                            ball.src = "";
                            ball.id = "ball_after";
                        }
                        if (h1 != null) {
                            h1.remove();
                            h1.id = "h1_after";
                        }
                        if (star != null) {
                            star.src = "";
                            star.id = "star_after";
                        }
                        treeType = 1;
                        // PHPスクリプトを呼び出して結果を取得

                    }
                    else if (e.key === "Enter" && treeType == 1 && canEnter == true && keyCount == 0) {
                        keyCount += 1;
                        document.getElementById("bell").play();
                        setTimeout(() => {
                            isLotteryDone = false;
                            console.log(keyCount + "回目");
                            //  変更点  //
                            document.getElementById("glass").pause();  
                            document.getElementById("bell").pause();
                            document.getElementById("dram").play();
                            canEnter = false;
                            /////////////
                            tree.src = "images/tree2.png";
                            ball = document.createElement("img");
                            ball.id = "ball";
                            ball.src = "images/ball.gif";
                            ball.width = "1200";
                            ball.height = "700";
                            document.body.appendChild(ball);
                            fetch('get_result.php')
                                .then(response => response.json())
                                .then(data => {
                                    name = data.name;
                                    setTimeout(Result, 3000);
                                })
                                .catch(error => console.error('Error:', error));
                            treeType = 0;
                        }, 1000);
                    }
                }

                //  当選者の名前を表示  //
                function Result() {
                    //  変更点  //
                    document.getElementById("dram").pause();
                    document.getElementById("end").play();
                    /////////////
                    h1 = document.createElement("h1");
                    h1.id = "h1";
                    h1.innerHTML = name + "様<br>おめでとうございます！";
                    document.body.appendChild(h1);
                    Star();
                }
                
                //  星エフェクトを表示  //
                function Star() {
                    star = document.createElement("img");
                    star.id = "star";
                    star.src = "images/star.gif";
                    star.width = "1000";
                    star.height = "500";
                    document.body.appendChild(star);
                    //  変更点  //
                    canEnter = true;
                    cancel = setTimeout(Reset,10000); //時間経過で最初の場面に戻らせる処理
                    /////////////

                    // Enterキーが押されたら再度抽選を行う
                    window.addEventListener('keydown', function (e) {
                        if (e.key === "Enter" && !isLotteryDone) {
                            tree.src = "images/tree.png";
                            if (ball != null) {
                                ball.remove();
                            }
                            if (h1 != null) {
                                h1.remove();
                            }
                            if (star != null) {
                                star.remove();
                            }
                            treeType = 0;

                            // 2回目の抽選が終わったらフラグを更新
                            isLotteryDone = true;

                            keyCount = 0; //エンターキーを押された回数を初期化
                            console.log(keyCount + "回目");
                        }
                    });
                }

                //  変更点  //
                function Reset(){
                    tree.src = "images/tree.png";
                    // if(ball != null) ball.remove();
                    if(ball != null) ball.remove();
                    if(h1 != null) h1.remove();
                    if(star != null) star.remove();
                    isLotteryDone = true;
                    keyCount = 0; //エンターキーを押された回数を初期化
                }
                //////////////

            </script>
        </main>
    </body>
</html>
