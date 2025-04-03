<?php declare(strict_types = 1);

namespace Tests;

\Hamcrest\Util::registerGlobalFunctions();

use KataThree;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
include __DIR__ . '/../KataThree.php';

class KataThreeTest extends TestCase {

    public function test_it_returns_zero_for_empty_string():void
    {
        $result = $this->kataThree()->add("");

        assertThat($result,is(equalTo(0)));
        $this->addToAssertionCount(1);
    }

    public function test_it_returns_the_sum_of_numbers_for_given_string():void
    {
        $result = $this->kataThree()->add("1,2");

        assertThat($result,is(equalTo(3)));
        $this->addToAssertionCount(1);
    }

    public function test_it_returns_the_sum_of_numbers_even_when_an_empty_string_is_included():void
    {
        $result = $this->kataThree()->add('10,20,"",4,5');

        assertThat($result,is(equalTo(39)));
        $this->addToAssertionCount(1);
    }

    #[DataProvider('addSumOfNumbers')]
    public function test_it_returns_sum_of_numbers_for_n_numbers_passed(string $numbers,int $expected):void
    {
        $stringCalculator = $this->kataThree();
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

    //tests inclusive of KataThree
    #[DataProvider('sumNumbers')]
    public function test_add_sums_the_numbers_given_between_new_lines(string $numbers,int $expected):void
    {
        $stringCalculator = $this->kataThree();
        $result = $stringCalculator->add($numbers);
        

        assertThat($result,is(equalTo($expected)));
        $this->addToAssertionCount(1);
    }

    public static function sumNumbers():array
    {
        return [
            'numbers with only one new line in between' => ["1\n2,3",6],
            'numbers with multiple new line in between' => ["1\n2\n3\n4",10],
            'numbers with multiple new line and comma in between' => ["1,2,3\n4\n5,6,7,8",36],
        ];
    }

    public function test_add_sums_the_numbers_given_between_new_lines_but_omits_empty_string():void
    {
        $stringCalculator = $this->kataThree();
        $result = $stringCalculator->add("1\n2,3,'',4");
        
        assertThat($result,is(equalTo(10)));
        $this->addToAssertionCount(1);
    }

    private function kataThree():KataThree
    {
        return new KataThree();
    }
}