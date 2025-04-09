<?php declare(strict_types = 1);

namespace Tests;

\Hamcrest\Util::registerGlobalFunctions();

use KataSeven;
use NegativeNumberException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RuntimeException;

include __DIR__ . '/../KataSeven.php';
include __DIR__ . '/../NegativeNumberException.php';

class KataSevenTest extends TestCase {

    public function test_it_returns_zero_for_empty_string():void
    {
        $result = $this->KataSeven()->add("");

        assertThat($result,is(equalTo(0)));
        $this->addToAssertionCount(1);
    }

    public function test_it_returns_the_sum_of_numbers_for_given_string():void
    {
        $result = $this->KataSeven()->add("1,2");

        assertThat($result,is(equalTo(3)));
        $this->addToAssertionCount(1);
    }

    public function test_it_returns_the_sum_of_numbers_even_when_an_empty_string_is_included():void
    {
        $result = $this->KataSeven()->add('10,20,"",4,5');

        assertThat($result,is(equalTo(39)));
        $this->addToAssertionCount(1);
    }

    #[DataProvider('addSumOfNumbers')]
    public function test_it_returns_sum_of_numbers_for_n_numbers_passed(string $numbers,int $expected):void
    {
        $stringCalculator = $this->KataSeven();
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

    
    #[DataProvider('sumNumbers')]
    public function test_add_sums_the_numbers_given_between_new_lines(string $numbers,int $expected):void
    {
        $stringCalculator = $this->KataSeven();
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
        $stringCalculator = $this->KataSeven();
        $result = $stringCalculator->add("1\n2,3,'',4");
        
        assertThat($result,is(equalTo(10)));
        $this->addToAssertionCount(1);
    }

    #[DataProvider('differentDelimiters')]
    public function test_add_supports_different_delimiters(string $numbers,int $expected):void
    {
        $stringCalculator = $this->KataSeven();
        $result = $stringCalculator->add($numbers);
        
        assertThat($expected,is(equalTo($result)));
        $this->addToAssertionCount(1);     
    }

    public static function differentDelimiters():array
    {
        return [
            'string with delimiter as semicolon' => ["1;2;3",6],
            'string with delimiter as newline' => ["1\n2\n4",7],
            'string with delimiter as single quotes' => ["1,'',2,'',6",9],
            'string with multiple delimiters' => ["//;\n1;2",3],
        ];
    }

    public function test_it_throws_when_an_negative_number_is_included():void
    {
        $stringCalculator = $this->KataSeven();

        $this->expectException(NegativeNumberException::class);
        $this->expectExceptionMessage("Negative number -4 is not allowed");
        $stringCalculator->add("1,2,3,-4,5");
        
        $this->addToAssertionCount(1);
    }

    public function test_it_throws_and_specifies_which_numbers_are_negative():void
    {
        $stringCalculator = $this->KataSeven();

        $this->expectException(NegativeNumberException::class);
        $this->expectExceptionMessage("Negative number -1,-3,-4 is not allowed");
        $stringCalculator->add("-1,2,-3,-4,5");
        
        $this->addToAssertionCount(1);
    }

    public function test_it_ignores_number_greater_than_1000():void
    {
        $stringCalculator = $this->KataSeven();
        $result = $stringCalculator->add("2,1001");
        
        assertThat($result,is(equalTo(2)));
        $this->addToAssertionCount(1);
    }

    public function test_it_does_not_ignore_number_less_than_1000():void
    {
        $stringCalculator = $this->KataSeven();
        $result = $stringCalculator->add("2,999");
        
        assertThat($result,is(equalTo(1001)));
        $this->addToAssertionCount(1);
    }

    public function test_it_does_not_ignore_number_less_than_or_equal_to_1000():void
    {
        $stringCalculator = $this->KataSeven();
        $result = $stringCalculator->add("2,1000");
        
        assertThat($result,is(equalTo(1002)));
        $this->addToAssertionCount(1);
    }

    //tests inclusive of KataSeven
    #[DataProvider('delimitersWithVariousLength')]
    public function test_it_adds_the_numbers_irrespective_of_the_length_of_delimiter(string $numbers,int $expected):void
    {
        $stringCalculator = $this->KataSeven();
        $result = $stringCalculator->add($numbers);
        
        assertThat($result,is(equalTo($expected)));
        $this->addToAssertionCount(1);
    }

    public static function delimitersWithVariousLength():array
    {
        return [
            'comma separated delimiter' => ["1,,,,2,,,,3",6],
            'semicolon separated delimiter' => ["1;;;3;;5",9],
            'asterisk separated delimiter' => ["//[***]\n1***2***3",6],
            'single quote separated delimiter' => ["1,'','',1,'',0",2],
            'new line separated delimiter with number greater than 1000' => ["2000\n3\n\n1000\n1001",1003]
        ];
    }

    private function KataSeven():KataSeven
    {
        return new KataSeven();
    }
}