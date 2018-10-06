<?php
/**
 * Calculator based on RPN (Reverse Polish Notation)
 */
require_once 'calc_3/Calc3Core.php';

$calc = new Calc3Core();
$expression = readline('Type an expression to calculate: ');
echo 'Result: ' . $calc->calculate($expression) . "\n";
