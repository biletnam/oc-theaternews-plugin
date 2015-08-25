<?php namespace Abnmt\TheaterNews\Components;

use Cms\Classes\ComponentBase;

class News extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'abnmt.theaternews::lang.components.news.name',
            'description' => 'abnmt.theaternews::lang.components.news.description'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

}