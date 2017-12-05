/*
 * Basic sample
*/

function addPage(page, book) {

	var id, pages = book.turn('pages');

	// Create a new element for this page
	var element = $('<div />', {});

	// Add the page to the flipbook
	if (book.turn('addPage', element, page)) {

		// Add the initial HTML
		// It will contain a loader indicator and a gradient
		element.html('<div class="gradient"></div><div class="loader"></div>');

		// Load the page
		loadPage(page, element);
	}
}

function loadPage(page, pageElement) {

	// Create an image element

	var img = $('<img />');

	img.mousedown(function(e) {
		e.preventDefault();
	});

	img.load(function() {
		
		// Set the size
		$(this).css({width: '100%', height: '100%'});

		// Add the image to the page after loaded

		$(this).appendTo(pageElement);

		// Remove the loader indicator
		
		pageElement.find('.loader').remove();
	});

	// Load the page

	// img.attr('src', 'pages/' +  page + '.jpg');
}


function loadLargePage(page, pageElement) {
	
	var img = $('<img />');

	img.load(function() {

		var prevImg = pageElement.find('img');
		$(this).css({width: '100%', height: '100%'});
		$(this).appendTo(pageElement);
		prevImg.remove();
		
	});

	// Loadnew page
	
	img.attr('src', 'pages/' +  page + '-large.jpg');
}


function loadSmallPage(page, pageElement) {
	
	var img = pageElement.find('img');

	img.css({width: '100%', height: '100%'});

	img.unbind('load');
	// Loadnew page

	img.attr('src', 'pages/' +  page + '.jpg');
}



// http://code.google.com/p/chromium/issues/detail?id=128488
function isChrome() {

	return navigator.userAgent.indexOf('Chrome')!=-1;

}

function onClickCopy() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", 'https://api-ssl.bitly.com/v3/shorten?access_token=911ea773466eea97753436d412a2c830e7d6c76e&longUrl=' + window.location.href);
    var cancelBtn = document.getElementsByClassName('remodal-cancel')[0];
    var copyBtn = document.getElementById('remodal_copy');
    var okBtn = document.getElementById('remodal_ok');

    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4) {
            if(xhr.status==200) {
                document.getElementById('shorten_url').innerHTML = JSON.parse(xhr.responseText)['data']['url'];
                cancelBtn.style.display = 'inline';
                copyBtn.style.display = 'inline';
                okBtn.style.display = 'none';
            } else {
                document.getElementById('shorten_url').innerHTML = '処理に失敗しました';
                cancelBtn.style.display = 'none';
                copyBtn.style.display = 'none';
                okBtn.style.display = 'inline';
            }

            $('[data-remodal-id=modal]').remodal().open();
        }
    };

    xhr.send();
}

function showErrModal() {
    document.getElementById('shorten_url').innerHTML = '処理に失敗しました';
    var cancelBtn = document.getElementsByClassName('remodal-cancel')[0];
    var copyBtn = document.getElementById('remodal_copy');
    var okBtn = document.getElementById('remodal_ok');
    cancelBtn.style.display = 'none';
    copyBtn.style.display = 'none';
    okBtn.style.display = 'inline';
    $('[data-remodal-id=modal]').remodal().open();
}

function onClickInfo() {
    window.location.href = 'https://github.com/HiroyukTamura/ChalengedBook/blob/master/README.md';
}

function onClickTwitter() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", 'https://api-ssl.bitly.com/v3/shorten?access_token=911ea773466eea97753436d412a2c830e7d6c76e&longUrl=' + window.location.href);
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4) {
            if(xhr.status==200) {
                console.log("CORS works!", xhr.responseText);
                var url = JSON.parse(xhr.responseText)['data']['url'];
                window.location.href = "http://twitter.com/share?url=" + url;
            } else {
                showErrModal();
            }
        }
    };

    xhr.send();
}

function onClickFb() {
    window.location.href = "http://www.facebook.com/plugins/like.php?href=" + window.location.href;
}

