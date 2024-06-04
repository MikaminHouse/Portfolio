var key;
var table;
var group;
var table_value;
var group_value;
var random_num;
var table_key;
var you_table;
var count = 0;
var count_sum;
var number_count = 0;
var loop_count = 0; //割り振る回数を計算する
var seat_count;
var table_list = {};
var count_list = [];
var number_list = [];
var final;
var final_list = [];
var final_list_key;
var final_table_value;
var final_group_value;

var final_table;
var cell_value;

var search_count = 0;
var search_list = [];
var random_count = 0;
var mode_count = 0;

function next(num) {
    table = document.getElementById("textbox1");
    group = document.getElementById("textbox2");
    table_value = table.value; //テーブル数を取得
    group_value = group.value;  //グループ数を取得  

    // エラーチェック
    if (table_value.match(/^[^\x01-\x7E\xA1-\xDF]+$/) || group_value.match(/^[^\x01-\x7E\xA1-\xDF]+$/)) {
        alert("半角数値で入力してください");
        num = 0;
    }
    if (table_value == "" || group_value == "") {
        alert("半角数字を入力してください");
        num = 0;
    }
    if (isNaN(table_value) == true || isNaN(group_value) == true) {
        alert("数字を入力してください");
        num = 0;
    }
    //
    if (num != 0 && count == 0) {
        final_table_value = table.value;
        final_group_value = group.value;
        count_sum = table_value * group_value;
        count += 1;
        if (mode_count == 2) {
            group_value = Number(group_value);
            number_count = group_value * -1;
        }
    }


    //繰り返す回数を取得(繰り返す回数の変動を防ぐためにif文で記載)  
    if (num == 1) { //「ランダムに割り振るページに変化」
        var len = table_value;
        //テーブルと席を連想配列で作成
        //テーブルを指定する数値を配列で作成
        //生徒番号のリストを作成
        for (var i = 1; i <= len; i++) {
            table_list["table" + i] = 0; //{table1:1,table2:2,table3:3...}
            count_list.push(i); //[1,2,3...]
        }
        for (var f = 0; f <= len - 1; f++) {
            final_list[f] = "ok"; //[1,2,3...]
        }
        for (var i = 1; i <= count_sum; i++) {
            var target = document.getElementById("textbox3");
            i = String(i);
            if (target.value == "スペシャリストコース") {
                number_list[i - 1] = "22110" + i; //[221101,221102,221103...]
                /*
                if(i.length > 1){
                    number_list[i-1] = "2211" + i; //[221101,221102,221103...]
                    alert("ok");
                }
                else{
                    number_list[i-1] = "22110" + i; //[221101,221102,221103...]
                    alert(i.length);
                }
                */
            }
            else if (target.value == "エンジニアコース") {
                number_list[i - 1] = "12110" + i;
                /*
                if(i.length > 1){
                    number_list[i-1] = "1211" + i; 
                }
                else{
                    number_list[i-1] = "12110" + i; 
                }
                */
            }
            else if (target.value == "") {
                if (i.length > 1) {
                    number_list[i - 1] = "No." + i;
                }
                else {
                    number_list[i - 1] = "No.0" + i;
                }
                //number_list[i-1] = i; //[1,2,3...]
            }
        }

        key = Object.keys(table_list); //連想配列のkeyを取得するための関数を作成
        random_num = Math.floor(Math.random() * table_value); //テーブルを指定する数値を指定する数値をランダムに取得（0から始まる）
        table_key = count_list[random_num]; //テーブルを指定する数値を取得
        you_table = table_list["table" + table_key]; //テーブルを指定して取得

        /*
        alert("table_value：" + table_value + "　｜　" + "group_value：" + group_value + "　｜　" + "count_sum：" + count_sum);
        alert("table_list：" + key + "　｜　" + "count_list：" + count_list + "　｜　" + "random_num：" + random_num + "　｜　" + "table_key：" + table_key);
        alert("you_table：" + you_table + "　｜　" + "count_list：" + count_list + "　｜　" + "random_num：" + random_num + "　｜　" + "count_list：" + count_list[random_num]);
        */
        //alert(final_list);

        var target = document.getElementById("table");
        target.style.display = "none";
        target = document.getElementById("text");
        target.style.display = "block";
        document.getElementById("target").innerHTML = "対象：" + number_list[loop_count];
    }
    else if (num == 2 && document.getElementById("mode").value == "") {
        alert("割り振る種類を選択してください");
    }
    else if (num == 2 && random_count == 1) { //「あなたは○のテーブルですのページに変化」
        loop_count += 1;
        var target = document.getElementById("text");
        target.style.display = "none";
        target = document.getElementById("number");
        target.style.display = "block";
        /*
        target = document.getElementsByClassName("p");
        target.style.display = "none";
        target = document.getElementById("h2");
        target.style.display = "block";
        */

        document.getElementById("name").innerHTML = number_list[loop_count - 1] + " は";
        document.getElementById("span").innerHTML = table_key;
        you_table = Number(you_table);
        table_list["table" + table_key] += 1;
        //表の作成
        for (var i = 0; i < final_table.rows.length; i++) {
            for (var j = 0; j < final_table.rows[i].cells.length; j++) {
                cell_value = final_table.rows[i].cells[j].innerHTML;
                if (cell_value == "テーブル" + table_key) {
                    final_table.rows[i + table_list["table" + table_key]].cells[j].innerHTML = number_list[loop_count - 1];
                }
            }
        }
        if (table_list["table" + table_key] == group.value) {
            final = " " + key[random_num] + ":" + table_list["table" + table_key] + " ";
            delete_table = "table" + table_key;
            delete table_list[delete_table];
            key = Object.keys(table_list);
            final_list_key = table_key - 1;
            final_list[final_list_key] = final;
            count_list.splice(random_num, 1);
            table.value -= 1;
            //alert("ok" + " " + table_list["table" + table_key]);
        }
        /*
        else{
            alert("no");
        }
        alert("table_list：" + key + "　｜　" + "count_list：" + count_list + "　｜　" + "table.value：" + table.value + "　｜　" + "loop_count：" + loop_count + "　｜　" + "count_sum：" + count_sum);
        */
    }

    else if (num == 2 && random_count == 2) { //「席が決定しましたのページに変化」　順番に割り振る場合
        // table要素を生成
        final_table = document.createElement('table');
        // tr部分のループ
        for (var i = 0; i <= final_group_value; i++) {
            // tr要素を生成
            var tr = document.createElement('tr');
            // th・td部分のループ
            for (var j = 0; j < final_table_value; j++) {
                // 1行目のtr要素の時
                if (i === 0) {
                    // th要素を生成
                    var th = document.createElement('th');
                    // th要素内にテキストを追加
                    var num = j + 1;
                    th.textContent = "テーブル" + num;
                    // th要素をtr要素の子要素に追加
                    tr.appendChild(th);
                } else {
                    // td要素を生成
                    var td = document.createElement('td');
                    // td要素内にテキストを追加
                    //横に割り振る場合の処理
                    if (mode_count == 1) {
                        td.textContent = number_list[number_count];
                        number_count += 1;
                    }
                    //縦に割り振る場合の処理
                    else if (mode_count == 2) {
                        group_value = Number(group_value);
                        td.textContent = number_list[number_count];
                        number_count += group_value;
                        //alert((j + 1) * i + "　" + table_value * i + "　j:" + j + "　i:" + i)
                        if ((j + 1) * i == table_value * i) {
                            number_count = group_value * -1;
                            number_count += i;
                            number_count += group_value;
                        }
                    }
                    else if (mode_count == 3) {
                        //テーブルを指定する数値を指定する数値をランダムに取得
                        random_num = Math.floor(Math.random() * table_value); //0から始まる
                        td.textContent = number_list[random_num];
                    }
                    // td要素をtr要素の子要素に追加
                    tr.appendChild(td);
                }
            }
            // tr要素をtable要素の子要素に追加
            final_table.appendChild(tr);
        }
        // 生成したtable要素を追加する
        document.getElementById('main_table').appendChild(final_table);
        //alert(table.rows[ 1 ].cells[ 2 ].firstChild.data);

        var target = document.getElementById("text");
        target.style.display = "none";
        target = document.getElementById("main_table");
        target.style.display = "block";
    }
    else if (num == 3 && loop_count != count_sum) { //「ランダムに割り振るページに変化」
        document.getElementById("target").innerHTML = "対象：" + number_list[loop_count];
        //テーブルを指定する数値を指定する数値をランダムに取得
        random_num = Math.floor(Math.random() * table_value); //0から始まる
        //テーブルを指定する数値を取得
        table_key = count_list[random_num];
        //テーブルを指定して取得
        you_table = table_list["table" + table_key];

        /*
        alert("table_value：" + table_value + "　｜　" + "group_value：" + group_value + "　｜　" + "count_sum：" + count_sum);
        alert("table_list：" + key + "　｜　" + "count_list：" + count_list + "　｜　" + "random_num：" + random_num + "　｜　" + "table_key：" + table_key);
        alert("you_table：" + you_table + "　｜　" + "count_list：" + count_list + "　｜　" + "random_num：" + random_num + "　｜　" + "count_list：" + count_list[random_num]);
        */

        var target = document.getElementById("number");
        target.style.display = "none";
        target = document.getElementById("text");
        target.style.display = "block";
        target = document.getElementById("mode");
        target.style.display = "none";
    }
    else if (num == 3 && loop_count === count_sum) { //「席が決定しましたのページに変化」
        var target = document.getElementById("number");
        target.style.display = "none";
        target = document.getElementById("finish");
        target.style.display = "block";
    }
    else if (num == 4) { //「席が決定しましたのページに変化」
        var target = document.getElementById("finish");
        target.style.display = "none";
        target = document.getElementById("main_table");
        target.style.display = "block";
    }
    else if (num == 5) { //「テーブル数とグループ数を入力のページに変化」
        var target = document.getElementById("main_table");
        target.style.display = "none";
        target = document.getElementById("table");
        target.style.display = "block";
        //alert(final_list);
        count_list = [];
        table_list = {};
        final_list = [];
        search_list = [];
        count = loop_count = 0;
        table.value = "";
        group.value = "";
        final_table.remove();
        target = document.getElementById("textbox4");
        target.value = "";
        search_count = 1;
        search();
        target = document.getElementById("mode");
        target.style.display = "block";
        target.value = "none";
        target = document.getElementById("target");
        target.style.display = "none";
        random_count = 0;
        number_count = 0;
        mode_count = 0;
    }
}

