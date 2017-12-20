<?php

  session_start();

  if (isset($_SESSION['authenticated']) === false) {
    header('location: login.php');
  }

?>


<!DOCTYPE html>

<html lang="en">
<head>

  <meta charset="utf-8">
  <title>Intel Sensor Project for DCC</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="stylesheet" type="text/css" href="css/global.min.css">

  <link rel="dns-prefetch" href="//maps.googleapis.com">
  <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">

  <script src="//use.typekit.net/yjj0arr.js"></script>
  <script>try{Typekit.load({ async: false });}catch(e){}</script>

  <script type="text/javascript">
		/*! modernizr 3.2.0 (Custom Build) | MIT *
		* http://modernizr.com/download/?-backgroundsize-flexbox !*/
		!function(e,n,t){function r(e){var n=x.className,t=Modernizr._config.classPrefix||"";if(_&&(n=n.baseVal),Modernizr._config.enableJSClass){var r=new RegExp("(^|\\s)"+t+"no-js(\\s|$)");n=n.replace(r,"$1"+t+"js$2")}Modernizr._config.enableClasses&&(n+=" "+t+e.join(" "+t),_?x.className.baseVal=n:x.className=n)}function o(e,n){return typeof e===n}function s(){var e,n,t,r,s,i,a;for(var l in C)if(C.hasOwnProperty(l)){if(e=[],n=C[l],n.name&&(e.push(n.name.toLowerCase()),n.options&&n.options.aliases&&n.options.aliases.length))for(t=0;t<n.options.aliases.length;t++)e.push(n.options.aliases[t].toLowerCase());for(r=o(n.fn,"function")?n.fn():n.fn,s=0;s<e.length;s++)i=e[s],a=i.split("."),1===a.length?Modernizr[a[0]]=r:(!Modernizr[a[0]]||Modernizr[a[0]]instanceof Boolean||(Modernizr[a[0]]=new Boolean(Modernizr[a[0]])),Modernizr[a[0]][a[1]]=r),g.push((r?"":"no-")+a.join("-"))}}function i(){return"function"!=typeof n.createElement?n.createElement(arguments[0]):_?n.createElementNS.call(n,"http://www.w3.org/2000/svg",arguments[0]):n.createElement.apply(n,arguments)}function a(e,n){return!!~(""+e).indexOf(n)}function l(e){return e.replace(/([a-z])-([a-z])/g,function(e,n,t){return n+t.toUpperCase()}).replace(/^-/,"")}function f(e,n){return function(){return e.apply(n,arguments)}}function u(e,n,t){var r;for(var s in e)if(e[s]in n)return t===!1?e[s]:(r=n[e[s]],o(r,"function")?f(r,t||n):r);return!1}function d(e){return e.replace(/([A-Z])/g,function(e,n){return"-"+n.toLowerCase()}).replace(/^ms-/,"-ms-")}function c(){var e=n.body;return e||(e=i(_?"svg":"body"),e.fake=!0),e}function p(e,t,r,o){var s,a,l,f,u="modernizr",d=i("div"),p=c();if(parseInt(r,10))for(;r--;)l=i("div"),l.id=o?o[r]:u+(r+1),d.appendChild(l);return s=i("style"),s.type="text/css",s.id="s"+u,(p.fake?p:d).appendChild(s),p.appendChild(d),s.styleSheet?s.styleSheet.cssText=e:s.appendChild(n.createTextNode(e)),d.id=u,p.fake&&(p.style.background="",p.style.overflow="hidden",f=x.style.overflow,x.style.overflow="hidden",x.appendChild(p)),a=t(d,e),p.fake?(p.parentNode.removeChild(p),x.style.overflow=f,x.offsetHeight):d.parentNode.removeChild(d),!!a}function m(n,r){var o=n.length;if("CSS"in e&&"supports"in e.CSS){for(;o--;)if(e.CSS.supports(d(n[o]),r))return!0;return!1}if("CSSSupportsRule"in e){for(var s=[];o--;)s.push("("+d(n[o])+":"+r+")");return s=s.join(" or "),p("@supports ("+s+") { #modernizr { position: absolute; } }",function(e){return"absolute"==getComputedStyle(e,null).position})}return t}function h(e,n,r,s){function f(){d&&(delete P.style,delete P.modElem)}if(s=o(s,"undefined")?!1:s,!o(r,"undefined")){var u=m(e,r);if(!o(u,"undefined"))return u}for(var d,c,p,h,v,y=["modernizr","tspan"];!P.style;)d=!0,P.modElem=i(y.shift()),P.style=P.modElem.style;for(p=e.length,c=0;p>c;c++)if(h=e[c],v=P.style[h],a(h,"-")&&(h=l(h)),P.style[h]!==t){if(s||o(r,"undefined"))return f(),"pfx"==n?h:!0;try{P.style[h]=r}catch(g){}if(P.style[h]!=v)return f(),"pfx"==n?h:!0}return f(),!1}function v(e,n,t,r,s){var i=e.charAt(0).toUpperCase()+e.slice(1),a=(e+" "+b.join(i+" ")+i).split(" ");return o(n,"string")||o(n,"undefined")?h(a,n,r,s):(a=(e+" "+z.join(i+" ")+i).split(" "),u(a,n,t))}function y(e,n,r){return v(e,t,t,n,r)}var g=[],C=[],w={_version:"3.2.0",_config:{classPrefix:"",enableClasses:!0,enableJSClass:!0,usePrefixes:!0},_q:[],on:function(e,n){var t=this;setTimeout(function(){n(t[e])},0)},addTest:function(e,n,t){C.push({name:e,fn:n,options:t})},addAsyncTest:function(e){C.push({name:null,fn:e})}},Modernizr=function(){};Modernizr.prototype=w,Modernizr=new Modernizr;var x=n.documentElement,_="svg"===x.nodeName.toLowerCase(),S="Moz O ms Webkit",b=w._config.usePrefixes?S.split(" "):[];w._cssomPrefixes=b;var z=w._config.usePrefixes?S.toLowerCase().split(" "):[];w._domPrefixes=z;var E={elem:i("modernizr")};Modernizr._q.push(function(){delete E.elem});var P={style:E.elem.style};Modernizr._q.unshift(function(){delete P.style}),w.testAllProps=v,w.testAllProps=y,Modernizr.addTest("backgroundsize",y("backgroundSize","100%",!0)),Modernizr.addTest("flexbox",y("flexBasis","1px",!0)),s(),r(g),delete w.addTest,delete w.addAsyncTest;for(var N=0;N<Modernizr._q.length;N++)Modernizr._q[N]();e.Modernizr=Modernizr}(window,document);
	</script>

