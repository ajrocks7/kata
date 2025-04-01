<?php declare(strict_types = 1);

class KataOne {
    public function add(string $numbers): int
    {
        $values = array_filter(str_split($numbers));
        
        if(count($values) === 0)
        {
            return 0;
        }

        return array_sum($values);
    }
}