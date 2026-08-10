<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_the_map_page_exposes_locations(): void
    {
        $locationId = DB::table('titik_lokasi')->insertGetId([
            'desa' => 'Desa Contoh',
            'latitude' => -2.56422,
            'longitude' => 102.77008,
            'confidence' => 'high',
        ]);

        $response = $this->get('/map');

        $response
            ->assertOk()
            ->assertSee('id="ember-map"', false)
            ->assertSee('-2.56422', false)
            ->assertSee('102.77008', false)
            ->assertSee('detail_url', false)
            ->assertSee('locations\\/1?lang=id', false)
            ->assertSee('id="map-detail-panel"', false)
            ->assertSee('id="map-detail-close"', false)
            ->assertSee('Buka detail lengkap')
            ->assertSee('h-[calc(100vh-6.5rem)]', false)
            ->assertDontSee('<footer', false);

        $this->get(route('user.locations.show', ['id' => $locationId, 'lang' => 'id']))
            ->assertOk()
            ->assertSee('Desa Contoh')
            ->assertSee('Confidence')
            ->assertSee('Tinggi')
            ->assertSee('id="location-detail-map"', false)
            ->assertSee('Buka di OpenStreetMap');
    }

    public function test_the_public_dashboard_supports_english_and_content_navigation(): void
    {
        $this->get('/?lang=en')
            ->assertOk()
            ->assertSee('Monitor fire-prone locations on')
            ->assertSee('Methodology')
            ->assertSee(route('user.about', ['lang' => 'en']), false)
            ->assertSee(route('user.team', ['lang' => 'en']), false)
            ->assertSee('id="back-to-top"', false)
            ->assertDontSee('header class="sticky', false);
    }

    public function test_public_search_finds_a_location_and_has_no_cms_button(): void
    {
        DB::table('titik_lokasi')->insert([
            'desa' => 'Suka Maju',
            'kecamatan' => 'Contoh',
            'latitude' => -2.92494,
            'longitude' => 104.68752,
        ]);

        $this->get('/search?q=Suka+Maju&lang=id')
            ->assertOk()
            ->assertSee('Suka Maju')
            ->assertSee('Hasil pencarian')
            ->assertDontSee('>CMS<', false);
    }

    public function test_map_year_filter_uses_the_available_date_range(): void
    {
        DB::table('titik_lokasi')->insert([
            [
                'latitude' => -2.56422,
                'longitude' => 102.77008,
                'date' => '2022-06-15',
            ],
            [
                'latitude' => 4.90892,
                'longitude' => 97.47369,
                'date' => '2024-09-20',
            ],
        ]);

        $this->get('/map?lang=id')
            ->assertOk()
            ->assertSee('id="map-year-range"', false)
            ->assertSee('data-year-values="2022,2024"', false)
            ->assertSee('>Semua<', false)
            ->assertSee('2 lokasi');
    }
}
