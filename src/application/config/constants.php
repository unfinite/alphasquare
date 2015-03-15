<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| General site constants
|--------------------------------------------------------------------------
|
| These are general site constants.
|
*/

// Broadcast
$broadcast = array(
  "New navbar design, and mobile bottom nav!",
	"Dashboard and profiles are now equipped with infinite scrolling!",
	"Implemented auto update of posts and comments!"
);

// Page to go to when user first registers
define('REGISTER_REDIRECT', 'dashboard');


/*
	Constant for the CDN (turn off in development environments.) 
	=======================================================================

	And here's a friendly reminder on what to do on develop environments.
	Don't EVER enable this on a development environment. You will spend hours
	trying to know why your changes weren't applying. Scratching your head like
	what is wrong with this!? Turns out you are USING THE CDN.
	Take it from prior experience.
	Set the boolean to false on development environments and save yourself
	some time. 

 */

define('USE_CDN', true);

// Email address for sys emails
define('SYS_EMAIL_FROM', 'noreply@alphasquare.us');

// The number of comments to initially display
define('COMMENT_DISPLAY_LIMIT', 3);

// The number of posts to display on dashboard (before more are loaded)
define('POST_DISPLAY_LIMIT', 10);

// Min Pass Length
define('MIN_PASS_LENGTH', 6);

// RegExp patterns

// Username format (only letters, numbers, underscores)
define('REGEX_USERNAME', '/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/');
// Links
//define('REGEX_LINK', '/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/');
// @replies
define('REGEX_AT_REPLY', '/@([a-zA-Z0-9_]+)/');
// &tags
define('REGEX_TAG', '/\B&(?!(?:apos|quot|[gl]t|amp);|#)(\w+)/');



/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */