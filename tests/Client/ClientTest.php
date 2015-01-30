<?php

/**
 * @file
 * Contains \Triquanta\IziTravel\Tests\Client\ClientTest.
 */

namespace Triquanta\IziTravel\Tests\Client;

use GuzzleHttp\Client as HttpClient;
use Triquanta\IziTravel\Client\Client;
use Triquanta\IziTravel\Client\DevelopmentRequestHandler;
use Triquanta\IziTravel\DataType\MtgObjectInterface;
use Triquanta\IziTravel\Tests\TestConfiguration;

/**
 * @coversDefaultClass \Triquanta\IziTravel\Client\Client
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{

  /**
   * The HTTP client.
   *
   * @var \GuzzleHttp\Client
   */
  protected $httpClient;

  /**
   * The request handler.
   *
   * @var \Triquanta\IziTravel\Client\DevelopmentRequestHandler
   */
  protected $requestHandler;

  /**
   * @var \Triquanta\IziTravel\Client\Client
   */
  protected $sut;

  public function setUp() {
    $configuration = TestConfiguration::getConfiguration();

    $this->httpClient = new HttpClient();

    $this->requestHandler = new DevelopmentRequestHandler($this->httpClient, $configuration['apiKey']);

    $this->sut = new Client($this->requestHandler);
  }

  /**
   * @covers ::__construct
   */
  public function test__Construct() {
    $this->sut = new Client($this->requestHandler);
  }

  /**
   * @covers ::getMtgObjectByUuid
   */
  public function testGetMtgObjectByUuid() {
    $uuid = 'bcf57367-77f6-4e39-9da6-1b481826501f';
    $languageCodes = ['en'];

    $mtgObject = $this->sut->getMtgObjectByUuid($uuid, $languageCodes);

    $this->assertInstanceOf('\Triquanta\IziTravel\DataType\CompactMtgObjectInterface', $mtgObject);
  }

  /**
   * @covers ::getMtgObjectsByUuids
   */
  public function testGetMtgObjectsByUuidsInCompactForm() {
    $uuids = ['bcf57367-77f6-4e39-9da6-1b481826501f', '9a7d0fd4-aa50-4d12-a8fa-26f080cd7e0c'];
    $languageCodes = ['en'];

    $mtgObjects = $this->sut->getMtgObjectsByUuids($uuids, $languageCodes, MtgObjectInterface::FORM_COMPACT);

    $this->assertInternalType('array', $mtgObjects);
    foreach ($mtgObjects as $mtgObject) {
      $this->assertInstanceOf('\Triquanta\IziTravel\DataType\CompactMtgObjectInterface', $mtgObject);
    }
  }

  /**
   * @covers ::getMtgObjectsByUuids
   */
  public function testGetMtgObjectsByUuidsInFullForm() {
    $uuids = ['bcf57367-77f6-4e39-9da6-1b481826501f', '9a7d0fd4-aa50-4d12-a8fa-26f080cd7e0c'];
    $languageCodes = ['en'];

    $mtgObjects = $this->sut->getMtgObjectsByUuids($uuids, $languageCodes, MtgObjectInterface::FORM_FULL);

    $this->assertInternalType('array', $mtgObjects);
    foreach ($mtgObjects as $mtgObject) {
      $this->assertInstanceOf('\Triquanta\IziTravel\DataType\FullMtgObjectInterface', $mtgObject);
    }
  }

  /**
   * @covers:: getMtgObjectsChildrenByUuid
   */
  public function testGetMtgObjectsChildrenByUuidInCompactForm() {
    $uuid = 'bcf57367-77f6-4e39-9da6-1b481826501f';
    $languageCodes = ['en'];

    $mtgObjects = $this->sut->getMtgObjectsChildrenByUuid($uuid, $languageCodes, MtgObjectInterface::FORM_COMPACT);

    $this->assertInternalType('array', $mtgObjects);
    foreach ($mtgObjects as $mtgObject) {
      $this->assertInstanceOf('\Triquanta\IziTravel\DataType\CompactMtgObjectInterface', $mtgObject);
    }
  }

  /**
   * @covers:: getMtgObjectsChildrenByUuid
   */
  public function testGetMtgObjectsChildrenByUuidInFullForm() {
    $uuid = 'bcf57367-77f6-4e39-9da6-1b481826501f';
    $languageCodes = ['en'];

    $mtgObjects = $this->sut->getMtgObjectsChildrenByUuid($uuid, $languageCodes, MtgObjectInterface::FORM_FULL);

    $this->assertInternalType('array', $mtgObjects);
    foreach ($mtgObjects as $mtgObject) {
      $this->assertInstanceOf('\Triquanta\IziTravel\DataType\FullMtgObjectInterface', $mtgObject);
    }
  }

  /**
   * @covers ::getCountryByUuid
   */
  public function testGetCountryByUuidInCompactForm() {
    $uuid = '15845ecf-4274-4286-b086-e407ff8207de';
    $languageCodes = ['en'];

    $mtgObject = $this->sut->getCountryByUuid($uuid, $languageCodes, MtgObjectInterface::FORM_COMPACT);

    $this->assertInstanceOf('\Triquanta\IziTravel\DataType\CompactCountryInterface', $mtgObject);
  }

  /**
   * @covers ::getCountryByUuid
   */
  public function testGetCountryByUuidInFullForm() {
    $uuid = '15845ecf-4274-4286-b086-e407ff8207de';
    $languageCodes = ['en'];

    $mtgObject = $this->sut->getCountryByUuid($uuid, $languageCodes, MtgObjectInterface::FORM_FULL);

    $this->assertInstanceOf('\Triquanta\IziTravel\DataType\FullCountryInterface', $mtgObject);
  }

  /**
   * @covers:: getCountries
   */
  public function testGetCountriesInCompactForm() {
    $languageCodes = ['en'];

    $countries = $this->sut->getCountries($languageCodes, MtgObjectInterface::FORM_COMPACT);

    $this->assertInternalType('array', $countries);
    foreach ($countries as $country) {
      $this->assertInstanceOf('\Triquanta\IziTravel\DataType\CompactCountryInterface', $country);
    }
  }

  /**
   * @covers:: getCountries
   */
  public function testGetCountriesInFullForm() {
    $languageCodes = ['en'];

    $countries = $this->sut->getCountries($languageCodes, MtgObjectInterface::FORM_FULL);

    $this->assertInternalType('array', $countries);
    foreach ($countries as $country) {
      $this->assertInstanceOf('\Triquanta\IziTravel\DataType\FullCountryInterface', $country);
    }
  }

}