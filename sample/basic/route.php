<?php
/**
 * Created by PhpStorm.
 * User: hiroyuki2
 * Date: 2017/12/03
 * Time: 0:43
 */

//header('X-FRAME-OPTIONS:DENY');
//mb_internal_encoding('UTF-8');
//
//$input = file_get_contents('php://input');
//$input = htmlspecialchars($input, ENT_QUOTES,'UTF-8');
//$input =str_replace( "\0", "", $input);
//
//$inputs = explode('&amp;', $input);
//
//
//if(count($inputs) !== 6){
//    kick404();
//}
//
//$value = [];
//for ($i=0; $i<count($inputs); $i++) {
//    $cutStr = mb_substr($inputs[$i], 2);
//    $cutStr = nl2br(urldecode($cutStr));
//    array_push($value, $cutStr);
//}
//
//$date = new DateTime();
//$dateFormatted =  $date->format('Y.m.d');
//
//function kick404(){
//    $redirectUrl = "error404";
//    header("HTTP/1.0 404 Not Found");
//    echo '404 Not Found';
//    exit;
//}
?>

<!DOCTYPE html>
<html lang="en">
<!--[if lt IE 7 ]> <html lang="en" class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="description" content="説明説明ふがふがほじほじ">
    <meta name="keywords" content="キーワード,キーワード">
    <title>WorkSupport3</title>
    <meta name="viewport" content="width = 1050, user-scalable = no" />
</head>

<body>

<div>
    <div id="holder" class="contents_wrapper" >
<!--        <p class="contents_title"></p>-->
<!--        <p class="contents"></p>-->
    </div>
</div>

<div class="flipbook-viewport">
    <div class="container">
        <div class="flipbook">
            <div class="hard" id="title_d">
                <h1 id="title">さんの<br>
                    取扱説明書</h1>
                <p id="sub_title"></p>
                <!--<div id="icon_wrapper">-->
                <img id="icon" src="pics/pencil.png"/>
                <!--</div>-->
            </div>
            <div class="hard" style="background-color : #f2f2f2"></div>
<!--            <div id="page0" style="background-image:url(pages/screen1.png)">-->
<!--                <div class="contents_wrapper" >-->
<!--                    <p class="contents_title">--><?php //echo getTitle(1); ?><!--</p>-->
<!--                    <p class="contents">--><?php //echo $value[2]?><!--</p>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div style="background-image:url(pages/2.jpg)"></div>-->
<!--            <div style="background-image:url(pages/3.jpg)"></div>-->
<!--            <div style="background-image:url(pages/4.jpg)"></div>-->
<!--            <div style="background-image:url(pages/5.jpg)"></div>-->
<!--            <div style="background-image:url(pages/6.jpg)"></div>-->
<!--            <div style="background-image:url(pages/7.jpg)"></div>-->
<!--            <div style="background-image:url(pages/8.jpg)"></div>-->
<!--            <div style="background-image:url(pages/9.jpg)"></div>-->
<!--            <div style="background-image:url(pages/10.jpg)"></div>-->
        </div>
    </div>
</div>

