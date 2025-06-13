<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

class FirebaseService
{
    protected Auth $auth;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(storage_path('app\firebase\gestion-de-proyectos-271ca-firebase-adminsdk-fbsvc-08599b1cb5.json'));

        $this->auth = $factory->createAuth();
    }

    public function getAllUsers()
    {
        return $this->auth->listUsers();
    }
}
