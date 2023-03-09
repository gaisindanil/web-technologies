<?php

declare(strict_types=1);

namespace Unit;

use App\Domain\Common\Types\Id;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 */
final class TestCase extends \PHPUnit\Framework\TestCase
{
    public function testSuccess(): void
    {
        $id = new Id($value = Uuid::uuid4()->toString());

        self::assertEquals($value, $id->getValue());
    }
}
