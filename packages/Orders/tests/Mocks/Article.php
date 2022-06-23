<?php


namespace Packages\Orders\tests\Mocks;

use App\Interfaces\OrderItemable;
use \App\Models\Article as ArticleClass;
use App\Models\ArticleTranslation;
use Database\Factories\ArticleFactory;
use Packages\Orders\database\factories\OrderFactory;

class Article extends ArticleClass implements OrderItemable {

    public function getTranslationModelName() :string
    {
        return ArticleTranslation::class;
    }

    protected static function newFactory()
    {
        return ArticleFactory::new();
    }

    public function getItemName()
    {
        return $this->title;
    }

    public function getItemPrice()
    {
        return 10;
    }

    public function getItemPath()
    {
        return route('cms.articles.edit', ['article'=>$this->id]);
    }
}
