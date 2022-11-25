<?php

namespace App\Models;

use Exception;

class MarkdownModel
{
    protected string $markdown = '';
    protected array $lines = [];

    /**
     * @return MarkdownModel
     */
    public static function factory(): MarkdownModel
    {
        $class = get_called_class();
        return new $class();
    }

    /**
     * @param string $markdown
     * @return $this
     */
    public function setMarkdown(string $markdown): MarkdownModel
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

        return $this;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function convertToHtml(): string
    {
        if ($this->markdown === '' || empty($this->lines)) {
            throw new Exception('Markdown text has not yet been set', 400);
        }

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
                    $line = $this->convertToPTag(
                        $this->scrubDisallowedHtmlFromLine($line),
                        $previous_line_is_p_tag,
                        $next_line_is_p_tag
                    );
                    $previous_line_is_p_tag = true;
                    break;
                case $this->isLineAHeader($line):
                    $line = $this->convertToHeader(
                        $this->scrubDisallowedHtmlFromLine($line)
                    );
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
     * This function is a little security measure to help prevent certain tags from executing on the page
     * when the converted HTML is rendered, just in case the user puts actual HTML into the input box.
     *
     * @param string $line
     * @return string
     * @throws Exception
     */
    public function scrubDisallowedHtmlFromLine(string $line): string
    {
        $replace_tags = [
            '<html'      => '&lt;html',
            '</html'     => '&lt;/html',
            '<head'      => '&lt;head',
            '</head'     => '&lt;/head',
            '<body'      => '&lt;body',
            '</body'     => '&lt;/body',
            '<main'      => '&lt;main',
            '</main'     => '&lt;/main',
            '<script'    => '&lt;script',
            '<form'      => '&lt;form',
            '<input'     => '&lt;input',
            '<button'    => '&lt;button',
            '<textarea'  => '&lt;textarea',
            '</textarea' => '&lt;/textarea',
            '<div'       => '&lt;div',
            '</div'      => '&lt;/div',
            '<?'         => '&lt;?',
        ];

        return str_replace(
            array_keys($replace_tags),
            array_values($replace_tags),
            $line
        );
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
        return preg_replace(
            '/\[([^]]+)]\((https?:\/\/[^)]+)\)/',
            '<a href="$2">$1</a>',
            $line
        );
    }
}
