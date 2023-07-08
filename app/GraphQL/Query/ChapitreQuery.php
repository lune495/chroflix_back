<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\Chapitre;
class ChapitreQuery extends Query
{
    protected $attributes = [
        'name' => 'chapitres'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Chapitre'));
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
        $query = Chapitre::query();
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (Chapitre $item)
        {
            return
            [
                'id'                      => $item->id,
                'titre'                   => $item->titre,
                'histoire'                => $item->histoire
            ];
        });

    }
}
