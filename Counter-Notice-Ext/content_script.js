(function()
{	
	var urls=[
		"http://kawaii-mobile.com/2014/06/divergence-eve/divergence-eve-misaki-kureha-ipod-5-wallpaper-640x1136-2/"
	];


	var getContainer = function() 
	{
		var container = document.getElementById("canvas_frame");
		if(!container) {
			container = document.body;
		}
		return container;
	};

	var getContainerDocument = function() 
	{
		var container = getContainer();
		var doc = null;
		if(container.contentDocument) 
		{
			// If an iframe get iframe document
			doc = container.contentDocument;
		}
		else 
		{
			// Otherwise just get the main document
			doc = document;
		}

		return doc;
	}

	var doc = getContainerDocument();

	function GetAppendURL(urlToAdd)
	{
		return '<div class="additional-textbox"><input maxlength="1000" name="material_location" value="'+urlToAdd+'" type="text"></div>';
	}


	function fillDCMA()
	{
		firstNameInput=$('#full_name');
		firstNameInput.val('ANDRII SALKO');

		addrText=$('textarea#address');
		addrText.val('Biblika street, 2-G, fl.105, Kharkiv, Ukraine');

		emailInput=$('#contact_email_noprefill');
		emailInput.val('andrewsalko@gmail.com');

		phoneInput=$('#phone');
		phoneInput.val('+380506381780');
		
		textDescript=$('textarea#dmca_clarifications');
		textDescript.val('On these pages and throughout the site, never place the video or audio material protected by copyright.Also, there are no links to illegal torrent files. These pages do not contain materials for sale, and are a form of materials for anime review.');

		//"MM/ДД/РРРР"
		signDateInput=$('#signature_date');
		now = new Date();
		monthNow=now.getMonth() + 1;
		dayNow=now.getDate();
		yearNow=now.getFullYear()
		fullDt=monthNow + '/' + dayNow + '/' +yearNow;

		signDateInput.val(fullDt);

		signatureInput=$('#signature');
		signatureInput.val('ANDRII SALKO');

		countrySelector=$('#country_residence');		
		countrySelector.val('UA');
		countrySelector.change();


		fairUseCheck=$('#dmca_clarifications_intro--counternotice\\.clarify_fairuse');
		fairUseCheck.prop('checked', true);

		$('#consent_statement1--dmca_consent_statement').prop('checked', true);
		$('#consent_statement2--dmca_consent_statementtwo').prop('checked', true);

		firstLink=$('.field input#material_location');
		firstLink.val(urls[0]);
			
		parDiv=$('.field input#material_location').closest('div');        	
		
		//add more links
		for(q = 1; q<urls.length; q++)
		{
			parDiv.append(GetAppendURL(urls[q]));
		}		
		
		alert("Done!");
	}

	$(getContainerDocument()).ready(function()
	{		
		fillDCMA();					
	});

})();