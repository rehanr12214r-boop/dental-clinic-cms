<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClinicInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clinic:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prepare a deployment: run migrations, seed the admin login, weekly schedule and treatments';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Installing the dental clinic application…');
        $this->newLine();

        $this->call('migrate', ['--force' => true]);
        $this->call('db:seed', ['--force' => true]);

        $this->newLine();
        $this->table(
            ['Item', 'Details'],
            [
                ['Admin login', 'admin@clinic.com / password'],
                ['Admin panel', url('/admin')],
                ['Booking portal', url('/')],
                ['Before going live', 'APP_DEBUG=false, real APP_URL, run npm run build, change the admin password'],
            ],
        );

        $this->info('Installation complete.');

        return self::SUCCESS;
    }
}
