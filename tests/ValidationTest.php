<?php

namespace Tests;

use CodeIgniter\Validation\Validation;
use Config\Services as AppServices;
use Config\Validation as ValidationConfig;
use PHPUnit\Framework\TestCase;

/**
 * @covers \app\ValidatorRulesCreator
 */
class ValidationTest extends TestCase
{
    protected static ?Validation $orgValidator;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$orgValidator = new Validation(config(ValidationConfig::class), AppServices::renderer());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = clone self::$orgValidator;
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->validator = null;
    }

    public function testSample(): void
    {
        $this->assertSame(1, 1);
    }
}