//表を作成する関数
function table_make() {
    // table要素を生成
    final_table = document.createElement('table');
    // tr部分のループ
    for (var i = 0; i <= final_group_value; i++) {
        // tr要素を生成
        var tr = document.createElement('tr');
        // th・td部分のループ
        for (var j = 0; j < final_table_value; j++) {
            // 1行目のtr要素の時
            if (i === 0) {
                // th要素を生成
                var th = document.createElement('th');
                // th要素内にテキストを追加
                var num = j + 1;
                th.textContent = "テーブル" + num;
                // th要素をtr要素の子要素に追加
                tr.appendChild(th);
            } else {
                // td要素を生成
                var td = document.createElement('td');
                // td要素をtr要素の子要素に追加
                tr.appendChild(td);
            }
        }
        // tr要素をtable要素の子要素に追加
        final_table.appendChild(tr);
    }
    // 生成したtable要素を追加する
    document.getElementById('main_table').appendChild(final_table);
    //alert(table.rows[ 1 ].cells[ 2 ].firstChild.data);
}



//「検索」ボタンを押すことで検索ボックスの表示・非表示を切り替える関数
function search() {
    var target1 = document.getElementById("textbox4");
    var target2 = document.getElementById("button7");
    if (search_count == 0) {
        target1.className = "ON";
        target2.className = "ON";
        search_count = 1;
    }
    else if (search_count == 1) {
        target1.className = "";
        target2.className = "";
        search_count = 0;
        target1.value = "";
        search_list = [];
        //検索ボックスを非表示にする際に、空欄にして文字列の色を黒色に戻す
        for (var i = 0; i < final_table.rows.length; i++) {
            for (var j = 0; j < final_table.rows[i].cells.length; j++) {
                cell_value = final_table.rows[i].cells[j].innerHTML;
                if (cell_value == target1.value) {
                    final_table.rows[i].cells[j].style.color = "red";
                    final_table.rows[i].cells[j].style.fontWeight = "bold";
                    //final_table.rows[i].cells[j].className = "td_ON";
                }
                else {
                    final_table.rows[i].cells[j].style.color = "black";
                    final_table.rows[i].cells[j].style.fontWeight = "normal";
                    final_table.rows[0].cells[j].style.fontWeight = "bold"; //タイトル行だけはボールドにする
                }
            }
        }
    }
}



