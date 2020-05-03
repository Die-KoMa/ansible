<?php
{{ ansible_managed|comment('c') }}


# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
  exit;
}

error_reporting( 0 );
ini_set( 'display_errors', 0 );

## Debug
 // error_reporting( -1 );
 // ini_set( 'display_errors', 1 );
 // $wgShowDebug = true;
 // $wgShowExceptionDetails = true;
 // $wgShowDBErrorBacktrace = true;

## Uncomment this to disable output compression
# $wgDisableOutputCompression = true;

## ReadOnlyFile
/**
 * If this lock file exists (size > 0), the wiki will be forced into read-only mode.
 * Its contents will be shown to users as part of the read-only warning
 * message.
 *
 * Will default to "{$wgUploadDirectory}/lock_yBgMBwiR" in Setup.php
 */
$wgReadOnlyFile = "ReadOnly/msg";

$wgSitename = "KoMapedia";

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs
## (like /w/index.php/Page_title to /wiki/Page_title) please see:
## https://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = "/wiki";

## The protocol and server name to use in fully-qualified URLs
$wgServer = "https://komapedia.org";

## The URL path to static resources (images, scripts, etc.)
#$wgResourceBasePath = '//';
$wgResourceBasePath = $wgScriptPath;

$wgLoadScript = '/load.php';

## The URL path to the logo.  Make sure you change this from the default,
## or else you'll overwrite your logo when you upgrade!
$wgLogo = "$wgResourceBasePath/resources/assets/komapedia_logo.png";

## UPO means: this is also a user preference option

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = "homepage@die-koma.org";
$wgPasswordSender = "homepage@die-koma.org";

$wgEnotifUserTalk = true; # UPO
$wgEnotifWatchlist = true; # UPO
$wgEmailAuthentication = true;

## Database settings
$wgDBtype = "mysql";
$wgDBserver = '{{ komapedia_db_host|mandatory }}';
$wgDBname = '{{ komapedia_db_name|mandatory }}';
$wgDBuser = '{{ komapedia_db_user|mandatory }}';
$wgDBpassword = '{{ komapedia_db_password|mandatory }}';

# MySQL specific settings
$wgDBprefix = "";

# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=utf8";

# Experimental charset support for MySQL 5.0.
$wgDBmysql5 = false;

## Shared memory settings
$wgMainCacheType = CACHE_ANYTHING;
#$wgMainCacheType = CACHE_ACCEL; # was causing wiered login failures
$wgMemCachedServers = [];

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = true;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

# InstantCommons allows wiki to use images from https://commons.wikimedia.org
$wgUseInstantCommons = false;

# Periodically send a pingback to https://www.mediawiki.org/ with basic data
# about this MediaWiki instance. The Wikimedia Foundation shares this data
# with MediaWiki developers to help guide future development efforts.
$wgPingback = true;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale
$wgShellLocale = "en_US.utf8";

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publically accessible from the web.
#$wgCacheDirectory = "$IP/cache";

// Site language code, should be one of the list in ./languages/data/Names.php
$wgLanguageCode = "de";

$wgSecretKey = '{{ komapedia_secetkey|mandatory }}';

# Changing this will log out all existing sessions.
$wgAuthenticationTokenVersion = "1";

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
$wgUpgradeKey = '{{ komapedia_upgradekey|mandatory }}';

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "";
$wgRightsText = "";
$wgRightsIcon = "";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";

# The following permissions were set based on your choice in the installer
$wgGroupPermissions['*']['edit'] = false;

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'vector', 'monobook':
$wgDefaultSkin = "vector";

# Enabled skins.
# The following skins were automatically enabled:
wfLoadSkin( 'CologneBlue' );
wfLoadSkin( 'Modern' );
wfLoadSkin( 'MonoBook' );
wfLoadSkin( 'Vector' );


# End of automatically generated settings.
# Add more configuration options below.

# Need this, otherwise crash!!!
#$wgCacheDirectory = "/srv/www/htdocs/die-koma.org/wiki-beta/cache/";

# InputBox extension is mandatory
wfLoadExtension( 'InputBox' );

# ParserFunctions extension is mandatory
wfLoadExtension( 'ParserFunctions' );

# PageForms extension is mandatory
wfLoadExtension( 'PageForms' );

# Remove the index.php in the url, only do this after rewrite rule is in place
$wgArticlePath = "/wiki/$1";

# Enable subpages in the main namespace
$wgNamespacesWithSubpages[NS_MAIN] = true;

# Enable subpages in the template namespace
$wgNamespacesWithSubpages[NS_TEMPLATE] = true;

# Semantic MediaWiki extension is very cool
require_once "$IP/extensions/SemanticMediaWiki/SemanticMediaWiki.php";
/**
 * It is strongly recommended to not change the setting of
 * this function after the initial setup of the wiki, not even if you
 * switch from "http://" to "https://" or to a completely different
 * domain like e.g. <example.org> to <beispiel.de>.
 */
enableSemantics( 'old.die-koma.org' );
$wgFooterIcons['poweredby']['semanticmediawiki'] = false;

# Enable String functions
$wgPFEnableStringFunctions = true;

# More variables are more fun
require_once "$IP/extensions/Variables/Variables.php";

# Editsubpages for some finer permission control
require_once "$IP/extensions/EditSubpages/EditSubpages.php";

# Allow Display names to differ from the url
$wgRestrictDisplayTitle = false;

# Allow adiitional file extensions
$wgFileExtensions[] = 'pdf';
$wgFileExtensions[] = 'tex';
$wgFileExtensions[] = 'txt';
$wgFileExtensions[] = 'svg';
$wgFileExtensions[] = 'zip';

# SVGs do not need to be rendered as png, they are supported and awesome
# $wgSVGConverter = false;
# well it does not work like that, but using NativeSvgHandler extension should do the trick.


# TEMPORARY SPAM MAIL FOO

# disable registration
$wgGroupPermissions['*']['createaccount'] = false;
# disable mail-support
$wgEnableEmail = false;

# Block and Nuke
# wfLoadExtension( 'BlockAndNuke' );
# require_once( "$IP/extensions/BlockAndNuke/BlockAndNuke.php" );
$wgWhitelist = "$IP/extensions/BlockAndNuke/whitelist.txt";

# User Merge
wfLoadExtension( 'UserMerge' );
$wgGroupPermissions['bureaucrat']['usermerge'] = true;
$wgGroupPermissions['bureaucrat']['hideuser'] = true;
