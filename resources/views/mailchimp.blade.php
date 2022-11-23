<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Mailchimp Markdown Test</title>
        <meta name="description" content="Mailchimp Markdown Test" />

        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="Mailchimp Markdown Test" />
        <meta property="og:description" content="Mailchimp Markdown Test" />
        <meta property="og:site_name" content="Mailchimp Markdown Test" />

        <!-- Bootstrap 4.6 CSS - this *MUST* be the first CSS instantiated on the page -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body>
    <header>
        <nav class="navbar navbar-expand-xl">
            <a class="navbar-brand" href="/"><img alt="Mailchimp Markdown Test" style="width: 56px; height: 56px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADgAAAA4CAMAAACfWMssAAAAgVBMVEX/4BsAAAD/4hv/6Bz/5hz/5BsAAAT/6hz02Bu/qhb/7R3bwhmSghKnlRTnzRrt0xvMtRheVQ1rYQ7GsBdQSAx4bA+gjxOtmhVTTAtYUAzSuhiLfRI4MQlMRAs7NwlmWw4cGQUuKwiXiROAcxIWEwS0oxcjIAZBPAopJQj/8x4QDwWAHeyLAAAB8klEQVRIie2V3XKjMAyFbcnCNg42gQAJ+SGBlqR9/wesIaTdq9jdu93JmeHyG0lHx4Kxl176twWESH+Boaq3uxYZCYkoojmiPa/KkuvUrLaHYxZLCpsUCgkdP/FZqzgSc15KYGi3fNFJRnGaW8FANvxba4zpM+eOGEDHi0OmzzOoI/wlyy0xUhdeQpmt+uGN801EQYAk9/XUmb9Xj0ZHBmFQVoP0yz89/JxlwyCZhIDJ4Q9qBX0XblVevQ/U3pFzqUzrUKgk6A3YxG8MD0uHAoAADCQQ6pV6nxEq71wnfVJ93weTiFBysNAE6fEODgi6d0CZuW21eF5TDHVqusWVi3Ttey1QtVBujs/HBJX0vFH5OJONVEbhYA1Res2fk6R4bnetu9dsvTVs+gDfArsExdPKjh/3d+FmN4GkvYaM9ftIFVUfcwIa//QFgtPrje2HwC7JRxwqVUygn69Yb3ZFZiWqU2jIbGQo1RwcwcasNIYhKi2r0NPCFd/Xtwn8JOxyZxmYfQ8yCSYdbX1eIkdQd103NEoIzcNBB7lkbpAg0B9HAuF4E3Ov5BKeRk5z+XW0/BBzdfwZuC45NyQlazueuIgjMJOPwCa3KX4XF/s3AKlvP0egp7h6swjb/Wb8PF8rDfgLbkL9/4a8rb8p99JL/5O+AJZBGRkdtoCeAAAAAElFTkSuQmCC" /></a>
            <ul class="navbar-nav mr-md-auto">
                <li class="nav-item">
                    <h5 class="mb-0"><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Mailchimp Markdown Test</a></h5>
                </li>
            </ul>
        </nav>
    </header>
    <main id="main-content">
        <div class="container">
            <div class="row">
                <div class="col">
                    <textarea id="markdown-source" class="form-control mr-sm-2" rows="10" aria-label="Enter your markdown here" placeholder="Enter your markdown here"></textarea>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col">
                    <button onclick="Markdown.convertToHtml();" id="convert-to-html" class="bg-light">Convert to HTML</button>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    <textarea id="converted-to-html" class="form-control mr-sm-2" rows="10" aria-label="Converted to HTML" placeholder="Converted to HTML" disabled></textarea>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col">
                    Rendered HTML
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div id="rendered-html" class="border rounded p-2"></div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col">
                    <p>&nbsp;</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
    <script>
        class Markdown {
            static convertToHtml() {
                let convertToHtml = $("#convert-to-html");
                convertToHtml.prop("disabled", true);
                this.renderAll("");
                let markdown = $.trim(
                    $("#markdown-source").val()
                );
                if (markdown === "") {
                    convertToHtml.prop("disabled", false);
                    return;
                }

                let jqxhr = $.post( "/api/convert-to-html", { "markdown": markdown })
                    .done(function(data) {
                        if (typeof data.error !== "undefined") {
                            Markdown.exception(data.error);
                            return;
                        }

                        // no known formatted error, but expected data is not present
                        // put a generic 400 error, since something weird went wrong
                        if (typeof data.data.converted_html === "undefined") {
                            Markdown.exception("400 (Bad Request)");
                            return;
                        }

                        Markdown.renderAll(data.data.converted_html);
                    });

                jqxhr.always(function() {
                    $("#convert-to-html").prop("disabled", false);

                    if (jqxhr.status >= 400) {
                        Markdown.exception(
                            Markdown.getErrorFromJqxhr(jqxhr)
                        );
                    }
                });
            }

            static getErrorFromJqxhr(jqxhr) {
                if (
                    typeof jqxhr.responseJSON.error === "string"
                    && typeof jqxhr.responseJSON.status === "string"
                    && jqxhr.responseJSON.status === "error"
                ) {
                    return jqxhr.responseJSON.error;
                }

                return jqxhr.status + " (" + jqxhr.statusText + ")";
            }

            static renderConvertedTextarea(html) {
                if (typeof html !== "string") {
                    html = "";
                }
                html = $.trim(html);
                $("#converted-to-html").val(
                    FunWithText.cleanString(html)
                );
            }

            static renderHtml(html) {
                $("#rendered-html").html(
                    FunWithText.cleanString(html)
                );
            }

            static renderAll(html) {
                this.renderConvertedTextarea(
                    FunWithText.cleanString(html)
                );
                this.renderHtml(
                    FunWithText.cleanString(html)
                );
            }

            static exception(message) {
                this.renderConvertedTextarea(
                    FunWithText.cleanString(message)
                );
                this.renderHtml("");
            }
        }

        class FunWithText {
            static cleanString(string) {
                if (typeof string !== "string") {
                    return "";
                }

                return $.trim(string);
            }
        }
    </script>
    </body>
</html>
