function enable_imageset() {
	if(document.getElementById('enable').checked == true){
		document.getElementById('smack-container').style.display='';
	}
	else{
		document.getElementById('smack-container').style.display='none';
	}
}

function disable_imageset() {
	if(document.getElementById('disable').checked == true){
		document.getElementById('smack-container').style.display='none';
	}
	else{
		document.getElementById('smack-container').style.display='';
	}
}
