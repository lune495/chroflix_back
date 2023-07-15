<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\Chapitre;
class BibliothequeQuery extends Query
{
    protected $attributes = [
        'name' => 'Bibliotheques'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Bibliotheque'));
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
        $query = Bibliotheque::query();
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (Bibliotheque $item)
        {
            return
            [
                'id'                               =>  $item->id,
                'bibliotheque_histoires'           =>  $item->bibliotheque_histoires,
            ];
        });
    }
}