<script type="text/javascript" src="../../extras/jquery.min.1.7.js"></script>
<script type="text/javascript" src="../../extras/modernizr.2.5.3.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.2.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.2.0/firebase-database.js"></script>
<script type="text/javascript">

    function loadApp() {

        var config = {
            apiKey: "AIzaSyBQnxP9d4R40iogM5CP0_HVbULRxoD2_JM",
            authDomain: "wordsupport3.firebaseapp.com",
            databaseURL: "https://wordsupport3.firebaseio.com",
            projectId: "wordsupport3",
            storageBucket: "wordsupport3.appspot.com",
            messagingSenderId: "60633268871"
        };
        firebase.initializeApp(config);

        var key = getParameterByName('key');
        if(!key){
            console.log('error 116');
            alert('処理に失敗しました');
            return;
        }

        firebase.database().ref('books/' + key).once('value').then(function(snapshot) {
            if(!snapshot.exists()){
                alert('処理に失敗しました');
                console.log('error 124');
                return;
            }

            document.getElementById('title').innerHTML = snapshot.child('name') + "さんの<br>取扱説明書</h1>";
            document.getElementById('sub_title').innerHTML = 'Written at ' + snapshot.child('date');

            var json = <?php echo $json = json_encode($value, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?> ;
            console.log(json);

            var flipBook = document.getElementsByClassName('flipbook')[0];

            var i=1;

            while (i < 10){
                console.log(json[i]);

                if(!json[i]){
                    i++;
                    console.log('きゃっちされました');
                    continue;
                }

                //フレーム作成
                var div = document.createElement('div');
                div.style.backgroundImage = "url('pages/screen1.png')";
                flipBook.appendChild(div);
                var innerDiv = document.createElement('div');
                div.appendChild(innerDiv);

                //コンテンツ作成
                var wrapper = makeContentsWrapper(getTitle(i), json[i]);
                innerDiv.appendChild(wrapper);

                if(wrapper.clientHeight < 600){

                    i++;

                    // while (i <json.length -1){
                    //
                    //     if(!json[i]){
                    //         i++;
                    //         console.log('きゃっちされました');
                    //         continue;
                    //     }
                    //
                    //     var nextWrapper = makeContentsWrapper(getTitle(i), json[i]);
                    //     innerDiv.appendChild(nextWrapper);
                    //     console.log(nextWrapper.parentElement.clientHeight);
                    //
                    //     var count = 0;
                    //     if(nextWrapper.parentElement.clientHeight >= 600) {
                    //         console.log('innerDiv.clientHeight >= 600' + json[i]);
                    //         nextWrapper.parentNode.removeChild(nextWrapper);
                    //         count++;
                    //         if(count > 100){
                    //             alert('処理に失敗しました');
                    //             return;
                    //         }
                    //         break;
                    //     }
                    //
                    //     i++;
                    // }

                } else {
                    console.log('こっちやね');

                    //ひとコンテンツではみ出してしまう。よって、分割が必要だ。
                    var str = json[i];
                    var content = wrapper.getElementsByClassName('contents')[0];
                    while (wrapper.clientHeight + 100 > 600){
                        str = str.slice(0, -5);
                        content.innerHTML = str;
                        console.log(wrapper.clientHeight);
                    }

                    //残りの文字を配列に格納し直す
                    json[i] = json[i].slice(str.length+1);
                    str = json[i];

                    while (json[i].length !== 0){
                        console.log('162'+str);

                        //枠組みとなるdivを生成
                        var divS = document.createElement('div');
                        divS.style.backgroundImage = "url('pages/screen1.png')";
                        // divS.className = 'contents_wrapper';
                        var innerDivS = document.createElement('div');
                        innerDivS.className = 'contents_wrapper';
                        divS.appendChild(innerDivS);

                        //コンテンツを格納
                        var strS = json[i];
                        var contentExtra = document.createElement('p');
                        contentExtra.className = 'contents';
                        contentExtra.innerHTML = strS;
                        innerDivS.appendChild(contentExtra);

                        //本体にappend
                        flipBook.appendChild(divS);

                        while (innerDivS.clientHeight +100 > 600){
                            str = str.slice(0, -5);
                            content.innerHTML = str;
                            console.log('うむ！'+ wrapper.clientHeight);
                        }

                        json[i] = json[i].slice(str.length);
                        str = json[i];
                    }

                    i++;
                }
            }

            //本は偶数ページ数でなければいけないから、その場合は1頁増やす
            if(flipBook.childNodes.length %2 === 0){
                flipBook.insertAdjacentHTML('beforeend', "<div style=\"background-image:url(pages/screen1.png)\"></div>");
                console.log('まさかの');
            }

            flipBook.insertAdjacentHTML('beforeend', "<div class=\"hard\" style=\"background-color : #f2f2f2\"></div>" +
                "\n" +
                "<div class=\"hard\" style=\"background-color : #f2f2f2\"></div>");


            // Create the flipbook
            $('.flipbook').turn({
                width:922,
                height:600,
                elevation: 50,
                gradients: true,
                autoCenter: true

            });
        });
    }

    // Load the HTML4 version if there's not CSS transform
    yepnope({
        test : Modernizr.csstransforms,
        yep: ['../../lib/turn.js'],
        nope: ['../../lib/turn.html4.min.js'],
        both: ['css/basic.css'],
        complete: loadApp
    });

    function getTitle(i) {
        switch (i){
            case 1:
                return '病気の概要';
            case 2:
                return '症状の内容';
            case 3:
                return 'お願いしたい配慮';
            case 4:
                return '当事者について';
            case 5:
                return 'お願い';

            default:
                return null;
        }
    }

    function makeContentsWrapper(titleStr, contentStr) {
        var wrapper = document.createElement('div');
        wrapper.className = 'contents_wrapper';

        var title = document.createElement('p');
        title.className = 'contents_title';
        title.innerHTML = titleStr;

        var content = document.createElement('p');
        content.className = 'contents';
        content.innerHTML = contentStr;

        wrapper.appendChild(title);
        wrapper.appendChild(content);

        return wrapper;
    }

    // function hedgeHoge(json, i, str, holder, pageCont) {
    //     console.log('hogehoge');
    //     str = json[i].slice(str.length);
    //
    //     holder.innerHTML = '';
    //     var contentD = document.createElement('p');
    //     contentD.className = 'contents';
    //     contentD.innerHTML = str;
    //
    //     if(holder.clientHeight < 600){
    //         console.log('ここ');
    //         pageCont.push(holder);
    //
    //     } else {
    //         console.log('こっち');
    //         while (holder.clientHeight > 600){
    //             str = str.slice(0, -5);
    //             contentD.innerHTML = str;
    //             console.log(holder.clientHeight);
    //         }
    //
    //         pageCont.push(holder);
    //
    //         hedgeHoge(json, i, str, holder, pageCont);
    //     }
    // }

    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        console.log(url);
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }
</script>

</body>
</html>
