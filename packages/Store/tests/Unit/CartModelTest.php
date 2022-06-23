<?php


namespace Packages\Store\tests\Unit;


use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Packages\Store\app\Models\Cart;
use Packages\Store\app\Models\Product;
use Tests\TestCase;

class CartModelTest extends TestCase
{
    use DatabaseMigrations;

    public $products;

    public function setUp() :void
    {
        parent::setUp();
        $this->products = Product::factory(3)->create();
    }

    /** @test */
    public function has_data()
    {
        $cart = Cart::factory()->create();

        $this->assertArrayHasKey('data', $cart->toArray());
        $this->assertIsArray($cart->data);
    }

    /** @test */
    public function has_a_session_id()
    {
        $cart = Cart::factory()->create();
        $this->assertArrayHasKey('session_id', $cart->toArray());
    }

    /** @test */
    public function can_belong_to_a_user()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create(['user_id'=>$user->id]);

        $this->assertInstanceOf(User::class, $cart->fresh()->user);
    }

    /** @test */
    public function has_a_share_link()
    {
        $cart = Cart::factory()->create();

        $this->assertArrayHasKey('share_link', $cart->toArray());
        $this->assertEquals(route('store.cart.share', ['uuid'=>$cart->uuid]), $cart->share_link);
    }

}
