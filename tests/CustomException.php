<?php

namespace Test;

use ModernPHPException\Solution;
use ModernPHPException\Interface\SolutionInterface;

class CustomException extends \Exception implements SolutionInterface
{
    public function getSolution(): Solution
    {
        return Solution::createSolution('My Solution')
            ->setDescription('description')
            ->setDocs('https://google.com');
    }

    /**
     * @param int $line
     */
    public function setLine(int $line)
    {
        $this->line = $line;
    }

    /**
     * @param string $file
     */
    public function setFile(string $file)
    {
        $this->file = $file;
    }
}
