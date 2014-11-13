<?php
/**
 * Unit test for Topic
 *
 * This is a MySQL enabled container for Topic topic and handling.
 *
 * @author Marc Hayes <marc.hayes.tech@gmail.com>
 */
// require the SimpleTest Framework
require_once("/usr/lib/php5/simpletest/autorun.php");

// require the class under scrutiny
require_once("../php/comment.php");

// require classes that table needs FK data from
// TODO: bring these back in
//require_once("../php/securityClass.php");
//require_once("../php/loginSource.php");
require_once("../php/user.php");
require_once("../php/profile.php");
require_once("../php/topic.php");

// require mysqli connection object
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

// the TopicTest is a container for all our tests
class CommentTest extends UnitTestCase
{
	// variable to hold mysqli connection
	private $mysqli				= null;
	// variable to hold the test results from database
	private $loginSources		= null;
	// variable to hold the test results from database
	private $securityClasses	= null;
	// variable to hold the test results from database
	private $users					= null;
	// variable to hold the test results from database
	private $profiles				= null;
	// variable to hold the test results from database
	private $topics				= null;
	// variable to hold the test results from database
	private $comments				= null;

	// "globals" used for testing
	private $commentSubject 	= "Nunc ac augue a nisl ultricies finibus vel vitae nulla. Etiam accumsan sem blandit ultricies posuere. Nam hendrerit risus vitae dolor porta rutrum congue ac dolor. Cras nisi orci, eleifend et aliquam eu, accumsan sed metus. Cras sed tortor purus cras amet.";
	private $commentBody			= "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus leo enim, pulvinar quis nulla id, commodo commodo mi. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed sed risus fermentum, maximus sem consectetur, elementum erat. Maecenas porta nisl nec rhoncus viverra. Maecenas pellentesque ante enim, a hendrerit arcu fringilla ut. Integer sed erat vitae lorem commodo rutrum placerat tincidunt diam. Nullam convallis elementum odio, sit amet fermentum sem. Ut eget ultrices libero, eu pellentesque nunc.

Maecenas malesuada eget lacus quis tempus. Pellentesque tincidunt interdum neque, eu commodo quam bibendum maximus. Aliquam ut tortor at erat rhoncus scelerisque vestibulum ultrices tortor. Curabitur quis turpis a libero facilisis blandit nec vitae diam. Praesent sit amet molestie dolor. Maecenas posuere turpis nulla, eu ultrices eros egestas ut.";

	// setUp() is a method the is run before each test
	// here, we use it to connect to mySQL (other functionality can be populated depending on test plan
	public function setUp()
	{
		// connect to mySQL
		$this->mysqli = MysqliConfiguration::getMysqli();

		// TODO: set this to use securityClass and loginSourceID from above objects
//		//create new securityClass
//		$this->securityClasses = new SecurityClass(null, "Uber Newb",0,0,0,0,0);
//		$this->securityClasses->insert($this->profiles);
//
//		// create new loginSource
//		$this->loginSources = new LoginSource(null,"thingy.com");
//		$this->loginSources->insert($this->mysqli);

		// create new user
		$this->users = new User(null, "1@1.com", null, null, null, 1, 1);
		$this->users->insert($this->mysqli);

		// create new profile
		$this->profiles = new Profile(null, $this->users->getUserId(), "First", "Last", null, "City", "Tester profile", null, null);
		$this->profiles->insert($this->mysqli);

		// create new topic
		$this->topics = new Topic(null, $this->profiles->getProfileId(), null, "Place holder Topic Subject.", "Place holder Topic Body.");
		$this->topics->insert($this->mysqli);
	}

	// tearDown() is a method that is run after each test
	// here, we use it to delete the test record and disconnect from mySQL
	public function tearDown()
	{
		if($this->comments !== null) {
			$this->comments->delete($this->mysqli);
			$this->comments = null;
		}

		// delete topic object from DB
		$this->topics->delete($this->mysqli);

		// delete profile object from DB
		$this->profiles->delete($this->mysqli);

		// delete user object from DB
		$this->users->delete($this->mysqli);

		// TODO: bring these back in
//		// delete loginSource object from DB
//		$this->loginSources->delete($this->mysqli);
//
//		// delete securityClass object from DB
//		$this->securityClasses->delete($this->mysqli);
	}

	// test comment creation and insertion
	public function testInsertComment() {
		// confirm that mySQL connection is OK
		$this->assertNotNull($this->mysqli);

		// create a comment to post to mySQL
		$this->comments = new Comment(null, $this->topics->getTopicId(), $this->profiles->getProfileId(), null, $this->commentSubject, $this->commentBody);

		// insert comment into mySQL
		$this->comments->insert($this->mysqli);

		// rebuild class from mySQL data for the object
		$this->comments = $this->comments->getCommentByCommentId($this->mysqli, $this->comments->getCommentId());

		// compare the fields
		// commentId
		$this->assertNotNull($this->comments->getCommentId());
		$this->assertTrue($this->comments->getCommentId() > 0);
		// topicId
		$this->assertNotNull($this->comments->getTopicId());
		$this->assertTrue($this->comments->gettopicId() > 0);
		$this->assertIdentical($this->comments->getTopicId(),		$this->topics->getTopicId());
		// profileId
		$this->assertNotNull($this->comments->getProfileId());
		$this->assertTrue($this->comments->getProfileId() > 0);
		$this->assertIdentical($this->comments->getProfileId(),		$this->profiles->getProfileId());
		// topicDate
		$this->assertNotNull($this->comments->getCommentDate());
		// topicSubject
		$this->assertNotNull($this->comments->getCommentSubject());
		$this->assertIdentical($this->comments->getCommentSubject(),	$this->commentSubject);
		// topicBody
		$this->assertNotNull($this->comments->getCommentBody());
		$this->assertIdentical($this->comments->getCommentBody(),		$this->commentBody);
	}

