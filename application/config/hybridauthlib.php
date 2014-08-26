<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

$config['hybridauth'] =
	array(
		// set on "base_url" the relative url that point to HybridAuth Endpoint
		'base_url' => 'dev/hauth/endpoint',

		"providers" => array (

			"OpenID" => array (
				"enabled" => false
			),

			"Google" => array (
				"enabled" => true,
				"keys"    => array ( "id" => "533752912361-upqcvv8dbjcb4n85nt8efu7halj765ci.apps.googleusercontent.com", "secret" => "R76zmNANmHWQxR6Mm2UpFYsD" ),
				"scope"   => "https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email"
			),

			"Facebook" => array (
				"enabled" => true,
				"keys"    => array ( "id" => "1458764027742317", "secret" => "0edef2b6c7dcaef90ec8241cc7d194fa" ),
				"scope"   => "email"
			),

			"Twitter" => array (
				"enabled" => true,
				"keys"    => array ( "key" => "", "secret" => "" )
			),
			
		),

		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => (ENVIRONMENT == 'development'),

		"debug_file" => APPPATH.'/logs/hybridauth.log',
	);



/* End of file hybridauthlib.php */
/* Location: ./application/config/hybridauthlib.php */