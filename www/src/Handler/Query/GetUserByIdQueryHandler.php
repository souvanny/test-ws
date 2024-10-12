<?php

namespace App\Handler\Query;

use App\Core\QueryHandlerInterface;

class GetUserByIdQueryHandler implements QueryHandlerInterface
{
    public function __invoke($query)
    {
        // Logique pour récupérer un utilisateur par ID
        echo "Détails de l'utilisateur avec ID : " . $query->userId . "\n";
    }
}
