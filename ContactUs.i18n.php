<?php
if (!defined('MEDIAWIKI'))
    die("Not a valid access point");
/**
 * Internationalisation for ContactUs
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();
 
/** English
 * @author Justin Folvarcik
 */
$messages[ 'en' ] = array(
	'contactus' => "Contact Us", // Important! This is the string that appears on Special:SpecialPages
	'contactus-desc' => "Creates a special page to allow users to contact specific staff based on the nature of their inquiry.",
    'contactus-head' => "Email the staff",
    'contactus-page-desc' => '<p>This page allows users and readers to contact the staff of {{SITENAME}}. Please try to be specific with you inquiry, '
   .'so that it can be sent to the proper staff members.</p>',
    'contactus-your-email' => 'Your Email Address',
    'contactus-your-username' => 'Your {{SITENAME}} Username',
    'contactus-problem-question' => 'What would you like to ask about?',
    'contactus-settings-msg' => 'This page allows you to view the current settings of the extension.',
    'contactus-settings-error-public' => 'This extension has not been configured properly. If you are attempting to contact the administration, you '.
    'will be unable to use this form until the problem has been rectified.',
    'contactus-settings-error-sysop' => 'The extension has not been properly configured. Please ensure that [[MediaWiki:Contactus_users]] has been set'.
    ' with the proper users and groups.',
    'contactus-settings-settings' => 'Settings',
    'contactus-table-users' => 'Users set to receive emails',
    'contactus-table-groups' => 'Groups set to receive requests',
    'contactus-table-other' => 'Other settings',
    'contactus-table-variable' => 'Setting',
    'contactus-table-value' => 'Value',
    'contactus-table-page' => 'Page to change setting'


);

/** Documentation
 * @author Justin Folvarcik
 */
$messages['qqq'] = array(
    'contactus' => 'Title of the page. It shows up in the listing.',
    'contactus-desc' => 'Description for the extension credits',
    'contactus-head' => 'The '
);