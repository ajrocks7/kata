<?php declare(strict_types = 1);

namespace Tests;

\Hamcrest\Util::registerGlobalFunctions();

use KataTwo;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
include __DIR__ . '/../KataTwo.php';

class KataTwoTest extends TestCase
{
    #[DataProvider('addSumOfNumbers')]
    public function test_it_returns_sum_of_numbers_for_n_numbers_passed(string $numbers,int $expected):void
    {
        $stringCalculator = $this->kataTwo();
        $sumOfNumbers = $stringCalculator->add($numbers);
        assertThat($expected,is(equalTo($sumOfNumbers)));   
        $this->addToAssertionCount(1);
    }

    public static function addSumOfNumbers():array
    {
        return [
            "zero when no numbers are given" => ["",0],
            "sum of three numbers and expected result is 11 " => ["50,20,4",74],
            "sum of 5 numbers with empty string and result is 30" => ["2,4,6,'',8,10",30],
            "sum of 10 numbers and expected result is " =>[implode(",",range(0,100,10)),550],
        ];
    }

    private function kataTwo():KataTwo
    {
        return new kataTwo();
    }
}