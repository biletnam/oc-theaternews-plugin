<?php namespace Abnmt\TheaterNews\Updates;

use October\Rain\Database\Updates\Seeder;
use System\Models\File as File;

class SeedNewsTable extends Seeder
{

    public function run()
    {

        $data = require_once 'news.php';

        $path     = "./storage/app/media/news";
        $fileData = $this->fillArrayWithFileNodes(new \DirectoryIterator($path), ["jpg", "png"]);

        // print_r($fileData);

        foreach ($data as $key => $model) {

            if (array_key_exists('category', $model)) {
                $categories = $model['category'];
                unset($model['category']);
            }

            $model = $this->createModel('Abnmt\TheaterNews\Models\Post', $model);

            if (isset($categories)) {
                $this->addTaxonomy('Abnmt\TheaterNews\Models\Category', $categories, $model);
            }

            // $this->assignImages($model, $fileData);

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

    private function assignImages($model, $fileData)
    {

        if (array_key_exists($model->slug, $fileData)) {

            $images = $fileData[$model->slug];

            // print_r($images);

            echo $model->slug . " [";
            // echo get_class($model) . "\n";

            if (!is_array($images)) {
                return;
            }

            foreach ($images as $key => $filePath) {

                if (!is_array($filePath)) {
                    $pathinfo = pathinfo($filePath);
                    $check    = File::where('attachment_id', '=', $model->id)
                        ->where('attachment_type', '=', get_class($model))
                        ->where('file_name', '=', $pathinfo['basename'])
                        // ->where('field', '=', $pathinfo['filename'])
                        ->first();

                    if (!is_null($check)) {
                        // echo $filePath . " ";
                        // echo filemtime($filePath) . " ";
                        // echo $check->updated_at->timestamp . "\n";
                        if (filemtime($filePath) > $check->updated_at->timestamp) {
                            // echo "File " . $filePath . " is Newer. Update!" . "\n";
                            echo "^";
                            $check->delete();
                        } else {
                            echo "~";
                            continue;
                        }
                    } else {
                        // echo "File " . $filePath . " is New. Create!" . "\n";
                        echo "+";
                    }

                    $file = new File();
                    $file->fromFile($filePath);

                    switch ($key) {
                        case 'cover':
                            $model->cover()->save($file, null, ['title' => $model->title]);
                            break;
                        default:
                            echo ' Image ' . $filePath . ' not saved.' . "\n";
                            break;
                    }
                }
            }
            echo "]\n";
        } else {
            // preg_match_all('#<img.+?src="(.+?)"#', $model->content, $matches);

            // // $images = $matches[1];

            // $images = array_filter($matches[1], function ($value) {
            //     return !preg_match('#^https?\:\/\/#', $value);
            // });

            // if (count($images) != 0) {
            //     $filePath = $images[0];

            //     // echo $model->title . " -- " . $filePath . "\n";

            //     $file = new File();
            //     $file->fromFile("./" . $filePath);

            //     $model->cover()->save($file, null, ['title' => $model->title]);
            // }
        }

    }

    private function fillArrayWithFileNodes(\DirectoryIterator $dir, $ext = ["jpg", "png"])
    {
        $data = array();
        foreach ($dir as $node) {
            if ($node->isDir() && !$node->isDot()) {
                $data[$node->getFilename()] = self::fillArrayWithFileNodes(new \DirectoryIterator($node->getPathname()));
            } elseif ($node->isFile() && in_array($node->getExtension(), $ext)) {
                $data[$node->getBasename('.' . $node->getExtension())] = $node->getPathname();
            }
        }
        return $data;
    }

}
