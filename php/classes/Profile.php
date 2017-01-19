<?php

/**
* The profile of a Google document creator.
*
* This profile will be linked to all documents created by this user. This profile will be connected to this profile's unique e-mail. This profile will also be able to invite other collaborators to any/all the documents they create.
*
* @author Sarah Ruth Finkel <srfinkel@gmail.com>
* @version 3.0.0
**/
class Profile {
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
	 **/
	public function setProfileEmail(string $newProfileEmail) {
		// verify the profile email is secure
		$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_EMAIL);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("email is empty or insecure"));
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
		return($this->profileHash);
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
		 *@param string $newProfileSalt new value of profile salt
		 *@throws \InvalidArgumentException if $newProfileSalt is empty or not a valid string
		 *@throws \RangeException is $newProfileSalt is > 64 characters
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
	}