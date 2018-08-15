<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Jisbell347\LostPaws\Profile;



//Verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

$reply = new \stdClass();
$reply->status = 200;
$reply->data = null;
/**
 * Create the client object and set the authorization configuration
**/
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/lostfuzzy.ini");
$config = readConfig("/etc/apache2/capstone-mysql/lostfuzzy.ini");
$google = json_decode($config["google"]);

$provider = new League\OAuth2\Client\Provider\Google([
	"clientId" => $google->clientId,
	"clientSecret" => $google->secretId,
	"redirectUri" => "https://bootcamp-coders.cnm.edu/~jisbell1/lost-paws/public_html/api/oauth/"
]);


if(!empty($_GET['error'])) {
	// Got an error, probably user denied access
	exit('Got error: ' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'));
} elseif(empty($_GET['code'])) {
	// If we don't have an authorization code, then get one
	$authUrl = $provider->getAuthorizationUrl();
	$_SESSION['oauth2state'] = $provider->getState();
	header('Location: ' . $authUrl);
	exit;
} elseif(empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
	//State is invalid, possible CSRF attack in progress
	unset($_SESSION['oauth2state']);
	exit('Invalid state');
} else {
	//Try to get an access token (using the authorization code grant)
	$token = $provider->getAccessToken('authorization_code', ['code' => $_GET['code']
	]);
	//Optional: Now you have a token you can look up a users profile data
	try {
		//We go an access token, let's now get the owner details
		$ownerDetails = $provider->getResourceOwner($token);
		$userId = $ownerDetails->getId();
		$userName= $ownerDetails->getName();
		$userEmail = $ownerDetails->getEmail();


		$profile = Profile::getProfileByProfileEmail($pdo, $userEmail);
		if(($profile) === null) {
			// create a new profile
			$user = new Profile(generateUuidV4(), 1, $token, $userEmail, $userName, "505-555-5555");
			$user->insert($pdo);
			$reply->message = "Welcome to Lost Paws!";
		}else {
			$reply->message ="Welcome back to Lost Paws!";
		}
		$profile = Profile::getProfileByProfileEmail($pdo, $userEmail);
		$_SESSION["profile"] = $profile;

		header("Location: ../..");

	} catch(Exception $e) {
		//Failed to get the user details
		exit('Something went wrong: ' . $e->getMessage());
	}
	//Use this to interact with an API on the users behalf
	echo $token->getToken();

	//Use this to get a new access token if the old one expires
	echo $token->getRefreshToken();

	//Number of seconds until the access token will expire and need refreshing
	echo $token->getExpires();
}





