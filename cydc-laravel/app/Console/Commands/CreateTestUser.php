<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-test-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user for authentication testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'test@cydc.com'],
            [
                'name' => 'Test User',
                'password' => \Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        $this->info('Test user created/updated successfully!');
        $this->info('Email: test@cydc.com');
        $this->info('Password: password123');
        
        return 0;
    }
}
