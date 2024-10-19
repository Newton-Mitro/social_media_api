<?php

function sum($a, $b)
{
    return $a + $b;
}

describe('sum', function (): void {
    it('may sum integers', function (): void {
        $result = sum(1, 2);

        expect($result)->toBe(3);
    });

    it('may sum floats', function (): void {
        $result = sum(1.5, 2.5);

        expect($result)->toBe(4.0);
    });
});
