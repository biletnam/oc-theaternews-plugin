<?php namespace Abnmt\TheaterNews;

use System\Classes\PluginBase;

/**
 * TheaterNews Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'abnmt.theaternews::lang.plugin.name',
            'description' => 'abnmt.theaternews::lang.plugin.description',
            'author'      => 'Abnmt',
            'icon'        => 'icon-leaf'
        ];
    }

}
