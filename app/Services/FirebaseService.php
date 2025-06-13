<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

class FirebaseService
{
    protected ?Auth $auth = null;

    protected function getAuth(): Auth
    {
        if (!$this->auth) {
            $serviceAccountPath = storage_path('app/firebase/gestion-de-proyectos-271ca-firebase-adminsdk-fbsvc-08599b1cb5.json');

            if (!file_exists($serviceAccountPath)) {
                throw new \Exception("Firebase service account file not found at: $serviceAccountPath");
            }

            $factory = (new Factory)->withServiceAccount($serviceAccountPath);
            $this->auth = $factory->createAuth();
        }

        return $this->auth;
    }

    public function getAllUsers()
    {
        return $this->getAuth()->listUsers();
    }
}
