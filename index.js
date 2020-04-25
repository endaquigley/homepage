const express = require('express');
const showdown = require('showdown');

const twitter = require('./twitter');
const database = require('./database');

const app = express();

app.set('view engine', 'ejs');
app.use(express.static('public'));

app.use((req, res, next) => {
  const tweets = twitter.getTweets();
  app.locals.tweets = tweets;
  return next();
});

app.get('/', (req, res) => {
  return res.render('index', {
    title: 'Enda Quigley - Frontend / UI Developer based in Dublin, Ireland'
  });
});

app.get('/blog', (req, res) => {
  const { posts } = database;

  return res.render('blog', {
    title: 'Enda Quigley - Blog',
    posts: posts.filter(({ published }) => published)
  });
});

app.get('/blog/:slug', (req, res) => {
  const { posts } = database;

  const post = posts.find(({ slug }) => {
    return slug === req.params.slug
  });

  if (post === undefined) {
    return res.redirect('/blog');
  }

  const converter = new showdown.Converter({
    smartIndentationFix: true,
  });

  const content = converter.makeHtml(post.content);

  return res.render('post', {
    title: `${ post.title } - Enda Quigley`,
    content: content,
    post: post,
  });
});

app.get('/platform', (req, res) => {
  return res.render('platform', {
    title: 'Enda Quigley - Game Based VLE'
  });
});

app.listen(3000);
