/*
* rwdImageMaps jQuery plugin v1.5
*
* Allows image maps to be used in a responsive design by recalculating the area coordinates to match the actual image size on load and window.resize
*
* Copyright (c) 2013 Matt Stow
* https://github.com/stowball/jQuery-rwdImageMaps
* http://mattstow.com
* Licensed under the MIT license
*/
(function(a){a.fn.rwdImageMaps=function(){var c=this;var b=function(){c.each(function(){if(typeof(a(this).attr("usemap"))=="undefined"){return}var e=this,d=a(e);a("<img />").load(function(){var g="width",m="height",n=d.attr(g),j=d.attr(m);if(!n||!j){var o=new Image();o.src=d.attr("src");if(!n){n=o.width}if(!j){j=o.height}}var f=d.width()/100,k=d.height()/100,i=d.attr("usemap").replace("#",""),l="coords";a('map[name="'+i+'"]').find("area").each(function(){var r=a(this);if(!r.data(l)){r.data(l,r.attr(l))}var q=r.data(l).split(","),p=new Array(q.length);for(var h=0;h<p.length;++h){if(h%2===0){p[h]=parseInt(((q[h]/n)*100)*f)}else{p[h]=parseInt(((q[h]/j)*100)*k)}}r.attr(l,p.toString())})}).attr("src",d.attr("src"))})};a(window).resize(b).trigger("resize");return this}})(jQueryLatest);


/*!
 * jQuery Cookie Plugin v1.4.0
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2013 Klaus Hartl
 * Released under the MIT license
 */
(function(e){if(typeof define==="function"&&define.amd){define(["jquery"],e)}else{e(jQuery)}})(function(e){function n(e){return e}function r(e){return decodeURIComponent(e.replace(t," "))}function i(e){if(e.indexOf('"')===0){e=e.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\")}try{return s.json?JSON.parse(e):e}catch(t){}}var t=/\+/g;var s=e.cookie=function(t,o,u){if(o!==undefined){u=e.extend({},s.defaults,u);if(typeof u.expires==="number"){var a=u.expires,f=u.expires=new Date;f.setDate(f.getDate()+a)}o=s.json?JSON.stringify(o):String(o);return document.cookie=[s.raw?t:encodeURIComponent(t),"=",s.raw?o:encodeURIComponent(o),u.expires?"; expires="+u.expires.toUTCString():"",u.path?"; path="+u.path:"",u.domain?"; domain="+u.domain:"",u.secure?"; secure":""].join("")}var l=s.raw?n:r;var c=document.cookie.split("; ");var h=t?undefined:{};for(var p=0,d=c.length;p<d;p++){var v=c[p].split("=");var m=l(v.shift());var g=l(v.join("="));if(t&&t===m){h=i(g);break}if(!t){h[m]=i(g)}}return h};s.defaults={};e.removeCookie=function(t,n){if(e.cookie(t)!==undefined){e.cookie(t,"",e.extend({},n,{expires:-1}));return true}return false}});


/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - https://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth

'use strict';

var Gorta = {};
Gorta.currentDocumentWidth = 0;

(function ($)
{
	$(document).ready(function()
	{
		if($.cookie('cookie_policy') == undefined)
		{
			$('#cookie-header-wrapper').css('display', 'block');
			$('#cookie-header-wrapper .close-button').click(function(e)
			{
				e.preventDefault();

				$('#cookie-header-wrapper').slideUp();
				$.cookie('cookie_policy', 'agree', { expires: 365 });
			});
		}
	});

})(jQuery);


(function ($)
{
	$(document).ready(function()
	{
		Gorta.screenResized();
		$(window).resize(function()
		{
			Gorta.screenResized();
		});

		// responsive imagemaps...
		$('img[usemap]').rwdImageMaps();

		$('#mobile-burger-button').click(function()
		{
			Gorta.scrollTo(0);

			var activeButton = $(this);
			$('#main-navigation-right').slideUp(function()
			{
				$(activeButton).toggleClass('active');
				
				$('#mobile-search-button').removeClass('active');
				$('#main-navigation-left').slideToggle();
			});
		});
		
		$('#mobile-search-button').click(function()
		{
			Gorta.scrollTo(0);

			var activeButton = $(this);
			$('#main-navigation-left').slideUp(function()
			{
				$(activeButton).toggleClass('active');
				
				$('#mobile-burger-button').removeClass('active');
				$('#main-navigation-right').slideToggle();
			});
		});

		$('#back-to-top, #back-to-top-mobile').click(function()
		{
			Gorta.scrollTo(0);
		});
		
		//Gift card selection
		$('#edit-ecard-gift-card-gift-card').change(function(){$('#edit-ecard .form-wrapper').slideUp();});
		$('#edit-ecard-gift-card-ecard').change(function(){$('#edit-ecard .form-wrapper').slideDown();});

		$('.donate-page #dd-plus-footer .show-button').click(function()
		{
			$(this).css('visibility', 'hidden');
			$('.donate-page #dd-plus-footer .hide-button').css('visibility', 'visible');
			$('.donate-page #dd-plus-footer .view-more').slideDown();
		});

		$('.donate-page #dd-plus-footer .hide-button').click(function()
		{
			$(this).css('visibility', 'hidden');
			$('.donate-page #dd-plus-footer .show-button').css('visibility', 'visible');
			$('.donate-page #dd-plus-footer .view-more').slideUp();
		});
		
	});

	Gorta.screenResized = function()
	{
		var newDocumentWidth = $(document).width();
		
		if(newDocumentWidth != Gorta.currentDocumentWidth)
		{	
			// remove temporary element styles...
			$('#main-navigation-left').removeAttr('style');
			$('#main-navigation-right').removeAttr('style');

			// remove temporary element classes...
			$('#mobile-burger-button').removeClass('active');
			$('#mobile-search-button').removeClass('active');
		}
		
		Gorta.currentDocumentWidth = newDocumentWidth;
	};
			
	Gorta.scrollTo = function(position)
	{
		$('html, body').animate({
			scrollTop: position
		}, 500);
	};

})(jQueryLatest);
;
