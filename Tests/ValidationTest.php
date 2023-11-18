<?php /** @noinspection GrazieInspection */

namespace Tests;

use CodeIgniter\Config\Services;
use CodeIgniter\Validation\Validation;
use PHPUnit\Framework\TestCase;
use Validator\Field;
use Validator\FieldRules;
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
        self::$orgValidator = Services::validation();
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

    /**
     * @return array<array{0: array, 1: bool, 2: string}>
     */
    public static function usernameProvider(): array
    {
        return [
            [[], false, 'field is missing'],
            [['username' => ''], false, 'empty username'],
            [['username' => 'ab'], false, 'less than 3 chars'],
            [['username' => 'abc'], true, 'exact 3 chars'],
            [['username' => 'gatheringforfriendlydiscussion'], true, 'exact 30 chars'],
            [['username' => 'vocationalrehabilitationprogram'], false, 'more than 30 chars'],
        ];
    }

    /**
     * It tests:
     * ```
     * $validation->setRule('username', 'Username', 'required|max_length[30]|min_length[3]');
     * ```
     * @dataProvider usernameProvider
     * @param array $data
     * @param bool $isValid
     * @param string $message
     * @return void
     */
    public function testUsernameIsRequiredAnd3CharsAtLeastAnd30CharsAtMost(array $data, bool $isValid, string $message): void
    {
        $fieldRule = new FieldRules();
        $fieldRule->required()->minLength(3)->maxLength(30);
        $field = new Field(name: 'username', label: 'Username', rules: $fieldRule);
        $this->rulesCreator->addField($field);

        $this->validation->setRules($this->rulesCreator->export());

        $this->assertSame($isValid, $this->validation->run($data), $message);
    }

    /**
     * @return array<array{0: array, 1: bool, 2: string}>
     */
    public static function passwordProvider(): array
    {
        return [
            [[], false, 'password is missing'],
            [['password' => ''], false, 'empty password'],
            [['password' => str_repeat('a', 7)], false, 'less than 8 chars'],
            [['password' => str_repeat('a', 8)], true, 'exact 8 chars'],
            [['password' => str_repeat('a', 255)], true, 'exact 255 chars'],
            [['password' => str_repeat('a', 256)], false, 'more than 255 chars'],
            [['password' => 'Password'], true, 'contains alphanumeric'],
            [['password' => '~!#$%&*-_+=|:.'], true, 'contains figures'],
            [['password' => '////////'], false, 'prohibited figures included'],
        ];
    }

    /**
     * It tests:
     * ```
     * $validation->setRule('password', 'Password', ['required', 'max_length[255]', 'min_length[8]', 'alpha_numeric_punct']);
     * ```
     * @dataProvider passwordProvider
     * @param array $data
     * @param bool $isValid
     * @param string $message
     * @return void
     */
    public function testPasswordIsRequiredAnd8CharsAtLeastAnd255CharsAtMostAndAlphaNumericPunctual(array $data, bool $isValid, string $message): void
    {
        $fieldRule = new FieldRules();
        $fieldRule->required()->minLength(8)->maxLength(255)->alphaNumericPunct();
        $field = new Field(name: 'password', label: 'Password', rules: $fieldRule);
        $this->rulesCreator->addField($field);

        $this->validation->setRules($this->rulesCreator->export());

        $this->assertSame($isValid, $this->validation->run($data), $message);
    }

    public function testErrorMessages(): void
    {
        # username
        $usernameFieldRules = new FieldRules();
        $usernameFieldRules
            ->required(message: 'All accounts must have {field} provided')
            ->maxLength(30)
            ->minLength(3);
        $usernameField = new Field(name: 'username', label: 'Username', rules: $usernameFieldRules);

        # password
        $passwordFieldRules = new FieldRules();
        $passwordFieldRules
            ->required()
            ->minLength(8, message: 'Your {field} is too short. You want to get hacked?')
            ->maxLength(255)
            ->alphaNumericPunct();
        $passwordField = new Field(name: 'password', label: 'Password', rules: $passwordFieldRules);

        $this->rulesCreator = new RulesCreator();
        $this->rulesCreator
            ->addField($usernameField)
            ->addField($passwordField);

        $this->validation = \Config\Services::validation();
        $this->validation->setRules($this->rulesCreator->export());

        $this->validation->run(['password' => 'a']);

        $this->assertSame(
            [
                'username' => 'All accounts must have Username provided',
                'password' => 'Your Password is too short. You want to get hacked?',
            ],
            $this->validation->getErrors()
        );
    }
}
