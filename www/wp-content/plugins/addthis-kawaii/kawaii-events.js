jQuery(document).ready(function() 
{
	jQuery('a').each(function() 
	{
		var a = jQuery(this);
		var href = a.attr('href');
		
		// Check if the a tag has a href, if not, stop for the current link
		if ( href == undefined )
			return;
		
		var url = href.replace('http://','').replace('https://','');
		var hrefArray = href.split('.').reverse();
		var extension = hrefArray[0].toLowerCase();
		var hrefArray = href.split('/').reverse();
		var domain = hrefArray[2];
	
		//add tracking custom image resolutions
		if(url.indexOf("custom-image")>=0)
		{
			var urlParts=url.split('/').reverse();
			var resolut=urlParts[0];

			a.click(function() 
			{				
				ga('send', 'event', resolut, 'custom-image', url);
			});
		}

		// If the link is external
	 	if ( ( href.match(/^http/) ) && ( !href.match(document.domain) )  ) 
		{
	    	// Add the tracking code
			a.click(function() 
			{
				ga('send', 'event', 'Outbound Traffic', href.match(/:\/\/(.[^/]+)/)[1], href);
			});
		}
	});
});