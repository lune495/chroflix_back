<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\{Histoire,Outil};
class HistoireQuery extends Query
{
    protected $attributes = [
        'name' => 'histoires'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Histoire'));
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
        $query = Histoire::query();
        if (isset($args['id']))
        {
            $query = $query->where('id', $args['id']);
        }
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (Histoire $item)
        {
            return
            [
                'id'                        => $item->id,
                'titre'                     => $item->titre,
                'genre'                     => $item->genre,
                'resume'                    => $item->resume,
                'chapitres'                 => $item->chapitres,
                'image_couverture'          => $item->image_couverture,
                'user_id'                   => $item->user_id,
                'user'                      => $item->user,
                'famille_histoire'          => $item->famille_histoire,
                'famille_histoire_id'       => $item->famille_histoire_id,
            ];
        });

    }
}
