<?php

namespace App\Console\Commands;

use App\Models\Usuario;
use App\Services\FirebaseService;
use Illuminate\Console\Command;

class SyncFirebaseUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-firebase-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa usuarios desde Firebase a MySQL';

    /**
     * Execute the console command.
     */
    public function __construct(private FirebaseService $firebase)
    {
        parent::__construct();
    }

    public function handle()
    {
        $users = $this->firebase->getAllUsers();

        foreach ($users as $firebaseUser) {
            Usuario::updateOrCreate(
                ['firebase_uid' => $firebaseUser->uid],
                [
                    'nombre' => $firebaseUser->displayName ?? 'Sin nombre',
                    'email' => $firebaseUser->email ?? '',
                ]
            );
        }

        $this->info('Usuarios sincronizados correctamente desde Firebase.');
    }
}
