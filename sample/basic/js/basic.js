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
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4) {
            if(xhr.status==200) {
                console.log("CORS works!", xhr.responseText);
                var url = JSON.parse(xhr.responseText)['data']['url'];
            } else {
                alert('処理に失敗しました');
            }
        }
    };

    xhr.send();

    // $.ajax({
    //     url: 'https://api-ssl.bitly.com/v3/shorten?access_token=https://api-ssl.bitly.com/v3/shorten?access_token=ACCESS_TOKEN&longUrl=' + window.location.href,
    //     type: 'POST',
    //     contentType: 'application/json; charset=utf-8',
    //     dataType: 'json',
    //     success: function(response) {
    //     	console.log(response);
    //         var result = JSON.parse(response); // Evaluate the J-Son response object.
		// 	alert(result);
    //     }
    // });
}

function onClickInfo() {

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
                alert('処理に失敗しました');
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

// function createContentsWrapper(attrs, i) {
//     var wrapper = document.createElement('div');
//     wrapper.className = 'contents_wrapper';
//     // wrapper.style.display = 'none';
//     var title = document.createElement('p');
//     title.className = "contents_title";
//     title.innerHTML = getTitle(i);
//     wrapper.appendChild(title);
//
//     var subTitle = document.createElement('p');
//     subTitle.className = "contents";
//     subTitle.innerHTML = attrs[i];
//     wrapper.appendChild(subTitle);
//     return wrapper;
// }