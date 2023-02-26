<?php

class Tester
{
    protected $basePath;

    protected $solver;

    /**
     * @param $basePath
     * @param $solver
     */
    public function __construct($solver, $basePath = __DIR__)
    {
        $this->basePath = $basePath;
        $this->solver = $solver;
    }

    public function solve()
    {
        $inputFileMask = "test.%s.in";
        $outputFileMask = "test.%s.out";

        $iteration = 0;
        while(1) {
            $inputFileName = sprintf($this->basePath.$inputFileMask, $iteration);
            $outputFileName = sprintf($this->basePath.$outputFileMask, $iteration);
            if (!file_exists($inputFileName)
            || !file_exists($outputFileName)) {
                return;
            }

            $inputData = trim(file_get_contents($inputFileName));
            $outputData = trim(file_get_contents($outputFileName));

            $result = $this->solver->solve($inputData);
            if ($result == $outputData) {
                echo "$iteration - Success. Result $result - actual $result\n";
            }
            else {
                echo "$iteration - Fail. Expected $outputData - actual $result\n";
            }

            $iteration++;
        }
    }
}

class StringSolver
{
    public function solve($input)
    {
        return (string) strlen($input);
    }
}

class TicketSolver1
{
    public function solve($input)
    {
        $numOfDigits = $input;

        $count = 0;

        $solveInternal = function($numOfDigits, $sumA, $sumB) use (&$count, &$solveInternal) {

            if ($numOfDigits == 0) {
                if ($sumA == $sumB) {
                    $count++;
                }

                return;
            }

            for($a = 0; $a < 10; $a++) {
                for($b = 0; $b < 10; $b++) {
                    $solveInternal($numOfDigits - 1, $sumA + $a, $sumB + $b);
                }
            }
        };

        $solveInternal($numOfDigits, 0, 0);

        return $count;
    }
}

class TicketSolver2
{
    public function solve($input)
    {
        $result = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1];

        $dive = function ($a) {
            $b = [];

            for($i = 0; $i <= 9; $i ++) {
                for($j = 0; $j < count($a); $j++) {
                    $b[$j] += $a[$j];
                }
                array_unshift($a, 0);
            }

            return $b;
        };

        for ($i = $input - 1; $i > 0; $i--) {
            $result = $dive($result);
        }

        $c = array_map(function($item) { return pow($item, 2);}, $result);

        $count = array_sum($c);

        return $count;
    }
}

$s = new TicketSolver2();
$t = new Tester($s, __DIR__."/tests/1.Tickets/");
$t->solve();
//$s->solve(2);