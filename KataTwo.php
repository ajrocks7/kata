<?php declare(strict_types = 1);

class KataTwo {
    public function add(string $numbers): int
    {
        $values = explode(',', $numbers);

        if(count($values) === 0)
        {
            return 0;
        }

        return array_sum($values);
    }
}