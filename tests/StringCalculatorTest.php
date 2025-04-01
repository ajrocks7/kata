<?php declare(strict_types = 1);

namespace Tests;

\Hamcrest\Util::registerGlobalFunctions();

use PHPUnit\Framework\TestCase;


class StringCalculatorTest extends TestCase
{
    public function test_assert():void
    {
        $ar = [1,2,3];
        assertThat($ar,is(arrayContaining([1,2,3])));

        $this->addToAssertionCount(1);
    }
}