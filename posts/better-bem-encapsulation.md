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
