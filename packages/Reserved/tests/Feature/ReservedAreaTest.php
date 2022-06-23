<?php


namespace Packages\Reserved\tests\Feature;


use App\Models\Article;
use App\Models\Page;
use App\Models\User;
use Packages\Reserved\App\Http\Livewire\cms\reserved_area\Table;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Packages\Reserved\App\Models\ReservedArea;
use Tests\Feature\cms\CmsTestCase;

class ReservedAreaTest extends CmsTestCase {
    use DatabaseMigrations;


    /** @test */
    public function a_authorized_user_can_see_the_link_to_see_the_reserved_areas()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->user_with_permissions);

        $response = $this->get(route('cms.home'));

        $response->assertStatus(200);
        $response->assertSee(route('cms.reserved_area.create'));
        $response->assertSee(__('reserved::cms.new'));
    }

    /** @test */
    public function a_unauthorized_user_cant_see_the_link_to_the_reserverd_areas()
    {
        $this->actingAs($this->user_without_permissions);

        $response = $this->get(route('cms.home'));

        $response->assertStatus(200);
        $response->assertDontSee(route('cms.reserved_area.create'));
    }

    /** @test */
    public function the_list_of_reserved_area_are_on_sidebar()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->user_with_permissions);
        $reserved_areas = ReservedArea::factory(3)->create();

        $response = $this->get(route('cms.home'));

        $response->assertStatus(200);

        foreach($reserved_areas as $reserved)
        {
            $response->assertSee($reserved->name);
            $response->assertSee(route('cms.reserved_area.show', ['reserved_area'=>$reserved->id]));
        }

    }

    /** @test */
    public function a_authorized_user_can_see_the_details_of_a_given_reserved_area()
    {
        $this->actingAs($this->user_with_permissions);
        $reserved_area = ReservedArea::factory()->create();

        $response = $this->get(route('cms.reserved_area.show', ['reserved_area'=>$reserved_area->id]));

        $response->assertStatus(200);

    }


    /** @test */
    public function a_unautorized_user_cant_access_to_the_list_of_reserved_areas()
    {
        $this->actingAs($this->user_without_permissions);

        $response = $this->get(route('cms.reserved_area.index'));

        $response->assertStatus(403);
    }

    /** @test */
    public function a_authorized_user_can_the_link_to_create_a_new_reserved_area()
    {
        $this->actingAs($this->user_with_permissions);

        $response = $this->get(route('cms.reserved_area.index'));
        $response->assertStatus(200);
        $response->assertSee(route('cms.reserved_area.create'));
    }

    /** @test */
    public function a_unauthorized_user_cant_access_the_link_to_create_a_new_reserved_area()
    {
        $this->actingAs($this->user_without_permissions);
        $this->get(route('cms.reserved_area.create'))->assertStatus(403);
    }

    /** @test */
    public function a_authorized_user_can_access_to_the_form_to_create_a_new_reserved_area()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->user_with_permissions);

        $response = $this->get(route('cms.reserved_area.create'));

        $response->assertStatus(200);
        $response->assertSee('name');
        $response->assertSee('prefix');
