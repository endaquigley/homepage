require('dotenv').config();

const Twitter = require('twitter');
const to = require('await-to-js').default;
const tweetParser = require('tweet-parser').default;

let latestTweets = [];

const client = new Twitter({
  consumer_key: process.env.CONSUMER_KEY,
  consumer_secret: process.env.CONSUMER_SECERT,
  access_token_key: process.env.ACCESS_TOKEN_KEY,
  access_token_secret: process.env.ACCESS_TOKEN_SECRET
});

(async function fetchTweets() {

  const parameters = {
    count: 5,
    screen_name: 'endaquigley'
  };

  const [ error, tweets ] = await to(client.get('statuses/user_timeline', parameters));

  if (error === null) {
    latestTweets = tweets.map((tweet) => {
      const retweet = tweet.hasOwnProperty('retweeted_status');
      return tweetParser(retweet === true ? tweet.retweeted_status.text : tweet.text);
    });
  }

  setTimeout(fetchTweets, 5 * 60 * 1000);

})();

module.exports.getTweets = () => latestTweets;
