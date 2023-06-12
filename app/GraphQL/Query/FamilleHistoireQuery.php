<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\{FamilleHistoire,Outil};
class FamilleHistoireQuery extends Query
{
    protected $attributes = [
        'name' => 'famille_histoires'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('FamilleHistoire'));
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
        $query = FamilleHistoire::query();
        if (isset($args['id']))
        {
            $query = $query->where('id', $args['id']);
        }
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (FamilleHistoire $item)
        {
            return
            [
                'id'                     => $item->id,
                'nom'                    => $item->nom
            ];
        });

    }
}
