const posts = [
  {
    published: true,
    title: 'Speed up your LAMP stack',
    date: '5th January 2016',
    slug: 'speed-up-your-lamp-stack',
    content: `
      The purpose of this article is to give a brief overview of the tasks I performed lately to speed up my LAMP stack. I regard myself first and foremost as a front-end developer these days but I also enjoy learning more about dev-ops, the terminal and Unix in general.

      If you do decide to go ahead with any of these changes I would suggest having an up-to-date backup / server snapshot, applying them one at a time and verifying that everything is still working as expected afterwards. It’s certainly a lot easier to troubleshoot these kind of problems when you can narrow down your search terms :)
      
      ## Upgrade to PHP 7
      
      PHP 7 is the first major update to the language in over 10 years. While it does add a few new features to the language it only really grabbed my attention once I heard about the improved performance over PHP 5.6\. The [official benchmarks](http://www.zend.com/en/resources/php7_infographic) show that:
      
      *   Wordpress runs twice as fast on PHP 7 and requires 75% less CPU instructions
      *   Magento serves up to 3x as many requests as those running PHP 5.6
      *   Drupal 8 (beta) currently runs 72% faster on PHP 7
      
      "_Thanks to the new Zend Engine 3.0, your apps see up to 2x faster performance and 50% better memory consumption than PHP 5.6, allowing you to serve more concurrent users without adding any hardware._"
      
      According to the [Ubuntu forums](http://askubuntu.com/questions/705880/how-to-install-php-7), we first need to add the PHP 7 repository to our system:
      
      <pre>
        <code class="language-markup">
          sudo apt-get install python-software-properties
          sudo add-apt-repository ppa:ondrej/php
        </code>
      </pre>
      
      Then make sure that PHP 5 is removed before installing the latest version:  
      (you may also need to install other PHP modules based on your application requirements)
      
      <pre>
      <code class="language-markup">
          sudo apt-get update
          sudo apt-get purge php5-fpm
          sudo apt-get install php7.0 php7.0-fpm php7.0-mysql
          sudo apt-get --purge autoremove
        </code>
      </pre>
      
      You could get the same bump in performance without having to change a single line of code - might be worth a shot.
      
      ## Enable HTTP 2 in Apache
      
      HTTP 1.1 (the transfer protocol used on the web) has served us well for the last 15 years but it's beginning to show it's age, it was simply not designed for the type of applications we run on the web these days.
      
      However, being a resourceful bunch, we developed a number of workarounds in an attempt to overcome the restrictions imposed by HTTP 1.1 (file concatenation, sprite sheets etc). We started to bundle all of our CSS and Javascript together in order to limit the number of TCP connections make to the server, even if most of that code was not needed on the page.
      
      The funny thing is, now that HTTP 2 has landed in most evergreen browsers, some of these "optimisation" techniques are now detrimental to front-end performance. That's not to say that we should scrap our whole Grunt / Gulp build process thought - we should continue compressing images, minifying CSS and uglifying our Javascript code.
      
      However, we need to start sending less data down the wire again. This can be achieved by writing modular CSS and Javascript, removing concatenation tasks and only requesting the resources needed for each page - [let HTTP 2 handle the rest](https://www.mnot.net/blog/2014/01/30/http2_expectations).
      
      To enable HTTP 2 in Apache, you need to be running version 2.4.17 or higher:
      
      <pre>
        <code class="language-markup">
          sudo add-apt-repository ppa:ondrej/apache2
          sudo apt-get update
          sudo apt-get install apache2
        </code>
      </pre>
      
      Next you'll need to update your server config file or virtual hosts to include the new "Protocols" directive:
      
      <pre>
        <code class="language-markup">
          <VirtualHost *:443>
            Protocols h2 http/1.1
            ServerName endaquigley.com
            ServerAlias www.endaquigley.com
            ...
          </VirtualHost>
        </code>
      </pre>
      
      And for your regular HTTP connections, just change "h2" to "h2c":
      
      <pre>
        <code class="language-markup">
          <VirtualHost *:80>
            Protocols h2c http/1.1
            ServerName endaquigley.com
            ServerAlias www.endaquigley.com
            ...
          </VirtualHost>
        </code>
      </pre>
      
      Once you restart Apache that should be it. You can verify that this has worked by installing the [HTTP 2 indicator](https://github.com/rauchg/chrome-spdy-indicator) plugin for Chrome. Any website with the blue lightning bolt icon in the address bar has been served with HTTP 2.
      
      ## Pagespeed Module
      
      Google [PageSpeed Insights](https://developers.google.com/speed/pagespeed/insights) is a great tool for analysing the performance of your front-end code and for suggesting optimisations based on best practices. I use it regularly along with [GTmetrix](https://gtmetrix.com) and [Webpagetest](http://www.webpagetest.org) to keep me on the right track.
      
      Build tools such as Grunt and Gulp have also helped developers improve the quality of their code over the last few years, but did you know that Google also has a [PageSpeed Module](https://developers.google.com/speed/pagespeed/module) for Apache that you can install on your server to automatically optimise your websites in the background?
      
      While this module should not be seen as a replacement for your front-end build process, it can often go the extra mile and optimise your site even further - especially for older sites with frameworks that are too tricky to decouple and refactor.
      
      Here are just some of the optimisations offered out of the box...
      
      *   Inline critical CSS
      *   CSS and JS concatenation + minification
      *   Image conversion + compression
      *   Lazy load images
      *   Inline small CSS + JS files
      *   Remove HTML whitespace + comments
      
      ## HTML5 Boilerplate
      
      The [HTML5 Boilerplate](https://github.com/h5bp/html5-boilerplate) is a collection of templates and configuration files that help you get started with any online project.
      
      It's worth spending a bit of time going through their sample [.htaccess](https://github.com/h5bp/html5-boilerplate/blob/master/dist/.htaccess) file and extracting whatever you think will be beneficial for your own website / server. Each section is well-documented so shouldn't take too long to figure out what each rule does and customise them to your needs. I normally use the same .htaccess file as the foundation for every site I work on these days.
      
      Most of these best practices and sensible defaults don't change from site-to-site.
      
      *   Specify character encoding
      *   Add web audio and video MIME types
      *   Gzip compression + caching
      *   Remove ETags headers
      *   Set expiration headers for site assets
      *   Force SSL and redirect all non-www connections
      
      ## Disable .htaccess
      
      Ok, I know this seems to be contradicting what I said in the last section - but wait, I'm going somewhere here...
      
      Having a .htaccess file allow us to set server configurations on a directory by directory basis. For many users (such as on shared hosting) this will be the only option available for them. The problem with .htaccess files is that they cascade (just like CSS) so the rules and directives defined up the directory tree (to the server root) need to be read into memory and applied for every HTTP request, whether it's a HTML page, stylesheet or image etc.
      
      As you can imagine, this results in [significant overhead](https://httpd.apache.org/docs/2.0/en/howto/htaccess.html#when). For example, before I disabled .htaccess on my own server, Apache used attempt to read at least 5 config files (4 of which don't exist on the file system) before it could return a response.
      
      <pre>
        <code class="language-markup">
          /.htaccess
          /var/.htaccess
          /var/www/.htaccess
          /var/www/enda.ie/.htaccess
          /var/www/enda.ie/public/.htaccess
        </code>
      </pre>
      
      It's for this reason that Apache decided to disable .htaccess by default a few versions ago. The idea of re-writing my rules again and moving them into the main server config seemed a bit tedious. I also wanted to keep my .htaccess files in their Git repos, just like any other config file. I had given up on the idea before I stumbled across [this article](http://blog.stefanxo.com/2013/09/move-your-htaccess-files-into-your-virtualhosts-file) where the author explains how you can keep .htaccess disabled yet still import its rules and direcives into your virtualhost every time the server boots - the best of both worlds.
    `
  },
  {
    published: true,
    title: 'Better BEM encapsulation',
    date: '8th December 2015',
    slug: 'better-bem-encapsulation',
    content: `
      One of the main goals of BEM (Blocks, Elements and Modifiers) is to build a set of small, composable components that can be used anywhere throughout your website. This is achieved by a strict naming convention, [reducing the specificity](http://csswizardry.com/2012/05/keep-your-css-selectors-short) of your CSS selectors by defining them all on the same level.

      This works great when we're creating stand-alone templates composed of multiple components. However, we often need to add CMS generated content in with our BEM components (e.g. block quotes, accordions, image captions etc.)
      
      <pre>
        <code class="language-html">
          <div class="content-area">
            
            <img src="...">
            <p>Content Paragraph</p>
            
            <div class="my-component">
              <p>Component Paragraph</p>
              <img class="my-component__image" src="...">
            </div>
            
          </div>
        </code>
      </pre>
      
      Ideally we want to make it easy for CMS users to update content on the site without having to worry about HTML markup and CSS classes. This is when we depend on our base CSS styles to kick in, apply sensible default to our WYSIWYG content, e.g. text size, line height, margins, padding etc.
      
      If we need a particular style in our content area we often end up writing something like this:
      
      <pre>
        <code class="language-css">
          .content-area p { ... }
          .content-area h1 { ... }
          .content-area img { ... }
        </code>
      </pre>
      
      The problem with this approach is that these loose CSS selectors are now more specific than our BEM components, and as such, have higher priority in the DOM. Every heading, paragraph and image within our content area is affected by these selectors, whether part of a BEM component or not as they share the same HTML tags.
      
      A handy way around this issue is to modify our content area selectors to only target HTML elements with no class names (WYSIWYG editors often favour additional tags and inline styles instead of CSS classes to apply content changes).
      
      <pre>
        <code class="language-css">
          .content-area p:not([class]) { ... }
          .content-area h1:not([class]) { ... }
          .content-area img:not([class]) { ... }
        </code>
      </pre>
      
      This way we can ensure that our BEM components are not affected by these loose content area selectors. The only caveat to this approach is that all elements within our BEM components must have a class attribute, whether they have a value or not.
      
      <pre>
        <code class="language-html">
          <div class="my-component">
            <p class="">Component Paragraph</p>
            <img class="my-component__image" src="...">
          </div>
        </code>
      </pre>
      
      ## Better Solution
      
      Like most things on the web there's nearly always a better solution just around the corner...  
      In this case, it's [Custom Elements](http://www.html5rocks.com/en/tutorials/webcomponents/customelements) and the [Shadow DOM](http://www.html5rocks.com/en/tutorials/webcomponents/shadowdom)
      
      Custom Elements allow us to create our own HTML elements instead of relying on the limited number of tags defined by the HTML5 spec. Modifications can be applied using class names as before but will result in cleaner markup that's easier to read.
      
      <pre>
        <code class="language-html">
          <my-component class="large">
            ...
          </my-component>
        </code>
      </pre>
      
      Shadow DOM on the other hand finally gives developers the ability to scope their CSS stylesheets - essentially giving us multiple DOM's within our DOM. We decide what CSS we want to inherit from the document root and can rest assured knowing that our component styles will not leak out and affect other areas of the site.
      
      With Microsoft [dropping support](https://www.microsoft.com/en-us/WindowsForBusiness/End-of-IE-support) for older versions of Internet Explorer in early 2016 and a [polyfill](https://github.com/webcomponents/webcomponentsjs) available for Custom Elements, HTML Imports and Shadow DOM, there's nothing stopping you from trying out these new techniques right now.
    `
  },
  {
    published: true,
    title: 'Get a free SSL certificate',
    date: '16th February 2015',
    slug: 'free-ssl-certificate',
    content: `
      Adding an SSL certificate to your site has never been easy - it's a clunky, time consuming and error prone process. I've never needed encryption on any personal project I've worked on over the years. The concept has always seemed appealing though, especially after Google announced that they have started to reward sites served over HTTPS with a minor boost in rankings.

      ## CloudFlare
      
      I stumbled across [CloudFlare](http://www.cloudflare.com) last month and decided to test out the service. I was aware that they offered a free CDN for your static site content (that was the main reason for signing up in the first place) but I had no idea that they also provided an SSL certificate on the free tier for each registered domain.
      
      And sure enough, enabling SSL on my site was as easy as they said it would be. Once I had updated my domain nameserver to point to the CloudFlare system and setup a rule to serve all traffic over HTTPS - that was it. All URLs on my site were relative links already so I didn't need to update anything on the server.
      
      This service is great for developers who care more about encryption rather than authentication. The SSL cert that was applied to my own portfolio site was issued to CloudFlare (not my own organisation as is usually the case) and shared with a few other sites - not 100% secure, but better than nothing. From the users perspective, as long as they see the green padlock in the address field that's normally good enough for them.
      
      ## Better alternative?
      
      I'm still waiting to see if [Let's Encrypt](https://letsencrypt.org) can deliver on their promise...
      
      _"Let’s Encrypt is a new free certificate authority, built on a foundation of cooperation and openness, that lets everyone be up and running with basic server certificates for their domains through a simple one-click process"._
      
      CloudFlare is a great solution for sites on shared hosting where they do not have access to the underlying operating system, but if you do have SSH access to your server I'd probably recommend using Let's Encrypt instead as they seem to offer encryption without having to sacrifice authentication. Let's Encrypt hope to be ready by Summer 2015 - looking forward to giving it a go.    
    `
  }
];

module.exports.posts = posts;
