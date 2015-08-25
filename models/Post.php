<?php namespace Abnmt\TheaterNews\Models;

use Model;
use Str;

/**
 * Post Model
 */
class Post extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'abnmt_theaternews_posts';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['published_at'];

    /**
     * The attributes on which the post list can be ordered
     * @var array
     */
    public static $allowedSortingOptions = array(
        'title asc'         => 'По заголовку (asc)',
        'title desc'        => 'По заголовку (desc)',
        'published_at asc'  => 'По дате публикации (asc)',
        'published_at desc' => 'По дате публикации (desc)',
    );

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [
        'categories' => ['Abnmt\TheaterNews\Models\Category', 'table' => 'abnmt_theaternews_posts_categories', 'order' => 'name']
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'cover' => ['System\Models\File']
    ];
    public $attachMany = [];



    public function beforeCreate()
    {
        // Generate a URL slug for this model
        $this->slug = Str::slug($this->title);
    }

    //
    // Scopes
    //

    /**
     * The attributes of posts Scopes
     * @var array
     */
    public static $allowedScopingOptions = [
        'getNewsFeed' => 'Новостная лента',
    ];

    public function scopeIsPublished($query)
    {
        return $query
            ->whereNotNull('published')
            ->where('published', true)
        ;
    }

    public function scopeGetNewsFeed($query)
    {
        $query
            ->isPublished()
            ->with(['cover'])
            ->orderBy('published_at', 'desc')
            ->take(6)
        ;

        return $query->get();
    }


    /**
     * Sets the "url" attribute with a URL to this object
     * @param string $pageName
     * @param Cms\Classes\Controller $controller
     */
    public function setUrl($pageName, $controller)
    {
        $params = [
            'id' => $this->id,
            'slug' => $this->slug,
        ];

        if (array_key_exists('categories', $this->getRelations())) {
            $params['category'] = $this->categories->count() ? $this->categories->first()->slug : null;
        }

        return $this->url = $controller->pageUrl($pageName, $params);
    }

}