//検索ボックスに入力された番号と一致する文字列の色と文字幅を変化させる関数
window.addEventListener('DOMContentLoaded', function search_run() { //検索ボックスに文字が入力される度に実行される
    // input要素を取得
    var target1 = document.getElementById("textbox4");
    // イベントリスナーでイベント「input」を登録
    target1.addEventListener("input", function () {
        for (var i = 0; i < final_table.rows.length; i++) {
            for (var j = 0; j < final_table.rows[i].cells.length; j++) {
                cell_value = final_table.rows[i].cells[j].innerHTML;
                if (cell_value == target1.value) {
                    final_table.rows[i].cells[j].style.color = "red";
                    final_table.rows[i].cells[j].style.fontWeight = "bold";
                    //final_table.rows[i].cells[j].className = "td_ON";
                }
                else {
                    final_table.rows[i].cells[j].style.color = "black";
                    final_table.rows[i].cells[j].style.fontWeight = "normal";
                    final_table.rows[0].cells[j].style.fontWeight = "bold"; //タイトル行だけはボールドにする
                }
                search_list.forEach(function (search_value) {
                    if (cell_value == search_value) {
                        final_table.rows[i].cells[j].style.color = "red";
                        final_table.rows[i].cells[j].style.fontWeight = "bold";
                    }
                    final_table.rows[0].cells[j].style.fontWeight = "bold"; //タイトル行だけはボールドにする
                })
                if (final_table.rows[0].cells[j].style.color == "red") {
                    final_table.rows[i].cells[j].style.color = "red";
                    //alert(final_table.rows[i].cells[j].innerHTML);
                }


            }
        }
    });
})