//        $response->assertSee(trans('reserved::cms.new_reserved_area'));
        $response->assertSee(route('cms.reserved_area.store'));
    }

    /** @test */
    public function a_reserved_area_must_have_a_name()
    {
        $this->actingAs($this->user_with_permissions);
        $data = ['name'=>'', 'prefix'=>'', 'login_page_id'=>''];
        $response = $this->post(route('cms.reserved_area.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
        $response->assertSessionHasErrors(['prefix']);
        $response->assertSessionHasErrors(['login_page_id']);
    }

    /** @test */
    public function on_submission_a_prefix_only_can_be_a_slug()
    {
        $this->actingAs($this->user_with_permissions);
        $data = ['name'=>'ola mundo', 'prefix'=>'reco da', 'login_page_id'=>1, ];
        $response = $this->post(route('cms.reserved_area.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['prefix']);

        $data = ['name'=>'ola mundo', 'prefix'=>'ola-mundo', 'login_page_id'=>1];
        $response = $this->post(route('cms.reserved_area.store'), $data);
        $response->assertSessionHasNoErrors(['prefix']);
    }

    /** @test */
    public function on_submission_the_data_its_perssisted_on_database()
    {
        $this->actingAs($this->user_with_permissions);
        $data = ['name' => 'ola mundo', 'prefix' => 'ola-mundo', 'login_page_id'=>Page::factory()->create()->id,];
        $response = $this->post(route('cms.reserved_area.store'), $data);
        $response->assertStatus(302);
        $response->assertRedirect(route('cms.reserved_area.index'));
        $this->assertDatabaseHas('reserved_areas', $data);
    }

    /** @test */
    public function a_authorized_user_can_see_all_reserved_areas()
    {
        $this->actingAs($this->user_with_permissions);
        $reserved_areas = ReservedArea::factory(3)->create();

        foreach($reserved_areas as $reserved_area)
        {
            Livewire::test(Table::class)
                ->assertSee($reserved_area->name)
                ->assertSee(route('cms.reserved_area.edit', ['reserved_area'=>$reserved_area->id]))
            ;
        }
    }

    /** @test */
    public function a_authorized_user_can_see_the_form_to_edit_a_reserved_area()
    {
        $this->actingAs($this->user_with_permissions);
        $reserved_area = ReservedArea::factory()->create();

        $response = $this->get(route('cms.reserved_area.edit', ['reserved_area'=>$reserved_area->id]));

        $response->assertStatus(200);
        $response->assertSee(route('cms.reserved_area.update', ['reserved_area'=>$reserved_area->id]));
        $response->assertSee($reserved_area->name);
        $response->assertSee($reserved_area->prefix);
    }

    /** @test */
    public function a_authorized_user_can_update_a_reserved_area()
    {
        $this->actingAs($this->user_with_permissions);
        $reserved_area = ReservedArea::factory()->create();
        $new = ReservedArea::factory()->raw();

        $response = $this->patch(route('cms.reserved_area.update', ['reserved_area'=>$reserved_area->id]), $new);

        $response->assertStatus(302);
        $response->assertRedirect(route('cms.reserved_area.index'));
        $this->assertDatabaseHas('reserved_areas', $new);
    }

    /** @test */
    public function a_authorized_user_can_see_the_link_to_see_the_list_of_forms_for_a_given_reserved_area()
    {
        $this->actingAs($this->user_with_permissions);
        $reserved_area = ReservedArea::factory()->create();

        $response = $this->get(route('cms.reserved_area.show', ['reserved_area'=>$reserved_area->id]));

        $response->assertStatus(200);
        $response->assertSee(route('cms.forms.index', ['formable_id'=>$reserved_area->id, 'formable_type'=>ReservedArea::class]));
    }

    /** @test */
    public function a_authorized_user_can_see_the_link_to_see_the_list_of_pages_for_a_given_reserved_area()
    {
        $this->actingAs($this->user_with_permissions);
        $reserved_area = ReservedArea::factory()->create();

        $response = $this->get(route('cms.reserved_area.show', ['reserved_area'=>$reserved_area->id]));

        $response->assertStatus(200);
        $response->assertSee(route('cms.pages.index', ['pageable_id'=>$reserved_area->id, 'pageable_type'=>ReservedArea::class]));
    }

    /** @test */
    public function a_authorized_user_can_see_all_the_users_in_the_detail_page_of_a_given_reserved_area()
    {
        $this->actingAs($this->user_with_permissions);
        $reserved_area = ReservedArea::factory()->create();
        $customers = User::factory(5)->create([
            'reserved_area_id'=>$reserved_area->id
        ]);

        $response = $this->get(route('cms.reserved_area.show', ['reserved_area'=>$reserved_area->id]));

        $response->assertStatus(200);

        foreach ($customers as $customer)
        {
            $response->assertSee($customer->name);
            $response->assertSee($customer->email);
        }

    }

    protected function getPermissions()
    {
        return ['reserved_area_index', 'reserved_area_store', 'reserved_area_update'];
    }
}
