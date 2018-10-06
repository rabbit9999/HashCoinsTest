<?php
/**
 * Eval based calculator
 */
require_once 'calc_2/Calc2Core.php';

$calc = new Calc2Core();
$expression = readline('Type an expression to calculate: ');
echo 'Result: ' . $calc->calculate($expression) . "\n";
