<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class LicenseStatus extends Command
{
    /**
     * اسم الكوماند
     *
     * @var string
     */
    protected $signature = 'license:status';

    /**
     * وصف الكوماند
     *
     * @var string
     */
    protected $description = 'Show current license status';

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

        $status = "Active ✅";
        if (empty($license['is_active']) || now()->greaterThan($license['expires_at'])) {
            $status = "Expired ❌";
        }

        $this->info("🔑 License Key: {$license['license_key']}");
        $this->line("📅 Expires At : {$license['expires_at']}");
        $this->line("📌 Status     : {$status}");
    }
}
