<?php
/*
Credits: Bit Repository
URL: http://www.bitrepository.com/
*/

$wp_load_include = "../wp-load.php";
$i = 0;
while (!file_exists($wp_load_include) && $i++ < 9) {
	$wp_load_include = "../$wp_load_include";
}
//required to include wordpress file
require($wp_load_include);

global $shortname;
$contact_email = get_option($shortname.'_contact_admin_email');

define("WEBMASTER_EMAIL", $contact_email);


$error = '';





function ValidateEmail($email) {
/*
(Name) Letters, Numbers, Dots, Hyphens and Underscores
(@ sign)
(Domain) (with possible subdomain(s) ).
Contains only letters, numbers, dots and hyphens (up to 255 characters)
(. sign)
(Extension) Letters only (up to 10 (can be increased in the future) characters)
*/

$regex = '/([a-z0-9_.-]+)'. # name

'@'. # at

'([a-z0-9.-]+){2,255}'. # domain & possibly subdomains

'.'. # period

'([a-z]+){2,10}/i'; # domain extension 

if($email == '') { 
	return false;
}
else {
$eregi = preg_replace($regex, '', $email);
}

return empty($eregi) ? true : false;
} // end function ValidateEmail



error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;

if($post)
{
//include 'functions.php';

$name = stripslashes($_POST['name']);
$email = trim($_POST['email']);
$subject = stripslashes($_POST['subject']);
$message = stripslashes($_POST['message']);







// Check name
if(!$name)
{
$error .= '<li>'.__('Please enter your name.', 'goodminimal').'</li>';
}

// Check email

if(!$email)
{
$error .= '<li>'.__('Please enter an e-mail address.', 'goodminimal').'</li>';
}

if($email && !ValidateEmail($email))
{
$error .= '<li>'.__('Please enter a valid e-mail address.', 'goodminimal').'</li>';
}
if(!$subject)
{
$error .= '<li>'.__('Please enter your subject.', 'goodminimal').'</li>';
}


// Check message (length)

if(!$message)
{
$error .= '<li>'.__('Please enter your message.', 'goodminimal').'</li>';
}


if(!$error) {
	if ( get_option($shortname.'_recaptcha_enabled') ) {

		if ( !function_exists('_recaptcha_qsencode') ) {
			require_once('../functions/recaptchalib.php');
		}

		$publickey = get_option($shortname.'_recaptcha_publickey');
		$privatekey = get_option($shortname.'_recaptcha_privatekey');
		
		$resp = null;
		$error = null;
		
		//if( isset($_POST['submit']) ) {
			$resp = recaptcha_check_answer ($privatekey,
				$_SERVER["REMOTE_ADDR"],
				$_POST["recaptcha_challenge_field"],
				$_POST["recaptcha_response_field"]
			);
			
			if ( !$resp->is_valid ) {
				$reCaptcha_error = $resp->error;
				$error = '<li>'.__('Please enter a valid reCAPTCHA.','goodminimal').'</li>';
			}
			
		//}
		
	}
}


if(!$error)
{

$message .= '


--
'.get_bloginfo('site_name').
'
'.home_url();
								
$mail = mail(WEBMASTER_EMAIL, $subject, $message,
     "From: ".$name." <".$email.">\r\n"
    ."Reply-To: ".$email."\r\n"
    ."X-Mailer: PHP/" . phpversion());


if($mail)
{
	echo 'OK';
}

}
else
{
	echo '<div class="notification_error" style="margin-bottom:20px;">'.$error.'</div>';
}

}
?>