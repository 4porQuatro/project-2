<?php

namespace Packages\Documents\tests\Unit;


use App\Classes\Front\Data\ComponentData;
use App\Models\Article;
use App\Models\Category;
use App\Models\Component;
use App\Models\Field;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Packages\Documents\App\Models\Document;
use Packages\Reserved\App\Models\ReservedArea;
use Packages\Store\app\Models\AttributeFamily;
use Packages\Store\app\Models\Product;
use PhpParser\Comment\Doc;
use Tests\TestCase;

class FrontDataTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function its_possible_to_retrieve_a_list_of_documents()
    {
        $documents = Document::factory(5)->create();

        $key = 'documents';

        $expected_result = Document::ordered()->with('translations')->get();

        list($component, $section) = $this->createSection($key, [], 'documents-list');

        $result = (new ComponentData($component, $section->data))->getData();

        $this->assertObjectHasAttribute($key, $result);
        $this->assertEquals($expected_result, $result->$key->default);
    }

    /** @test */
    public function is_possible_to_retrieve_documents_of_specific_categories()
    {
        $key = 'documents';
        $categories = Category::factory(2)->create(['categorable'=>'documents'])->fresh();

        $documents = Document::factory(10)->create()->fresh();

        $documents->each(function($item) use ($categories) {
            $item->categories()->sync([$categories->random()->id]);
        });

        foreach ($categories as $category)
        {
            list($component, $section) = $this->createSection($key, ['categories'=>[$category->id]], 'documents-list');
            $result = (new ComponentData($component, $section->data))->getData();

            $expected_result = Document::whereHas('categories', function ($q) use ($category){
                $q->whereIn('categories.id', [$category->id]);
            })->ordered()->with('translations')->get();

            $this->assertObjectHasAttribute($key, $result);
            $this->assertEquals($expected_result, $result->$key->default);
        }
    }

    /** @test */
    public function is_possible_to_retrieve_documents_of_specific_reserved_area()
    {
        $key = 'documents';
        $reserved_areas = ReservedArea::factory(2)->create()->fresh();

        foreach ($reserved_areas as $reserved_area)
        {
            Document::factory(5)->create([
                'documentable_id'=>$reserved_area->id,
                'documentable_type'=>ReservedArea::class,
            ])->fresh();
        }

        foreach ($reserved_areas as $reserved_area)
        {
            list($component, $section) = $this->createSection($key, ['reserved_areas'=>[$reserved_area->id]], 'documents-list');
            $result = (new ComponentData($component, $section->data))->getData();

            $expected_result = Document::whereHasMorph(
                'documentable',
                ReservedArea::class,
                function ($q) use ($reserved_area){
                    $q->whereIn('id', [$reserved_area->id]);
            })->ordered()->with('translations')->get();

            $this->assertObjectHasAttribute($key, $result);
            $this->assertEquals($expected_result, $result->$key->default);
        }
    }

    /** @test */
    public function is_possible_to_retrieve_documents_of_a_authenticated_user()
    {
        $users = User::factory(2)->create();

        $key = 'documents';

        foreach ($users as $user)
        {
            Document::factory(5)->create([
                'documentable_id'=>$user->id,
                'documentable_type'=>User::class,
            ])->fresh();
        }

        foreach ($users as $user)
        {
            $this->actingAs($user);
            list($component, $section) = $this->createSection($key, ['auth_user'=>1], 'documents-list');
            $result = (new ComponentData($component, $section->data))->getData();

            $expected_result = Document::whereHasMorph(
                'documentable',
                User::class,
                function ($q) use ($user){
                    $q->where('id', $user->id);
                })->ordered()->with('translations')->get();

            $this->assertObjectHasAttribute($key, $result);
            $this->assertEquals($expected_result, $result->$key->default);
        }
    }

    /** @test */
    public function is_possible_to_limit_a_list_of_documents()
    {
        $key = 'documents';

        Document::factory(5)->create()->fresh();

        $limit_amount = 3;

        list($component, $section) = $this->createSection($key, ['limit'=>$limit_amount], 'documents-list');
        $result = (new ComponentData($component, $section->data))->getData();

        $expected_result = Document::ordered()->limit($limit_amount)->with('translations')->get();

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
}
