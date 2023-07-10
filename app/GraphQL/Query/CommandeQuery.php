<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\Commande;
class CommandeQuery extends Query
{
    protected $attributes = [
        'name' => 'commandes'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Commande'));
    }

    public function args(): array
    {
        return
        [
            'id'                  => ['type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = Commande::query();
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (Commande $item)
        {
            return
            [
                'id'                      => $item->id,
                'ref_commande'            => $item->ref_commande,
                'nom_commande'            => $item->nom_commande,
                'env'                     => $item->env,
                'devise'                  => $item->devise,
                'status'                  => $item->status,
                'histoire'                => $item->histoire,
                'user'                    => $item->user
            ];
        });
    }
}
