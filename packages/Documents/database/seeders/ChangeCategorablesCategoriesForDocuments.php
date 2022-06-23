<?php

namespace Packages\Documents\database\seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Packages\Documents\App\Models\Document;

class ChangeCategorablesCategoriesForDocuments extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::where('categorable', 'documents')->get();

        foreach ($categories as $category)
        {
            $category->update([
                'categorable'=>Document::class
            ]);
        }
    }

    public function runInverse()
    {
        $categories = Category::where('categorable', Document::class)->get();

        foreach ($categories as $category)
        {
            $category->update([
                'categorable'=>'documents'
            ]);
        }
    }
}
