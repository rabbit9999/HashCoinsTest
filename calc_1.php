<?php
/**
 * The simplest eval based unsafe calculator
 */

echo "Result: " . eval('return ' . readline('Type an expression to calculate: ') . ';') . "\n";