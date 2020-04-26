The purpose of this article is to give a brief overview of the tasks I performed lately to speed up my LAMP stack. I regard myself first and foremost as a front-end developer these days but I also enjoy learning more about dev-ops, the terminal and Unix in general.

If you do decide to go ahead with any of these changes I would suggest having an up-to-date backup / server snapshot, applying them one at a time and verifying that everything is still working as expected afterwards. It’s certainly a lot easier to troubleshoot these kind of problems when you can narrow down your search terms :)

## Upgrade to PHP 7

PHP 7 is the first major update to the language in over 10 years. While it does add a few new features to the language it only really grabbed my attention once I heard about the improved performance over PHP 5.6\. The [official benchmarks](http://www.zend.com/en/resources/php7_infographic) show that:

- Wordpress runs twice as fast on PHP 7 and requires 75% less CPU instructions
- Magento serves up to 3x as many requests as those running PHP 5.6
- Drupal 8 (beta) currently runs 72% faster on PHP 7

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

- Inline critical CSS
- CSS and JS concatenation + minification
- Image conversion + compression
- Lazy load images
- Inline small CSS + JS files
- Remove HTML whitespace + comments

## HTML5 Boilerplate

The [HTML5 Boilerplate](https://github.com/h5bp/html5-boilerplate) is a collection of templates and configuration files that help you get started with any online project.

It's worth spending a bit of time going through their sample [.htaccess](https://github.com/h5bp/html5-boilerplate/blob/master/dist/.htaccess) file and extracting whatever you think will be beneficial for your own website / server. Each section is well-documented so shouldn't take too long to figure out what each rule does and customise them to your needs. I normally use the same .htaccess file as the foundation for every site I work on these days.

Most of these best practices and sensible defaults don't change from site-to-site.

- Specify character encoding
- Add web audio and video MIME types
- Gzip compression + caching
- Remove ETags headers
- Set expiration headers for site assets
- Force SSL and redirect all non-www connections

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
