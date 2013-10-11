<h1>Read Me</h1>

<h2>How to use / How it works</h2>

<h3>Step 1: Create an application</h3>
<p>First of you will need to register/login at <a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a> and create a new application. Fill out the required fields and it will generate the required credentials for you. The only credentials you need are <code>consumer key</code> and <code>consumer secret</code>.</p>

<h3>Step 2: Exchange credentials for access token</h3>
<p>Now you need to make a POST request to API’s oAuth endpoint to exchange above-mentioned credentials for an <code>access token</code>. The request made at this stage requires <code>Authorization headers</code>. This will result in a response with app level <code>bearer access token</code>. You might want to save/cache the acquired <code>access token</code> instead of making a request each time.</p>

<h3>Step 3: Make request to get the required feed</h3>
<p>Now that you have the <code>access token</code>, you can make requests to Twitter API endpoint and receive data in response. The request made at this stage also requires inclusion of <code>Authorization headers</code>.</p>

<p>Now since all these results are returned in plain text and so are the links, hashtags and mentions in the tweets. This issue can easily be solved by using <strong>“regex match and replace”</strong> methods, that is available in this example as <code>text2tweet()</code> function.</p>

<h2>License</h2>

<p>MIT License - http://opensource.org/licenses/MIT</p>