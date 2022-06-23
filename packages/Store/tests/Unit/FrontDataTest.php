<?php

namespace Packages\Store\tests\Unit;


use App\Classes\Front\Data\ComponentData;
use App\Models\Article;
use App\Models\Category;
use App\Models\Component;
use App\Models\Field;
use App\Models\Section;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Packages\Store\app\Models\AttributeFamily;
use Packages\Store\app\Models\Product;
use Tests\TestCase;

class FrontDataTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function its_possible_to_retrieve_a_list_of_products()
    {
        $key = 'products';
        $attribute_family = AttributeFamily::factory()->create()->fresh();
        Product::factory(5)->create([
            'attribute_family_id'=>$attribute_family->id,
        ])->fresh();

        $expected_result = Product::with('translations')->get();

        list($component, $section) = $this->createSection($key, [], 'products-list');

        $result = (new ComponentData($component, $section->data))->getData();

        $this->assertObjectHasAttribute($key, $result);
        $this->assertEquals($expected_result, $result->$key->default);
    }

    /** @test */
    public function when_retrieving_a_list_of_products_the_products_respect_their_order()
    {
        $key = 'products';

        $attribute_family = AttributeFamily::factory()->create()->fresh();
        $products = Product::factory(5)->create([
            'attribute_family_id'=>$attribute_family->id,
        ])->fresh();

        $this->randomizePrioritys($products);

        list($component, $section) = $this->createSection($key, [], 'products-list');
        $result = (new ComponentData($component, $section->data))->getData();

        $expected_result = Product::with('translations')->ordered()->get();

        $this->assertObjectHasAttribute($key, $result);
        $this->assertEquals($expected_result, $result->$key->default);
    }

    /** @test */
    public function when_retrieving_a_list_of_products_only_the_primary_products_are_retrieved()
    {
        $key = 'products';

        $attribute_family = AttributeFamily::factory()->create()->fresh();
        $main_products = Product::factory(5)->create([
            'attribute_family_id'=>$attribute_family->id,
        ])->fresh();

        $variants = Product::factory(10)->create()->fresh();
        foreach ($variants as $variant)
        {
            $variant->update(['parent_id'=>$main_products->random()->id]);
        }


        list($component, $section) = $this->createSection($key, [], 'products-list');
        $result = (new ComponentData($component, $section->data))->getData();

        $expected_result = Product::with('translations')->primary()->ordered()->get();

        $this->assertObjectHasAttribute($key, $result);
        $this->assertEquals($expected_result, $result->$key->default);
    }

    /** @test */
    public function when_retrieving_a_list_of_products_only_the_actives_are_retrieved()
    {
        $key = 'products';
        $attribute_family = AttributeFamily::factory()->create()->fresh();

        Product::factory(5)->create([
            'attribute_family_id'=>$attribute_family->id,
        ])->fresh();

        Product::factory(5)->create([
            'attribute_family_id'=>$attribute_family->id,
            'active'=>false
        ])->fresh();

        list($component, $section) = $this->createSection($key, [], 'products-list');
        $result = (new ComponentData($component, $section->data))->getData();

        $expected_result = Product::with('translations')->active()->ordered()->get();

        $this->assertObjectHasAttribute($key, $result);
        $this->assertEquals($expected_result, $result->$key->default);
    }

    /** @test */
    public function is_possible_to_retrieve_products_of_specific_categories()
    {
        $key = 'products';
        $categories = Category::factory(2)->create(['categorable'=>'products'])->fresh();
        $attribute_family = AttributeFamily::factory()->create()->fresh();

        $products = Product::factory(10)->create([
            'attribute_family_id'=>$attribute_family->id,
        ])->fresh();

        $products->each(function($item) use ($categories) {
            $item->categories()->sync([$categories->random()->id]);
        });

        foreach ($categories as $category)
        {
            list($component, $section) = $this->createSection($key, ['categories'=>[$category->id]], 'products-list');
            $result = (new ComponentData($component, $section->data))->getData();

            $expected_result = Product::with('translations')->whereHas('categories', function ($q) use ($category){
                $q->whereIn('categories.id', [$category->id]);
            })->active()->ordered()->get();

            $this->assertObjectHasAttribute($key, $result);
            $this->assertEquals($expected_result, $result->$key->default);
        }
    }

    /** @test */
    public function is_possible_to_retrieve_products_of_specific_attribute_families()
    {
        $key = 'products';
        $attributes_families = AttributeFamily::factory(2)->create()->fresh();

        foreach ($attributes_families as $attribute_family)
        {
            $products = Product::factory(5)->create([
                'attribute_family_id'=>$attribute_family->id,
            ])->fresh();
        }

        foreach ($attributes_families as $attribute_family)
        {
            list($component, $section) = $this->createSection($key, ['attribute_families'=>[$attribute_family->id]], 'products-list');
            $result = (new ComponentData($component, $section->data))->getData();

            $expected_result = Product::with('translations')->where('attribute_family_id', $attribute_family->id)->active()->ordered()->get();

            $this->assertObjectHasAttribute($key, $result);
            $this->assertEquals($expected_result, $result->$key->default);
        }
    }

    /** @test */
    public function is_possible_to_limit_a_list_of_products()
    {
        $key = 'products';
        $attribute_family = AttributeFamily::factory()->create()->fresh();
        Product::factory(5)->create([
            'attribute_family_id'=>$attribute_family->id,
        ])->fresh();

        $limit_amount = 3;

        list($component, $section) = $this->createSection($key, ['limit'=>$limit_amount], 'products-list');
        $result = (new ComponentData($component, $section->data))->getData();

        $expected_result = Product::with('translations')->active()->ordered()->limit($limit_amount)->get();

        $this->assertObjectHasAttribute($key, $result);
        $this->assertEquals($expected_result, $result->$key->default);
    }

    /** @test */
    public function is_possible_to_retrieve_only_the_promoted_products()
    {
        $key = 'products';
        $attribute_family = AttributeFamily::factory()->create()->fresh();

        Product::factory(5)->create([
            'attribute_family_id'=>$attribute_family->id,
            'promoted'=>false
        ])->fresh();

        Product::factory(5)->create([
            'attribute_family_id'=>$attribute_family->id,
            'promoted'=>true
        ])->fresh();


        list($component, $section) = $this->createSection($key, ['promoted'=>true], 'products-list');
        $result = (new ComponentData($component, $section->data))->getData();

        $expected_result = Product::with('translations')->active()->promoted()->ordered()->get();

        $this->assertObjectHasAttribute($key, $result);
        $this->assertEquals($expected_result, $result->$key->default);
    }

    /** @test */
    public function is_possible_to_retrieve_only_the_highlighted_products()
    {
        $key = 'products';
        $attribute_family = AttributeFamily::factory()->create()->fresh();

        Product::factory(5)->create([
            'attribute_family_id'=>$attribute_family->id,
            'highlighted'=>false
        ])->fresh();

        Product::factory(5)->create([
            'attribute_family_id'=>$attribute_family->id,
            'highlighted'=>true
        ])->fresh();


        list($component, $section) = $this->createSection($key, ['highlighted'=>true], 'products-list');
        $result = (new ComponentData($component, $section->data))->getData();

        $expected_result = Product::with('translations')->active()->highlighted()->ordered()->get();

        $this->assertObjectHasAttribute($key, $result);
        $this->assertEquals($expected_result, $result->$key->default);
    }

    /**
     * @param string $key
     * @param string $text
     * @return array
     */
    private function createSection(string $key, $text , string $type): array
    {
        $component = Component::factory()->create();
        $field = Field::factory()->create(['type' => $type, 'name' => $key, 'fieldable_type' => Component::class, 'fieldable_id' => $component->id]);
        $section = Section::factory()->create(['data' => [$key => $text]]);

        return array($component, $section);
    }

    private function randomizePrioritys(Collection $collection)
    {
        $prioritys_array = $collection->pluck('priority')->toArray();
        shuffle($prioritys_array);

        foreach ($collection as $key=>$model)
        {
            $model->update(['priority'=>$prioritys_array[$key]]);
        }
    }
}
