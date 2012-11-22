<?php

// Emulating wmf's setup based on wmf-config is more fun than an own LocalSettings.php

require_once __DIR__.'/../config/environment.php';
require_once __DIR__.'/../config/db.php';
require_once __DIR__.'/../config/cache.php';
require_once 'Cache.php';
require_once 'MultiVersion.php';
require_once 'CommonSettings.php';
require_once 'UnloadCentralAuth.php';
require_once 'Mobile.php';
require_once 'RandomFixes.php';

// FancyCaptcha requires images in $wgCaptchaDirectory, which I don't have; let's just move to SimpleCaptcha for now
$wgCaptchaClass = 'SimpleCaptcha';
require( "$IP/extensions/ConfirmEdit/Captcha.php" );

// keys
$wgSecretKey = "9377d36ba9ef17873b072856ede44dcb772614c9e9af1e38da1ad413d695bd10";
$wgUpgradeKey = "5d3d2659e21e53ea";

// show exceptions & SQL
$wgShowExceptionDetails = true;
$wgShowSQLErrors = true;

// log clicktracking stuff to db
$wgClickTrackingDatabase = true;
