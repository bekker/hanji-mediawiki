<?php
/**
 * This PHP entry point is deprecated. Please use wfLoadSkin() and the skin.json file
 * instead. See https://www.mediawiki.org/wiki/Manual:Extension_registration for more details.
 */
if ( !function_exists( 'wfLoadSkin' ) ) {
	die( 'The Hanji skin requires MediaWiki 1.25 or newer.' );
}
$wgResourceModules['skins.hanji'] = array(
	'scripts' => 'resources/bootstrap/js/bootstrap.min.js',
	'styles' => array(
		'resources/screen.css' => array( 'media' => 'screen' ),
		'resources/bootstrap/css/bootstrap.min.css' => array( 'media' => 'screen' ),
        'resources/clearFont.css' => array( 'media' => 'screen' ),
	),
	'remoteSkinPath' => 'Hanji',
	'localBasePath' => __DIR__,
);
wfLoadSkin( 'Hanji' );
