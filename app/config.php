<?php
return
	array(
		"base_url" => getenv("SITE_URL"),
		"providers" => array(
			"OpenID" => array(
				"enabled" => getenv("OPENID_ENABLED")
			),
			"Yahoo" => array(
				"enabled" => getenv("YAHOO_ENABLED"),
				"keys" => array("key" => getenv("YAHOO_ID"), "secret" => getenv("YAHOO_SECRET"))
			),
			"AOL" => array(
				"enabled" => getenv("AOL_ENABLED")
			),
			"Google" => array(
				"enabled" => getenv("GOOGLE_ENABLED"),
				"keys" => array("id" => getenv("GOOGLE_ID"), "secret" => getenv("GOOGLE_SECRET"))
			),
			"Facebook" => array(
				"enabled" => getenv("FACEBOOK_ENABLED"),
				"keys" => array("id" => getenv("FACEBOOK_ID"), "secret" => getenv("FACEBOOK_SECRET")),
				"trustForwarded" => false
			),
			"Twitter" => array(
				"enabled" => getenv("TWITTER_ENABLED"),
				"keys" => array("key" => getenv("TWITTER_KEY"), "secret" => getenv("TWITTER_SECRET")),
				"includeEmail" => false
			),
			"Live" => array(
				"enabled" => getenv("LIVE_ENABLED"),
				"keys" => array("id" => getenv("LIVE_ID"), "secret" => getenv("LIVE_SECRET"))
			),
			"LinkedIn" => array(
				"enabled" => getenv("LINKEDIN_ENABLED"),
				"keys" => array("key" => getenv("LINKEDIN_KEY"), "secret" => getenv("LINKEDIN_SECRET"))
			),
			"Foursquare" => array(
				"enabled" => getenv("FOURSQUARE_ENABLED"),
				"keys" => array("id" => getenv("FOURSQUARE_ID"), "secret" => getenv("FOURSQUARE_SECRET"))
			),
		),
		// If you want to enable logging, set 'debug_mode' to true.
		// You can also set it to
		// - "error" To log only error messages. Useful in production
		// - "info" To log info and error messages (ignore debug messages)
		"debug_mode" => false,
		// Path to file writable by the web server. Required if 'debug_mode' is not false
		"debug_file" => ""
	);