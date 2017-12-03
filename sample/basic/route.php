<?php
/**
 * Created by PhpStorm.
 * User: hiroyuki2
 * Date: 2017/12/03
 * Time: 0:43
 */

$input = file_get_contents('php://input');

$inputs = explode('&', $input);
for ($i=0; $i<count($inputs); $i++) {
    $value = mb_substr($inputs[$i], 2);
} ?>

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
    <script type="text/javascript" src="../../extras/jquery.min.1.7.js"></script>
    <script type="text/javascript" src="../../extras/modernizr.2.5.3.min.js"></script>
</head>
<body>

<div class="flipbook-viewport">
    <div class="container">
        <div class="flipbook">
            <div class="hard" id="title_d">
                <h1 id="title"><?php echo $value[0]; ?>さんの<br>
                    取扱説明書</h1>
                <p id="sub_title">Written at 2017.11.30</p>
                <!--<div id="icon_wrapper">-->
                <img id="icon" src="pics/pencil.png"/>
                <!--</div>-->
            </div>
            <div class="hard">Turn.js</div>
            <div style="background-image:url(pages/screen1.png)">
                <div class="contents_wrapper" >
                    <p class="contents_title">病名</p>
                    <p class="contents">ADHD, 気分変調性障害</p>
                </div>
            </div>
            <div style="background-image:url(pages/2.jpg)"></div>
            <div style="background-image:url(pages/3.jpg)"></div>
            <div style="background-image:url(pages/4.jpg)"></div>
            <div style="background-image:url(pages/5.jpg)"></div>
            <div style="background-image:url(pages/6.jpg)"></div>
            <div style="background-image:url(pages/7.jpg)"></div>
            <div style="background-image:url(pages/8.jpg)"></div>
            <div style="background-image:url(pages/9.jpg)"></div>
            <div style="background-image:url(pages/10.jpg)"></div>
            <div style="background-image:url(pages/11.jpg)"></div>
            <div style="background-image:url(pages/12.jpg)"></div>
        </div>
    </div>
</div>


<script type="text/javascript">

    function loadApp() {

        // Create the flipbook

        $('.flipbook').turn({
            width:922,
            height:600,
            elevation: 50,
            gradients: true,
            autoCenter: true

        });

        // var atters = [];
        // showAttrs(atters);
    }

    window.addEventListener('resize', function (e) {
        var size = resize(el);
        $(el).turn('size', size.width, size.height);
    });

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
