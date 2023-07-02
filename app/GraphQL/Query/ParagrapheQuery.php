<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\Paragraphe;
class ParagrapheQuery extends Query
{
    protected $attributes = [
        'name' => 'paragraphes'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Paragraphe'));
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
        $query = Paragraphe::query();
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (Role $item)
        {
            return
            [
                'id'                      => $item->id,
                'corps'                   => $item->nom,
                'chapitre'                => $item->chapitre,
            ];
        });

    }
}
