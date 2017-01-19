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
	* @var string

}
