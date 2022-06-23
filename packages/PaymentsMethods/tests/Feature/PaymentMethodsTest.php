<?php


namespace Packages\PaymentMethods\tests\Feature;


use App\Models\Setting;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Packages\PaymentsMethods\App\Http\Controllers\Livewire\cms\payment_methods\Table;
use Packages\PaymentsMethods\App\Models\PaymentMethod;
use Packages\PaymentsMethods\Providers\Easypay\EasyPay;
use Packages\PaymentsMethods\Providers\Eupago\EuPago;
use Tests\Feature\cms\CmsTestCase;

class PaymentMethodsTest extends CmsTestCase {

    use DatabaseMigrations;
    public $payment_methods;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        Setting::create(['name' => 'payment_methods', 'data' => [
            ['provider' => EuPago::class, 'key' => 'olá mundo', 'private_key' => 'private_key'],
            ['provider' => EasyPay::class, 'key' => 'olá mundo', 'private_key' => 'private_key']
        ]]);
        $this->payment_methods = PaymentMethod::factory(2)->create();
    }

    /** @test */
    public function a_authorized_user_can_see_the_link_to_see_the_payment_methods_module()
    {
        $this->actingAs($this->sudo_user);

        $response = $this->get(route('cms.home'));

        $response->assertStatus(200);
        $response->assertSee(route('cms.payment_methods.index'));
    }

    /** @test */
    public function a_unautorized_user_cant_see_the_link_to_create_new_payment_methods()
    {
        $this->actingAs($this->user_without_permissions);
        $response = $this->get(route('cms.home'));

        $response->assertDontSee(route('cms.payment_methods.index'));
    }

    /** @test */
    public function a_authorized_user_can_access_to_the_index_page()
    {
        $this->actingAs($this->user_with_permissions);

        $response = $this->get(route('cms.payment_methods.index'));

        $response->assertStatus(200);
        $response->assertSee(route('cms.payment_methods.create'));

    }

    /** @test */
    public function a_unauthorized_user_cant_access_to_the_index_page()
    {
        $this->actingAs($this->user_without_permissions);

        $response = $this->get(route('cms.payment_methods.index'));

        $response->assertStatus(403);

    }

    /** @test */
    public function a_authorized_can_see_the_list_of_payment_methods()
    {

        $this->actingAs($this->user_with_permissions);
        $livewire = Livewire::test(Table::class);

        foreach($this->payment_methods as $payment_method)
        {
            $livewire->assertSee($payment_method->name);
            $livewire->assertSee(route('cms.payment_methods.edit', ['payment_method'=>$payment_method->id]));
        }
        $livewire->call('delete', $this->payment_methods->first()->id);
        $this->assertDatabaseMissing('payment_methods', ['name'=>$this->payment_methods->first()->name]);

    }

    /** @test */
    public function a_authorized_user_can_access_to_creation_form()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->user_with_permissions);

        $response = $this->get(route('cms.payment_methods.create'));

        $response->assertStatus(200);
        $response->assertSee(route('cms.payment_methods.store'));
    }


    /** @test */
    public function a_unauthorized_user_cant_access_to_creation_form()
    {
        $this->actingAs($this->user_without_permissions);

        $response = $this->get(route('cms.payment_methods.create'));

        $response->assertStatus(403);
    }

    /** @test */
    public function a_authorized_user_can_create_a_new_payment_method()
    {
        $this->actingAs($this->user_with_permissions);

        $data = ['provider'=>EuPago::class, 'provider_method'=>array_rand((new EuPago())->avaliableMethods()), 'name'=>'Eu pago'];

        $response = $this->post(route('cms.payment_methods.store'), $data);

        $response->assertStatus(302);
        $response->assertRedirect(route('cms.payment_methods.index'));
        $this->assertDatabaseHas('payment_methods', $data);
    }

    /** @test */
    public function a_authorized_user_can_see_the_edit_form()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->user_with_permissions);

        $response = $this->get(route('cms.payment_methods.edit', ['payment_method'=>$this->payment_methods->first()->id]));

        $response->assertStatus(200);
        $response->assertSee(route('cms.payment_methods.update', ['payment_method'=>$this->payment_methods->first()->id]));
    }

    /** @test */
    public function a_authorized_user_can_update_a_existing_payment_method()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->user_with_permissions);
        $data = ['provider'=>EuPago::class, 'provider_method'=>array_rand((new EuPago())->avaliableMethods()), 'name'=>'Eu pago'];

        $response = $this->patch(route('cms.payment_methods.update', ['payment_method'=>$this->payment_methods->first()->id]), $data);

        $response->assertStatus(302);
        $response->assertRedirect(route('cms.payment_methods.index'));
        $this->assertDatabaseHas('payment_methods', $data);

    }

    /** @test */
    public function a_authorized_user_can_see_the_link_to_create_details_about_the_payment()
    {

        $this->actingAs($this->sudo_user);


        foreach($this->payment_methods as $payment_method)
        {
            $response = $this->get(route('cms.payment_methods.edit', ['payment_method'=>$payment_method->id]));
            $route_article = route('cms.articlable.edit', ['articlable_type'=>PaymentMethod::class, 'articlable_id'=>$payment_method->id]);
            $response->assertSee($route_article);
        }
    }

    /** @test */
    public function a_authorized_user_can_see_the_link_to_add_section_to_a_payment_method()
    {
        $this->actingAs($this->user_with_permissions);
        $livewire = Livewire::test(Table::class);

        foreach($this->payment_methods as $payment_method)
        {
            $livewire->assertSee($payment_method->name)
            ->assertSeeHtml(route('cms.articlable.edit', ['articlable_type'=>PaymentMethod::class, 'articlable_id'=>$payment_method->id]));
        }
    }

    /** @test */
    public function when_a_user_creates_a_new_payment_mehtod_the_sections_are_automacly_generated()
    {
        $this->actingAs($this->user_with_permissions);

        $data = ['provider'=>EuPago::class, 'provider_method'=>array_rand((new EuPago())->avaliableMethods()), 'name'=>'Eu pago'];

        $response = $this->post(route('cms.payment_methods.store'), $data);

        $response->assertStatus(302);

        $payment_method = PaymentMethod::orderBy('id', 'desc')->first();
        $this->assertcount(1, $payment_method->sections);
        $this->assertTrue($payment_method->sections()->first()->component->componentable_type == PaymentMethod::class);
        $this->assertNotEmpty($payment_method->layout_id);
    }


    protected function getPermissions()
    {
        return ['payment_methods_index', 'payment_methods_store', 'payment_methods_update', 'payment_methods_destroy'];
    }
}
