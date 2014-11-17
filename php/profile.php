<?php
/**
 * mySQL Enabled Profile
 *
 * This is an mySQL enabled container fot the Profile authentication
 *
 * @author Steven Chavez <schavez256@yahoo.com>
 * @see Profile
 **/
class Profile
{
	/**
	 * profile id for Profile; Primary Key
	 */
	private $profileId;
	/**
	 * userId for Profile; Foreign Key
	 **/
	private $userId;
	/**
	 * firstName for Profile; not null
	 **/
	private $firstName;
	/**
	 * last name for Profile; not null
	 **/
	private $lastName;
	/**
	 * middle name for Profile
	 **/
	private $middleName;
	/**
	 * location associated with Profile
	 **/
	private $location;
	/**
	 * Description associated with Profile
	 **/
	private $description;
	/**
	 * File name of the picture associated with Profile
	 **/
	private $profilePicFileName;
	/**
	 * File type of the profile picture associated with Profile
	 **/
	private $profilePicFileType;

	/**
	 * Constructor of Profile
	 *
	 * @param int    $newProfileId   profileId
	 * @param int    $newUserId      userId
	 * @param string $newFirstName   firstName
	 * @param string $newLastName    lastName
	 * @param string $newMiddleName  middleName
	 * @param string $newLocation    location
	 * @param string $newDesc        description
	 * @param string $newPicFileName profilePicFileName
	 * @param string $newPicFileType profilePicFileType
	 */
	public function __construct($newProfileId, $newUserId, $newFirstName,
										 $newLastName, $newMiddleName, $newLocation,
										 $newDesc, $newPicFileName, $newPicFileType)
	{
		try {
			$this->setProfileId($newProfileId);
			$this->setUserId($newUserId);
			$this->setFirstName($newFirstName);
			$this->setLastName($newLastName);
			$this->setMiddleName($newMiddleName);
			$this->setLocation($newLocation);
			$this->setDescription($newDesc);
			$this->setProfilePicFileName($newPicFileName);
			$this->setProfilePicFileType($newPicFileType);
		} catch(UnexpectedValueException $unexpectedValue) {
			//rethrow to the caller
			throw(new UnexpectedValueException("Unable to construct Profile", 0, $unexpectedValue));
		} catch(RangeException $range) {
			//rethrow to the caller
			throw(new RangeException("Unable to construct Profile", 0, $range));
		}

	}

	/**
	 * gets value of $profileId
	 *
	 * @return mixed $profileId int or null if new object
	 */
	public function getProfileId()
	{
		return $this->profileId;
	}


	/**
	 * sets the value for profileId
	 *
	 * @param mixed $newProfileId profile id(or null if new object
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if profile id isn't positive
	 */
	public function setProfileId($newProfileId)
	{
		// zeroth, set allow the profile id to be null if a new object
		if($newProfileId === null) {
			$this->profileId = null;
			return;
		}

		// first, make sure profile id is an integer
		if(filter_var($newProfileId, FILTER_VALIDATE_INT) == false) {
			throw(new UnexpectedValueException("profile id $newProfileId is not numeric"));
		}

		//second, enforce that user id is an integer and positive
		$newProfileId = intval($newProfileId);
		if($newProfileId <= 0) {
			throw(new RangeException("profile id $newProfileId is not positive"));
		}

		// finally after sanitizing data assign it
		$this->profileId = $newProfileId;
	}

	/**
	 * get value of $userId
	 *
	 * @return int $userId
	 */
	public function getUserId()
	{
		return $this->userId;
	}


	/**
	 * sets the value for userId
	 *
	 * @param int $newUserId user id
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if user id isn't positive
	 */
	public function setUserId($newUserId)
	{
		// first, make sure user id is an integer
		if(filter_var($newUserId, FILTER_VALIDATE_INT) == false) {
			throw(new UnexpectedValueException("user id $newUserId is not numeric"));
		}

		//second, enforce that user id is an integer and positive
		$newUserId = intval($newUserId);
		if($newUserId <= 0) {
			throw(new RangeException("user id $newUserId is not positive"));
		}

		// finally after sanitizing data assign it
		$this->userId = $newUserId;
	}

	/**
	 * gets value of $firstName
	 *
	 * @return string $firstName
	 */
	public function getFirstName()
	{
		return $this->firstName;
	}



	/**
	 * sets the value of first name
	 *
	 * @param string $newFirstName firstName
	 * @throws UnexpectedValueException if the input does not appear to be an name
	 * @throws RangeException if the input exceeds 64 characters
	 */
	public function setFirstName($newFirstName)
	{
		//first we take out the white space
		$newFirstName = trim($newFirstName);

		//Second we ensure that input is a string
		if(filter_var($newFirstName, FILTER_SANITIZE_STRING) === false) {
			throw(new UnexpectedValueException("First name $newFirstName is not string"));
		}

		//third make sure length is not greater than 64
		if(strlen($newFirstName) > 64) {
			throw(new RangeException("First name $newFirstName exceeds 64 character limit"));
		}

		//assign value
		$this->firstName = $newFirstName;
	}

