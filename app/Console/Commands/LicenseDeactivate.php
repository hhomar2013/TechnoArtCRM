<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class LicenseDeactivate extends Command
{
    /**
     * اسم الكوماند
     *
     * @var string
     */
    protected $signature = 'license:deactivate';

    /**
     * وصف الكوماند
     *
     * @var string
     */
    protected $description = 'Deactivate current license';

    /**
     * تنفيذ الكوماند
     */
    public function handle()
    {
        $path = 'mtg.json';

        if (!Storage::disk('local')->exists($path)) {
            $this->error("❌ License file not found.");
            return;
        }

        try {
            $license = json_decode(decrypt(Storage::disk('local')->get($path)), true);
        } catch (\Exception $e) {
            $this->error("❌ License file is corrupted.");
            return;
        }

        $license['is_active'] = false;

        Storage::disk('local')->put($path, encrypt(json_encode($license)));

        $this->info("✅ License deactivated successfully.");
    }
}
