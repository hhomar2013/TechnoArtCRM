<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LicenseGenerate extends Command
{
    /**
     * اسم الكوماند
     *
     * @var string
     */
    protected $signature = 'license:generate {--days=30 : Number of days before license expires}';

    /**
     * وصف الكوماند
     *
     * @var string
     */
    protected $description = 'Generate or renew license file';

    /**
     * تنفيذ الكوماند
     */
    public function handle()
    {
        $days = (int)$this->option('days');
        $licenseKey = Str::uuid()->toString();

        $data = [
            'license_key' => $licenseKey,
            'expires_at'  => now()->addDays($days)->toDateString(),
            'is_active'   => true,
        ];

        // تخزين مشفر
        Storage::disk('local')->put('mtg.json', encrypt(json_encode($data)));

        $this->info("✅ License generated successfully!");
        $this->line("🔑 Key: {$licenseKey}");
        $this->line("📅 Expires At: {$data['expires_at']}");
    }
}
