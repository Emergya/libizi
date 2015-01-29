<?php

/**
 * @file
 * Contains \Triquanta\IziTravel\Tests\DataType\FullCityTest.
 */

namespace Triquanta\IziTravel\Tests\DataType;

use Triquanta\IziTravel\DataType\FullCity;
use Triquanta\IziTravel\DataType\CityInterface;

/**
 * @coversDefaultClass \Triquanta\IziTravel\DataType\FullCity
 */
class FullCityTest extends \PHPUnit_Framework_TestCase
{

  /**
   * The UUID.
   *
   * @var string
   */
  protected $uuid;

  /**
   * The revision hash.
   *
   * @var string
   */
  protected $revisionHash;

  /**
   * The language codes for available translations.
   *
   * @var string[]
   *   Values are ISO 639-1 alpha-2 language codes.
   */
  protected $availableLanguageCodes = [];

  /**
   * The country code.
   *
   * @var string|null
   *   An ISO 3166-1 alpha-2 country code.
   */
  protected $countryCode;

  /**
   * The map.
   *
   * @var \Triquanta\IziTravel\DataType\MapInterface|null
   */
  protected $map;

  /**
   * The translations.
   *
   * @var \Triquanta\IziTravel\DataType\CountryCityTranslationInterface[]
   */
  protected $translations = [];

  /**
   * The location.
   *
   * @var \Triquanta\IziTravel\DataType\LocationInterface|null
   */
  protected $location;

  /**
   * The status.
   *
   * @var string
   */
  protected $status;

  /**
   * The number of child objects.
   *
   * @return int|null
   */
  protected $numberOfChildren;

  /**
   * Whether the object must be visible in listings.
   *
   * @var bool
   */
  protected $visible = false;

  /**
   * The content.
   *
   * @Var \Triquanta\IziTravel\DataType\CityContentInterface[]
   */
  protected $content;

  /**
   * The class under test.
   *
   * @var \Triquanta\IziTravel\DataType\FullCity|\PHPUnit_Framework_MockObject_MockObject
   */
  protected $sut;

  public function setUp()
  {
    $this->uuid = 'foo-bar-baz-' . mt_rand();

    $this->revisionHash = 'hwg98309t82ohtwqlekhgf0823yt';

    $this->availableLanguageCodes = ['nl', 'uk'];

    $this->countryCode = 'UA';

    $this->map = $this->getMock('\Triquanta\IziTravel\DataType\MapInterface');

    $this->translations = [
      $this->getMock('\Triquanta\IziTravel\DataType\CountryCityTranslationInterface'),
      $this->getMock('\Triquanta\IziTravel\DataType\CountryCityTranslationInterface'),
      $this->getMock('\Triquanta\IziTravel\DataType\CountryCityTranslationInterface'),
    ];

    $this->status = CityInterface::STATUS_PUBLISHED;

    $this->numberOfChildren = mt_rand();

    $this->visible = (bool) mt_rand(0, 1);

    $this->location = $this->getMock('\Triquanta\IziTravel\DataType\LocationInterface');

    $this->content = [
      $this->getMock('\Triquanta\IziTravel\DataType\CityContentInterface'),
      $this->getMock('\Triquanta\IziTravel\DataType\CityContentInterface'),
      $this->getMock('\Triquanta\IziTravel\DataType\CityContentInterface'),
    ];

    $this->sut = new FullCity(
        $this->uuid,
        $this->revisionHash,
        $this->availableLanguageCodes,
        $this->map,
        $this->translations,
        $this->location,
        $this->status,
        $this->numberOfChildren,
        $this->visible,
        $this->content
      );
  }

  /**
   * @covers ::__construct
   * @covers ::createFromJson
   * @covers ::createFromData
   */
  public function testCreateFromJson()
  {
    $json = <<<'JSON'
{
        "uuid": "3f879f37-21b0-479d-bd74-aa26f72fa328",
        "type": "city",
        "languages": [
            "nl",
            "de",
            "en",
            "ru",
            "it",
            "es",
            "fr",
            "ja"
        ],
        "status": "published",
        "children_count": 13,
        "translations": [
            {
                "name": "Amsterdam",
                "language": "en"
            },
            {
                "name": "Amesterdão",
                "language": "pt"
            },
            {
                "name": "Amsterdam",
                "language": "ro"
            },
            {
                "name": "Amsterdam",
                "language": "it"
            },
            {
                "name": "Амстердам",
                "language": "ru"
            },
            {
                "name": "Amsterdam",
                "language": "de"
            },
            {
                "name": "阿姆斯特丹",
                "language": "zh"
            },
            {
                "name": "Amsterdam",
                "language": "fr"
            },
            {
                "name": "Amsterdam",
                "language": "nl"
            },
            {
                "name": "Ámsterdam",
                "language": "es"
            },
            {
                "name": "Amsterdam",
                "language": "sv"
            }
        ],
        "map": {
            "bounds": "52.3182742,4.7288558,52.4311573,5.0683775"
        },
        "hash": "68ad379344ed90799b8171f0acda9f62180d9905",
        "visible": true,
        "content": [
            {
                "title": "Amsterdam",
                "summary": "",
                "desc": "",
                "language": "en",
                "images": [
                    {
                        "uuid": "3f879f37-21b0-479d-bd74-aa26f72fa328",
                        "type": "city",
                        "order": 1
                    }
                ]
            }
        ],
        "location": {
            "altitude": 0,
            "latitude": 52.3702157,
            "longitude": 4.8951679,
            "country_code": "nl",
            "country_uuid": "15845ecf-4274-4286-b086-e407ff8207de"
        }
    }
JSON;

    FullCity::createFromJson($json);
  }

  /**
   * @covers ::__construct
   * @covers ::createFromJson
   * @covers ::createFromData
   *
   * @expectedException \Triquanta\IziTravel\DataType\InvalidJsonFactoryException
   */
  public function testCreateFromJsonWithInvalidJson()
  {
    $json = 'foo';

    FullCity::createFromJson($json);
  }

  /**
   * @covers ::createFromJson
   * @covers ::createFromData
   *
   * @expectedException \Triquanta\IziTravel\DataType\MissingUuidFactoryException
   */
  public function testCreateFromJsonWithoutUuid()
  {
    $json = <<<'JSON'
{
    "type": "country",
    "languages": [
        "nl",
        "de",
        "en",
        "fr",
        "es",
        "it",
        "ru",
        "ja"
    ],
    "status": "published",
    "map": {
        "bounds": "50.7503838,3.357962,53.5560213,7.2275102"
    },
    "hash": "625fa5ae924390fdc162e25d704549f83ec2dac8",
    "country_code": "nl",
    "content": [
        {
            "title": "Netherlands",
            "summary": "",
            "desc": "",
            "language": "en"
        }
    ],
    "location": {
        "altitude": 0,
        "latitude": 52.132633,
        "longitude": 5.291266
    },
    "translations": [
            {
                "name": "Amsterdam",
                "language": "en"
            },
            {
                "name": "Amesterdão",
                "language": "pt"
            },
            {
                "name": "Amsterdam",
                "language": "ro"
            }
        ]
}
JSON;

    FullCity::createFromJson($json);
  }

  /**
   * @covers ::getContent
   */
  public function testGetContent()
  {
    $this->assertSame($this->content, $this->sut->getContent());
  }

}
