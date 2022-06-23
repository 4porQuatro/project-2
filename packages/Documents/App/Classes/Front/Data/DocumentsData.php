<?php


namespace Packages\Documents\App\Classes\Front\Data;

use App\Classes\Front\Data\FieldDataAbstract;
use App\Models\Article;
use App\Models\User;
use Packages\Documents\App\Models\Document;
use Packages\Reserved\App\Models\Customer;
use Packages\Reserved\App\Models\ReservedArea;
use Packages\Store\app\Models\Product;

class DocumentsData extends FieldDataAbstract {

    public function setDefaultValue()
    {

        $categories = $this->getCategories();
        $limit = $this->getLimit();
        $reserved_areas = $this->getReservedAreas();
        $auth_user = $this->getAuthUser();

        $documents = new Document();

        if($categories)
        {
            $documents = $documents->whereHas('categories', function ($q) use ($categories){
                $q->whereIn('categories.id', $categories);
            });
        }

        if($limit)
        {
            $documents = $documents->limit($limit);
        }

        if($reserved_areas)
        {
            $documents = $documents->whereHasMorph(
                'documentable',
                ReservedArea::class,
                function ($q) use ($reserved_areas){
                $q->whereIn('id', $reserved_areas);
            });
        }

        if($auth_user)
        {
            $documents = $documents->whereHasMorph(
                'documentable',
                [User::class, Customer::class],
                function ($q) {
                    $q->where('id', auth()->user()->id);
                });
        }

        return $documents->ordered()->with('translations')->get();
    }

    public function setAlternativesValue(): \stdClass
    {
        return new \stdClass();
    }

    public function getCategories()
    {
        return isset($this->data->data_array[$this->field->name]) && isset($this->data->data_array[$this->field->name]['categories']) ? $this->data->data_array[$this->field->name]['categories'] :[];
    }

    public function getLimit()
    {
        return isset($this->data->data_array[$this->field->name]) && isset($this->data->data_array[$this->field->name]['limit']) ? $this->data->data_array[$this->field->name]['limit'] : null;
    }

    public function getReservedAreas()
    {
        return isset($this->data->data_array[$this->field->name]) && isset($this->data->data_array[$this->field->name]['reserved_areas']) ? $this->data->data_array[$this->field->name]['reserved_areas'] :[];
    }

    public function getAuthUser()
    {
        return isset($this->data->data_array[$this->field->name]) && isset($this->data->data_array[$this->field->name]['auth_user']) ? $this->data->data_array[$this->field->name]['auth_user'] : null;
    }
}
