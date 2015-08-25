<?php namespace Abnmt\TheaterNews\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Lang;

/**
 * News Back-end Controller
 */
class News extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Abnmt.TheaterNews', 'theaternews', 'news');
    }

    /**
     * Deleted checked news.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $newsId) {
                if (!$news = News::find($newsId)) continue;
                $news->delete();
            }

            Flash::success(Lang::get('abnmt.theaternews::lang.news.delete_selected_success'));
        }
        else {
            Flash::error(Lang::get('abnmt.theaternews::lang.news.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}