<?php

namespace Test;

use ModernPHPException\Solution;
use ModernPHPException\Interface\SolutionInterface;

class CustomException extends \Exception implements SolutionInterface
{
    public function getSolution(): Solution
    {
        return Solution::createSolution('My Solution')
            ->setDescription('An custom description to exception')
            ->setDocs('https://google.com', 'See more');
    }

    /* public function setLine(int $line)
    {
        $this->line = $line;
    }

    public function setFile(string $file)
    {
        $this->file = $file;
    } */
}
