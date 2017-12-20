require('dotenv').config();

const Twitter = require('twitter');
const tweetParser = require('tweet-parser').default;

let latestTweets = [];

const client = new Twitter({
  consumer_key: process.env.COMSUMER_KEY,
  consumer_secret: process.env.COMSUMER_SECERT,
  access_token_key: process.env.ACCESS_TOKEN_KEY,
  access_token_secret: process.env.ACCESS_TOKEN_SECRET
});

(async function fetchTweets() {

  const params = { count: 5, screen_name: 'endaquigley' };
  const tweets = await client.get('statuses/user_timeline', params);

  latestTweets = tweets.map((tweet) => {
    const retweet = tweet.hasOwnProperty('retweeted_status');
    return tweetParser(retweet === true ? tweet.retweeted_status.text : tweet.text);
  });

  setTimeout(fetchTweets, 5 * 60 * 1000);

})();

module.exports.getTweets = () => latestTweets;