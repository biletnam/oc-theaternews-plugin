<?php namespace Abnmt\TheaterNews\Components;

use Cms\Classes\ComponentBase;

class Archive extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'abnmt.theaternews::lang.components.archive.name',
            'description' => 'abnmt.theaternews::lang.components.archive.description'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

}