<?php declare(strict_types = 1);

namespace Tests;

\Hamcrest\Util::registerGlobalFunctions();

use KataOne;
use PHPUnit\Framework\TestCase;
include __DIR__ . '/../KataOne.php';

class KataOneTest extends TestCase
{
    public function test_it_returns_zero_for_empty_string():void
    {
        $stringCalculator = new KataOne();
        $result = $stringCalculator->add("");

        assertThat($result,is(equalTo(0)));
        $this->addToAssertionCount(1);
    }

    public function test_it_returns_the_sum_of_numbers_for_given_string():void
    {
        $stringCalculator =  new KataOne();
        $result = $stringCalculator->add("1,2");

        assertThat($result,is(equalTo(3)));
        $this->addToAssertionCount(1);
    }

    public function test_it_returns_the_sum_of_numbers_even_when_an_empty_string_is_included():void
    {
        $stringCalculator =  new KataOne();
        $result = $stringCalculator->add('1,2,"",4,5');

        assertThat($result,is(equalTo(12)));
        $this->addToAssertionCount(1);
    }
}