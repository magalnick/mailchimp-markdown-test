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
        for ($i = 0; $i < $size; $i++) {
            $line = $this->lines[$i];

            switch (true) {
                case $line === '':
                    // nothing to do on an empty line
                    break;
                case substr($line, 0, 1) === '#':
                    $line = $this->convertToHeader($line);
                    break;
                default:
                    // do the p tag
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
     * @return string
     * @throws Exception
     */
    public function convertTheLinks(string $line): string
    {
        return $line;
    }
}
