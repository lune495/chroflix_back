<?php
namespace App\GraphQL\Type;

use App\Models\Chapitre;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class BibliothequeType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Bibliotheque',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [
                'id'                          => ['type' => Type::id(), 'description' => ''],
                'titre'                       => ['type' => Type::string()],
                'corps'                       => ['type' => Type::string()],
                'histoire_id'                 => ['type' => Type::int()],
                'bibliotheque_histoires'      => ['type' => Type::listOf(GraphQL::type('BibliothequeHistoire')), 'description' => ''],
            ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    // protected function resolveEmailField($root, array $args)
    // {
    //     return strtolower($root->email);
    // }
}