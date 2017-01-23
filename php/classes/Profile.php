<?php

/**
* The profile of a Google document creator.
*
* This profile will be linked to all documents created by this user. This profile will be connected to this profile's unique e-mail. This profile will also be able to invite other collaborators to any/all the documents they create.
*
* @author Sarah Ruth Finkel <srfinkel@gmail.com>
* @version 3.0.0
**/
class Profile implements \JsonSerializable {
	/**
	 * id for this Profile; this is the primary key
	 * @var int $profileId
	 **/
	private $profileId;
	/**
	 * email connected to this Profile. This email should be unique
	 * @var string $profileEmail ;
	 **/
	private $profileEmail;
	/**
	 * hash connected to this profile for the password
	 * @var string $profileHash
	 **/
	private $profileHash;
	/**
	 * salt connected to this profile for the password
	 * @var string $profileSalt
	 **/
	private $profileSalt;

	/**
	 * constructor for this profile
	 *
	 *@param int|null $newProfileId id of this profile or null if a new profile
	 *@param string $newProfileEmail var of the profile that is associated with this profile
	 *@param string $newProfileHash var of this profile
	 *@param string $newProfileSalt var of this profile
	 *@throws \InvalidArgumentException if data types are not valid
	 *@throws \RangeException if data values are out of bounds (e.g. strings are too long, negative int)
	 *@throws \TypeError if data types violate type hints
	 *@throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newProfileId = null, string $newProfileEmail, string $newProfileHash, string $newProfileSalt) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileHash($newProfileHash);
			$this->setProfileSalt($newProfileSalt);
		}	catch(\InvalidArgumentException $invalidArgument)
		{
				//rethrow the exception to the caller
			throw(new \InvalidArgumentException(
$invalidArgument->getMessage(), 0, $invalidArgument));
		}	catch(\RangeException $range) {
				//rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		}	catch(TypeError $typeError) {
			//rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		}	catch(Exception $exception) {
			//rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for profile id
	 *
	 * @return int|null value of profile id
	 **/
	public function getProfileId() {
		return ($this->profileId);
	}

	/**
	 * mutator method for profile id
	 *
	 * @param int|null $newProfileId new value of profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setProfileId(int $newProfileId = null) {
		// if the profile id is null, this is a new profile without a mySQL assigned id (yet)
		if($newProfileId === null) {
			$this->profileId = null;
			return;
		}
		// verify the profile id is positive
		if($newProfileId <= 0) {
			throw (new \RangeException("profile id is not positive"));
		}
		// convert and store the profile id
		$this->profileId = $newProfileId;
	}

	/**
	 * accessor method for profile email
	 *
	 * @return string value of profile email
	 **/
	public function getProfileEmail() {
		return ($this->profileEmail);
	}

	/**
	 * mutator method for profile email
	 *
	 * @param string $newProfileEmail new value of profile email
	 * @throws \InvalidArgumentException if $newProfileEmail is not a string
	 * @throws \RangeException if profile email is too long
	 **/
	public function setProfileEmail(string $newProfileEmail) {
		// verify the profile email is secure
		$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_EMAIL);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("email is empty or insecure"));
		}
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("email is too long"));
		}
		// store the profile email
		$this->profileEmail = $newProfileEmail;
	}

	/**
	 * accessor method for profile hash
	 *
	 * @return string value of profile hash
	 **/
	public function getProfileHash() {
		return ($this->profileHash);
	}

	/**
	 * mutator method for profile hash
	 *
	 * @param string $newProfileHash new value of profile hash
	 * @throws \InvalidArgumentException if $newProfileHash is empty or not a valid string
	 * @throws \RangeException if $newProfileHash is > 128 characters
	 **/
	public function setProfileHash(string $newProfileHash) {
		// verify the profile hash is valid
		$newProfileHash = trim($newProfileHash);
		$newProfileHash = strtolower($newProfileHash);
		if(ctype_xdigit($newProfileHash) === false) {
			throw (new \InvalidArgumentException("hash has empty or invalid contents"));
		}
		if(strlen($newProfileHash) !== 128) {
			throw(new \RangeException("hash length" . strlen($newProfileHash) . "is incorrect length"));
		}
		// store the profile hash
		$this->profileHash = $newProfileHash;
	}

	/**
	 * accessor method for profile salt
	 *
	 * @return string value of profile salt
	 **/
	public
	function getProfileSalt() {
		return ($this->profileSalt);
	}

	/**
	 * mutator method for profile salt
	 *
	 * @param string $newProfileSalt new value of profile salt
	 * @throws \InvalidArgumentException if $newProfileSalt is empty or not a valid string
	 * @throws \RangeException is $newProfileSalt is > 64 characters
	 **/
	public function setProfileSalt(string $newProfileSalt) {
		// verify the profile salt id valid
		$newProfileSalt = trim($newProfileSalt);
		$newProfileSalt = strtolower($newProfileSalt);
		if(ctype_xdigit($newProfileSalt) === false) {
			throw (new \InvalidArgumentException("salt us empty or has invalid contents"));
		}
		if(strlen($newProfileSalt) !== 64) {
			throw(new \RangeException("salt length" . strlen($newProfileSalt) . "is incorrect length"));
		}
		// store the profile salt
		$this->profileSalt = $newProfileSalt;
	}

	/**
	 * inserts this Profile into mySQL
	 *
	 * @param \PDO $pdo connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		//enforce the profileId is null (i.e., don't insert a profile that already exists)
		if($this->profileId !== null) {
			throw(new \PDOException("not a new profile"));
		}

		//create query template
		$query = "INSERT INTO profile(profileId, profileEmail, profileHash, profileSalt) VALUES(:profileId, :profileEmail, :profileHash, :profileSalt)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profileSalt" => $this->profileSalt];
		$statement->execute($parameters);

		//update the null profileId with what mySQL just gave us
		$this->profileId = intval($pdo->lastInsertId());
	}
	/**
	 * deleted this profile from mySQL
	 *
	 * @param \PDO $pdo connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) {
		//enforce the profileId is null (i.e., don't insert a profile that already exists)
		if($this->profileId === null) {
			throw(new \PDOException("unable to delete a profile that does not exist"));
		}

		//create query template
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId];
		$statement->execute($parameters);
	}
	/**
	 * updates this profile from mySQL
	 *
	 * @param \PDO $pdo connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) {
		//enforce the profileId is null (i.e., don't update a profile that hasn't been inserted)
		if($this->profileId === null) {
			throw(new \PDOException("unable to update a profile that does not exist"));
		}

		//create query template
		$query = "UPDATE profile SET profileId = :profileId, profileEmail = :profileEmail, profileHash = :profileHash, profileSalt = :profileSalt";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profileSalt" => $this->profileSalt];
		$statement->execute($parameters);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
			$fields = get_object_vars($this);
			unset($fields["profileHash , profileSalt"]);
			return($fields);

		// TODO: Implement jsonSerialize() method.
	}
}
