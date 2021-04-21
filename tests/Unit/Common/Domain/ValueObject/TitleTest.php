<?php
declare(strict_types=1);

namespace App\Tests\Unit\Common\Domain\ValueObject;

use App\Common\Domain\ValueObject\Enum;
use App\Common\Domain\ValueObject\Title;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TitleTest extends TestCase
{
    public function testItCanFetchValue()
    {
        $title = new Title(Title::MR);

        self::assertEquals(Title::MR, $title->value());
    }

    public function testItCanFetchLabel()
    {
        $title = new Title(Title::MR);

        self::assertEquals('Mr', $title->label());
    }

    public function testItCanFetchValues()
    {
        $expectedValues = [
            'mr',
            'mrs',
            'ms',
            'miss'
        ];

        self::assertEquals($expectedValues, Title::values());
    }

    public function testItCanFetchLabels()
    {
        $expectedLabels = [
            'mr' => 'Mr',
            'mrs' => 'Mrs',
            'ms' => 'Ms',
            'miss' => 'Miss'
        ];

        self::assertEquals($expectedLabels, Title::labels());
    }

    public function testItCanCheckIfValueExist()
    {
        self::assertTrue(Title::valueExist(Title::MR));
        self::assertFalse(Title::valueExist('wrong-value'));
    }

    public function testItCanCheckIfLabelExist()
    {
        self::assertTrue(Title::labelExist(Title::MR));
        self::assertFalse(Title::labelExist('wrong-value'));
    }

    public function testItCanFetchValueAsString()
    {
        $title = new Title(Title::MR);

        self::assertEquals('mr', $title);
    }

    public function testItCanThrowExceptionForWrongValuesInitiated()
    {
        self::expectException(InvalidArgumentException::class);

        new Title('wrong-value');
    }

    public function testItCanCheckEquals()
    {

        self::assertTrue((new Title(Title::MR))->equals(new Title(Title::MR)));
        self::assertFalse((new Title(Title::MR))->equals(new Title(Title::MRS)));
    }
}
