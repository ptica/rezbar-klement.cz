//requestVars start
/*
 * @author      Jesse Berman
 * @copyright   2008-01-31
 * @version     1.0
 * @license     http://www.gnu.org/copyleft/lesser.html
 *
 * Portions by Dieter Raber <dieter@dieterraber.net>
 * copyright   2004-12-27
 *
 * Modifications by Ivo Truxa http://truxoft.com
 * copyright   2009-10-27
*/

/* pwa.js: a drop-in JavaScript utility that displays galleries from picasaweb.google.com in your website */
/* This JavaScript file, when called from a webpage, will load all the thumbnail images of all the galleries
   in a user's Picasa Web Albums account into an HTML table that's 4 rows wide.  Clicking on any of the
   galleries will display thumbnails of all the photos in that gallery, and clicking on any of those thumbnails
   will display the photo.  

   To call this file from your own webpage, use the following syntax:

       <script type="text/javascript">username='YourPicasawebUsername'; photosize='800';</script>
       <script type="text/javascript" src="http://www.yoursite.com/pwa.js"></script>

   Make sure you change YourPicasawebUsername to your actual Picasaweb username.  For more information about
   Picasa, check out picasaweb.google.com.  Also, www.yoursite.com should point to your actual site name, and
   the location of the pwa.js file.  The script looks for the images back.jpg, next.jpg, and home.jpg, in the
   same directory as pwa.js, to create the navigation arrows.  Please make sure those exist!  I'm providing
   samples in the SourceForce repository, but feel free to substitute your own.

   Note: "Photosize" is the size of the image to be displayed when viewing single images.  I like 800.  :-)
   You may omit either this value; if you do, the default settings are 800 for photosize.
*/

// Global variables
var hs;                      // declare hs variable for testing of presence of HigSlide script - if not declared, testing for it returns an error
var photolist = new Array(); // this is used globally to store the entire list of photos in a given album, rather than pass the list around in a URL (which was getting rediculously long as a result)
var album_name = "";         // this is used globally to store the album name, so we don't have to pass it around in the URL anymore either.
var my_numpics = "";         // this is used globally to store the number of items in a particular album, so we don't have to pass it around in the URL anymore either.
var prev = "";               // used in the navigation arrows when viewing a single item
var next = "";               // used in the navigation arrows when viewing a single item
if (!photosize) {var photosize = 800;}

// string variables - can be localized in the calling script, by default set to English
var sViewThis, sGalHome, sOf, sPhotos;
if (!sViewThis)  sViewThis  = ["View this gallery in Picasa","View this album in Picasa","View this image in Picasa"];
if (!sPhotos)    sPhotos    = [" photo or video"," photos or videos"];
if (!sGalHome)   sGalHome   = "gallery home";
if (!sOf)        sOf        = " of ";


// -------------------------------------------------------------------
// shortcut function
// -------------------------------------------------------------------
function w(a){document.write(a);}


