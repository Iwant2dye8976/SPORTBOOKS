<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class OP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:op {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grant Admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        $user =  User::where('email', $email)->first();

        if (!$user) {
            $this->error('Không tìm thấy user với email: ' . $email);
            return;
        }

        $user->type = 'admin';
        $user->save();

        $this->info('Đã cấp quyền admin cho user: ' . $email);
    }
}
