<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Response;
use App\Models\MarkdownModel;
use Illuminate\Http\Response as BaseResponse;
use Exception;

class ConvertToHtmlController extends Controller
{

    /**
     * @param Request $request
     * @return BaseResponse
     */
    public function convert(Request $request): BaseResponse
    {
        try {
            $markdown = $request->post('markdown');
            if (trim($markdown) === '') {
                throw new Exception("No markdown provided to convert to HTML!", 400);
            }

            $converted_html = MarkdownModel::factory()
                ->setMarkdown($markdown)
                ->convertToHtml()
            ;

            return Response::success(['converted_html' => $converted_html]);
        } catch (Exception $e) {
            return Response::error($e->getMessage(), $e->getCode());
        }
    }
}
