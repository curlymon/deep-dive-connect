<?php
// first require the SimpleTest framework
require_once("/usr/lib/php5/simpletest/autorun.php");
// then require the class under scrutiny
require_once("../php/securityClass.php");

// the UserTest is a container for all our tests
class SecurityClassTest extends UnitTestCase {
	// variable to hold the mySQL connection
	private $mysqli = null;
	// variable to hold the test database row
	private $security   = null;

	// a few "global" variables for creating test data
	private $DESCRIPTION   = "ChedGeek5";
	private $ISDEFAULT       = null;
	private $CREATETOPIC = null;
	private $CANEDITOTHER       = null;
	private $CANPROMOTE       = null;
	private $SITEADMIN       = null;

	// setUp() is a method that is run before each test

	public function setUp() {
		// connect to mySQL
		mysqli_report(MYSQLI_REPORT_STRICT);
		$this->mysqli = new mysqli("localhost", "store_dylan", "deepdive", "store_dylan");

		// randomize the salt, hash, and authentication token
		$this->SALT       = bin2hex(openssl_random_pseudo_bytes(32));
		$this->AUTH_TOKEN = bin2hex(openssl_random_pseudo_bytes(16));
		$this->HASH       = hash_pbkdf2("sha512", $this->PASSWORD, $this->SALT, 2048, 128);
	}

	// tearDown() is a method that is run after each test
	// here, we use it to delete the test record and disconnect from mySQL
	public function tearDown() {
		// delete the user if we can
		if($this->security !== null) {
			$this->security->delete($this->mysqli);
			$this->security = null;
		}

		// removed the disconnect

	}

	// test creating a new User and inserting it to mySQL
	public function testInsertNewUser() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a user to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTH_TOKEN);

		// third, insert the user to mySQL
		$this->user->insert($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull($this->user->getUserId());
		$this->assertTrue($this->user->getUserId() > 0);
		$this->assertIdentical($this->user->getEmail(),               $this->EMAIL);
		$this->assertIdentical($this->user->getPassword(),            $this->HASH);
		$this->assertIdentical($this->user->getSalt(),                $this->SALT);
		$this->assertIdentical($this->user->getAuthenticationToken(), $this->AUTH_TOKEN);
	}

	// test updating a User in mySQL
	public function testUpdateUser() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a user to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTH_TOKEN);

		// third, insert the user to mySQL
		$this->user->insert($this->mysqli);

		// fourth, update the user and post the changes to mySQL
		$newEmail = "jake@cortez.org.mx";
		$this->user->setEmail($newEmail);
		$this->user->update($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull($this->user->getUserId());
		$this->assertTrue($this->user->getUserId() > 0);
		$this->assertIdentical($this->user->getEmail(),               $newEmail);
		$this->assertIdentical($this->user->getPassword(),            $this->HASH);
		$this->assertIdentical($this->user->getSalt(),                $this->SALT);
		$this->assertIdentical($this->user->getAuthenticationToken(), $this->AUTH_TOKEN);
	}

	// test deleting a User
	public function testDeleteUser() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a user to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTH_TOKEN);

		// third, insert the user to mySQL
		$this->user->insert($this->mysqli);

		// fourth, verify the User was inserted
		$this->assertNotNull($this->user->getUserId());
		$this->assertTrue($this->user->getUserId() > 0);

		// fifth, delete the user
		$this->user->delete($this->mysqli);
		$this->user = null;

		// finally, try to get the user and assert we didn't get a thing
		$hopefulUser = User::getUserByEmail($this->mysqli, $this->EMAIL);
		$this->assertNull($hopefulUser);
	}

	// test grabbing a User from mySQL
	public function testGetUserByEmail() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a user to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTH_TOKEN);

		// third, insert the user to mySQL
		$this->user->insert($this->mysqli);

		// fourth, get the user using the static method
		$staticUser = User::getUserByEmail($this->mysqli, $this->EMAIL);

		// finally, compare the fields
		$this->assertNotNull($staticUser->getUserId());
		$this->assertTrue($staticUser->getUserId() > 0);
		$this->assertIdentical($staticUser->getUserId(),              $this->user->getUserId());
		$this->assertIdentical($staticUser->getEmail(),               $this->EMAIL);
		$this->assertIdentical($staticUser->getPassword(),            $this->HASH);
		$this->assertIdentical($staticUser->getSalt(),                $this->SALT);
		$this->assertIdentical($staticUser->getAuthenticationToken(), $this->AUTH_TOKEN);
	}
}