	// test comment update
	public function testUpdateComment() {
		// new subject
		$newSubject = "This is an updated subject";

		// confirm that mySQL connection is OK
		$this->assertNotNull($this->mysqli);

		// create a comment to post to mySQL
		$this->comments = new Comment(null, $this->topics->getTopicId(), $this->profiles->getProfileId(), null, $this->commentSubject, $this->commentBody);

		// insert comment into mySQL
		$this->comments->insert($this->mysqli);

		// rebuild class from mySQL data for the object
		$this->comments = $this->comments->getCommentByCommentId($this->mysqli, $this->comments->getCommentId());

		// change a value then push update
		$this->comments->setCommentSubject($newSubject);
		$this->comments->update($this->mysqli);

		// rebuild class from mySQL data for the object
		$this->comments = $this->comments->getCommentByCommentId($this->mysqli, $this->comments->getCommentId());

		// compare the fields
		// commentId
		$this->assertNotNull($this->comments->getCommentId());
		$this->assertTrue($this->comments->getCommentId() > 0);
		// topicId
		$this->assertNotNull($this->comments->getTopicId());
		$this->assertTrue($this->comments->gettopicId() > 0);
		$this->assertIdentical($this->comments->getTopicId(),		$this->topics->getTopicId());
		// profileId
		$this->assertNotNull($this->comments->getProfileId());
		$this->assertTrue($this->comments->getProfileId() > 0);
		$this->assertIdentical($this->comments->getProfileId(),		$this->profiles->getProfileId());
		// topicDate
		$this->assertNotNull($this->comments->getCommentDate());
		// topicSubject
		$this->assertNotNull($this->comments->getCommentSubject());
		$this->assertIdentical($this->comments->getCommentSubject(),	$newSubject);
		// topicBody
		$this->assertNotNull($this->comments->getCommentBody());
		$this->assertIdentical($this->comments->getCommentBody(),		$this->commentBody);
	}

	// test comment deletion
	public function testDeleteComment() {
		// confirm that mySQL connection is OK
		$this->assertNotNull($this->mysqli);

		// create a comment to post to mySQL
		$this->comments = new Comment(null, $this->topics->getTopicId(), $this->profiles->getProfileId(), null, $this->commentSubject, $this->commentBody);

		// insert comment into mySQL
		$this->comments->insert($this->mysqli);

		// rebuild class from mySQL data for the object
		$this->comments = $this->comments->getCommentByCommentId($this->mysqli, $this->comments->getCommentId());

		// compare the fields
		// commentId
		$this->assertNotNull($this->comments->getCommentId());
		$this->assertTrue($this->comments->getCommentId() > 0);
		// topicId
		$this->assertNotNull($this->comments->getTopicId());
		$this->assertTrue($this->comments->gettopicId() > 0);
		$this->assertIdentical($this->comments->getTopicId(),		$this->topics->getTopicId());
		// profileId
		$this->assertNotNull($this->comments->getProfileId());
		$this->assertTrue($this->comments->getProfileId() > 0);
		$this->assertIdentical($this->comments->getProfileId(),		$this->profiles->getProfileId());
		// topicDate
		$this->assertNotNull($this->comments->getCommentDate());
		// topicSubject
		$this->assertNotNull($this->comments->getCommentSubject());
		$this->assertIdentical($this->comments->getCommentSubject(),	$this->commentSubject);
		// topicBody
		$this->assertNotNull($this->comments->getCommentBody());
		$this->assertIdentical($this->comments->getCommentBody(),		$this->commentBody);

		// delete object
		$this->comments->delete($this->mysqli);

		// get now deleted topic
		$this->comments = $this->comments->getCommentbyCommentId($this->mysqli, $this->comments->getCommentId());

		// assert null
		$this->assertNull($this->comments);
	}

	// test comment object retrieval from database by commentId
	public function testGetCommentByCommentId() {
		// confirm that mySQL connection is OK
		$this->assertNotNull($this->mysqli);

		// create a comment to post to mySQL
		$this->comments = new Comment(null, $this->topics->getTopicId(), $this->profiles->getProfileId(), null, $this->commentSubject, $this->commentBody);

		// insert comment into mySQL
		$this->comments->insert($this->mysqli);

		// rebuild class from mySQL data for the object
		$newComments = Comment::getCommentByCommentId($this->mysqli, $this->comments->getCommentId());

		// compare the fields
		// commentId
		$this->assertNotNull($newComments->getCommentId());
		$this->assertTrue($newComments->getCommentId() > 0);
		// topicId
		$this->assertNotNull($newComments->getTopicId());
		$this->assertTrue($newComments->gettopicId() > 0);
		$this->assertIdentical($newComments->getTopicId(),		$this->topics->getTopicId());
		// profileId
		$this->assertNotNull($newComments->getProfileId());
		$this->assertTrue($newComments->getProfileId() > 0);
		$this->assertIdentical($newComments->getProfileId(),		$this->profiles->getProfileId());
		// topicDate
		$this->assertNotNull($newComments->getCommentDate());
		// topicSubject
		$this->assertNotNull($newComments->getCommentSubject());
		$this->assertIdentical($newComments->getCommentSubject(),	$this->commentSubject);
		// topicBody
		$this->assertNotNull($newComments->getCommentBody());
		$this->assertIdentical($newComments->getCommentBody(),		$this->commentBody);
	}

	// test comment array of objects retrieval from database by topicId
	public function testGetCommentsByTopicId() {
		// TODO: implement testGetCommentsByTopicId
	}

	// test comment array of objects retrieval from database by profileId
	public function testGetCommentsByProfileId() {
		// TODO: implement testGetCommentsByProfileId
	}
}