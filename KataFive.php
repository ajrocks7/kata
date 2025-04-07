<?php declare(strict_types = 1);

use Illuminate\Support\Collection;

class KataFive {
    public function add(string $numbers):int
    {
        $values = preg_split("/[;\n,]/", $numbers);
        

        if(count($values) === 0)
        {
            return 0;
        }

        $Filteredvalues = array_filter($values, 'strlen');
        $negatives = [];

        collect($Filteredvalues)
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

        return array_sum($values);
    }
}