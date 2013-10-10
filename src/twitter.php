<?php

/**
 * Methods to fetch Twitter feed using Twitter API v1.1 and Oauth2
 *
 * @author: hello@jabran.me
 * @version: 1.0
 * @package: Twitter API v1.1
 * @license: MIT License
 *
 */


function text2html( $text = '' )	{
	
	// Regex to match URL/Links in text
	$reg_url = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

	// Regex to match the Twitter mentions/handler in text
	$reg_mentions = "/@([a-zA-Z0-9])+/";

	// Regex to match the hashtags in text
	$reg_hashtags = "/#([a-zA-Z0-9])+/";

	// Match the URL/Link and wrap it inside HTML anchor tags
	if ( preg_match($reg_url, $text, $url) )
		$text = preg_replace($reg_url, '<a target="_blank" href="' . $url[0] . '" rel="nofollow">' . $url[0] . '</a>', $text);

	// Match the mentions/handlers and wrap them inside HTML anchor tags
	if ( preg_match($reg_mentions, $text, $mention) )
		$text = preg_replace($reg_mentions, '<a target="_blank" href="https://twitter.com/' . substr($mention[0], 1) . '" rel="nofollow">' . $mention[0] . '</a>', $text);

	// Match the hashtags and wrap them inside HTML anchor tags
	if ( preg_match($reg_hashtags, $text, $hashtags) )
		$text = preg_replace($reg_hashtags, '<a target="_blank" href="https://twitter.com/search?q=' . urlencode($hashtags[0]) . '" rel="nofollow">' . $hashtags[0] . '</a>', $text);

	return $text;
}

function get_twitter_access_token( $consumer_key = 'INSERT_CONSUMER_KEY', $consumer_secret = 'INSERT_CONSUMER_SECRET' )	{

	// oAuth endpoint to make request
	$endpoint = 'https://api.twitter.com/oauth2/token';

	// Prepare CURL authorization header
	$headers = array('Authorization: Basic ' . base64_encode($consumer_key . ':' . $consumer_secret) );

	// Prepare CURL options
	$options = array(
		CURLOPT_POSTFIELDS => array('grant_type' => 'client_credentials'),
		CURLOPT_HTTPHEADER => $headers,
		CURLOPT_HEADER => false,
		CURLOPT_URL => $endpoint,
		CURLOPT_RETURNTRANSFER => true
	);

	// Initialize CURL
	$curl = curl_init();

	// Setup CURL options & headers
	curl_setopt_array($curl, $options);

	// Execute CURL
	$oauthResponse = curl_exec($curl);

	// Close and end CURL
	curl_close($curl);

	// Get and decode the JSON return in result of CURL
	if ($oauthResponse)
		$oauthResponse = json_decode($oauthResponse);

	// If a bearer type token found, return the token
	if ( $oauthResponse && property_exists($oauthResponse, 'token_type') && $oauthResponse->token_type === 'bearer') )
		return $oauthResponse->access_token;

	// Otherwise return false
	return false;
}

function get_tweets( $handler = 'jabranr', $count = 10 )	{

	// Start the session if there is not any so we can cache the token
	if ( !session_start() ) session_start();

	// Cache the access token to session to reuse and avoid continuous oAuth requests
	if ( !isset($_SESSION['_twitter_token']) )
		$_SESSION['_twitter_token'] = get_twitter_access_token();

	// Get first time access token straight from function to avoid undefined index error
	$access_token = !isset($_SESSION['_twitter_token']) && get_twitter_access_token();

	// Get access token from session cache
	$access_token = isset($_SESSION['_twitter_token']) && $_SESSION['_twitter_token'];

	// Setup endpoint to make requests
	$endpoint = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $handler . '&count=' . $count;

	// Prepare CURL authorization header
	$headers = array('Authorization: Bearer ' . $access_token);

	// Prepare CURL options
	$options = array(
		CURLOPT_HTTPHEADER => $headers,
		CURLOPT_HEADER => false,
		CURLOPT_URL => $endpoint,
		CURLOPT_RETURNTRANSFER => true
  	);

  	// Initialize CURL
	$curl = curl_init();

	// Setup CURL options
	curl_setopt_array($curl, $options);

	// Execute CURL and save results
	$json = curl_exec($curl);

	// Close and end CURL
	curl_close($curl);

	// Decode JSON and return the data
	return json_decode($json);
}
