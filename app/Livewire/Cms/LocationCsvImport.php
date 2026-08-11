<?php

namespace App\Livewire\Cms;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use RuntimeException;

class LocationCsvImport extends Component
{
    use WithFileUploads;

    public $csvFile;

    public array $importErrors = [];

    public function importCsv()
    {
        $this->resetErrorBag();
        $this->importErrors = [];

        $this->validate([
            'csvFile' => ['required', 'file', 'mimes:csv,txt', 'max:5120'],
        ], [
            'csvFile.required' => 'Pilih file CSV yang akan diimpor.',
            'csvFile.mimes' => 'File harus berformat CSV.',
            'csvFile.max' => 'Ukuran file CSV maksimal 5 MB.',
        ]);

        try {
            $rows = $this->readCsv($this->csvFile->getRealPath());
        } catch (RuntimeException $exception) {
            $this->addError('csvFile', $exception->getMessage());

            return null;
        }

        $validRows = [];

        foreach ($rows as $row) {
            $line = $row['_line'];
            unset($row['_line']);

            $validator = Validator::make($row, $this->locationRules());

            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $message) {
                    $this->importErrors[] = "Baris {$line}: {$message}";
                }

                continue;
            }

            $validRows[] = [
                ...$validator->validated(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($this->importErrors !== []) {
            $this->importErrors = array_slice($this->importErrors, 0, 20);
            $this->addError('csvFile', 'Impor dibatalkan karena terdapat data yang tidak valid.');

            return null;
        }

        if ($validRows === []) {
            $this->addError('csvFile', 'CSV tidak memiliki baris data untuk diimpor.');

            return null;
        }

        DB::transaction(fn () => DB::table('titik_lokasi')->insert($validRows));

        session()->flash('success', count($validRows).' titik lokasi berhasil diimpor dari CSV.');

        return $this->redirectRoute('cms.locations.index');
    }

    public function render()
    {
        return view('livewire.cms.location-csv-import');
    }

    private function locationRules(): array
    {
        return [
            'provinsi' => ['nullable', 'string', 'max:255'],
            'kabupaten_kota' => ['nullable', 'string', 'max:255'],
            'kecamatan' => ['nullable', 'string', 'max:255'],
            'desa' => ['nullable', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'date' => ['nullable', 'date_format:Y-m-d'],
            'confidence' => ['nullable', 'string', 'max:50'],
        ];
    }

    private function readCsv(string $path): array
    {
        $handle = fopen($path, 'rb');

        if ($handle === false) {
            throw new RuntimeException('File CSV tidak dapat dibaca.');
        }

        try {
            $header = fgetcsv($handle, escape: '');

            if ($header === false) {
                throw new RuntimeException('File CSV kosong.');
            }

            $header = array_map(
                fn ($column) => strtolower(trim((string) $column)),
                $header
            );
            $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]) ?? $header[0];

            $expectedHeader = [
                'provinsi',
                'kabupaten_kota',
                'kecamatan',
                'desa',
                'latitude',
                'longitude',
                'date',
                'confidence',
            ];

            if ($header !== $expectedHeader) {
                throw new RuntimeException(
                    'Header CSV tidak sesuai. Gunakan template CSV yang tersedia tanpa mengubah nama atau urutan kolom.'
                );
            }

            $rows = [];
            $line = 1;

            while (($values = fgetcsv($handle, escape: '')) !== false) {
                $line++;

                if (count(array_filter($values, fn ($value) => trim((string) $value) !== '')) === 0) {
                    continue;
                }

                if (count($values) !== count($expectedHeader)) {
                    throw new RuntimeException("Baris {$line} memiliki jumlah kolom yang tidak sesuai.");
                }

                $row = array_combine($expectedHeader, $values);

                foreach ($row as $column => $value) {
                    $value = trim((string) $value);
                    $row[$column] = $value === '' ? null : $value;
                }

                $row['_line'] = $line;
                $rows[] = $row;

                if (count($rows) > 10000) {
                    throw new RuntimeException('Satu file CSV maksimal berisi 10.000 baris data.');
                }
            }

            return $rows;
        } finally {
            fclose($handle);
        }
    }
}
