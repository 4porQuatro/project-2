<?php


namespace Packages\Reserved\tests\Feature;


use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Packages\Orders\App\Constants\CheckoutTypes;
use Packages\Orders\App\Models\Checkout;
use Packages\Reserved\App\Models\ReservedArea;
use Packages\Store\app\Classes\Front\Shoppingcart\Cart;
use Packages\Store\app\Models\Product;
use Tests\TestCase;

class LoginTest extends TestCase {

    use DatabaseMigrations;
    public $reserved;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->reserved = ReservedArea::factory()->create(['prefix'=>'prefix_test']);
    }

    /** @test */
    public function when_a_vistor_try_access_to_the_reseved_area_its_redirected_to_the_login_page()
    {
        $response = $this->get($this->reserved->prefix);

        $response->assertStatus(302);
        $response->assertRedirect($this->reserved->loginPage->path());
    }

    /** @test */
    public function a_authenticaded_user_can_access_to_the_reserved_area()
    {
        $user = User::factory()->create(['name'=>'Mister fill good','reserved_area_id'=>$this->reserved->id, 'email'=>'reco@reco.pt']);
        $user->password = Hash::make('filipe');
        $user->save();
        $response = $this->post(route($this->reserved->prefix.'.login'), ['email'=>'reco@reco.pt', 'password'=>'filipe']);

        $response->assertStatus(302);
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect($this->reserved->prefix);

    }

    /** @test */
    public function if_a_user_has_a_cart_it_redirected_to_the_normal_checkout()
    {
        $user = User::factory()->create(['name'=>'Mister fill good','reserved_area_id'=>$this->reserved->id, 'email'=>'reco@reco.pt']);
        $user->password = Hash::make('filipe');
        $user->save();
        if(env('APP_STORE') && env('APP_ORDERS'))
        {
            $cart = new Cart(session());
            $product = Product::factory()->create();
            $cart->add($product, 1);
        }
        $checkout = Checkout::factory()->create(['type' => CheckoutTypes::NORMAL, 'reserved_area_id'=>$this->reserved->id]);

        $response = $this->post(route($this->reserved->prefix.'.login'), ['email'=>'reco@reco.pt', 'password'=>'filipe']);

        $response->assertStatus(302);
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('checkout.show', ['checkout'=>$checkout->id]));
    }

    /** @test */
    public function is_not_possible_to_login_with_the_wrong_credentials()
    {
        $user = User::factory()->create(['name'=>'Mister fill good','reserved_area_id'=>$this->reserved->id, 'email'=>'reco@reco.pt']);
        $user->password = Hash::make('filipe_wrong');
        $user->save();
        $response = $this->post(route($this->reserved->prefix.'.login'), ['email'=>'reco@reco.pt', 'password'=>'filipe']);

        $response->assertStatus(302);
        $this->assertNull(auth()->user());
        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function is_not_possible_to_login_with_unexisted_credentials()
    {
        $response = $this->post(route($this->reserved->prefix.'.login'), ['email'=>'reco@reco.pt', 'password'=>'filipe']);

        $response->assertStatus(302);
        $this->assertNull(auth()->user());
        $response->assertSessionHasErrors(['email']);
    }


}