	/**
	 * get value of $lastName
	 *
	 * @return string $lastName
	 */
	public function getLastName()
	{
		return $this->lastName;
	}



	/**
	 * sets the value of last name
	 *
	 * @param string $newLastName last name
	 * @throws UnexpectedValueException if the input does not appear to be an name
	 * @throws RangeException if the input exceeds 64 characters
	 */
	public function setLastName($newLastName)
	{
		//first we take out the white space
		$newLastName = trim($newLastName);

		//Second we ensure that input is a string
		if(filter_var($newLastName, FILTER_SANITIZE_STRING) === false) {
			throw(new UnexpectedValueException("Last name $newLastName is not string"));
		}

		//third make sure length is not greater than 64
		if(strlen($newLastName) > 64) {
			throw(new RangeException("First name $newLastName exceeds 64 character limit"));
		}

		//assign value
		$this->lastName = $newLastName;
	}

	/**
	 * get value of $middleName
	 *
	 * @return mixed $middleName string or null if user has no middle name
	 */
	public function getMiddleName()
	{
		return $this->middleName;
	}



	/**
	 * sets the value of middle name
	 *
	 * @param string $newMiddleName middle name
	 * @throws UnexpectedValueException if the input does not appear to be an name
	 * @throws RangeException if the input exceeds 64 characters
	 */
	public function setMiddleName($newMiddleName)
	{
		//zeroth check to see if middle name is null
		if($newMiddleName === null) {
			$this->middleName = null;
			return;
		}
		//first we take out the white space
		$newMiddleName = trim($newMiddleName);

		//Second we ensure that input is a string
		if(filter_var($newMiddleName, FILTER_SANITIZE_STRING) === false) {
			throw(new UnexpectedValueException("Middle name $newMiddleName is not string"));
		}

		//third make sure length is not greater than 64
		if(strlen($newMiddleName) > 64) {
			throw(new RangeException("First name $newMiddleName exceeds 64 character limit"));
		}

		$this->middleName = $newMiddleName;
	}

	/**
	 * get value of location
	 *
	 * @return mixed $location string or null if no location
	 */
	public function getLocation()
	{
		return $this->location;
	}



	/**
	 * sets location to Profile
	 *
	 * @param string $newLocation location
	 * @throws UnexpectedValueException if the input does not appear to be a string
	 * @throws RangeException if the input exceeds 256 characters
	 */
	public function setLocation($newLocation)
	{
		//zeroth, allow the location to be null if a new object
		if($newLocation === null) {
			$this->location = null;
			return;
		}

		//first, sanitize string from tags
		if(filter_var($newLocation, FILTER_SANITIZE_STRING) === false) {
			throw(new UnexpectedValueException("location $newLocation doesn't appear to be string"));
		}

		//Ensure that location doesn't exceed 256
		if(strlen($newLocation) > 256) {
			throw(new RangeException("location $newLocation exceeds 256 character limit"));
		}

		// assign variable
		$this->location = $newLocation;

	}

	/**
	 * get value of description
	 *
	 * @return mixed $description string or null if no value
	 */
	public function getDescription()
	{
		return $this->description;
	}



	/**
	 * sets description for Profile
	 *
	 * @param string $newDesc location
	 * @throws UnexpectedValueException if the input does not appear to be a string
	 * @throws RangeException if the input exceeds 4096 characters
	 */
	public function setDescription($newDesc)
	{
		//zeroth, allow the Description to be null if a new object
		if($newDesc === null) {
			$this->description = null;
			return;
		}

		//first, sanitize string from tags
		if(filter_var($newDesc, FILTER_SANITIZE_STRING) === false) {
			throw(new UnexpectedValueException("location $newDesc doesn't appear to be string"));
		}

		//Ensure that description doesn't exceed 4096
		if(strlen($newDesc) > 4096) {
			throw(new RangeException("description exceeds 256 character limit"));
		}

		// assign variable
		$this->description = $newDesc;

	}

	/**
	 * get value of $profilePicFilename
	 *
	 * @return mixed $profilePicFilename string or null if no value
	 */
	public function getProfilePicFileName()
	{
		return $this->profilePicFileName;
	}



	/**
	 * sets profilePicFileName for Profile
	 *
	 * @param string $newPicFileName profilePicFileName
	 * @throws UnexpectedValueException if not valid upload file
	 * @returns valid upload file
	 **/
	public function setProfilePicFileName($newPicFileName)
	{
		//zeroth, set allow the PicFileName to be null if null
		if($newPicFileName === null) {
			$this->profilePicFileName = null;
			return;
		}

		//make directory to upload to
		$uploadDir = "/uploads";   //TODO: not real directory for uploads

		if((move_uploaded_file($newPicFileName, $uploadDir)) === false) {
			//throw(new UnexpectedValueException("file name $newPicFileName is not a valid upload file"));
		}

		//assign value
		$this->profilePicFileName = $newPicFileName;

		//Todo Profile pic file name
		//can you set up a place to upload pics ask dylan
		//move_uploaded_file
	}

