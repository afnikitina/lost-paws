<?php



namespace Jisbell347\LostPaws;
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
/**
 * access token for this profile
 * TODO: include my own autoloader
 */
use Ramsey\Uuid\Uuid;
/*
 * Profile section of the lostpaws.com site. After logging in with oAuth, a user profile is created which displays name and contact info.
 */


/**
 * Profile class describes a registere user of LostPaws.com
 *
 * This entity depends on the OAuth entity
 *
 * @author Asya Nikitina <anikitina@cnm.edu>
 * @version 1.0.0
 **/

class Profile {
	use ValidateUuid;

	/**
	 * id for this Profile; this is the primary key
	 * @var Uuid $profileId
	 **/
	private $profileId;

	/**
	 * OAuth id for this Profile; this is the foreign key
	 * @var int $profileOAuthId
	 **/
	private $profileOAuthId;

	/**
	 * access token for this profile
	 * TODO: find out about access token
	 * @var $profileAccessToken
	 **/
	private $profileAccessToken;

	/**
	 * email for this Profile; this is a unique index
	 * @var string $profileEmail
	 **/
	private $profileEmail;

	/**
	 * full name for this profile
	 * @var string $profileName
	 **/
	private $profileName;

	/**
	 * phone number for this profile
	 * @var string $profilePhone
	 **/
	private $profilePhone;

	/**
	 * constructor for this Profile
	 *
	 * @param string|Uuid $newProfileId id of this Profile or null if a new Profile
	 * @param int $newProfileOAuthId OAuth id for this Profile
	 * @param string $newProfileAccessToken access token to safe guard against malicious accounts
	 * @param string $newProfileEmail string containing email for this Profile
	 * @param string $newProfileName string containing a full name for this Profile
	 * @param string $newProfilePhone string containing phone number for this Profile
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if a data type violates a data hint
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newProfileId, int $newProfileOAuthId, ?string $newProfileAccessToken,
										 string $newProfileEmail, string $newProfileName, ?string $newProfilePhone) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileOAuthId($newProfileOAuthId);
			$this->setProfileAccessToken($newProfileAccessToken);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileName($newProfileName);
			$this->setProfilePhone($newProfilePhone);
		} catch(\InvalidArgumentException | \RangeException |\TypeError | \Exception $exception) {
			//determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for profile id
	 *
	 * @return Uuid value of profile id (or null if new Profile)
	 **/
	public function getProfileId(): Uuid {
		return ($this->profileId);
	}

	/**
	 * mutator method for profile id
	 *
	 * @param  Uuid| string $newProfileId value of new profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if the profile Id is not
	 **/
	public function setProfileId($newProfileId): void {
		try {
			// make sure that $newProfileId is a valid UUID
			$newProfileId = self::validateUuid($newProfileId);
		} catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception  $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->profileId = $newProfileId;
	}

	/**
	 * accessor method for OAuth id
	 *
	 * @return $profileOAuthId value for this Profile as an integer
	 **/
	public function getProfileOAuthId(): int {
		return ($this->profileOAuthId);
	}

	/**
	 * mutator method for OAuth id
	 *
	 * @param  int $newProfileOAuthId OAuth id for this Profile
	 *  @throws \TypeError if $newProfileOAuthId is not a string
	 * @throws \RangeException if $newProfileOAuthId is not positive
	 **/
	public function setProfileOAuthId(int $newProfileOAuthId): void {
		try {
			// make sure that $newProfileOAuthId is an integer
			if (!is_int($newProfileOAuthIdb)) {
				throw (new \TypeError("Profile OAuth ID must be a positive integer", 0, $exception));
			}
			// make sure that $newProfileOAuthId is a positive integer
			if ($newProfileOAuthId <= 0) {
				throw (new \RangeException("Profile OAuth ID must be a positive integer", 0, $exception));
			}
		} catch( \TypeError | \Exception  $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->profileOAuthId = $newProfileOAuthId;
	}

	/**
	 * accessor method for an access token for this Profile
	 *
	 * @return $profileAccessToken value for this Profile as string
	 **/
	public function getProfileAccessToken(): string {
		return ($this->profileAccessToken);
	}

	/**
	 * mutator method for account activation token
	 *
	 * @param string $newProfileAccessToken
	 * @throws \InvalidArgumentException  if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the access token is not a string
	 */
	public function setProfileAccessToken(?string $newProfileAccessToken): void {
		if($newProfileAccessToken === null) {
			$this->profileAccessToken = null;
			return;
		}
		$newProfileAccessToken = strtolower(trim($newProfileAccessToken));
		// check if all characters are digits, if not - throw an exception
		if(!ctype_xdigit($newProfileAccessToken)) {
			throw(new \RangeException("User access token is not valid"));
		}
		//make sure user access token is more than 255 characters
		if(strlen($newProfileActivationToken) > 255) {
			throw(new \RangeException("User access token cannot be longer than 255-character long"));
		}
		$this->profileAccessToken = $newProfileAccessToken;
	}

	/**
	 * accessor method for an email address
	 *
	 * @return string value of email
	 **/
	public function getProfileEmail(): string {
		return $this->profileEmail;
	}

	/**
	 * mutator method for setting/changing an email address
	 *
	 * @param string $newProfileEmail new value of an email address
	 * @throws \InvalidArgumentException if $newEmail is not a valid email or insecure
	 * @throws \RangeException if $newEmail is > 128 characters
	 * @throws \TypeError if $newEmail is not a string
	 **/
	public function setProfileEmail(string $newProfileEmail): void {
		// verify the email is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("profile email is empty or insecure"));
		}
		// verify the email will fit in the database
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("profile email is too large"));
		}
		// store the email
		$this->profileEmail = $newProfileEmail;
	}




	/*
	 * $this->setProfileEmail($newProfileEmail);
			$this->setProfileName($newProfileName);
			$this->setProfilePhone($newProfilePhone);
	 */












}