function onClickLine() {
    window.location.href = "http://line.me/R/msg/text/?" + window.location.href;
}

function getTitle(i) {
    switch (i){
        case 0:
            return '病気の概要';
        case 1:
            return '症状の内容';
        case 2:
            return 'お願いしたい配慮';
        case 3:
            return '当事者について';
        case 4:
            return '';

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

function init() {
    // var errDiv = document.getElementById('err_div');

    var flipBook = document.getElementsByClassName('flipbook')[0];
    // var loadingImg = document.getElementsByClassName('center_img')[0];
    var clipboard = new Clipboard('#remodal_copy');

    var key = getParameterByName('key');
    if (!key) {
        document.title = 'エラー';
        // loadingImg.style.display = 'none';
        showErrModal();
        return;
    }

    firebase.database().ref('books/' + key).once('value').then(function (snapshot) {
        if (!snapshot.exists()) {
            // document.getElementById('placeholder').style.display = 'none';
            // errDiv.style.display = 'inline';
            console.log('error 124');
            document.title = 'エラー';
            // loadingImg.style.display = 'none';
            showErrModal();
            return;
        }

        var name = snapshot.child('name').val();
        document.title = name + 'さんのトリセツ';
        document.getElementById('title').innerHTML = snapshot.child('name').val() + "さんの<br>トリセツ";
        document.getElementById('sub_title').innerHTML = 'Written at ' + snapshot.child('date').val();

        //var json = <?php //echo $json = json_encode($value, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>// ;
        var json = [];
        json[0] = snapshot.child('aboutDisease').val();
        json[1] = snapshot.child('detailDisease').val();
        json[2] = snapshot.child('consideration').val();
        json[3] = snapshot.child('aboutMe').val();
        json[4] = snapshot.child('msg').val();

        console.log(json);

        var i = 0;

        json.forEach(function (value) {
            value = value.replace('\n', '<br>');
        });

        while (i < 5) {
            console.log(json[i]);

            if (!json[i]) {
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

            if (wrapper.clientHeight < 600) {

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
                while (wrapper.clientHeight + 100 > 600) {
                    str = str.slice(0, -5);
                    content.innerHTML = str;
                    console.log(wrapper.clientHeight);
                }

                //残りの文字を配列に格納し直す
                json[i] = json[i].slice(str.length + 1);
                str = json[i];

                while (json[i].length !== 0) {
                    console.log('162' + str);

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

                    while (innerDivS.clientHeight + 100 > 600) {
                        str = str.slice(0, -5);
                        content.innerHTML = str;
                        console.log('うむ！' + wrapper.clientHeight);
                    }

                    json[i] = json[i].slice(str.length);
                    str = json[i];
                }

                i++;
            }
        }

        //本は偶数ページ数でなければいけないから、その場合は1頁増やす
        if (flipBook.childNodes.length % 2 === 0) {
            flipBook.insertAdjacentHTML('beforeend', "<div style=\"background-image:url(../pages/screen1.png)\"></div>");
            console.log('まさかの');
        }

        flipBook.insertAdjacentHTML('beforeend', "<div class=\"hard\" style=\"background-color : #f2f2f2\"></div>" +
            "\n" +
            "<div class=\"hard\" style=\"background-color : #f2f2f2\"></div>");

        // loadingImg.style.display = 'none';
        document.getElementById('socials').style.visibility = 'visible';

        // Create the flipbook
        $('.flipbook').turn({
            width:922,
            height:600,
            elevation: 50,
            gradients: true,
            autoCenter: true
        });

        flipBook.style.visibility = 'visible';
    });
}

function initFirebase() {
    var config = {
        apiKey: "AIzaSyBQnxP9d4R40iogM5CP0_HVbULRxoD2_JM",
        authDomain: "wordsupport3.firebaseapp.com",
        databaseURL: "https://wordsupport3.firebaseio.com",
        projectId: "wordsupport3",
        storageBucket: "wordsupport3.appspot.com",
        messagingSenderId: "60633268871"
    };
    firebase.initializeApp(config);
}