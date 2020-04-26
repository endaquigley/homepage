const fs = require('fs');
const showdown = require('showdown');

const converter = new showdown.Converter();

const loadContent = (filename) => {
  const path = `./posts/${filename}.md`;
  const markdown = fs.readFileSync(path, 'utf8');

  return converter.makeHtml(markdown);
}

const posts = [
  {
    published: true,
    title: 'Speed up your LAMP stack',
    date: '5th January 2016',
    slug: 'speed-up-your-lamp-stack',
    content: loadContent('speed-up-your-lamp-stack')
  },
  {
    published: true,
    title: 'Better BEM encapsulation',
    date: '8th December 2015',
    slug: 'better-bem-encapsulation',
    content: loadContent('better-bem-encapsulation')
  },
  {
    published: true,
    title: 'Get a free SSL certificate',
    date: '16th February 2015',
    slug: 'free-ssl-certificate',
    content: loadContent('free-ssl-certificate')
  }
];

module.exports.posts = posts;
