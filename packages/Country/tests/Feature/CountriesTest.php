<?php

namespace Packages\Country\tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Zone;
use Packages\Country\tests\Unit\CountryTest;
use Tests\TestCase;

class CountriesTest extends TestCase {
    use DatabaseMigrations;

    /** @test */
    public function its_possible_to_retrieve_all_active_zones_with_their_related_countries()
    {
        $category = Category::factory()->create(['categorable'=>Country::class, 'name'=>'REco']);
        $countries = Country::limit(5)->get();
        $category->categorables()->attach($countries->pluck('id')->toArray());

        $response = $this->get(route('zones.get'));

        $response->assertStatus(200);
        foreach($countries as $country)
        {
            $this->assertCount(1, $response->baseResponse->original->first()->countries->filter(fn($item)=> $item->id == $country->id));
        }

        $this->assertCount(5, $response->baseResponse->original->first()->countries);

    }
}
