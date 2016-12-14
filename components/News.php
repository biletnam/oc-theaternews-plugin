<?php namespace Abnmt\TheaterNews\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;

use Abnmt\TheaterNews\Models\Post as PostModel;

use CW;

class News extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'abnmt.theaternews::lang.components.news.name',
            'description' => 'abnmt.theaternews::lang.components.news.description'
        ];
    }

    /**
     * @var The post model used for display.
     */
    public $post;

    /**
     * @var string Reference to the page name for linking to categories.
     */
    public $categoryPage;


    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'abnmt.theaternews::lang.settings.post_slug',
                'description' => 'abnmt.theaternews::lang.settings.post_slug_description',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
            'categoryPage' => [
                'title'       => 'abnmt.theaternews::lang.settings.post_category',
                'description' => 'abnmt.theaternews::lang.settings.post_category_description',
                'type'        => 'dropdown',
                'default'     => 'theaterNews/category',
            ],
        ];
    }

    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
        $this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');
        $this->post = $this->page['post'] = $this->loadPost();
    }

    protected function loadPost()
    {
        $slug = $this->property('slug');
        $post = PostModel::isPublished()->where('slug', $slug)->with(['cover'])->first();

        /*
         * Add a "url" helper attribute for linking to each category
         */
        if ($post && $post->categories->count()) {
            $post->categories->each(function($category){
                $category->setUrl($this->categoryPage, $this->controller);
            });
        }

        CW::info(['News' => $post]);

        return $post;
    }

}