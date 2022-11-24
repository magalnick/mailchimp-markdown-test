# Mailchimp Markdown Test

## Applicant

- David Magalnick
- [LinkedIn](https://www.linkedin.com/in/dmagalnick/)

## Requirements

- [Implement a Markdown => HTML converter](https://gist.github.com/mc-interviews/305a6d7d8c4ba31d4e4323e574135bf9)

## Language and Framework

### Backend

- PHP 7.4
- Laravel 8.x

### Frontend

- jQuery 3.6.1
- Bootstrap 5.1.3

## Installation and System Requirements

### Install From the Attached Zip File

- Unzip it and go. The vendor directory is included for your convenience.

### Install From Github

```
git clone git@github.com:magalnick/mailchimp-markdown-test.git
cd mailchimp-markdown-test
composer install
```

### System Requirements

- If you intend to run this, it should be with PHP 7.4.
- It may run with PHP 8.0 or 8.1, but they haven't been tested, so no guarantees.

## Files to Check

```
routes/api.php
routes/web.php
app/Http/Controllers/ConvertToHtmlController.php
app/Http/Response.php
app/Models/MarkdownModel.php
tests/Models/MarkdownModelTest.php
resources/views/mailchimp.blade.php
```

## Special Notes

- The server that I used to host this is a 2 year old Ubuntu 20.04 box running PHP 7.4, which limits the Laravel install to 8.x. Thus the slightly older versions of PHP and Laravel.
- The base Laravel install is mostly untouched. My changes are primarily new files.
- Since this is a throw together site with 1 page and 1 API call, there's no fancy multi-environment modifications. The `.env` file is committed directly to the git repo, even though that's a big no-no in the real world.
- Along with unit tests for the different methods, I also manually tested the web page to figure out various scenarios that might break things.

## Live Demo

- [Check it out!](https://random-stuff.madmarye.com/)

## Run the Unit Tests

```
vendor/bin/phpunit tests/Models/MarkdownModelTest.php
```
