<?php

namespace App\controllers;

use App\controllers\Functions;

class Controller
{
    protected function renderView(array $pageInfo, string $template, string $layout, array $data = [])
    {
        $params["page-info"] = $pageInfo;
        $params["data"] = $data;
        $template = Functions::getTemplate($template, $params);
        Functions::getLayout($layout, $template, $params);
    }

    protected function response(string $message, bool $status)
    {
        echo json_encode(["message" => $message, "status" => $status]);
    }
}
