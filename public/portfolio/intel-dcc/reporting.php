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
            <a href="events.php" class="site-header__nav__link ">Manage Notifications</a>
          </li>
          <li class="site-header__nav__item">
            <a href="device-manager.php" class="site-header__nav__link ">Manage Devices</a>
          </li>
          <li class="site-header__nav__item">
            <a href="users.php" class="site-header__nav__link ">Manage Users</a>
          </li>
          <li class="site-header__nav__item">
            <a href="reporting.php" class="site-header__nav__link  site-header__nav__link--active ">Reporting</a>
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

    <h1 class="main-section__heading">Reporting</h1>

    <div class="sidebar-layout">
      <div class="sidebar-layout__left">

        <div class="page-content">

          <h3 class="page-content__heading">Sites</h3>
          <div id="reporting-site-list">

            <div class="page-content__outlet">
              <div class="device-listing device-listing--loading">
                <div class="loading-icon loading-icon--show"></div>
              </div>
            </div>

            <!-- populate from intel API -->

          </div>

        </div>

      </div>
      <div class="sidebar-layout__right">

        <div class="page-content">

          <h3 class="page-content__heading">Filter</h3>
          <div class="page-content__outlet page-content__outlet--extra-padding">

            <div class="period-filter">
              <div class="period-filter__options">

                <label class="period-filter__option">
                  <input class="period-filter__option__input" type="radio" name="period-filter" data-period-filter value="3h">
                  <span class="period-filter__option__background">Last 3 hours</span>
                </label>

                <label class="period-filter__option">
                  <input class="period-filter__option__input" type="radio" name="period-filter" data-period-filter="default" value="24h">
                  <span class="period-filter__option__background">Today</span>
                </label>

                <label class="period-filter__option">
                  <input class="period-filter__option__input" type="radio" name="period-filter" data-period-filter value="48h">
                  <span class="period-filter__option__background">Last 48 hours</span>
                </label>

                <label class="period-filter__option">
                  <input class="period-filter__option__input" type="radio" name="period-filter" data-period-filter value="7d">
                  <span class="period-filter__option__background">Last 7 days</span>
                </label>

                <label class="period-filter__option">
                  <input class="period-filter__option__input" type="radio" name="period-filter" data-period-filter value="custom">
                  <span class="period-filter__option__background">Custom</span>
                </label>

              </div>
              <div class="period-filter__footer" data-period-filter-footer>

                <div class="date-picker">
                  <div class="date-picker__section">
                    <input id="custom-from-date" type="text" class="standard-input standard-input--full-width standard-input--text-center" placeholder="From Date" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}" required>
                  </div>
                  <div class="date-picker__divider">
                    <span>to</span>
                  </div>
                  <div class="date-picker__section">
                    <input id="custom-to-date"  type="text" class="standard-input standard-input--full-width standard-input--text-center" placeholder="To Date" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}" required>
                  </div>
                </div>

              </div>
            </div>

          </div>

          <h3 class="page-content__heading">Rainfall Data</h3>
          <div id="rain-interval-filters" class="page-content__outlet page-content__outlet--extra-padding">

            <label class="fancy-checkbox">
              <input class="fancy-checkbox__input" type="radio" name="rain-interval-filter" data-interval-filter="default" value="raw">
              <span class="fancy-checkbox__icon fancy-checkbox__icon--radio"></span>
              <span class="fancy-checkbox__text">Raw</span>
            </label>

            <label class="fancy-checkbox">
              <input class="fancy-checkbox__input" type="radio" name="rain-interval-filter" data-interval-filter value="5m">
              <span class="fancy-checkbox__icon fancy-checkbox__icon--radio"></span>
              <span class="fancy-checkbox__text">5 min</span>
            </label>

            <label class="fancy-checkbox">
              <input class="fancy-checkbox__input" type="radio" name="rain-interval-filter" data-interval-filter value="15m">
              <span class="fancy-checkbox__icon fancy-checkbox__icon--radio"></span>
              <span class="fancy-checkbox__text">15 min</span>
            </label>

            <label class="fancy-checkbox">
              <input class="fancy-checkbox__input" type="radio" name="rain-interval-filter" data-interval-filter value="24h">
              <span class="fancy-checkbox__icon fancy-checkbox__icon--radio"></span>
              <span class="fancy-checkbox__text">Hourly Total</span>
            </label>

          </div>

          <h3 class="page-content__heading">River Level Data</h3>
          <div id="river-interval-filters"  class="page-content__outlet page-content__outlet--extra-padding">

            <label class="fancy-checkbox">
              <input class="fancy-checkbox__input" type="radio" name="river-interval-filter" data-interval-filter="default" value="raw">
              <span class="fancy-checkbox__icon fancy-checkbox__icon--radio"></span>
              <span class="fancy-checkbox__text">Raw</span>
            </label>

            <label class="fancy-checkbox">
              <input class="fancy-checkbox__input" type="radio" name="river-interval-filter" data-interval-filter value="24h">
              <span class="fancy-checkbox__icon fancy-checkbox__icon--radio"></span>
              <span class="fancy-checkbox__text">Hourly Total</span>
            </label>

          </div>

        </div>

        <div class="page-content-tabs" data-page-content-tabs>

          <button class="page-content-tabs__tab page-content-tabs__tab--active" data-page-content-tab data-target-id="graph-content-area">
            <h3 class="page-content-tabs__heading">View Graph</h3>
          </button>

          <button class="page-content-tabs__tab" data-page-content-tab data-target-id="data-content-area">
            <h3 class="page-content-tabs__heading">View Data</h3>
          </button>

        </div>

        <div class="page-content">

          <div class="page-content__outlet page-content__outlet--extra-padding">

            <div id="graph-content-area">
              <!-- generate charts here -->
            </div>

            <div id="data-content-area" class="hidden">
              <!-- generate data tables here -->
            </div>

          </div>

          <div class="page-content__footer">

            <form id="export-excel-form" action="api/generate-report.php" method="POST" target="_blank">
              <input id="export-excel-data" name="export-excel-data" type="hidden">
              <input class="standard-button standard-button--no-margin" type="submit" value="Export to Excel">
            </form>

          </div>

        </div>

      </div>
    </div>

    <div id="intel-api-loading-icon" class="loading-icon loading-icon--corner"></div>

  </div>
</section>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>

<script src="js/global.min.js"></script>


<script src="js/charts.min.js"></script>
<script src="js/reporting.min.js"></script>

</body>
</html>

