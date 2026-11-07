<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeAdministrator extends Command
{
    protected $signature = 'user:make-administrator {email : Email address of an existing user}';

    protected $description = 'Promote an existing user to administrator';

    public function handle(): int
    {
        $user = User::where('email', $this->argument('email'))->first();

        if (! $user) {
            $this->error('No user exists with that email address.');

            return self::FAILURE;
        }

        if ($user->role === 'administrator') {
            $this->info("{$user->email} is already an administrator.");

            return self::SUCCESS;
        }

        if (! $this->confirm("Promote {$user->email} to administrator?")) {
            $this->info('No changes were made.');

            return self::SUCCESS;
        }

        $user->forceFill(['role' => 'administrator'])->save();

        $this->info("{$user->email} is now an administrator.");

        return self::SUCCESS;
    }
}
