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

function showAttrs() {
	// if(attrs.length ===
	// 	return;
    //
    // for (var i=0; i<10; i++){
     //    if(i === 1){
     //        alert("うまし");
     //        var wrapper = createContentsWrapper(attrs, i);
     //        document.getElementById('page0').appendChild(wrapper);
     //    }
	// }
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