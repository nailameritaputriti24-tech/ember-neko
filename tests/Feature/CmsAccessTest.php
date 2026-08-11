<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CmsAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_cms_login(): void
    {
        $this->get('/cms/titik-lokasi')
            ->assertRedirect(route('cms.login'));

        $this->get('/cms/geojson')
            ->assertRedirect(route('cms.login'));
    }

    public function test_admin_can_login_and_view_location_detail(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@ember.test',
            'password' => 'password',
        ]);

        $locationId = DB::table('titik_lokasi')->insertGetId([
            'latitude' => -2.56422,
            'longitude' => 102.77008,
            'confidence' => 'high',
        ]);

        $this->post('/cms/login', [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('cms.locations.index'));

        $this->get(route('cms.locations.show', $locationId))
            ->assertOk()
            ->assertSee('Detail lokasi')
            ->assertSee('Tinggi')
            ->assertSee('-2.56422');
    }

    public function test_authenticated_admin_can_manage_about_and_team(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->put(route('cms.about.update'), [
                'image_id' => UploadedFile::fake()->image('about-id.jpg', 1200, 800),
                'image_en' => UploadedFile::fake()->image('about-en.jpg', 1200, 800),
                'content_id' => 'Sistem pemantauan dini.',
                'content_en' => 'An early monitoring system.',
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('about_pages', [
            'content_id' => 'Sistem pemantauan dini.',
            'content_en' => 'An early monitoring system.',
        ]);

        $this->actingAs($admin)
            ->post(route('cms.team.store'), [
                'photo' => UploadedFile::fake()->image('team.jpg', 600, 600),
                'nama' => 'Tim Monitoring',
                'npm' => '2312345678',
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('team_members', [
            'nama' => 'Tim Monitoring',
            'npm' => '2312345678',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_manage_bilingual_methodology_and_public_can_switch_language(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->put(route('cms.methodology.update'), [
                'content_id' => 'Penjelasan dalam bahasa Indonesia.',
                'content_en' => 'Explanation in English.',
            ])
            ->assertSessionHas('success');

        $this->get(route('user.methodology', ['lang' => 'id']))
            ->assertOk()
            ->assertSee('Penjelasan dalam bahasa Indonesia.');

        $this->get(route('user.methodology', ['lang' => 'en']))
            ->assertOk()
            ->assertSee('Explanation in English.');
    }

    public function test_authenticated_admin_can_edit_location_details(): void
    {
        $admin = User::factory()->create();
        $locationId = DB::table('titik_lokasi')->insertGetId([
            'latitude' => -2.92494,
            'longitude' => 104.68752,
        ]);

        $this->actingAs($admin)
            ->get(route('cms.locations.edit', $locationId))
            ->assertOk()
            ->assertSee('Edit Detail Lokasi');

        $this->actingAs($admin)
            ->put(route('cms.locations.update', $locationId), [
                'provinsi' => 'Sumatera Selatan',
                'kabupaten_kota' => 'Palembang',
                'kecamatan' => 'Ilir Timur',
                'desa' => 'Contoh Desa',
                'latitude' => -2.92494,
                'longitude' => 104.68752,
                'date' => '2026-08-10',
                'confidence' => 'high',
            ])
            ->assertRedirect(route('cms.locations.show', $locationId))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('titik_lokasi', [
            'id' => $locationId,
            'provinsi' => 'Sumatera Selatan',
            'kabupaten_kota' => 'Palembang',
            'confidence' => 'high',
        ]);
    }

    public function test_authenticated_admin_can_add_location(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->get(route('cms.locations.create'))
            ->assertOk()
            ->assertSee('Tambah Titik Lokasi');

        $response = $this->actingAs($admin)
            ->post(route('cms.locations.store'), [
                'provinsi' => 'Aceh',
                'kabupaten_kota' => 'Aceh Utara',
                'kecamatan' => 'Muara Batu',
                'desa' => 'Contoh Desa Baru',
                'latitude' => 4.90892,
                'longitude' => 97.47369,
                'date' => '2026-08-10',
                'confidence' => 'high',
            ]);

        $locationId = DB::table('titik_lokasi')->where('desa', 'Contoh Desa Baru')->value('id');

        $response
            ->assertRedirect(route('cms.locations.show', $locationId))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('titik_lokasi', [
            'id' => $locationId,
            'provinsi' => 'Aceh',
            'desa' => 'Contoh Desa Baru',
            'confidence' => 'high',
        ]);
    }

    public function test_authenticated_admin_can_upload_and_delete_reference_photo(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->post(route('cms.references.store'), [
                'title' => 'Foto Tim',
                'alt_text' => 'Tim EMBER',
                'photo' => UploadedFile::fake()->image('tim-ember.jpg', 800, 600),
            ])
            ->assertSessionHas('success');

        $photo = DB::table('photo_references')->where('title', 'Foto Tim')->first();

        $this->assertNotNull($photo);
        Storage::disk('public')->assertExists($photo->photo_path);

        $this->actingAs($admin)
            ->delete(route('cms.references.destroy', $photo->id))
            ->assertSessionHas('success');

        Storage::disk('public')->assertMissing($photo->photo_path);
        $this->assertDatabaseMissing('photo_references', ['id' => $photo->id]);
    }

    public function test_authenticated_admin_can_upload_and_delete_geojson_layer(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();
        $geojson = json_encode([
            'type' => 'FeatureCollection',
            'features' => [
                [
                    'type' => 'Feature',
                    'properties' => ['name' => 'Sumatera'],
                    'geometry' => [
                        'type' => 'Polygon',
                        'coordinates' => [[[95, -6], [106, -6], [106, 6], [95, -6]]],
                    ],
                ],
            ],
        ], JSON_THROW_ON_ERROR);

        $this->actingAs($admin)
            ->post(route('cms.geojson.store'), [
                'name' => 'Batas Sumatera',
                'description' => 'Batas wilayah Pulau Sumatera.',
                'geojson' => UploadedFile::fake()->createWithContent('sumatera.geojson', $geojson),
                'administrative_level' => 'province',
                'is_active' => '1',
            ])
            ->assertSessionHas('success');

        $layer = DB::table('geojson_layers')->where('name', 'Batas Sumatera')->first();

        $this->assertNotNull($layer);
        $this->assertSame('FeatureCollection', $layer->geojson_type);
        $this->assertSame(1, $layer->feature_count);
        Storage::disk('public')->assertExists($layer->file_path);

        $this->actingAs($admin)
            ->delete(route('cms.geojson.destroy', $layer->id))
            ->assertSessionHas('success');

        Storage::disk('public')->assertMissing($layer->file_path);
        $this->assertDatabaseMissing('geojson_layers', ['id' => $layer->id]);
    }

    public function test_authenticated_admin_can_upload_pmtiles_and_public_can_request_a_byte_range(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();
        $contents = "PMTiles\x03".str_repeat("\0", 248);

        $this->actingAs($admin)
            ->post(route('cms.geojson.store'), [
                'name' => 'Batas Kecamatan Sumatera',
                'description' => 'Layer kecamatan ringkas.',
                'geojson' => UploadedFile::fake()->createWithContent('kecamatan_sumatera_ringkas.pmtiles', $contents),
                'administrative_level' => 'district',
                'is_active' => '1',
            ])
            ->assertSessionHas('success');

        $layer = DB::table('geojson_layers')->where('name', 'Batas Kecamatan Sumatera')->first();

        $this->assertNotNull($layer);
        $this->assertSame('pmtiles', $layer->file_format);
        $this->assertSame('PMTiles v3', $layer->geojson_type);

        $this->actingAs($admin)
            ->patch(route('cms.geojson.update', $layer->id), [
                'is_active' => '1',
                'administrative_level' => 'district',
                'min_zoom' => 6,
                'max_zoom' => 10,
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('geojson_layers', [
            'id' => $layer->id,
            'is_active' => true,
            'min_zoom' => 6,
            'max_zoom' => 10,
        ]);

        $response = $this->withHeader('Range', 'bytes=0-7')
            ->get(route('map-layers.show', $layer->id));

        $response
            ->assertStatus(206)
            ->assertHeader('Accept-Ranges', 'bytes')
            ->assertHeader('Content-Range', 'bytes 0-7/256')
            ->assertHeader('Content-Type', 'application/vnd.pmtiles');

        $this->assertSame("PMTiles\x03", $response->streamedContent());

        $this->get(route('user.map'))
            ->assertOk()
            ->assertSee('Batas Kecamatan Sumatera')
            ->assertSee('map-layers\\/'.$layer->id, false)
            ->assertSee('"minZoom":6', false)
            ->assertSee('"maxZoom":10', false);
    }
}
