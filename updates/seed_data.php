<?php namespace Abnmt\TheaterNews\Updates;

use October\Rain\Database\Updates\Seeder;
use System\Models\File as File;

class SeedNewsTable extends Seeder
{

    public function run()
    {

        $data = require_once 'news.php';

        foreach ($data as $key => $model) {

            if (array_key_exists('category', $model)) {
                $categories = $model['category'];
                unset($model['category']);
            }

            $model = $this->createModel('Abnmt\TheaterNews\Models\Post', $model);

            if (isset($categories)) {
                $this->addTaxonomy('Abnmt\TheaterNews\Models\Category', $categories, $model);
            }

            preg_match_all('#<img.+?src="(.+?)"#', $model->content, $matches);

            // $images = $matches[1];

            $images = array_filter($matches[1], function ($value) {
                return !preg_match('#^https?\:\/\/#', $value);
            });

            if (count($images) != 0) {
                $filePath = $images[0];

                // echo $model->title . " -- " . $filePath . "\n";

                $file = new File();
                $file->fromFile("./" . $filePath);

                $model->cover()->save($file, null, ['title' => $model->title]);
            }
        }
    }

    private function createModel($modelName, $model)
    {
        $model = $modelName::create($model);

        return $model;
    }

    private function addTaxonomy($taxonomyModelName, $categories, $model)
    {
        if (!is_array($categories)) {
            $categories = [$categories];
        }

        foreach ($categories as $key => $category) {
            $taxonomy = $taxonomyModelName::where('name', '=', $category)->first();

            if (is_null($taxonomy)) {
                $taxonomy = $taxonomyModelName::create(['name' => $category]);
            }

            if (!is_null($taxonomy)) {
                $model->categories()->add($taxonomy, null);
            }
        }

    }
}