// -------------------------------------------------------------------
// parsing the URI
// -------------------------------------------------------------------
function readGet(){
  var _GET = new Array();
  var uriStr  = window.location.href.replace(/&amp;/g, '&');
  var paraSplit;
  if (uriStr.indexOf('?') > -1){
    var uriArr  = uriStr.split('?');
    var paraStr = uriArr[1];
  }else return _GET;
  var paraArr = (paraStr.indexOf('&') > -1) ? paraStr.split('&') : new Array(paraStr);
  for(var i = 0; i < paraArr.length; i++){
    paraArr[i] = paraArr[i].indexOf('=') > -1 ? paraArr[i] : paraArr[i] + '=';
    paraSplit  = paraArr[i].split('=');
    _GET[paraSplit[0]] = decodeURI(paraSplit[1].replace(/\+/g, ' '));
  }
  return _GET;
}
var _GET = readGet();

  
// -------------------------------------------------------------------
// returns the list of all albums for the user
// -------------------------------------------------------------------
function picasaweb(j){ 
 w("<div style='margin-left:3px'>"+sGalHome+"</div><div style='text-align:right; margin-right:5px; margin-top:-14px'><a target=PICASA href='http://picasaweb.google.com/"+username+"/'>" + sViewThis[0] + "</a></div><br>");

 for(var i in j.feed.entry){
    // for each of the albums in the feed, grab its album cover thumbnail and the link to that album,
    var id_begin = j.feed.entry[i].id.$t.indexOf('albumid/')+8;
    var id_end   = j.feed.entry[i].id.$t.indexOf('?');
    var id_base  = j.feed.entry[i].id.$t.slice(id_begin, id_end);
    var img_base = j.feed.entry[i].media$group.media$content[0].url;
    var caption  = j.feed.entry[i].title.$t.replace(/\'/g,"&#39;");
    var descr    = j.feed.entry[i].media$group.media$description.$t.replace(/\'/g,"&#39;");
    if (!descr) descr = caption;

    // converting picasa date format to locale format
    var date   = j.feed.entry[i].published.$t.replace(/-/g,"/");
    var myDate = new Date(date.substring(0,date.indexOf('T')));  
    date = myDate.toLocaleDateString();
    date = date.substring(date.indexOf(' '),date.length);
    
    // getting the number of photos in album - unfortunately only available in the summary HTML code and it comes
    // differently formatted for each locale version of browser :(
    // well, this is neither ideal nor reliable, and may break as soon as Picasa changes the format
    // but better than nothing
    var count = j.feed.entry[i].summary.$t.toLowerCase();
    if (count.indexOf('number of photos in album:')!=-1)
         count = count.substring(count.indexOf('number of photos in album:'),count.length);
    else count = count.substr(count.indexOf('<p><a href')-30,30);
    count = count.substr(count.indexOf('">'), 10);
    count = count.substring(2,count.indexOf('<'));
    if (count == 1)    count = "<br>1" + sPhotos[0];
    else if (count >1) count = "<br>" + count + sPhotos[1];
    else               count = "";

    w("<div class='item' title='"+ caption +"'><a href='?albumid="+id_base+"'><img src='"+img_base+"?imgmax=160&crop=1' alt='"+ descr +"' /><p><b>"+ caption +"</b><br>"+ date + count +"</p></a></div>");
 }
}


// -------------------------------------------------------------------
// This function is called just before displaying an item; it returns info about the item's current state within its parent
// album, such as the name of the album it's in, the index of the photo in that album, and the IDs of the previous and next
// photos in that album (so we can link to them using navigation arrows).  This way we don't have to pass state information
// around in the URL, which was resulting in hellishly long URLs (sometimes causing "URI too long" errors on some servers).
// -------------------------------------------------------------------
function getphotolist(j){
 my_numpics = j.feed.openSearch$totalResults.$t;  // Get the number of pictures in the album
 album_name = j.feed.title.$t;                    // Also get the name of the album, so we don't have to pass that around either

 for (var i in j.feed.entry){
   // get the list of all photos referenced in the album and display;
   // also stored in an array (photoids) for navigation in the photo view (passed via the URL)
   var id_begin = j.feed.entry[i].id.$t.indexOf('photoid/')+8;
   var id_end   = j.feed.entry[i].id.$t.indexOf('?');
   var id_base  = j.feed.entry[i].id.$t.slice(id_begin, id_end);
   photolist[i] = id_base;

   // now get previous and next photos relative to the photo we're currently viewing
   if (i > 0){
     var prev_begin = j.feed.entry[i-1].id.$t.indexOf('photoid/')+8;
     var prev_end   = j.feed.entry[i-1].id.$t.indexOf('?');
     prev = j.feed.entry[i-1].id.$t.slice(id_begin, id_end);
   }
   if (i+1 < j.feed.entry.length){
     var next_begin = j.feed.entry[i+1].id.$t.indexOf('photoid/')+8;
     var next_end   = j.feed.entry[i+1].id.$t.indexOf('?');
     next = j.feed.entry[i+1].id.$t.slice(id_begin, id_end);
   }
 }
}


// -------------------------------------------------------------------
// returns all photos in a specific album
// -------------------------------------------------------------------
function albums(j){  
 //get the number of photos in the album
 var np          = j.feed.openSearch$totalResults.$t;
 var album_begin = j.feed.entry[0].summary.$t.indexOf('href="')+6;
 var album_end   = j.feed.entry[0].summary.$t.indexOf('/photo#');
 var album_link  = j.feed.entry[0].summary.$t.slice(album_begin, album_end);
 var photoids    = new Array();

 w("<div style='margin-left:3px'><a href='" + window.location.protocol + "//" + window.location.hostname+window.location.pathname+"'>"+sGalHome+"</a> &gt; "+ j.feed.title.$t +"&nbsp;&nbsp;["+ np + sPhotos[(np==1)?0:1] +"]</div><div style='text-align:right; margin-right:5px; margin-top:-14px'><a target=PICASA href='"+album_link+"'>" + sViewThis[1] + "</a></div><br>");

 for (var i in j.feed.entry){
   var img_base = j.feed.entry[i].media$group.media$content[0].url;
   var id_begin = j.feed.entry[i].id.$t.indexOf('photoid/')+8;
   var id_end   = j.feed.entry[i].id.$t.indexOf('?');
   var id_base  = j.feed.entry[i].id.$t.slice(id_begin, id_end);
   var caption  = j.feed.entry[i].media$group.media$description.$t.replace(/\'/g,"&#39;");
   photoids[i]  = id_base;

   // display the thumbnail and make the link to the photo page, including the gallery name so it can be displayed.
   // TX: HiSlide gallery only for photos, not for videos
   var link_url = "?albumid="+_GET['albumid']+"&photoid="+id_base; 
   w("<div class=item title='"+ caption +"'>");
   if (!hs || (j.feed.entry[i].media$group.media$content.length > 1 && j.feed.entry[i].media$group.media$content[1].medium == "video")){
     w("<a href='"+link_url+"'><img src='"+img_base+"?imgmax=160&crop=1' alt='"+ caption +"' /><p><b class='hi'>video</b>&nbsp;"+ caption +"</p></a>");
   }else{
     w("<a href='"+img_base+((photosize)?"?imgmax="+photosize:"")+"' class='highslide' onclick='return hs.expand(this)'><img alt='"+ caption +"' src='"+img_base+"?imgmax=160&crop=1' class='pwimages' /><p>"+ caption +"</p></a>");
     w("<div class='highslide-caption' style='display:hidden'><b>"+ caption +"</b></div>");
   }
   w("</div>");
 }
}


// -------------------------------------------------------------------
// returns exactly one photo
// -------------------------------------------------------------------
function photo(j){
 var album_begin = j.entry.summary.$t.indexOf('href="')+6;
 var album_end   = j.entry.summary.$t.indexOf('/photo#');
 var album_link  = j.entry.summary.$t.slice(album_begin, album_end);
 var img_title   = j.entry.title.$t;
 var img_base    = j.entry.media$group.media$content[0].url;
 var img_width   = j.entry.media$group.media$content[0].width;
 var img_height  = j.entry.media$group.media$content[0].height;
 var photo_begin = j.entry.summary.$t.indexOf('href="')+6;
 var photo_end   = j.entry.summary.$t.indexOf('"><img');
 var photo_link  = j.entry.summary.$t.slice(photo_begin, photo_end);
 var photo_id    = _GET['photoid'];
 var is_video    = (j.entry.media$group.media$content.length > 1 && j.entry.media$group.media$content[1].medium == "video");
 
 var album_id = _GET['albumid'];
 var my_next  = next;
 var my_prev  = prev;
 var photo_array = photolist;
 var my_galleryname       = album_name;
 var my_fixed_galleryname = album_name;
 var album_base_path      = window.location.protocol + "//" + window.location.hostname+window.location.pathname +"?albumid="+ _GET['albumid'];

 // Get the filename for display in the breadcrumbs
 var LastSlash = 0;
 var img_filename = img_title;
 for (var i in img_base) if (img_base.charAt(i)=="/") LastSlash = i;
 if (LastSlash != 0) {
 	 img_filename = img_base.slice(LastSlash+1, img_base.length);
 }
 // replace some commonly-used URL characters like %20
 img_filename = img_filename.replace("%20"," ");
 img_filename = img_filename.replace("%22","\"");
 img_filename = img_filename.replace("%27","\'");


 // find preceding two and following two pictures in the array; used for the navigation arrows.
 // the arrows are already linked to the previous and next pics, which were passed in with the URL.
 // however, we need the ones that are two behind and two ahead so that we can pass that info along when we link to another photo.
 for (var i in photo_array){
   if (photo_array[i]==photo_id) {
	   var p1 = photo_array[i-1]; // ID of the picture one behind this one; if null, we're at the beginning of the album
	   var current_index = i + 1; // this is the count of the current photo
	   var n1 = photo_array[i+1]; // ID of the picture one ahead of this one; if null, we're at the end of the album
   }
 }
 //these will be passed along if we move to the next or previous photo 
 var prev = album_base_path + "&photoid=" + p1; 
 var next = album_base_path + "&photoid=" + n1; 

 //Display the breadcrumbs
 var current_index_text = current_index + sOf + my_numpics;
 if (is_video) {current_index_text = current_index_text + "&nbsp;&nbsp;[VIDEO]";}  //show in the breadcrumbs that the item is a video
 w("<div style='margin-left:3px'><a href='"+ window.location.protocol + "//" + window.location.hostname+window.location.pathname+"'>"+sGalHome+"</a> &gt; <a href='" + album_base_path + "'>" + my_fixed_galleryname + "</a> &gt; <!--" + img_filename + "-->" + current_index_text + "</div><div style='text-align:right; margin-right:3px; margin-top:-14px'><a target=PICASA href='"+photo_link+"'>" + sViewThis[2] + "</a></div><br>");

 // we're at the first/last picture in the album; going back takes us to the album index
 if (p1 == null) var prev = album_base_path;
 if (n1 == null) var next = album_base_path;

 //the navigation panel: back, home, and next.
 w("<center><table border=0><tr valign=top>");
 if (photo_array.length > 1) { w("<td><a href='"+prev+"'><img border=0 alt='Previous item' src='/pic/p_btn.gif'></a> </td><td></td>"); }
 w("<td> <a href='"+album_base_path+"'><img border=0 alt='Back to album index' src='/pic/f_btn.gif'></a> </td>");
 if (photo_array.length > 1) { w("<td></td><td> <a href='"+next+"'><img border=0 alt='Next item' src='/pic/n_btn.gif'></a></td>"); }
 w("</tr></table></center><br>");

 //don't scale up photos that are narrower than our max width; disable this to set all photos to max width
 var display_width = Math.min(img_width,photosize);

 //at long last, display the image and its description. photos larger than max_width are scaled down; smaller ones are left alone
 photo_link = album_base_path;
 if (prev) photo_link = prev;
 if (next) photo_link = next;
 if (is_video){
   var tmpWi  = Math.round(3*display_width/4);
   var tmpHi  = Math.round(3*tmpWi/4);
   var tmpUrl = j.entry.media$group.media$content[1].url; 
   var tmpContent = "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0' type='application/x-shockwave-flash' data='/FlowPlayer.swf' width="+tmpWi+" height="+tmpHi+"><param name='movie' value='/FlowPlayer.swf'></param><param name='flashvars' value='videoFile=" + escape(tmpUrl) + "&autoPlay=0'></param><param name='allowScriptAccess' value='sameDomain'></param><param name='quality' value='high'></param><param name='bgcolor' value='#ddeeff'><param name='loop' value='false'><param name='wmode' value='transparent'></param><embed src='/FlowPlayer.swf' flashvars='videoFile=" + escape(tmpUrl) + "' type='application/x-shockwave-flash' quality='high' bgcolor='#ddeeff' width="+tmpWi+" height="+tmpHi+" pluginspage='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></embed></object>";
 }else{
   var tmpContent = "<img id='picture' width="+display_width+" src='"+img_base+"?imgmax="+photosize+"' class='pwimages' />";
 }
 w("<center><a border=0 href='"+photo_link+"'>"+tmpContent+"</a></center>");
 w("<br><center><div style='margin-left:2px'>"+j.entry.media$group.media$description.$t+"</div></center></p>");

 //now we will trap left and right arrow keys so we can scroll through the photos with a single keypress ;-) JMB 7/5/2007
 w('<script language="Javascript"> function testKeyCode(evt, intKeyCode) {if (window.createPopup) return evt.keyCode == intKeyCode; else return evt.which == intKeyCode;} document.onkeydown = function(evt) {if (evt==null) evt = event; if (testKeyCode(evt,37)) {window.location = "' + prev + '"; return false;} if (testKeyCode(evt,39)) { window.location = "' + next + '"; return false;} }</script>');
}


// -------------------------------------------------------------------
// no function - code called directly when loading this script file
// -------------------------------------------------------------------
if(_GET['photoid']&&_GET['albumid']){
  w('<script type="text/javascript" src="http://picasaweb.google.com/data/feed/base/user/'+username+'/albumid/'+_GET['albumid']+'?category=photo&alt=json&callback=getphotolist"></script>');//get the list of photos in the album and put it in the global "photolist" array so we can properly display the navigation arrows; this eliminates the need for really long URLs :-) 7/16/2007
  w('<script type="text/javascript" src="http://picasaweb.google.com/data/entry/base/user/'+username+'/albumid/'+_GET['albumid']+'/photoid/'+_GET['photoid']+'?alt=json&callback=photo"></script>');//photo
}else if(_GET['albumid']&&!_GET['photoid']){
  w('<script type="text/javascript" src="http://picasaweb.google.com/data/feed/base/user/'+username+'/albumid/'+_GET['albumid']+'?category=photo&alt=json&callback=albums"></script>');//albums
}else{
  w('<script type="text/javascript" src="http://picasaweb.google.com/data/feed/base/user/'+username+'?category=album&alt=json&callback=picasaweb&access=public"></script>');//picasaweb
}


