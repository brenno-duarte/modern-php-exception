<?php

namespace ModernPHPException;

class Solution
{
    /**
     * @var string
     */
    private static string $solution_title = "";

    /**
     * @var string
     */
    private static string $solution_description = "";

    /**
     * @var string
     */
    private static string $solution_docs = "";

    /**
     * @var string
     */
    private static string $button_name = "";

    /**
     * Name of solution to fix exception
     * 
     * @param string $title
     * 
     * @return static
     */
    public static function createSolution(string $title): static
    {
        self::$solution_title = $title;
        return new static();
    }

    /**
     * Detailed description of exception solution
     * 
     * @param string $description
     * 
     * @return Solution
     */
    public function setDescription(string $description): Solution
    {
        self::$solution_description = $description;
        return $this;
    }

    /**
     * If a documentation exists, this method will display a button for a documentation.
     * By default, the name of the button will be `Read More`, but you can change the name 
     * by changing the second parameter of the method
     * 
     * @param string $docs_link
     * @param string $button_name
     * 
     * @return Solution
     */
    public function setDocs(string $docs_link, string $button_name = "Read More"): Solution
    {
        self::$solution_docs = $docs_link;
        self::$button_name = $button_name;
        return $this;
    }

    /**
     * Get solution title
     * 
     * @return string
     */
    public function getTitle(): string
    {
        return self::$solution_title;
    }

    /**
     * Get solution description
     * 
     * @return string
     */
    public function getDescription(): string
    {
        return self::$solution_description;
    }

    /**
     * Get solution docs
     * 
     * @return array
     */
    public function getDocs(): array
    {
        return [
            'link' => self::$solution_docs,
            'button' => self::$button_name
        ];
    }
}
