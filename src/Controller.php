<?php

namespace App;

use App\Functions;

class Controller{
    public function renderView(array $pageInfo, string $template, string $layout)
    {
        $params["page-info"] = $pageInfo;
        $template = Functions::getTemplate($template, $params);
        Functions::getLayout($layout, $template, $params);
    }
}