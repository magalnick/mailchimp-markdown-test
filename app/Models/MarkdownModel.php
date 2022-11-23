<?php

namespace App\Models;

use Exception;

class MarkdownModel
{
    protected string $markdown;
    protected array $lines = [];

    /**
     * @param string $markdown
     * @return mixed
     */
    public static function factory(string $markdown): MarkdownModel
    {
        $class = get_called_class();
        return new $class($markdown);
    }

    /**
     * MarkdownModel constructor.
     * @param string $markdown
     */
    protected function __construct(string $markdown)
    {
        $this->markdown = trim($markdown);

        // since this is coming in from some unknown web-based source
        // the line endings could be windows or unix style
        // convert everything to "\n"
        // start with the "\r\n" combination, then do "\r" in case it's standalone
        $this->markdown = str_replace("\r\n", "\n", $this->markdown);
        $this->markdown = str_replace("\r", "\n", $this->markdown);
        $lines = explode("\n", $this->markdown);
        foreach ($lines as $line) {
            $this->lines[] = trim($line);
        }
    }

    /**
     * @return string
     */
    public function convertToHtml(): string
    {
        // doing this as a for loop instead of a foreach loop so that a previous or next line can be compared
        // specifically for a multi-line <p> tag
        $size = count($this->lines);
        $previous_line_is_p_tag = false;
        for ($i = 0; $i < $size; $i++) {
            $line = $this->lines[$i];

            $next_line_is_p_tag = false;
            if ($i + 1 < $size && $this->isLineUnformattedText($this->lines[$i+1])) {
                $next_line_is_p_tag = true;
            }

            switch (true) {
                case $this->isLineUnformattedText($line):
                    $line = $this->convertToPTag($line, $previous_line_is_p_tag, $next_line_is_p_tag);
                    $previous_line_is_p_tag = true;
                    break;
                case $this->isLineAHeader($line):
                    $line = $this->convertToHeader($line);
                    $previous_line_is_p_tag = false;
                    break;
                case $this->isLineBlank($line):
                default:
                    $previous_line_is_p_tag = false;
            }

            $this->lines[$i] = $this->convertTheLinks($line);
        }

        return join("\n", $this->lines);
    }

    /**
     * @return $this
     */
    protected function validate(): MarkdownModel
    {
        return $this;
    }

    /**
     * @param string $line
     * @return bool
     */
    public function isLineBlank(string $line): bool
    {
        return $line === '';
    }

    /**
     * @param string $line
     * @return bool
     */
    public function isLineAHeader(string $line): bool
    {
        return substr($line, 0, 1) === '#';
    }

    /**
     * @param string $line
     * @return bool
     */
    public function isLineUnformattedText(string $line): bool
    {
        if ($this->isLineBlank($line) || $this->isLineAHeader($line)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $line
     * @return string
     * @throws Exception
     */
    public function convertToHeader(string $line): string
    {
        $h_count = 0;
        while (substr($line, 0, 1) === '#') {
            $line = substr($line, 1);
            $h_count++;
            if ($h_count > 6) {
                throw new Exception('The highest number header tag is 6.', 400);
            }
        }

        $line = trim($line);

        return "<h$h_count>$line</h$h_count>";
    }

    /**
     * @param string $line
     * @param bool $previous_line_is_p_tag
     * @param bool $next_line_is_p_tag
     * @return string
     */
    public function convertToPTag(string $line, bool $previous_line_is_p_tag, bool $next_line_is_p_tag): string
    {
        if (!$previous_line_is_p_tag) {
            $line = "<p>$line";
        }
        if (!$next_line_is_p_tag) {
            $line .= '</p>';
        }
        return $line;
    }

    /**
     * @param string $line
     * @return string
     * @throws Exception
     */
    public function convertTheLinks(string $line): string
    {
        return $line;
    }
}