//検索した文字列を登録して複数の文字列を強調表示させる
function search_add() {
    var target1 = document.getElementById("textbox4");
    search_list.push(target1.value);
    //alert(search_list);
    target1.value = "";
}


//グループをランダムに分けるか、順番に分けるか選ぶ関数
function mode() {
    if (document.getElementById("mode").value == "順番に席を割り振る（横）") {
        var target = document.getElementById("target");
        target.style.display = "none";
        if (random_count == 1) {
            final_table.remove();
        }
        random_count = 2;
        mode_count = 1;
    }
    else if (document.getElementById("mode").value == "順番に席を割り振る（縦）") {
        var target = document.getElementById("target");
        target.style.display = "none";
        if (random_count == 1) {
            final_table.remove();
        }
        random_count = 2;
        mode_count = 2;
    }
    else if (document.getElementById("mode").value == "ランダムに席を割り振る") {
        var target = document.getElementById("target");
        target.style.display = "block";
        if (random_count == 2) {
            random_count = 0;
        }
        if (random_count == 0) {
            table_make();
            random_count = 1;
        }
    }
    else if (document.getElementById("mode").value == "ランダムに席を割り振る（自動）") {
        var target = document.getElementById("target");
        target.style.display = "none";
        if (random_count == 1) {
            final_table.remove();
        }
        random_count = 2;
        mode_count = 3;
    }
    else if (document.getElementById("mode").value == "") {
        var target = document.getElementById("target");
        target.style.display = "none";
        if (random_count == 1) {
            final_table.remove();
        }
        random_count = 0;
    }
}


