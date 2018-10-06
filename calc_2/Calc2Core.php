<?php

class Calc2Core
{
    public function calculate($expression)
    {
        try{
            return eval('return ' . $this->filter($expression) . ';');
        }
        catch (Exception $e){
            return 0;
        }
    }
    public function filter($expression){
        $expression = str_replace(',', '.', $expression);
        $expression = preg_replace('/[^0-9\.\+\-\*\/\(\)]/', '', $expression);

        if(strlen($expression) == 0){
            throw new Exception('There is no expression to calculate');
        }
        return $expression;
    }
}