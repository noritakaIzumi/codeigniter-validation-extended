<?php /** @noinspection GrazieInspection */

namespace Tests;

use CodeIgniter\Validation\Validation;
use Config\Services as AppServices;
use Config\Validation as ValidationConfig;
use PHPUnit\Framework\TestCase;
use Tests\Support\UsernameProvider;
use Validator\Field;
use Validator\Rules;
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

    public static function usernameProvider(): array
    {
        return [
            [new UsernameProvider([], false, 'field is missing')],
            [new UsernameProvider(['username' => ''], false, 'empty username')],
            [new UsernameProvider(['username' => 'ab'], false, 'less than 3 chars')],
            [new UsernameProvider(['username' => 'abc'], true, 'exact 3 chars')],
            [new UsernameProvider(['username' => 'gatheringforfriendlydiscussion'], true, 'exact 30 chars')],
            [new UsernameProvider(['username' => 'vocationalrehabilitationprogram'], false, 'more than 30 chars')],
        ];
    }

    /**
     * It tests:
     * ```
     * $validation->setRule('username', 'Username', 'required|max_length[30]|min_length[3]');
     * ```
     * @dataProvider usernameProvider
     * @param UsernameProvider $provider
     * @return void
     */
    public function testUsernameIsRequiredAnd3CharsAtLeastAnd30CharsAtMost(UsernameProvider $provider): void
    {
        $rules = new Rules();
        $rules->required()->minLength(3)->maxLength(30);
        $field = new Field(name: 'username', label: 'Username', rules: $rules);
        $this->rulesCreator->addField($field);

        $this->validation->setRules($this->rulesCreator->export());

        $this->assertSame($provider->isValid, $this->validation->run($provider->data), $provider->message);
    }
}
