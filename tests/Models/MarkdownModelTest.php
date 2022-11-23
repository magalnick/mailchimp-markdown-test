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
        $actual   = MarkdownModel::factory($markdown)->convertToHeader($markdown);
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
        $actual   = MarkdownModel::factory($markdown)->convertToHeader($markdown);
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
        $actual   = MarkdownModel::factory($markdown)->convertToHeader($markdown);
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
        $actual   = MarkdownModel::factory($markdown)->convertToHeader($markdown);
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
        $actual   = MarkdownModel::factory($markdown)->convertToHeader($markdown);
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
        $actual   = MarkdownModel::factory($markdown)->convertToHeader($markdown);
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
        MarkdownModel::factory($markdown)->convertToHeader($markdown);
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
        $actual   = MarkdownModel::factory($markdown)->convertToPTag($markdown, false, false);
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
        $actual   = MarkdownModel::factory($markdown)->convertToPTag($markdown, false, true);
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
        $actual   = MarkdownModel::factory($markdown)->convertToPTag($markdown, true, true);
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
        $actual   = MarkdownModel::factory($markdown)->convertToPTag($markdown, true, false);
        $this->assertEquals($expected, $actual);
    }
}
