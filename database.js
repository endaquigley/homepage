const escape = require('escape-html');

const posts = [
  {
    published: false,
    title: 'The power of WeakMaps',
    date: '12th January 2018',
    slug: 'the-power-of-weakmaps',
    content: `
      <p>Keep a Javascript reference to dynamic objects without the need for IDs or data attributes</p>

      <pre>
        <code class="language-html">
          ${escape(`
            <button data-person-index="0">Enda</button>
            <button data-person-index="1">Conor</button>
          `)}
        </code>
      </pre>

      <pre>
        <code class="language-javascript">
          ${escape(`
            const people = [
              { name: 'Enda', age: 30 },
              { name: 'Conor', age: 33 }
            ];

            const onClick = (e) => {

              const index = e.target.getAttribute('data-person-index');
              const { name, age } = people[index];

              ${'console.log(`${ name } is ${ age } years old`);'}

            }

            people.forEach((person, index) => {

              const button = document.createElement('button');
              button.setAttribute('data-person-index', index);
              button.innerHTML = person.name;

              button.addEventListener('click', onClick);
              document.body.append(button);

            });
          `)}
        </code>
      </pre>

      <p>Looks good, but ain't very robust. The following can cause the code to break...</p>

      <ul>
        <li>element deleted</li>
        <li>element order updated</li>
        <li>element added to start of the array</li>
        <li>element moved to another data structure</li>
      </ul>

      <pre>
        <code class="language-javascript">
          ${escape(`
            people.unshift({ name: 'Aisling', age: 40 });
          `)}
        </code>
      </pre>

      <p>React gets around this issue by using the <a href="https://reactjs.org/docs/lists-and-keys.html#keys" target="_blank">key attribute</a>.</p>
      <p>We could make our code more robust by assigning a unique ID to each element, using that value as the DOMs data attribute then filtering the array for that value in our event handler.</p>

      <pre>
        <code class="language-javascript">
          ${escape(`
            const showMessage = document.querySelector('#show-message');
            const moveMessage = document.querySelector('#move-message');

            const inbox = [{
              from: 'endaquigley@gmail.com',
              subject: 'Hello, how are you today?'
            }];

            const trash = [];

            moveMessage.addEventListener('click', () => {
              const message = inbox.pop();
              trash.push(message);
            });

            ((weakmap) => {

              // bind message to button
              weakmap.set(showMessage, inbox[0]);

              showMessage.addEventListener('click', (e) => {
                const message = weakmap.get(e.target);
                console.table(message);
              });

            })(new WeakMap());
          `)}
        </code>
      </pre>

      <p>WeakMaps allow us to associate one object with another. In this case, associate an array element with a DOM element.</p>
    `
  },
  {
    published: true,
    title: 'Speed up your LAMP stack',
    date: '5th January 2016',
    slug: 'speed-up-your-lamp-stack',
    content: `
      <p>The purpose of this article is to give a brief overview of the tasks I performed lately to speed up my LAMP stack. I regard myself first and foremost as a front-end developer these days but I also enjoy learning more about dev-ops, the terminal and Unix in general.</p>
      <p>If you do decide to go ahead with any of these changes I would suggest having an up-to-date backup / server snapshot, applying them one at a time and verifying that everything is still working as expected afterwards. It’s certainly a lot easier to troubleshoot these kind of problems when you can narrow down your search terms :)</p>

      <h2>Upgrade to PHP 7</h2>

      <p>PHP 7 is the first major update to the language in over 10 years. While it does add a few new features to the language it only really grabbed my attention once I heard about the improved performance over PHP 5.6. The <a href="http://www.zend.com/en/resources/php7_infographic" target="_blank">official benchmarks</a> show that:</p>

      <ul>
        <li>Wordpress runs twice as fast on PHP 7 and requires 75% less CPU instructions</li>
        <li>Magento serves up to 3x as many requests as those running PHP 5.6</li>
        <li>Drupal 8 (beta) currently runs 72% faster on PHP 7</li>
      </ul>

      <p>"<em>Thanks to the new Zend Engine 3.0, your apps see up to 2x faster performance and 50% better memory consumption than PHP 5.6, allowing you to serve more concurrent users without adding any hardware.</em>"</p>
      <p>According to the <a href="http://askubuntu.com/questions/705880/how-to-install-php-7" target="_blank">Ubuntu forums</a>, we first need to add the PHP 7 repository to our system:</p>

      <pre>
        <code class="language-markup">
          ${escape(`
            sudo apt-get install python-software-properties
            sudo add-apt-repository ppa:ondrej/php
          `)}
        </code>
      </pre>

      <p>Then make sure that PHP 5 is removed before installing the latest version: <br> (you may also need to install other PHP modules based on your application requirements)</p>

      <pre>
        <code class="language-markup">
          ${escape(`
            sudo apt-get update
            sudo apt-get purge php5-fpm
            sudo apt-get install php7.0 php7.0-fpm php7.0-mysql
            sudo apt-get --purge autoremove
          `)}
        </code>
      </pre>

      <p>You could get the same bump in performance without having to change a single line of code - might be worth a shot.</p>

      <h2>Enable HTTP 2 in Apache</h2>

      <p>HTTP 1.1 (the transfer protocol used on the web) has served us well for the last 15 years but it's beginning to show it's age, it was simply not designed for the type of applications we run on the web these days.</p>
      <p>However, being a resourceful bunch, we developed a number of workarounds in an attempt to overcome the restrictions imposed by HTTP 1.1 (file concatenation, sprite sheets etc). We started to bundle all of our CSS and Javascript together in order to limit the number of TCP connections make to the server, even if most of that code was not needed on the page.</p>
      <p>The funny thing is, now that HTTP 2 has landed in most evergreen browsers, some of these "optimisation" techniques are now detrimental to front-end performance. That's not to say that we should scrap our whole Grunt / Gulp build process thought - we should continue compressing images, minifying CSS and uglifying our Javascript code.</p>
      <p>However, we need to start sending less data down the wire again. This can be achieved by writing modular CSS and Javascript, removing concatenation tasks and only requesting the resources needed for each page - <a href="https://www.mnot.net/blog/2014/01/30/http2_expectations" target="_blank">let HTTP 2 handle the rest</a>.</p>
      <p>To enable HTTP 2 in Apache, you need to be running version 2.4.17 or higher:</p>

      <pre>
        <code class="language-markup">
          ${escape(`
            sudo add-apt-repository ppa:ondrej/apache2
            sudo apt-get update
            sudo apt-get install apache2
          `)}
        </code>
      </pre>

      <p>Next you'll need to update your server config file or virtual hosts to include the new "Protocols" directive:</p>

      <pre>
        <code class="language-markup">
          ${escape(`
            <VirtualHost *:443>
              Protocols h2 http/1.1
              ServerName endaquigley.com
              ServerAlias www.endaquigley.com
              ...
            </VirtualHost>
          `)}
        </code>
      </pre>

      <p>And for your regular HTTP connections, just change "h2" to "h2c":</p>

      <pre>
        <code class="language-markup">
          ${escape(`
            <VirtualHost *:80>
              Protocols h2c http/1.1
              ServerName endaquigley.com
              ServerAlias www.endaquigley.com
              ...
            </VirtualHost>
          `)}
        </code>
      </pre>

      <p>Once you restart Apache that should be it. You can verify that this has worked by installing the <a href="https://github.com/rauchg/chrome-spdy-indicator" target="_blank">HTTP 2 indicator</a> plugin for Chrome. Any website with the blue lightning bolt icon in the address bar has been served with HTTP 2.</p>

      <h2>Pagespeed Module</h2>

      <p>Google <a href="https://developers.google.com/speed/pagespeed/insights" target="_blank">PageSpeed Insights</a> is a great tool for analysing the performance of your front-end code and for suggesting optimisations based on best practices. I use it regularly along with <a href="https://gtmetrix.com" target="_blank">GTmetrix</a> and <a href="http://www.webpagetest.org" target="_blank">Webpagetest</a> to keep me on the right track.</p>
      <p>Build tools such as Grunt and Gulp have also helped developers improve the quality of their code over the last few years, but did you know that Google also has a <a href="https://developers.google.com/speed/pagespeed/module" target="_blank">PageSpeed Module</a> for Apache that you can install on your server to automatically optimise your websites in the background?</p>
      <p>While this module should not be seen as a replacement for your front-end build process, it can often go the extra mile and optimise your site even further - especially for older sites with frameworks that are too tricky to decouple and refactor.</p>
      <p>Here are just some of the optimisations offered out of the box...</p>

      <ul>
        <li>Inline critical CSS</li>
        <li>CSS and JS concatenation + minification</li>
        <li>Image conversion + compression</li>
        <li>Lazy load images</li>
        <li>Inline small CSS + JS files</li>
        <li>Remove HTML whitespace + comments</li>
      </ul>

      <h2>HTML5 Boilerplate</h2>

      <p>The <a href="https://github.com/h5bp/html5-boilerplate" target="_blank">HTML5 Boilerplate</a> is a collection of templates and configuration files that help you get started with any online project.</p>
      <p>It's worth spending a bit of time going through their sample <a href="https://github.com/h5bp/html5-boilerplate/blob/master/dist/.htaccess" target="_blank">.htaccess</a> file and extracting whatever you think will be beneficial for your own website / server. Each section is well-documented so shouldn't take too long to figure out what each rule does and customise them to your needs. I normally use the same .htaccess file as the foundation for every site I work on these days.</p>
      <p>Most of these best practices and sensible defaults don't change from site-to-site.</p>

      <ul>
        <li>Specify character encoding</li>
        <li>Add web audio and video MIME types</li>
        <li>Gzip compression + caching</li>
        <li>Remove ETags headers</li>
        <li>Set expiration headers for site assets</li>
        <li>Force SSL and redirect all non-www connections</li>
      </ul>

      <h2>Disable .htaccess</h2>

      <p>Ok, I know this seems to be contradicting what I said in the last section - but wait, I'm going somewhere here...</p>
      <p>Having a .htaccess file allow us to set server configurations on a directory by directory basis. For many users (such as on shared hosting) this will be the only option available for them. The problem with .htaccess files is that they cascade (just like CSS) so the rules and directives defined up the directory tree (to the server root) need to be read into memory and applied for every HTTP request, whether it's a HTML page, stylesheet or image etc.</p>
      <p>As you can imagine, this results in <a href="https://httpd.apache.org/docs/2.0/en/howto/htaccess.html#when" target="_blank">significant overhead</a>. For example, before I disabled .htaccess on my own server, Apache used attempt to read at least 5 config files (4 of which don't exist on the file system) before it could return a response.</p>

      <pre>
        <code class="language-markup">
          ${escape(`
            /.htaccess
            /var/.htaccess
            /var/www/.htaccess
            /var/www/endaquigley.com/.htaccess
            /var/www/endaquigley.com/public/.htaccess
          `)}
        </code>
      </pre>

      <p>It's for this reason that Apache decided to disable .htaccess by default a few versions ago. The idea of re-writing my rules again and moving them into the main server config seemed a bit tedious. I also wanted to keep my .htaccess files in their Git repos, just like any other config file. I had given up on the idea before I stumbled across <a href="http://blog.stefanxo.com/2013/09/move-your-htaccess-files-into-your-virtualhosts-file" target="_blank">this article</a> where the author explains how you can keep .htaccess disabled yet still import its rules and direcives into your virtualhost every time the server boots - the best of both worlds.</p>
    `
  },
  {
    published: true,
    title: 'Better BEM encapsulation',
    date: '8th December 2015',
    slug: 'better-bem-encapsulation',
    content: `
      <p>One of the main goals of BEM (Blocks, Elements and Modifiers) is to build a set of small, composable components that can be used anywhere throughout your website. This is achieved by a strict naming convention, <a href="http://csswizardry.com/2012/05/keep-your-css-selectors-short" target="_blank">reducing the specificity</a> of your CSS selectors by defining them all on the same level.</p>
      <p>This works great when we're creating stand-alone templates composed of multiple components. However, we often need to add CMS generated content in with our BEM components (e.g.  block quotes, accordions, image captions etc.)</p>

      <pre>
        <code class="language-html">
          ${escape(`
            <div class="content-area">

              <img src="...">
              <p>Content Paragraph</p>

              <div class="my-component">
                <p>Component Paragraph</p>
                <img class="my-component__image" src="...">
              </div>

            </div>
          `)}
        </code>
      </pre>

      <p>Ideally we want to make it easy for CMS users to update content on the site without having to worry about HTML markup and CSS classes. This is when we depend on our base CSS styles to kick in, apply sensible default to our WYSIWYG content, e.g. text size, line height, margins, padding etc.</p>
      <p>If we need a particular style in our content area we often end up writing something like this:</p>

      <pre>
        <code class="language-css">
          ${escape(`
            .content-area p { ... }
            .content-area h1 { ... }
            .content-area img { ... }
          `)}
        </code>
      </pre>

      <p>The problem with this approach is that these loose CSS selectors are now more specific than our BEM components, and as such, have higher priority in the DOM. Every heading, paragraph and image within our content area is affected by these selectors, whether part of a BEM component or not as they share the same HTML tags.</p>
      <p>A handy way around this issue is to modify our content area selectors to only target HTML elements with no class names (WYSIWYG editors often favour additional tags and inline styles instead of CSS classes to apply content changes).</p>

      <pre>
        <code class="language-css">
          ${escape(`
            .content-area p:not([class]) { ... }
            .content-area h1:not([class]) { ... }
            .content-area img:not([class]) { ... }
          `)}
        </code>
      </pre>

      <p>This way we can ensure that our BEM components are not affected by these loose content area selectors. The only caveat to this approach is that all elements within our BEM components must have a class attribute, whether they have a value or not.</p>

      <pre>
        <code class="language-html">
          ${escape(`
            <div class="my-component">
              <p class="">Component Paragraph</p>
              <img class="my-component__image" src="...">
            </div>
          `)}
        </code>
      </pre>

      <h2>Better Solution</h2>

      <p>Like most things on the web there's nearly always a better solution just around the corner...<br>In this case, it's <a href="http://www.html5rocks.com/en/tutorials/webcomponents/customelements" target="_blank">Custom Elements</a> and the <a href="http://www.html5rocks.com/en/tutorials/webcomponents/shadowdom" target="_blank">Shadow DOM</a></p>
      <p>Custom Elements allow us to create our own HTML elements instead of relying on the limited number of tags defined by the HTML5 spec. Modifications can be applied using class names as before but will result in cleaner markup that's easier to read.</p>

      <pre>
        <code class="language-html">
          ${escape(`
            <my-component class="large">
              ...
            </my-component>
          `)}
        </code>
      </pre>

      <p>Shadow DOM on the other hand finally gives developers the ability to scope their CSS stylesheets - essentially giving us multiple DOM's within our DOM. We decide what CSS we want to inherit from the document root and can rest assured knowing that our component styles will not leak out and affect other areas of the site.</p>
      <p>With Microsoft <a href="https://www.microsoft.com/en-us/WindowsForBusiness/End-of-IE-support" target="_blank">dropping support</a> for older versions of Internet Explorer in early 2016 and a <a href="https://github.com/webcomponents/webcomponentsjs" target="_blank">polyfill</a> available for Custom Elements, HTML Imports and Shadow DOM, there's nothing stopping you from trying out these new techniques right now.</p>
    `
  },
  {
    published: true,
    title: 'Get a free SSL certificate',
    date: '16th February 2015',
    slug: 'free-ssl-certificate',
    content: `
      <p>Adding an SSL certificate to your site has never been easy - it's a clunky, time consuming and error prone process. I've never needed encryption on any personal project I've worked on over the years. The concept has always seemed appealing though, especially after Google announced that they have started to reward sites served over HTTPS with a minor boost in rankings.</p>

      <h2>CloudFlare</h2>
      <p>I stumbled across <a href="http://www.cloudflare.com" target="_blank">CloudFlare</a> last month and decided to test out the service. I was aware that they offered a free CDN for your static site content (that was the main reason for signing up in the first place) but I had no idea that they also provided an SSL certificate on the free tier for each registered domain.</p>
      <p>And sure enough, enabling SSL on my site was as easy as they said it would be. Once I had updated my domain nameserver to point to the CloudFlare system and setup a rule to serve all traffic over HTTPS - that was it. All URLs on my site were relative links already so I didn't need to update anything on the server.</p>
      <p>This service is great for developers who care more about encryption rather than authentication. The SSL cert that was applied to my own portfolio site was issued to CloudFlare (not my own organisation as is usually the case) and shared with a few other sites - not 100% secure, but better than nothing. From the users perspective, as long as they see the green padlock in the address field that's normally good enough for them.</p>

      <h2>Better alternative?</h2>
      <p>I'm still waiting to see if <a href="https://letsencrypt.org" target="_blank">Let's Encrypt</a> can deliver on their promise...</p>
      <p><em>"Let’s Encrypt is a new free certificate authority, built on a foundation of cooperation and openness, that lets everyone be up and running with basic server certificates for their domains through a simple one-click process".</em></p>
      <p>CloudFlare is a great solution for sites on shared hosting where they do not have access to the underlying operating system, but if you do have SSH access to your server I'd probably recommend using Let's Encrypt instead as they seem to offer encryption without having to sacrifice authentication. Let's Encrypt hope to be ready by Summer 2015 - looking forward to giving it a go.</p>
    `
  }
];

module.exports.posts = posts;
