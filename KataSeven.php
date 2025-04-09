<?php declare(strict_types = 1);

use Hamcrest\Type\IsNumeric;
use Illuminate\Support\Collection;

class KataSeven {
    public function add(string $numbers):int
    {
        $values = array_map('intval',preg_split("/[;\n,*]/", $numbers));

        if(count($values) === 0)
        {
            return 0;
        }

        $filteredvalues = array_filter($values, 'strlen');
        $negatives = [];

        $allValues = collect($filteredvalues)
        ->filter()
        ->each(function(string $number) use (&$negatives){
            
                if((int) $number < 0)
                {
                    $negatives[] = $number;
                }
        });

        if(count($negatives) > 0)
        {
            $msg = "Negative number ".implode(',',$negatives)." is not allowed";
            throw new NegativeNumberException($msg);
        }

        return $allValues->filter(fn($num) => $num <= 1000)->sum();
    }
}