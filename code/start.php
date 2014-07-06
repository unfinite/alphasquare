<?php

/*

Welcome to the start file. This must be included in each single page you will make using the framework.

Please complete the below configuration to your liking.

*/

// Start session
session_start();

// Configuration start

// Base Directory
define('ZEAM_BASEDIR', '/');

// Module directory
define('ZEAM_MODULE_BASEDIR', 'modules');

// Module suffix
define('ZEAM_MODULE_SUFFIX', '.module.php');

// Description file suffix
define('DESC_SUFFIX', '.desc.txt');

// Views directory
define('ZEAM_VIEW_BASEDIR', 'views');

// View suffix
define('ZEAM_VIEW_SUFFIX', '.view.php');

// Configuration end


// Okay, we're ready to start it up!

require('core.php');

$ZeamEngine = New Zeam();

require('modules.php');
require('views.php');

$Modules = New Modules($ZeamEngine);
$Views = New Views($ZeamEngine);

// Custom code for this

$Modules->load_module("test_module");
$Views->add_link("GitHub", "http://github.com/Alphasquare/Zeam/");
$HelloWorld = New HelloWorld;
