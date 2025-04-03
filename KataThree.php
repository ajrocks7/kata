<?php declare(strict_types = 1);

class KataThree {
    public function add(string $numbers): int
    {
        $values = preg_split("/[\n,]/", $numbers);
        

        if(count($values) === 0)
        {
            return 0;
        }

        return array_sum($values);
    }
}
