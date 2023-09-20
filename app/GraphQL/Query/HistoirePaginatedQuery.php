<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Arr;
use \App\Models\Histoire;

class HistoirePaginatedQuery extends Query
{
    protected $attributes = [
        'name'              => 'histoirespaginated',
        'description'       => ''
    ];

    public function type():type
    {
        return GraphQL::type('histoirespaginated');
    }

    public function args():array
    {
        return
        [
            'id'                            => ['type' => Type::int()],
        
            'page'                          => ['name' => 'page', 'description' => 'The page', 'type' => Type::int() ],
            'count'                         => ['name' => 'count',  'description' => 'The count', 'type' => Type::int() ]
        ];
    }


    public function resolve($root, $args)
    {
        $query = Histoire::query();
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }
        if (isset($args['user_d']))
        {
            $query = $query->where('user_d', $args['user_d']);
        }
      
        $count = Arr::get($args, 'count', 20);
        $page  = Arr::get($args, 'page', 1);

        return $query->orderBy('created_at', 'desc')->paginate($count, ['*'], 'page', $page);
    }
}