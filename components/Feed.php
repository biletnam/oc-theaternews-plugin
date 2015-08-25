<?php namespace Abnmt\TheaterNews\Components;

use Cms\Classes\ComponentBase;

class Feed extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'abnmt.theaternews::lang.components.feed.name',
            'description' => 'abnmt.theaternews::lang.components.feed.description'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

}