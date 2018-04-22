<?php

class Renderer
{

    public function render($template, $data)
    {
        ob_start();

        include __DIR__ . '/../Templates/' . $template;

        return ob_get_clean();
    }
}