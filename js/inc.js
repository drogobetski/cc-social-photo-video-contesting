// JavaScript Document


// Popup in center of screen
function centerPop(URLtoOpen, windowName, wwidth, wheight)
	{
	var leftPos = 0
	if (screen) {
		leftPos = ((screen.width - wwidth)/2)
		}
	var topPos = 0
	if (screen) {
		topPos = ((screen.height - wheight)/2)
		}
	newWindow=window.open(URLtoOpen,windowName,'width='+wwidth+',height='+wheight+',left='+leftPos+',top='+topPos+',scrollbars=no,noresize'					
	)
}


// Close Popup and Reload Main Window
function closeReload()
	{
	var reloadLoc = opener.location.href+'?z='+Math.floor(Math.random()*11);
	opener.location.href = reloadLoc;
	window.close("pop");
}


// Limit number of characters in a text field
function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}


// Limit number of words in a text field
function limitWords(limitField, limitCount, limitNum) {
	var formcontent = limitField.value;
	formcontent=formcontent.split(" ");
	if (formcontent.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - formcontent.length;
	}
	
}
