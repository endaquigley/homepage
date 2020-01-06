require('dotenv').config();

const Twit = require('twit');
const to = require('await-to-js').default;
const tweetParser = require('tweet-parser').default;

let latestTweets = [];

const client = new Twit({
  consumer_key: process.env.CONSUMER_KEY,
  consumer_secret: process.env.CONSUMER_SECRET,
  access_token: process.env.ACCESS_TOKEN,
  access_token_secret: process.env.ACCESS_TOKEN_SECRET
});

(async function fetchTweets() {

  const [ error, response ] = await to(client.get('statuses/user_timeline', {
    count: 5,
    screen_name: 'endaquigley'
  }));

  if (error === null) {
    latestTweets = response.data.map((tweet) => {
      const retweet = tweet.hasOwnProperty('retweeted_status');
      return tweetParser(retweet === true ? tweet.retweeted_status.text : tweet.text);
    });
  }

  setTimeout(fetchTweets, 5 * 60 * 1000);

})();

module.exports.getTweets = () => latestTweets;
