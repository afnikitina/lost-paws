<?php
namespace Jisbell347\LostPaws\Test;
/**
 * TODO: Add oAuth
 */
use Jisbell347\LostPaws\{
	Profile,
	Animal,
	OAuth
};
use PDO;
use PHPUnit\DbUnit\TestCase;

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Animal class
 *
 * This is a complete PHPUnit test of the Animal class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see \Jisbell347\LostPaws\Animal
 * @author Jude Baca-Miller <judeamiller@gmail.com>
 **/

Class AnimalTest extends LostPawsTest{
	/**
	 * OAuth Id that created profile
	 * @var OAuth oAuth
	 */
	protected $oAuth = null;
	/**
	 * Profile that created the Animal: this is the foreign key
	 * @var Profile profile
	 **/
	protected $profile = null;
	/**
	 * Color of the Animal
	 * @var string $VALID_ANIMAL_COLOR
	 **/
	protected $VALID_ANIMAL_COLOR = "PHPUnit test passing";
	/**
	 * Updated color of the Animal
	 * @var string $VALID_ANIMAL_COLOR2
	 **/
	protected $VALID_ANIMAL_COLOR2 = "PHPUnit test is still passing";
	/**
	 * timestamp of the Animal; this starts as null and is assigned later
	 * @var \DateTime $VALID_ANIMAL_DATE
	 **/
	protected $VALID_ANIMAL_DATE = null;
	/**
	 * update timestamp of the Animal; this starts as null and is assigned later
	 * @var \DateTime $VALID_ANIMAL_DATE2
	 **/
	protected $VALID_ANIMAL_DATE2 = null;
	/**
	 * Description of the Animal
	 * @var string $VALID_ANIMAL_DESCRIPTION
	 **/
	protected $VALID_ANIMAL_DESCRIPTION = "PHPUnit test passing";
	/**
	 * Updated description of the Animal
	 * @var string $VALID_ANIMAL_DESCRIPTION2
	 **/
	protected $VALID_ANIMAL_DESCRIPTION2 = "PHPUnit test is still passing";
	/**
	 * Gender of the Animal
	 * @var string $VALID_ANIMAL_GENDER
	 **/
	protected $VALID_ANIMAL_GENDER = "PHPUnit test passing";
	/**
	 * Updated Gender of the Animal
	 * @var string $VALID_ANIMAL_GENDER2
	 **/
	protected $VALID_ANIMAL_GENDER2 = "PHPUnit test is still passing";
	/**
	 * URL of Animal photo
	 * @var string $VALID_ANIMAL_IMAGEURL
	 **/
	protected $VALID_ANIMAL_IMAGEURL = "PHPUnit test passing";
	/**
	 * Updated URL of Animal photo
	 * @var string $VALID_ANIMAL_IMAGEURL2
	 **/
	protected $VALID_ANIMAL_IMAGEURL2 = "PHPUnit test is still passing";
	/**
	 * Location of the Animal
	 * @var string $VALID_ANIMAL_LOCATION
	 **/
	protected $VALID_ANIMAL_LOCATION = "PHPUnit test passing";
	/**
	 * Updated location of the Animal
	 * @var string $VALID_ANIMAL_LOCATION2
	 **/
	protected $VALID_ANIMAL_LOCATION2 = "PHPUnit test is still passing";
	/**
	 * Name of the Animal
	 * @var string $VALID_ANIMAL_NAME
	 **/
	protected $VALID_ANIMAL_NAME = "PHPUnit test passing";
	/**
	 * Updated name of the Animal
	 * @var string $VALID_ANIMAL_NAME2
	 **/
	protected $VALID_ANIMAL_NAME2 = "PHPUnit test is still passing";
	/**
	 * Species of the Animal
	 * @var string $VALID_ANIMAL_SPECIES
	 **/
	protected $VALID_ANIMAL_SPECIES = "PHPUnit test passing";
	/**
	 * Updated species of the Animal
	 * @var string $VALID_ANIMAL_SPECIES2
	 **/
	protected $VALID_ANIMAL_SPECIES2 = "PHPUnit test is still passing";
	/**
	 * Status of the Animal
	 * @var string $VALID_ANIMAL_STATUS
	 **/
	protected $VALID_ANIMAL_STATUS = "PHPUnit test passing";
	/**
	 * Updated status of the Animal
	 * @var string $VALID_ANIMAL_STATUS2
	 **/
	protected $VALID_ANIMAL_STATUS2 = "PHPUnit test is still passing";




	/**
	 * Valid timestamp to use as an OLD_ANIMAL_POST_DATE
	 **/
	protected $VALID_OLD_ANIMAL_POST_DATE = null;
	/**
	 * Valid timestamp to use as an NEW_ANIMAL_POST_DATE
	 **/
	protected $VALID_NEW_ANIMAL_POST_DATE = null;


	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp(): void {
		parent::setUp();
		//create and insert a Profile to own and test the Animal.
		$this->oAuth = new OAuth($this->oAuth->getOAuthId(),$this->oAuth->getOAuthSource());
		//Replaced info below with filler as per tweet example. Not sure if this is correct.
		//$this->profile = new Profile($this->profile->getProfileId(), $this->profile->getProfileOAuthId(), $this->profile->getProfileAccessToken(), $this->profile->getProfileEmail(), $this->profile->getProfileName(), $this->profile->getProfilePhone());
		$this->profile = new Profile(generateUuidV4(), "Google", null, "juantabo@aol.com", "Juan Tabo", "505-869-5309");
		$this->profile->insert($this->getPDO());
		//calculate the date(use the time the unit test was setup)
		$this->VALID_ANIMAL_DATE = new \DateTime();
		//format the new animal post date to use for testing P5D means period of 5 days
		$this->VALID_NEW_ANIMAL_POST_DATE = new \DateTime();
		$this->VALID_NEW_ANIMAL_POST_DATE->sub(new \DateInterval("P5D"));
		//format the old animal post date to use for testing
		$this->VALID_OLD_ANIMAL_POST_DATE = new \DateTime();
		$this->VALID_OLD_ANIMAL_POST_DATE->sub(new \DateInterval("P5D"));
	}

	/**
	 * test inserting a valid Animal Posting, and verify that the actual mySQL data matches
	 **/
	public function testInsertValidAnimal(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("animal");
		//create a new Animal and insert into mySQL
		$animalId = generateUuidV4();
		$animal = new Animal($animalId, $this->profile->getProfileId(),$this->VALID_ANIMAL_COLOR, $this->VALID_ANIMAL_DATE, $this->VALID_ANIMAL_DESCRIPTION, $this->VALID_ANIMAL_GENDER,$this->VALID_ANIMAL_IMAGEURL, $this->VALID_ANIMAL_LOCATION, $this->VALID_ANIMAL_NAME, $this->VALID_ANIMAL_SPECIES, $this->VALID_ANIMAL_STATUS);
		$animal->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAnimal = Animal::getAnimalByAnimalId($this->getPDO(),$animal->getAnimalId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("animal"));
		$this->assertEquals($pdoAnimal->getAnimalId(), $animalId);
		$this->assertEquals($pdoAnimal->getAnimalProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoAnimal->getAnimalColor(), $this->VALID_ANIMAL_COLOR);
		$this->assertEquals($pdoAnimal->getAnimalDescription(),$this->VALID_ANIMAL_DESCRIPTION);
		$this->assertEquals($pdoAnimal->getAnimalGender(), $this->VALID_ANIMAL_GENDER);
		$this->assertEquals($pdoAnimal->getAnimalImageUrl(),$this->VALID_ANIMAL_IMAGEURL);
		$this->assertEquals($pdoAnimal->getAnimalLocation(), $this->VALID_ANIMAL_LOCATION);
		$this->assertEquals($pdoAnimal->getAnimalName(),$this->VALID_ANIMAL_NAME);
		$this->assertEquals($pdoAnimal->getAnimalSpecies(), $this->VALID_ANIMAL_SPECIES);
		$this->assertEquals($pdoAnimal->getAnimalStatus(), $this->VALID_ANIMAL_STATUS);
		//format the date to seconds since the beginning of time to avoid round off error.
		$this->assertEquals($pdoAnimal->getAnimalDate()->getTimestamp(), $this->VALID_ANIMAL_DATE->getTimestamp());
	}
	/**
	 * test inserting an animal, editing, then updating it
	 */
	public function testUpdateValidAnimal() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("animal");
		//create a new Animal and insert into mySQL
		$animalId = generateUuidV4();
		$animal = new Animal($animalId, $this->profile->getProfileId(),$this->VALID_ANIMAL_COLOR, $this->VALID_ANIMAL_DATE, $this->VALID_ANIMAL_DESCRIPTION, $this->VALID_ANIMAL_GENDER,$this->VALID_ANIMAL_IMAGEURL, $this->VALID_ANIMAL_LOCATION, $this->VALID_ANIMAL_NAME, $this->VALID_ANIMAL_SPECIES, $this->VALID_ANIMAL_STATUS);
		$animal->insert($this->getPDO());
		//edit the Animal and update it in mySQL
		$animal->setAnimalDescription($this->VALID_ANIMAL_DESCRIPTION2);
		$animal->update($this->getPDO());
		//grab the data from mySQL and enforce the fields to match our expectations
		$pdoAnimal = Animal::getAnimalByAnimalId($this->getPDO(),$animal->getAnimalId());
		$this->assertEquals($pdoAnimal->getAnimalId(), $animalId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("animal"));
		$this->assertEquals($pdoAnimal->getAnimalProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoAnimal->setAnimalDescription(), $this->VALID_ANIMAL_DESCRIPTION2);
		//format the date to seconds since the beginning of time to avoid round off error.
		$this->assertEquals($pdoAnimal->getAnimalDate()->getTimestamp(), $this->VALID_ANIMAL_DATE->getTimestamp());
	}
	/**
	 * Test creating an Animal and then removing it.
	 **/
	public function testDeleteValidAnimal(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("animal");
		//create a new Animal and insert into mySQL
		$animalId = generateUuidV4();
		$animal = new Animal($animalId, $this->profile->getProfileId(),$this->VALID_ANIMAL_COLOR, $this->VALID_ANIMAL_DATE, $this->VALID_ANIMAL_DESCRIPTION, $this->VALID_ANIMAL_GENDER,$this->VALID_ANIMAL_IMAGEURL, $this->VALID_ANIMAL_LOCATION, $this->VALID_ANIMAL_NAME, $this->VALID_ANIMAL_SPECIES, $this->VALID_ANIMAL_STATUS);
		$animal->insert($this->getPDO());
		// Delete the animal from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("animal"));
		$animal->delete($this->getPDO());
		//grab the data from mySQL and enforce that the animal is removed.
		$pdoAnimal = Animal::getAnimalByAnimalId($this->getPDO(), $animal->getAnimalId());
		$this->assertNull($pdoAnimal);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("animal"));
	}
	/**
	 * test grabbing an an Animal that does not exist (AKA Grab Unicorn)
	 */
	public function testGetInvalidAnimalByAnimalId() : void {
		// grab a profile id that exceeds the max allowable profile id
		$animal = Animal::getAnimalByAnimalId($this->getPDO(), generateUuidV4());
		$this->assertNull($animal);
	}
	/**
	 * test grabbing an animal by animal color
	 */
	public function testGetAnimalByAnimalColor() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("animal");
		//create a new Animal and insert into mySQL
		$animalId = generateUuidV4();
		$animal = new Animal($animalId, $this->profile->getProfileId(),$this->VALID_ANIMAL_COLOR, $this->VALID_ANIMAL_DATE, $this->VALID_ANIMAL_DESCRIPTION, $this->VALID_ANIMAL_GENDER,$this->VALID_ANIMAL_IMAGEURL, $this->VALID_ANIMAL_LOCATION, $this->VALID_ANIMAL_NAME, $this->VALID_ANIMAL_SPECIES, $this->VALID_ANIMAL_STATUS);
		$animal->insert($this->getPDO());
		// grab the data from mySQL and enforce that the fields match expectations
		$results = Animal::getAnimalByAnimalColor($this->getPDO(), $animal->getAnimalColor());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("animal"));
		$this->assertCount(1, $results);
		//enforce that no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Jisbell347\LostPaws\php\Animal", $results);
		//grab the result from the array and validate it
		$pdoAnimal = $results[0];
		$this->assertEquals($pdoAnimal->getAnimalId(), $animalId);
		$this->assertEquals($pdoAnimal->getAnimalProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoAnimal->getAnimalColor(), $this->VALID_ANIMAL_COLOR);
		$this->assertEquals($pdoAnimal->getAnimalDescription(),$this->VALID_ANIMAL_DESCRIPTION);
		$this->assertEquals($pdoAnimal->getAnimalGender(), $this->VALID_ANIMAL_GENDER);
		$this->assertEquals($pdoAnimal->getAnimalImageUrl(),$this->VALID_ANIMAL_IMAGEURL);
		$this->assertEquals($pdoAnimal->getAnimalLocation(), $this->VALID_ANIMAL_LOCATION);
		$this->assertEquals($pdoAnimal->getAnimalName(),$this->VALID_ANIMAL_NAME);
		$this->assertEquals($pdoAnimal->getAnimalSpecies(), $this->VALID_ANIMAL_SPECIES);
		$this->assertEquals($pdoAnimal->getAnimalStatus(), $this->VALID_ANIMAL_STATUS);
		//format the date to seconds since the beginning of time to avoid round off error.
		$this->assertEquals($pdoAnimal->getAnimalDate()->getTimestamp(), $this->VALID_ANIMAL_DATE->getTimestamp());
	}
	/**
	 * test grabbing an animal by an animal color that does not exist
	 */
	public function testGetInvalidAnimalByAnimalColor() : void {
		//grab an animal by color that does not exist for an animal
		$animal = Animal::getAnimalByAnimalColor($this->getPDO(),"purple");
		$this->assertCount(0, $animal);
	}
	/**
	 * test grabbing an animal by animal description
	 */
	public function testGetAnimalByAnimalDescription() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("animal");
		//create a new Animal and insert into mySQL
		$animalId = generateUuidV4();
		$animal = new Animal($animalId, $this->profile->getProfileId(),$this->VALID_ANIMAL_COLOR, $this->VALID_ANIMAL_DATE, $this->VALID_ANIMAL_DESCRIPTION, $this->VALID_ANIMAL_GENDER,$this->VALID_ANIMAL_IMAGEURL, $this->VALID_ANIMAL_LOCATION, $this->VALID_ANIMAL_NAME, $this->VALID_ANIMAL_SPECIES, $this->VALID_ANIMAL_STATUS);
		$animal->insert($this->getPDO());
		// grab the data from mySQL and enforce that the fields match expectations
		$results = Animal::getAnimalByAnimalDescription($this->getPDO(), $animal->getAnimalDescription());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("animal"));
		$this->assertCount(1, $results);
		//enforce that no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Jisbell347\LostPaws\php\Animal", $results);
		//grab the result from the array and validate it
		$pdoAnimal = $results[0];
		$this->assertEquals($pdoAnimal->getAnimalId(), $animalId);
		$this->assertEquals($pdoAnimal->getAnimalProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoAnimal->getAnimalColor(), $this->VALID_ANIMAL_COLOR);
		$this->assertEquals($pdoAnimal->getAnimalDescription(),$this->VALID_ANIMAL_DESCRIPTION);
		$this->assertEquals($pdoAnimal->getAnimalGender(), $this->VALID_ANIMAL_GENDER);
		$this->assertEquals($pdoAnimal->getAnimalImageUrl(),$this->VALID_ANIMAL_IMAGEURL);
		$this->assertEquals($pdoAnimal->getAnimalLocation(), $this->VALID_ANIMAL_LOCATION);
		$this->assertEquals($pdoAnimal->getAnimalName(),$this->VALID_ANIMAL_NAME);
		$this->assertEquals($pdoAnimal->getAnimalSpecies(), $this->VALID_ANIMAL_SPECIES);
		$this->assertEquals($pdoAnimal->getAnimalStatus(), $this->VALID_ANIMAL_STATUS);
		//format the date to seconds since the beginning of time to avoid round off error.
		$this->assertEquals($pdoAnimal->getAnimalDate()->getTimestamp(), $this->VALID_ANIMAL_DATE->getTimestamp());
	}
	/**
	 * test grabbing an animal by an animal description that does not exist
	 */
	public function testGetInvalidAnimalByAnimalDescription() : void {
		//grab an animal by a description that does not exist for an animal
		$animal = Animal::getAnimalByAnimalDescription($this->getPDO(), "Salvage Title but it just needs a bumper, Low Miles, A/C needs recharge, Owned by a Non-Smoker. $10,000. No low ballers. I know what I have!");
		$this->assertCount(0, $animal);
	}
	/**
	 * Test grabbing all of the animals
	 */
	public function testGetAllValidAnimals() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("animal");
		//create a new Animal and insert into mySQL
		$animalId = generateUuidV4();
		$animal = new Animal($animalId, $this->profile->getProfileId(),$this->VALID_ANIMAL_COLOR, $this->VALID_ANIMAL_DATE, $this->VALID_ANIMAL_DESCRIPTION, $this->VALID_ANIMAL_GENDER,$this->VALID_ANIMAL_IMAGEURL, $this->VALID_ANIMAL_LOCATION, $this->VALID_ANIMAL_NAME, $this->VALID_ANIMAL_SPECIES, $this->VALID_ANIMAL_STATUS);
		$animal->insert($this->getPDO());
		// grab the data from mySQl and enforce that the fields match expectations.
		$results = Animal::getAllAnimals($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("animal"));
		$this->assertCount(1, $results);
		//enforce that no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Jisbell347\LostPaws\php\Animal", $results);
		//grab the result from the array and validate it.
		$pdoAnimal = $results[0];
		$this->assertEquals($pdoAnimal->getAnimalId(), $animalId);
		$this->assertEquals($pdoAnimal->getAnimalProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoAnimal->getAnimalColor(), $this->VALID_ANIMAL_COLOR);
		$this->assertEquals($pdoAnimal->getAnimalDescription(),$this->VALID_ANIMAL_DESCRIPTION);
		$this->assertEquals($pdoAnimal->getAnimalGender(), $this->VALID_ANIMAL_GENDER);
		$this->assertEquals($pdoAnimal->getAnimalImageUrl(),$this->VALID_ANIMAL_IMAGEURL);
		$this->assertEquals($pdoAnimal->getAnimalLocation(), $this->VALID_ANIMAL_LOCATION);
		$this->assertEquals($pdoAnimal->getAnimalName(),$this->VALID_ANIMAL_NAME);
		$this->assertEquals($pdoAnimal->getAnimalSpecies(), $this->VALID_ANIMAL_SPECIES);
		$this->assertEquals($pdoAnimal->getAnimalStatus(), $this->VALID_ANIMAL_STATUS);
		//format the date to seconds since the beginning of time to avoid round off error.
		$this->assertEquals($pdoAnimal->getAnimalDate()->getTimestamp(), $this->VALID_ANIMAL_DATE->getTimestamp());
	}
}