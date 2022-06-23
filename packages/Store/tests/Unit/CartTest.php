<?php

namespace Packages\Store\tests\Unit;

use App\Models\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Session\SessionManager;
use Packages\Store\app\Classes\Front\Shoppingcart\Cart;
use Packages\Store\app\Exceptions\BuyableException;
use Packages\Store\app\Interfaces\Buyable;
use Packages\Store\app\Models\Product;
use Tests\TestCase;

class CartTest extends TestCase
{
    use DatabaseMigrations;

    public function getCart($type = null)
    {
        $session = $this->app->make('session');

        return new Cart($session, $type);
    }

    /** @test */
    public function a_cart_as_a_session()
    {
        $cart = $this->getCart();

        $this->assertNotNull($cart->session);
        $this->assertInstanceOf(SessionManager::class, $cart->session);
    }

    /** @test */
    public function a_cart_as_a_instance()
    {
        $cart = $this->getCart();

        $this->assertNotNull($cart->instance);
    }

    /** @test */
    public function is_possible_to_define_a_new_cart_instance()
    {
        $cart = $this->getCart('wishlist');

        $first_cart_instance =$this->getCart();

        //$cart = $cart->instance('wishlist');

        $this->assertNotEquals($first_cart_instance, $cart->instance);
    }

    /** @test */
    public function each_instance_can_have_their_own_content()
    {
        $product = Product::factory()->create();
        $product_2 = Product::factory()->create();
        $cart = $this->getCart();
        $cart_2 = $this->getCart('wishlist');
        $cart->add($product);
        $cart_2->add($product_2);

        $this->assertCount(1, $cart->getContent());
        $this->assertCount(1, $cart_2->getContent());
        $this->assertNotEquals($cart->getContent(), $cart_2->getContent());
    }

    /** @test */
    public function a_exception_occurs_when_trying_to_add_a_non_buyable_model_on_cart()
    {
        $this->expectException(BuyableException::class);

        $article = Article::factory()->create();
        $this->assertFalse($article instanceof Buyable);

        $cart = $this->getCart();
        $cart->add($article);
    }

    /** @test */
    public function is_possible_to_add_a_product()
    {
        $product = Product::factory()->create();

        $this->assertTrue($product instanceof Buyable);

        $cart = $this->getCart();

        $this->assertEquals(0, $cart->count());

        $cart->add($product);

        $this->assertEquals(1, $cart->count());
    }

    /** @test */
    public function is_possible_to_define_the_quantity_when_adding_a_item()
    {
        $product = Product::factory()->create();

        $quantity = 5;

        $cart = $this->getCart();

        $cart->add($product, $quantity);

        $this->assertEquals($quantity, $cart->count());
    }

    /** @test */
    public function when_adding_a_product_the_product_quantity_is_updated_if_the_item_already_exists_in_the_cart()
    {
        $product = Product::factory()->create();

        $cart = $this->getCart();

        $cart->add($product);
        $cart->add($product);
        $cart->add($product);
        $cart->add($product, 2);

        $this->assertEquals(5, $cart->count());
        $this->assertEquals(1, $cart->getContent()->count());
    }

    /** @test */
    public function is_possible_to_update_a_product_quantity()
    {
        $quantity = 5;

        $product = Product::factory()->create();

        $cart = $this->getCart();
        $cart->add($product);
        $cart->update($product->id, $quantity);

        $this->assertEquals($quantity, $cart->count());
        $this->assertEquals(1, $cart->getContent()->count());
    }

    /** @test */
    public function if_the_product_quantity_is_changed_to_zero_the_product_is_removed()
    {
        $product = Product::factory()->create();

        $cart = $this->getCart();
        $cart->add($product);
        $cart->update($product->id, 0);

        $this->assertEquals(0, $cart->count());
        $this->assertEquals(0, $cart->getContent()->count());
    }

    /** @test */
    public function if_the_product_quantity_is_changed_to_negative_the_product_is_removed()
    {
        $product = Product::factory()->create();

        $cart = $this->getCart();
        $cart->add($product);
        $cart->update($product->id, -1);

        $this->assertEquals(0, $cart->count());
        $this->assertEquals(0, $cart->getContent()->count());
    }

    /** @test */
    public function is_possible_to_remove_a_item_from_the_cart()
    {
        $product = Product::factory()->create();

        $cart = $this->getCart();
        $cart->add($product);
        $cart->remove($product->id);

        $this->assertEquals(0, $cart->count());
        $this->assertEquals(0, $cart->getContent()->count());
    }

    /** @test */
    public function is_possible_to_get_a_item_from_the_cart_by_her_id()
    {
        $product = Product::factory()->create();

        $cart = $this->getCart();
        $cart->add($product);

        $cartItem = $cart->get($product->id);

        $this->assertInstanceOf(Product::class, $cartItem);
    }

    /** @test */
    public function is_possible_to_destroy_a_cart_instance()
    {
        $product = Product::factory()->create();

        $cart = $this->getCart();

        $cart->add($product);

        $this->assertEquals(1, $cart->count());
        $this->assertEquals(1, $cart->getContent()->count());

        $cart->destroy();

        $this->assertEquals(0, $cart->count());
        $this->assertEquals(0, $cart->getContent()->count());
    }

    /** @test */
    public function it_can_get_the_total_price_of_the_cart_content()
    {
        $product_1 = Product::factory()->create([
            'price'=>10.00,
            'promoted_price'=>null
        ]);

        $product_2 = Product::factory()->create([
            'price'=>30.00,
            'promoted_price'=>25.00
        ]);

        $cart = $this->getCart();

        $cart->add($product_1);
        $cart->add($product_2, 2);

        $this->assertEquals(3, $cart->count());
        $this->assertEquals(2, $cart->getContent()->count());

        $this->assertEquals(60.00, $cart->total());
    }

    /** @test */
    public function its_possible_get_the_total_cart_weight()
    {
        $product_1 = Product::factory()->create([
            'price'=>10.00,
            'promoted_price'=>null,
            'shippment_weight'=>10,
            'shippment_length'=>10,
            'shippment_width'=>10,
            'shippment_height'=>10,
        ]);

        $product_2 = Product::factory()->create([
            'price'=>30.00,
            'promoted_price'=>25.00,
            'shippment_weight'=>20,
            'shippment_length'=>5,
            'shippment_width'=>5,
            'shippment_height'=>5,
        ]);

        $cart = $this->getCart();

        $cart->add($product_1);
        $cart->add($product_2, 2);

        $this->assertEquals(10+20*2, $cart->getShippmentWeight());
    }

    /** @test */
    public function its_possible_getThe_total_cart_volume()
    {
        $product_1 = Product::factory()->create([
            'price'=>10.00,
            'promoted_price'=>null,
            'shippment_weight'=>10,
            'shippment_length'=>10,
            'shippment_width'=>10,
            'shippment_height'=>10,
        ]);

        $product_2 = Product::factory()->create([
            'price'=>30.00,
            'promoted_price'=>25.00,
            'shippment_weight'=>20,
            'shippment_length'=>5,
            'shippment_width'=>5,
            'shippment_height'=>5,
        ]);

        $cart = $this->getCart();

        $cart->add($product_1);
        $cart->add($product_2, 2);

        $this->assertEquals((10*10*10)+(5*5*5)*2, $cart->getShippmentVolume());
    }
}
