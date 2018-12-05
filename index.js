const express = require('express');
const twitter = require('./twitter');
const database = require('./database');

const app = express();
const { posts } = database;

app.set('view engine', 'ejs');
app.use(express.static('public'));

app.use((req, res, next) => {
  const tweets = twitter.getTweets();
  app.locals.tweets = tweets;
  next();
});

app.get('/', (req, res) => {
  res.render('index', {
    title: 'Enda Quigley - Frontend / UI Developer based in Dublin, Ireland'
  });
});

app.get('/blog', (req, res) => {
  res.render('blog', {
    title: 'Enda Quigley - Blog',
    posts: posts.filter(post => post.published)
  });
});

app.get('/blog/:slug', (req, res) => {
  const { slug } = req.params;
  const post = posts.find((x) => x.slug === slug);

  if (post === undefined) {
    return res.redirect('/blog');
  }

  res.render('post', {
    title: `${ post.title } - Enda Quigley`,
    post: post
  });
});

app.get('/platform', (req, res) => {
  res.render('platform', {
    title: 'Enda Quigley - Game Based VLE'
  });
});

app.listen(8080);
