<?php /** @noinspection GrazieInspection */

namespace Tests;

use CodeIgniter\Validation\Validation;
use Config\Services as AppServices;
use Config\Validation as ValidationConfig;
use PHPUnit\Framework\TestCase;
use Validator\RulesCreator;

/**
 * @covers \Validator\RulesCreator
 */
class ValidationTest extends TestCase
{
    protected static Validation $orgValidator;
    protected static RulesCreator $orgRulesCreator;
    protected ?Validation $validation;
    protected ?RulesCreator $rulesCreator;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$orgValidator = new Validation(config(ValidationConfig::class), AppServices::renderer());
        self::$orgRulesCreator = new RulesCreator();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->validation = clone self::$orgValidator;
        $this->rulesCreator = clone self::$orgRulesCreator;
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->validation = null;
        $this->rulesCreator = null;
    }

    public function testSample(): void
    {
        $this->assertSame(1, 1);
    }
}
