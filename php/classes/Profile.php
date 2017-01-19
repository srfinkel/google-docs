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
	* @var string $profileEmail;
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
		//verify the profile id is positive
		if($newProfileId <= 0) {
			throw (new \RangeException("profile id is not positive"));
		}
		//convert and store the profile id
		$this->profileId = $newProfileId;
	}
	/**
	 * accessor method for profile email
	 *
	 * @return string value of profile email
	 **/

}
?>