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
     * @param string $title
     * 
     * @return Solution
     */
    public static function createSolution(string $title): Solution
    {
        self::$solution_title = $title;
        return new static();
    }

    /**
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
     * @return string
     */
    public function getTitle(): string
    {
        return self::$solution_title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return self::$solution_description;
    }

    /**
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