	/**
	 * get value for $profilePicFileType
	 *
	 * @return mixed $profilePicFileType string or null if no value
	 */
	public function getProfilePicFileType()
	{
		return $this->profilePicFileType;
	}


	/**
	 * sets profilePicFileType for Profile
	 *
	 * @param string $newPicFileType profilePicFileType
	 * @throws UnexpectedValueException if file type not allowed
	 **/
	public function setProfilePicFileType($newPicFileType){
		//if file type is null let it be null
		if($newPicFileType === null){
			$this->profilePicFileType = null;
			return;
		}

		//check file type given by browser and see if it matches
		//one of the three png, jpg, gif.
		if($newPicFileType == "png"){
			/*$imgResourceId = imagecreatefrompng($newPicFileType);
			if($imgResourceId === false){
				throw(new UnexpectedValueException("file type $newPicFileType is not png"));
			}*/
		}
		elseif($newPicFileType == "jpeg"){
			/*$imgResourceId = imagecreatefromjpeg($newPicFileType);
			if($imgResourceId === false) {
				throw(new UnexpectedValueException("file type $newPicFileType is not jpeg"));
			}*/
		}
		elseif($newPicFileType == "gif"){
			/*$imgResourceId = imagecreatefromgif($newPicFileType);
			if($imgResourceId === false){
				throw(new UnexpectedValueException("file type $newPicFileType is not gif"));
			}*/
		}
		else{
			throw(new UnexpectedValueException("file type $newPicFileType is not supported"));
		}

		//free any memory associated with image
		//imagedestroy($newPicFileType);

		//Todo:Fix the above once you go over uploads
		$this->profilePicFileType = $newPicFileType;

		//	TODO profile pic file type
		//	in data base store mime type image/*
		//	take type from browser
		//	after taking that on faith; we through our faith away
		//	imgcreatefromfoo
		//	imgdestroy*/

	}

	/**
	 * insert this Profile to mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throw mysqli_sql_exception when mySQL related errors occur.
	 **/
	public function insert(&$mysqli){
		//handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the profileId is null (i.e., don't insert a user that already exists)
		if($this->profileId !== null) {
			throw(new mysqli_sql_exception("not a new profile"));
		}

		//create query template
		$query = "INSERT INTO profile(userId, firstName, lastName, middleName, location, description, profilePicFileName, profilePicFileType) VALUES(?,?,?,?,?,?,?,?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		//bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("isssssss", $this->userId, $this->firstName, $this->lastName,
														$this->middleName, $this->location, $this->description,
														$this->profilePicFileName, $this->profilePicFileType);
		if($wasClean === false){
			throw(new mysqli_sql_exception("unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false){
			throw(new mysqli_sql_exception("unable to execute mySQL statement"));
		}

		//update the null profileId with what mySQL just gave us
		$this->profileId = $mysqli->insert_id;
	}

	/**
	 * deletes this Profile from mySQL
	 * @param resources $mysqli pointer to mySQL connections, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function delete(&$mysqli)
	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// make sure profileId is not null
		if($this->profileId === null) {
			throw(new mysqli_sql_exception("Unable to delete a user that does not exist"));
		}

		//create query template
		$query = "DELETE FROM profile WHERE profileId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		//bind the member variables to the place holder in the template
		$wasClean = $statement->bind_param("i", $this->profileId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}

	/**
	 * updates this Profile in mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function update(&$mysqli){
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the profileId is not null (i.e., don't update a user that hasn't been inserted)
		if($this->profileId === null) {
			throw(new mysqli_sql_exception("Unable to update a user that does not exist"));
		}

		//create query template
		$query = "UPDATE profile SET userId = ?, firstName = ?, lastName = ?, middleName = ?, location = ?, description = ?, profilePicFileName = ?, profilePicFileType =? WHERE profileId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false){
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		//bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("isssssssi", $this->userId, $this->firstName, $this->lastName, $this->middleName, $this->location, $this->description, $this->profilePicFileName, $this->profilePicFileType, $this->profileId);
		if($wasClean === false){
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false){
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

	}

	/**
	 * gets the profile by userId
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param string $userId userId to search for
	 * @return mixed User found or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */
	public static function getProfileByUserId(&$mysqli, $userId){
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// sanitize userId before searching
		// first, make sure user id is an integer
		if(filter_var($userId, FILTER_VALIDATE_INT) == false) {
			throw(new UnexpectedValueException("user id $userId is not numeric"));
		}

		//second, enforce that user id is an integer and positive
		$userId = intval($userId);
		if($userId <= 0) {
			throw(new RangeException("user id $userId is not positive"));
		}
	}

}




















?>