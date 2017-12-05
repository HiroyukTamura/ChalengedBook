<?php
/**
 * Created by PhpStorm.
 * User: hiroyuki2
 * Date: 2017/12/03
 * Time: 0:43
 */

header('Access-Control-Allow-Origin: "https://api-ssl.bitly.com/v3/shorten"');

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
    <link rel="stylesheet" type="text/css" href="css/basic.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <style type="text/css">
        .fa {
            margin: 5px;
            color: #FF6D3B;
            cursor: pointer;
            font-size: large;
        }

        .fa:hover {

        }

        .fa:before {
            margin: 0 4px;
            text-transform: none;
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            line-height: 1;
            speak: none;
            -webkit-font-smoothing: antialiased;
        }

        .fa span {
            display: none;
            position: absolute;
            font-size: 1em;
            padding: 0.5em 0 0 0.25em;
            font-weight: 700;
        }

        .fa:hover span {
            display: block;
            color: #6a7b7e;
        }
    </style>
</head>

<body>

<div id="socials" style="margin: 20px;">
    <i class="fa fa-info-circle" aria-hidden="true" onclick="onClickInfo()"><span>info</span></i>
    <i class="fa fa-clone" aria-hidden="true" onclick="onClickCopy()"><span>urlをコピー</span></i>
    <i class="fa fa-twitter" onclick="onClickTwitter()"><span>twitter</span></i>
    <i class="fa fa-facebook-official" onclick="onClickFb()"><span>facebook</span></i>
    <i class="fa fa-comment" aria-hidden="true" onclick="onClickLine()"><span>line</span></i>
</div>

<div class="flipbook-viewport">
    <div class="container">
        <div class="flipbook">
            <div class="hard" id="title_d">
                <h1 id="title"></h1>
                <p id="sub_title"></p>
                <!--<div id="icon_wrapper">-->
                <img id="icon" src="pics/pencil.png"/>
                <!--</div>-->
            </div>
            <div class="hard" style="background-color : #f2f2f2"></div>
            <!--            <div style="background-image:url(pages/2.jpg)"></div>-->
            <!--            <div style="background-image:url(pages/3.jpg)"></div>-->
        </div>
    </div>
</div>

<script type="text/javascript" src="../../extras/jquery.min.1.7.js"></script>
<script type="text/javascript" src="../../extras/modernizr.2.5.3.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.2.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.2.0/firebase-database.js"></script>
<script src="https://apis.google.com/js/api.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="js/basic.js"></script>
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

            document.getElementById('title').innerHTML = snapshot.child('name').val() + "さんの<br>トリセツ</h1>";
            document.getElementById('sub_title').innerHTML = 'Written at ' + snapshot.child('date').val();

            //var json = <?php //echo $json = json_encode($value, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>// ;
            var json = [];
            json[0] = snapshot.child('aboutDisease').val();
            json[1] = snapshot.child('detailDisease').val();
            json[2] = snapshot.child('consideration').val();
            json[3] = snapshot.child('aboutMe').val();
            json[4] = snapshot.child('msg').val();

            console.log(json);

            var flipBook = document.getElementsByClassName('flipbook')[0];

            var i=0;

            json.forEach(function (value) {
                value = value.replace('\n', '<br>');
            });

            while (i < 5){
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
</script>

</body>
</html>
