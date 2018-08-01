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
		if(empty($newProfileEmail)) {
			throw(new \InvalidArgumentException("Profile email address is empty or insecure"));
		}
		// verify the email will fit in the database
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("Profile email address is too long"));
		}
		// store the valid email address
		$this->profileEmail = $newProfileEmail;
	}

	/**
	 * accessor method for a full profile name
	 *
	 * @return string value of a Profile name
	 **/
	public function getProfileName(): string {
		return $this->profileName;
	}

	/**
	 * mutator method for setting/changing a profile name
	 *
	 * @param string $newPProfileName new value of a user name for this Profile
	 * @throws \InvalidArgumentException if $newProfileName is not a valid string
	 * @throws \RangeException if $newProfileName is longer than 92-character long
	 * @throws \TypeError if $newProfileName is not a string
	 **/
	public function setProfileName(string $newProfileName): void {
		// verify that the user name is not empty and shorter than 92 characters
		$newProfileName = trim($newProfileName);
		if(empty($newProfileName | !ctype_alpha($newProfileName))) {
			throw(new \InvalidArgumentException("Profile name is empty or invalid"));
		}
		// verify that a Profile name is shorter than 92 characters
		if(strlen($newProfileName) > 92) {
			throw(new \RangeException("Profile name is too long"));
		}
		// store the valid name in the class state variable
		$this->profileName = $newProfileName;
	}

	/**
	 * accessor method for a Profile phone number
	 *
	 * @return string value of a Profile phone number
	 **/
	public function getProfilePhone(): string {
		return $this->profilePhone;
	}

	/**
	 * mutator method for setting/changing a Profile phone number
	 *
	 * @param string $newProfilePhone new value of a phone number for this Profile
	 * @throws \InvalidArgumentException if $newProfileName is empty or contains digits and special characters
	 * @throws \RangeException if $newProfileName is longer than 92-character long
	 * @throws \TypeError if $newProfileName is not a string
	 **/
	public function setProfilePhone(string $newProfilePhone): void {
		//if $profilePhone is null return it right away
		if($newProfilePhone === null) {
			$this->profilePhone = null;
			return;
		}
		// verify the phone is secure
		$newProfilePhone = trim($newProfilePhone);
		$newProfilePhone = filter_var($newProfilePhone, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		// we don't allow using '+' in phone numbers, only digits
		if(empty($newProfilePhone | !ctype_xdigit($newProfilePhone))) {
			throw(new \InvalidArgumentException("Pofile phone number is empty or insecure"));
		}
		// verify the phone will fit in the database
		if(strlen($newProfilePhone) > 15) {
			throw(new \RangeException("profile phone number is too long"));
		}
		// store the phone
		$this->profilePhone = $newProfilePhone;
	}

	/**
	 * inserts this Profile into mySQL
	 *
	 * @param \PDO $dbc PDO database connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \Exception -- all others except for \PDOException exception
	 **/
	public function insertProfile(\PDO $dbc): void {
		// create query template
		$query = "INSERT INTO profile(profileId, profileOAuthId, profileAccessToken, profileEmail, profileName, profilePhone) VALUES (:profileId, :profileOAuthId, :profileAccessToken, :profileEmail, :profileName, :profilePhone)";
		try {
			$stmt = $dbc->prepare($query);
			$stmt->bindParam(':profileId', $this->profileId->getBytes());
			$stmt->bindParam(':profileOAuthId', $this->profileOAuthId);
			$stmt->bindParam(':profileAccessToken', $this->profileAccessToken);
			$stmt->bindParam(':profileEmail', $this->profileEmail);
			$stmt->bindParam(':profileName', $this->profileName);
			$stmt->bindParam(':profilePhone', $this->profilePhone);
			$stmt->execute();

			// disconect from the database
			$dbc = null;
		} catch (\PDOException | \Exception $e) {
			error_log( "Error: " .$e->getMessage());
			exit(0);
		}
	}

	/**
	 * update this Profile from mySQL where profileId matches
	 *
	 * @param \PDO $dbc database connection object
	 * @throws \PDOException in case of mySQL related errors
	 * @throws \Exception -- all others except for \PDOException exception
	 **/
	public function updateProfile(\PDO $dbc): void {
		try {
			$query = "UPDATE profile SET profileOAuthId = :profileOAuthId,
                                    profileAccessToken = :profileAccessToken,
                                    profileEmail = :profileEmail,
                                    profileName = :profileName,                              
                                    profilePhone = :profilePhone WHERE profileId = :profileId";
			$stmt = $dbc->prepare($query);
			$stmt->bindParam(':profileId', $this->profileId->getBytes());
			$stmt->bindParam(':profileOAuthId', $this->profileOAuthId);
			$stmt->bindParam(':profileAccessToken', $this->profileAccessToken);
			$stmt->bindParam(':profileEmail', $this->profileEmail);
			$stmt->bindParam(':profileName', $this->profileName);
			$stmt->bindParam(':profilePhone', $this->profilePhone);
			$stmt->execute();

			// disconect from the database
			$dbc = null;
		} catch (\PDOException | \Exception $e) {
			error_log( "Error: " .$e->getMessage());
			exit(0);
		}
	}


	/**
	 * delete this Profile from mySQL where profileId matches
	 *
	 * @param \PDO $dbc database connection object
	 * @throws \PDOException in case of mySQL related errors
	 * @throws \Exception -- all others except for \PDOException exception
	 **/
	public function deleteProfile(\PDO $dbc): void {
		try {
			$query = "DELETE FROM profile WHERE profileId = :profileId";
			$stmt = $dbc->prepare($query);
			$stmt->bindParam(':profileId', $this->profileId->getBytes());
			$stmt->execute();

			// disconect from the database
			$dbc = null;
		} catch (\PDOException | \Exception $e) {
			error_log( "Error: " .$e->getMessage());
			exit(0);
		}
	}


	/**
	 * get this Profile by profileId
	 *
	 * @param \PDO $dbc database connection object
	 * @param string $currProfileId profile Id to search for
	 * @return Profile object or null if profile is not found
	 * @throws \PDOException in case of mySQL related errors
	 * @throws \Exception -- all others except for \PDOException exception
	 **/
	public function getProfileByProfileId(\PDO $dbc, string $currProfileId): ?Profile {
		// sanitize the  user id before searching
		try {
			$currUserId = self::validateUuid($currProfileId);
		} catch (\Exception $e) {
			error_log( "Error: " .$e->getMessage());
			return null;
		}

		try {
			$query = "SELECT * FROM profile WHERE profileId = :profileId";
			$stmt = $dbc->prepare($query);
			$stmt->bindParam(':profileId', $this->profileId->getBytes());
			$stmt->execute();
			$errorInfo = $stmt->errorInfo();
			if(isset($errorInfo[2])) {
				$error = $errorInfo[2];
			}
		}  catch (\PDOException | \Exception $e) {
			error_log( "Error: " .$e->getMessage());
			exit(0);
		}

		try {
			// grab the profile from mySQL
			$row = $stmt->fetch(\PDO::FETCH_ASSOC);
			if ($row) {
				$newProfile = new Profile($row["profileId"], $row["profileOAuthId"], $row["profileAccessToken"],
					$row["profileEmail"], $row["userName"], $row["profilePhone"]);
			}
			else {
				$newProfile = null;
			}
			// disconect from the database
			$dbc = null;
		} catch (\Exception $e) {
			error_log( "Error: " .$e->getMessage());
		} finally {
			return $newProfile;
		}
	}

	/**
	 * get this Profile by profile email address
	 *
	 * @param \PDO $dbc database connection object
	 * @param string $currProfileEmail profile email address to search for
	 * @return Profile object or null if profile is not found
	 * @throws \PDOException in case of mySQL related errors
	 * @throws \InvalidArgumentException in case email address is empty or insecure
	 * @throws \Exception -- all others except for \PDOException exception
	 **/
	public function getProfileByProfileEmail(\PDO $dbc, string $currProfileEmail): ?Profile {
		// verify that user email is secure
		try {
			$currProfileEmail = trim($currProfileEmail);
			$currProfileEmail = filter_var($currProfileEmail, FILTER_VALIDATE_EMAIL);
			if(empty($currProfileEmail)) {
				throw(new \InvalidArgumentException("Profile email is empty or insecure"));
			}
		} catch (\Exception $e) {
			error_log( "Error: " .$e->getMessage());
			return null;
		}

		try {
			$query = "SELECT * FROM profile WHERE profileEmail = :profileEmail";
			$stmt = $dbc->prepare($query);
			$stmt->bindParam(':profileEmail', $this->profileEmail);
			$stmt->execute();
			$errorInfo = $stmt->errorInfo();
			if(isset($errorInfo[2])) {
				$error = $errorInfo[2];
			}
		} catch(\Exception $e) {
			$error = $e->getMessage();
			return null;
		}

		try {
			// grab the selected profile from mySQL
			$row = $stmt->fetch(\PDO::FETCH_ASSOC);
			if ($row) {
				$newProfile = new Profile($row["profileId"], $row["profileOAuthId"], $row["profileAccessToken"],
					$row["profileEmail"], $row["userName"], $row["profilePhone"]);
			}
			else {
				$newProfile = null;
			}
			// disconect from the database
			$dbc = null;
		} catch (\Exception $e) {
			error_log( "Error: " .$e->getMessage());
		} finally {
			return $newProfile;
		}
	}


	/*
	 * CREATE TABLE profile (
	profileId BINARY(16) NOT null,
	profileOAuthId TINYINT UNSIGNED NOT null,
	profileAccessToken VARCHAR(255),
	profileEmail VARCHAR(128) NOT null,
	profileName VARCHAR(92) NOT null,
	profilePhone VARCHAR(15),
	-- create indexes
	INDEX (profileOAuthId),
	INDEX(profileEmail),
	INDEX (profileName),
	FOREIGN KEY(profileOAuthId) REFERENCES oAuth(oAuthId),
	PRIMARY KEY (profileId)
);
	*/

	/**
	 * TODO: include some test units for the accessors, mutators, and constractor
	 */






}