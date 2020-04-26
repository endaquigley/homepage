Adding an SSL certificate to your site has never been easy - it's a clunky, time consuming and error prone process. I've never needed encryption on any personal project I've worked on over the years. The concept has always seemed appealing though, especially after Google announced that they have started to reward sites served over HTTPS with a minor boost in rankings.

## CloudFlare

I stumbled across [CloudFlare](http://www.cloudflare.com) last month and decided to test out the service. I was aware that they offered a free CDN for your static site content (that was the main reason for signing up in the first place) but I had no idea that they also provided an SSL certificate on the free tier for each registered domain.

And sure enough, enabling SSL on my site was as easy as they said it would be. Once I had updated my domain nameserver to point to the CloudFlare system and setup a rule to serve all traffic over HTTPS - that was it. All URLs on my site were relative links already so I didn't need to update anything on the server.

This service is great for developers who care more about encryption rather than authentication. The SSL cert that was applied to my own portfolio site was issued to CloudFlare (not my own organisation as is usually the case) and shared with a few other sites - not 100% secure, but better than nothing. From the users perspective, as long as they see the green padlock in the address field that's normally good enough for them.

## Better alternative?

I'm still waiting to see if [Let's Encrypt](https://letsencrypt.org) can deliver on their promise...

_"Let’s Encrypt is a new free certificate authority, built on a foundation of cooperation and openness, that lets everyone be up and running with basic server certificates for their domains through a simple one-click process"._

CloudFlare is a great solution for sites on shared hosting where they do not have access to the underlying operating system, but if you do have SSH access to your server I'd probably recommend using Let's Encrypt instead as they seem to offer encryption without having to sacrifice authentication. Let's Encrypt hope to be ready by Summer 2015 - looking forward to giving it a go.
