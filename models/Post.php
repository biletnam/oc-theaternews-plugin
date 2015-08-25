<?php namespace Abnmt\TheaterNews\Models;

use Model;

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
        'title asc'         => 'Заголовок (asc)',
        'title desc'        => 'Заголовок (desc)',
        'published_at asc'  => 'Дата публикации (asc)',
        'published_at desc' => 'Дата публикации (desc)',
    );

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [
        'categories' => ['Abnmt\TheaterNews\Models\Category', 'table' => 'abnmt_theaternews_posts_categories', 'order' => 'title']
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

    public function scopeIsPublished($query)
    {
        return $query
            ->whereNotNull('published')
            ->where('published', true)
        ;
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