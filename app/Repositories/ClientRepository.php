<?php

namespace App\Repositories;

use App\Models\Client;



class ClientRepository extends RessourceRepository{
    public function __construct(Client $client)
    {
        $this->model = $client;
    }
}
