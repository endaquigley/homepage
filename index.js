const express = require('express');

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
    title: 'Enda Quigley, Frontend / UI Developer based in Dublin, Ireland'
  });
});

app.get('/blog', (req, res) => {
  const { posts } = database;

  return res.render('blog', {
    title: 'Blog - Enda Quigley',
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

  return res.render('post', {
    title: `${ post.title } - Enda Quigley`,
    post: post
  });
});

app.get('/platform', (req, res) => {
  return res.render('platform', {
    title: 'Game Based VLE - Enda Quigley'
  });
});

app.listen(3000);
