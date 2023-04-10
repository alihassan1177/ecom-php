<?php

namespace App;

use App\Functions;

class Controller{
    protected function renderView(array $pageInfo, string $template, string $layout)
    {
        $params["page-info"] = $pageInfo;
        $template = Functions::getTemplate($template, $params);
        Functions::getLayout($layout, $template, $params);
    }

    protected function response(string $message, bool $status)
    {
        echo json_encode(["message" => $message, "status" => $status]);
    }
}