</head>
<body>

<header id="site-header" class="site-header">

  <div class="site-header__items">
    <div class="site-header__item site-header__item--logo">

      <a class="site-header__logo" href="dashboard.php" title="Back to Dashboard"></a>

    </div>
    <div class="site-header__item site-header__item--nav">

      <nav id="site-header-nav" class="site-header__nav">
        <ul class="site-header__nav__list">
          <li class="site-header__nav__item">
            <a href="dashboard.php" class="site-header__nav__link ">Map View</a>
          </li>
          <li class="site-header__nav__item">
            <a href="events.php" class="site-header__nav__link  site-header__nav__link--active ">Manage Notifications</a>
          </li>
          <li class="site-header__nav__item">
            <a href="device-manager.php" class="site-header__nav__link ">Manage Devices</a>
          </li>
          <li class="site-header__nav__item">
            <a href="users.php" class="site-header__nav__link ">Manage Users</a>
          </li>
          <li class="site-header__nav__item">
            <a href="reporting.php" class="site-header__nav__link ">Reporting</a>
          </li>
        </ul>
      </nav>

    </div>
    <div class="site-header__item site-header__item--burger">

      <input id="burger-button" type="button" class="site-header__burger" value="Main Menu">

    </div>
  </div>

</header>


<section class="main-section">
  <div class="main-section__container">

    <h1 id="main-section-heading" class="main-section__heading">Edit Event</h1>
    <div id="intel-api-loading-icon" class="loading-icon loading-icon--corner"></div>

    <div class="page-content">

      <div id="page-notification" class="page-notification">
        <div class="page-notification__message page-notification__message--success">Event Updated</div>
      </div>

      <h3 class="page-content__heading">Details</h3>

      <div id="event-settings" class="inline-fields">
        <div class="inline-fields__row">
          <div class="inline-fields__left">
            <label for="event-name">Name:</label>
          </div>
          <div class="inline-fields__right">
            <input id="event-name" class="standard-input" type="text">
            <p style="margin-top: 2px">(This will be used as title in text messages and emails)</p>
          </div>
        </div>
        <div class="inline-fields__row">
          <div class="inline-fields__left">
            <label for="event-comment">Comment:</label>
          </div>
          <div class="inline-fields__right">
            <input id="event-comment" class="standard-input" type="text">
          </div>
        </div>
        <div class="inline-fields__row">
          <div class="inline-fields__left">
            <label for="event-type">Type:</label>
          </div>
          <div class="inline-fields__right">
            <select id="event-type" class="standard-input standard-input--select standard-input--border">
              <option value="AND">AND</option>
              <option value="OR">OR</option>
            </select>
          </div>
        </div>
      </div>

      <br>
      <br>

      <h3 class="page-content__heading">Alerts</h3>

      <div id="alerts-list" class="standard-list">
        <div class="standard-list__item standard-list__item--teal">Device, Sensor - Level</div>

        <!-- populate list of alerts from Intel API -->

      </div>

      <div id="alerts-list-dropdowns" class="hidden">

        <br>
        <div class="inline-dropdowns">
  <div class="inline-dropdowns__row">
    <div class="inline-dropdowns__section">

      <h3 class="inline-dropdowns__heading">Groups</h3>
      <div class="standard-input-wrapper">
        <select id="sensor-selector-groups" class="standard-input standard-input--select standard-input--full-width"></select>
      </div>

    </div>
    <div class="inline-dropdowns__section">

      <h3 class="inline-dropdowns__heading">Device</h3>
      <div class="standard-input-wrapper">
        <select id="sensor-selector-devices" class="standard-input standard-input--select standard-input--full-width"></select>
      </div>

    </div>
  </div>
  <div class="inline-dropdowns__row">
    <div class="inline-dropdowns__section">

      <h3 class="inline-dropdowns__heading">Sensor</h3>
      <div class="standard-input-wrapper">
        <select id="sensor-selector-sensors" class="standard-input standard-input--select standard-input--full-width"></select>
      </div>

    </div>
    <div class="inline-dropdowns__section">

      <h3 class="inline-dropdowns__heading">Level</h3>
      <div class="standard-input-wrapper">
        <select id="sensor-selector-levels" class="standard-input standard-input--select standard-input--full-width">
          <option value="1">Low</option>
          <option value="2">Medium</option>
          <option value="3">High</option>
          <option value="4">Very High</option>
        </select>
      </div>

    </div>
  </div>
