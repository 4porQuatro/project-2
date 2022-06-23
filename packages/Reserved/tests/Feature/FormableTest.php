<?php


namespace Packages\Reserved\tests\Feature;


use App\Models\Article;
use App\Models\Form;
use Packages\Reserved\App\Constants\FormTypes;
use Packages\Reserved\App\Http\Livewire\cms\reserved_area\Table;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Packages\Reserved\App\Models\ReservedArea;
use Tests\Feature\cms\CmsTestCase;

class FormableTest extends CmsTestCase {

    use DatabaseMigrations;


    /** @test */
    public function if_a_user_creates_a_new_form_of_type_login_the_fields_email_and_password_are_generated()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->user_with_permissions);
        $reserved = ReservedArea::factory()->create();
        $form = Form::factory()->raw(['type'=>FormTypes::LOGIN, 'formable_type'=>ReservedArea::class, 'formable_id'=>$reserved->id]);

        $response = $this->post(route('cms.forms.store'), $form);
        $response->assertStatus(302);
        $this->assertDatabaseHas('forms', $form);
        $fields = Form::latest()->first()->fields;
        $this->assertCount(2, $fields);
        $this->assertFalse($fields->first()->editable);

    }

    /** @test */
    public function if_a_user_creates_a_new_form_of_type_login_the_settings_are_automacly_generated()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->user_with_permissions);
        $reserved = ReservedArea::factory()->create();
        $form = Form::factory()->raw(['type' => FormTypes::LOGIN, 'formable_type' => ReservedArea::class, 'formable_id' => $reserved->id]);
        $response = $this->post(route('cms.forms.store'), $form);
        $response->assertStatus(302);
        $this->assertDatabaseHas('forms', $form);
        $form = Form::orderBy('id', 'desc')->first();
        $this->assertFalse($form->can_add_fields);
        $this->assertFalse($form->can_see_answears);
    }

    /** @test */
    public function if_a_user_creates_a_new_form_of_type_login_it_cant_add_fields()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->user_with_permissions);
        $reserved = ReservedArea::factory()->create();
        $form = Form::factory()->raw(['type' => FormTypes::LOGIN, 'formable_type' => ReservedArea::class, 'formable_id' => $reserved->id]);
        $this->post(route('cms.forms.store'), $form);
        $response = $this->get(route('cms.fields.index', ['model'=>'Form', 'id'=>Form::latest()->first()->id]));
        $response->assertStatus(200);
        $response->assertDontSee(route('cms.fields.create', ['model'=>'Form', 'id'=>Form::latest()->first()->id]));

    }

    protected function getPermissions()
    {
        return ['reserved_area_index', 'reserved_area_store', 'reserved_area_update', 'form_store', 'field_index', 'field_store'];
    }
}
