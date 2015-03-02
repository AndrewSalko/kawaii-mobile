
//======== Digital Ocean Promo link
var digitalOcean=" | Hosted in <a target=\'_blank\' rel=\"nofollow\" style=\'font-weight:bold;text-decoration:underline\' href=\'https://www.digitalocean.com/?refcode=3a2a2bb76e2c\'>DigitalOcean Cloud. Get $10 bonus upon signup. </a>";

var aElements=document.getElementsByTagName("a");
for(i=0; i<aElements.length; i++)
{
    var test=aElements[i];
    var attrib=test.getAttribute("rel");
    if(attrib!=null && attrib=="publisher")
    {
        //alert(digitalOcean);
        test.insertAdjacentHTML("afterend", digitalOcean);
        break;
    }
}

