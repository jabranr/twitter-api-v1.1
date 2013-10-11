<?php

/**
 * Example: Fetch tweets using Twitter API v1.1
 *
 * @author: hello@jabran.me
 * @version: 1.1
 * @package: Twitter API v1.1
 * @license: MIT License
 *
 */

require('../src/twitter.php');

?>
<!doctype html>
<html>
	<head>
		<title>Twitter feed Example</title>
		<meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1.0, width=device-width">
	</head>
	<body>
		<?php
			$handler = 'jabranr';
			// Assign the acquired data to a variable so we can loop through it
			$tweets = get_tweets($handler, 5);

			// Setup an unordered list
			echo '<ul class="twitter-feed">';

			// Loop through results and get the tweets
			foreach($tweets as $tweet)	{
				// Get tweet ID to setup the link to original tweet
				$tweet_id = $tweet->id;

				// Use the text2tweet() function to properly setup the URLs, mentions and hashtags
				$tweet_msg = text2tweet($tweet->text);

				// Output the formatted tweet
				echo '<li>' . $tweet_msg;
				echo ' <a href="https://twitter.com/' . $handler . '/status/' . $tweet_id . '" target="_blank" title="Go to this tweet">&raquo;</a></li>';
			}

			echo '</ul>';
		?>
	</body>
</html>