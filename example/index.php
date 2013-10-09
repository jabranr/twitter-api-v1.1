<?php

/**
 * Example: Fetch tweets using Twitter API v1.1
 *
 * @author: hello@jabran.me
 * @version: 1.0
 * @package: Twitter API v1.1
 * @license: MIT License
 *
 */

require('../src/twitterfeed.php');

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

			// Assign the acquired data to a variable so we can loop through it
			$tweets = get_tweets('jabranr', 3);

			// Setup an unordered list
			echo '<ul class="twitter-feed">';

			// Loop through results and get the tweets
			foreach($tweets as $tweet)	{
				// Use the text2html() function to properly setup the URLs, mentions and hashtags
				echo '<li>' . text2html($tweet->text) . '</li>';
			}

			echo '</ul>';
		?>
	</body>
</html>
