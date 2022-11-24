<?php

namespace Tests\Models;

use Illuminate\Foundation\Testing\WithFaker;
use App\Models\MarkdownModel;
use Tests\TestCase;
use Exception;

class MarkdownModelTest extends TestCase
{
    use WithFaker;

    /**
     * Test the convert to HTML function for an h1 tag
     *
     * @test
     * @return void
     */
    public function testConvertToHeader_h1(): void
    {
        $this->setUpFaker();
        $faker    = $this->faker->sha256;
        $markdown = "# $faker";
        $expected = "<h1>$faker</h1>";
        $actual   = MarkdownModel::factory()->convertToHeader($markdown);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the convert to HTML function for an h2 tag
     *
     * @test
     * @return void
     */
    public function testConvertToHeader_h2(): void
    {
        $this->setUpFaker();
        $faker    = $this->faker->sha256;
        $markdown = "## $faker";
        $expected = "<h2>$faker</h2>";
        $actual   = MarkdownModel::factory()->convertToHeader($markdown);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the convert to HTML function for an h3 tag
     *
     * @test
     * @return void
     */
    public function testConvertToHeader_h3(): void
    {
        $this->setUpFaker();
        $faker    = $this->faker->sha256;
        $markdown = "### $faker";
        $expected = "<h3>$faker</h3>";
        $actual   = MarkdownModel::factory()->convertToHeader($markdown);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the convert to HTML function for an h4 tag
     *
     * @test
     * @return void
     */
    public function testConvertToHeader_h4(): void
    {
        $this->setUpFaker();
        $faker    = $this->faker->sha256;
        $markdown = "#### $faker";
        $expected = "<h4>$faker</h4>";
        $actual   = MarkdownModel::factory()->convertToHeader($markdown);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the convert to HTML function for an h5 tag
     *
     * @test
     * @return void
     */
    public function testConvertToHeader_h5(): void
    {
        $this->setUpFaker();
        $faker    = $this->faker->sha256;
        $markdown = "##### $faker";
        $expected = "<h5>$faker</h5>";
        $actual   = MarkdownModel::factory()->convertToHeader($markdown);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the convert to HTML function for an h6 tag
     *
     * @test
     * @return void
     */
    public function testConvertToHeader_h6(): void
    {
        $this->setUpFaker();
        $faker    = $this->faker->sha256;
        $markdown = "###### $faker";
        $expected = "<h6>$faker</h6>";
        $actual   = MarkdownModel::factory()->convertToHeader($markdown);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the convert to HTML function for an h7 throws an exception
     *
     * @test
     * @return void
     */
    public function testConvertToHeader_h7(): void
    {
        $this->setUpFaker();
        $faker    = $this->faker->sha256;
        $markdown = "####### $faker";

        $this->expectException(Exception::class);
        MarkdownModel::factory()->convertToHeader($markdown);
    }

    /**
     * Test the convert to HTML function for un-formatted text on its own
     *
     * @test
     * @return void
     */
    public function testConvertToPTag_standalone(): void
    {
        $this->setUpFaker();
        $markdown = $this->faker->sha256;
        $expected = "<p>$markdown</p>";
        $actual   = MarkdownModel::factory()->convertToPTag($markdown, false, false);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the convert to HTML function for un-formatted text as the first of multiple lines
     *
     * @test
     * @return void
     */
    public function testConvertToPTag_firstLine(): void
    {
        $this->setUpFaker();
        $markdown = $this->faker->sha256;
        $expected = "<p>$markdown";
        $actual   = MarkdownModel::factory()->convertToPTag($markdown, false, true);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the convert to HTML function for un-formatted text nestled between other lines
     *
     * @test
     * @return void
     */
    public function testConvertToPTag_middleLine(): void
    {
        $this->setUpFaker();
        $markdown = $this->faker->sha256;
        $expected = "$markdown";
        $actual   = MarkdownModel::factory()->convertToPTag($markdown, true, true);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the convert to HTML function for un-formatted text as the last of multiple lines
     *
     * @test
     * @return void
     */
    public function testConvertToPTag_lastLine(): void
    {
        $this->setUpFaker();
        $markdown = $this->faker->sha256;
        $expected = "$markdown</p>";
        $actual   = MarkdownModel::factory()->convertToPTag($markdown, true, false);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the scrub function to validate certain HTML tags are being removed.
     * Note that this will only test a few of the many that are specified
     *
     * @test
     * @return void
     */
    public function testScrubDisallowedHtmlFromLine_clean(): void
    {
        $markdown = '<script><button></button></html><a href><div></div>';
        $expected = '&lt;script>&lt;button></button>&lt;/html><a href>&lt;div>&lt;/div>';
        $actual   = MarkdownModel::factory()->scrubDisallowedHtmlFromLine($markdown);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the scrub function to validate unspecified tags remain intact
     *
     * @test
     * @return void
     */
    public function testScrubDisallowedHtmlFromLine_nothingToClean(): void
    {
        $this->setUpFaker();
        $faker    = $this->faker->sha256;
        $markdown = "<p><a href><strong>$faker</strong></a></p>";
        $expected = $markdown;
        $actual   = MarkdownModel::factory()->scrubDisallowedHtmlFromLine($markdown);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the function to convert a link works as intended
     *
     * @test
     * @return void
     */
    public function testConvertTheLinks_success(): void
    {
        $markdown = 'This is [an inline link](https://www.mailchimp.com/). Woohoo!';
        $expected = 'This is <a href="https://www.mailchimp.com/">an inline link</a>. Woohoo!';
        $actual   = MarkdownModel::factory()->convertTheLinks($markdown);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the function to convert a link doesn't work if the markdown isn't formatter properly
     *
     * @test
     * @return void
     */
    public function testConvertTheLinks_failure(): void
    {
        $markdown = 'This is [an inline link] (https://www.mailchimp.com/). Woohoo!';
        $expected = $markdown;
        $actual   = MarkdownModel::factory()->convertTheLinks($markdown);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the function to convert a link doesn't do anything if there is no markdown that looks like a link
     *
     * @test
     * @return void
     */
    public function testConvertTheLinks_nothingToDo(): void
    {
        $markdown = 'There is no link to convert.';
        $expected = $markdown;
        $actual   = MarkdownModel::factory()->convertTheLinks($markdown);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test the function to convert multiple links on a line works as intended
     *
     * @test
     * @return void
     */
    public function testConvertTheLinks_multipleLinks(): void
    {
        $markdown = 'Here\'s [link 1](https://www.google.com/), and here\'s [link 2](https://www.mailchimp.com/). Woohoo!';
        $expected = 'Here\'s <a href="https://www.google.com/">link 1</a>, and here\'s <a href="https://www.mailchimp.com/">link 2</a>. Woohoo!';
        $actual   = MarkdownModel::factory()->convertTheLinks($markdown);
        $this->assertEquals($expected, $actual);
    }
}
