<?php namespace Abnmt\TheaterNews;

use System\Classes\PluginBase;

use Abnmt\TheaterNews\Models\Post     as PostModel;
use Abnmt\TheaterNews\Models\Category as CategoryModel;

use Illuminate\Foundation\AliasLoader;
use Event;

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
            'icon'        => 'icon-newspaper-o'
        ];
    }

    public function registerNavigation()
    {
        return [
            'theaternews' => [
                'label' => 'Новости',
                'url' => \Backend::url('abnmt/theaternews/posts'),
                'icon' => 'icon-pencil',
                'order' => 500,
                'sideMenu' => [
                    'posts' => [
                        'label' => 'Новости',
                        'icon'  => 'icon-pencil',
                        'url'   => \Backend::url('abnmt/theaternews/posts'),
                    ],
                    'categories' => [
                        'label' => 'Категории',
                        'icon'  => 'icon-list',
                        'url'   => \Backend::url('abnmt/theaternews/categories'),
                    ],
                ],
            ],
        ];
    }

    /**
     * Register Components
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Abnmt\TheaterNews\Components\News'    => 'theaterNews',
            'Abnmt\TheaterNews\Components\Feed'    => 'theaterNewsFeed',
            'Abnmt\TheaterNews\Components\Archive' => 'theaterNewsArchive',
        ];
    }

    public function boot()
    {
        $alias = AliasLoader::getInstance();
        $alias->alias( 'Carbon', '\Carbon\Carbon' );
        $alias->alias( 'CW', '\Clockwork\Support\Laravel\Facade' );

        /*
         * Register menu items for the RainLab.Pages plugin
         */
        Event::listen('pages.menuitem.listTypes', function() {
            return [
                'newsarchive' => 'Архив новостей',
            ];
        });

        Event::listen('pages.menuitem.getTypeInfo', function($type) {
            if ($type == 'newsarchive')
                return PostModel::getMenuTypeInfo($type);
        });

        Event::listen('pages.menuitem.resolveItem', function($type, $item, $url, $theme) {
            if ($type == 'newsarchive')
                return PostModel::resolveMenuItem($item, $url, $theme);
        });
    }

}
