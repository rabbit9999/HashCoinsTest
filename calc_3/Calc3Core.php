<?php

class Calc3Core
{
    private $deep = 0;

    //Entrance point
    public function calculate($expression){
        $this->deep = 0;
        $expression = $this->filter($expression);
        $expression = $this->escapeSingleOperators($expression);
        $rpn = $this->rpn($expression);
        return $this->calculateRpn($rpn);
    }

    //Calculate RPN expression
    public function calculateRpn($rpn){
        if($this->deep > 100000){
            throw new Exception('Recursion goes too deep');
        }
        $this->deep++;

        $result = [];
        $len = count($rpn);

        for($i = 0; $i < $len; $i++ ){
            $currentElement = $rpn[$i];
            $prevVal_1 = $i - 1 >= 0 ? $rpn[$i - 1] : '';
            $prevVal_2 = $i - 2 >= 0 ? $rpn[$i - 2] : '';

            if(is_string($currentElement) && preg_match("/[\+\-\/\*]/", $currentElement)
                && (preg_match("/[0-9]/", $prevVal_1) || is_float($prevVal_1))
                && (preg_match("/[0-9]/", $prevVal_2) || is_float($prevVal_2))){
                $res = 0;
                switch ($currentElement){
                    case '+':
                        $res = (float)$prevVal_2 + (float)$prevVal_1;
                        break;
                    case '-':
                        $res = (float)$prevVal_2 - (float)$prevVal_1;
                        break;
                    case '*':
                        $res = (float)$prevVal_2 * (float)$prevVal_1;
                        break;
                    case '/':
                        $res = (float)$prevVal_2 / (float)$prevVal_1;
                        break;
                }
                array_pop($result);
                array_pop($result);
                $result[] = $res;
            }
            else{
                $result[] = $currentElement;
            }
        }
        if(count($result) == 1){
            return $result[0];
        }
        else{
            return $this->calculateRpn($result);
        }
    }

    //Filter input string
    public function filter($expression){
        $expression = str_replace(',', '.', $expression);
        $expression = preg_replace('/[^0-9\.\+\-\*\/\(\)]/', '', $expression);

        if(strlen($expression) == 0){
            throw new Exception('There is no expression to calculate');
        }
        return $expression;
    }

    //Escaping leading non-numeric characters
    public function escapeSingleOperators($expression){
        $splitted = str_split($expression);
        $result = [];
        $prevChar = '';
        foreach ($splitted as $key=>$val){
            if(preg_match("/[\+\-]/", $val) && !preg_match("/[0-9\)]/", $prevChar)){
                $result[] = 0;
            }
            $result[] = $val;
            $prevChar = $val;
        }
        if($result[0] === '('){
            array_unshift($result,'0','+');
        }
        return implode($result);
    }

    //Converting string to Reverse Polish Notation
    public function rpn($str)
    {
        $stack = array();
        $out = array();

        $prior = array(
            "*" => 3,
            "/" => 3,
            "+" => 2,
            "-" => 2,
        );

        $token = str_split($str);

        $lastnum = TRUE;
        foreach ($token as $key => $value) {
            if (preg_match("/[\+\-\*\/]/", $value)){
                $endop = FALSE;

                while ($endop != TRUE) {
                    $lastop = array_pop($stack);
                    if ($lastop == "") {
                        $stack[] = $value;
                        $endop = TRUE;
                    }
                    else{
                        $curr_prior = isset($prior[$value]) ? $prior[$value] : 0;
                        $prev_prior = isset($prior[$lastop]) ? $prior[$lastop] : 0;

                        switch ($curr_prior) {
                            case ($curr_prior > $prev_prior):
                                $stack[] = $lastop;
                                $stack[] = $value;
                                $endop = TRUE;
                                break;

                            case ($curr_prior <= $prev_prior):
                                $out[] = $lastop;
                                break;
                        }
                    }
                }
                $lastnum = false;
            }
            elseif (preg_match("/[0-9\.]/", $value)){
                if ($lastnum == TRUE){
                    $num = array_pop($out);
                    $out[] = $num . $value;
                }
                else{
                    $out[] = $value;
                    $lastnum = TRUE;
                }
            }
            elseif ($value == "("){
                $stack[] = $value;
                $lastnum = FALSE;
            }
            elseif ($value == ")"){
                $skobka = FALSE;
                while ($skobka != TRUE){
                    $op = array_pop($stack);
                    if ($op == "(") {
                        $skobka = TRUE;
                    }
                    else{
                        $out[] = $op;
                    }
                }

                $lastnum = FALSE;
            }
        }

        $stack1 = $stack;
        $rpn = $out;

        while ($stack_el = array_pop($stack1)){
            $rpn[] = $stack_el;
        }
        return $rpn;
    }
}