</div>


      </div>

      <div class="page-content__footer">
        <input id="add-alert-button" type="button" class="standard-button standard-button--no-margin" value="Add Alert">
        <input id="cancel-add-alert-button" type="button" class="standard-button standard-button--no-margin hidden" value="Cancel">
        <input id="confirm-add-alert-button" type="button" class="standard-button standard-button--no-margin hidden" value="Add Alert">
      </div>

      <br>
      <br>

      <h3 class="page-content__heading">Recipients</h3>

      <div id="user-list" class="standard-list">
        <div class="standard-list__item standard-list__item--teal">Name</div>

        <!-- populate list of users from Intel API -->

      </div>

      <div id="user-list-dropdowns" class="hidden">

        <br>
        <h3 class="inline-dropdowns__heading">Recipient</h3>
<div class="standard-input-wrapper">

  <select id="user-selector" class="standard-input standard-input--select standard-input--full-width"></select>

</div>


      </div>

      <div class="page-content__footer">
        <input id="add-user-button" type="button" class="standard-button standard-button--no-margin" value="Add Recipient">
        <input id="cancel-add-user-button" type="button" class="standard-button standard-button--no-margin hidden" value="Cancel">
        <input id="confirm-add-user-button" type="button" class="standard-button standard-button--no-margin hidden" value="Add Recipient">
      </div>

      <br>
      <br>
      <hr>

      <div class="page-content__footer">
        <input id="save-event-button" type="button" class="standard-button standard-button--no-margin" value="Save">
      </div>

    </div>

  </div>
</section>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>

<script src="js/global.min.js"></script>


<script src="js/sensor-selector.min.js"></script>
<script src="js/user-selector.min.js"></script>
<script src="js/event-manager.min.js"></script>

</body>
</html>


