<?php
namespace App\GraphQL\Type;

use App\Models\Chapitre;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class BibliothequeHistoireType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'BibliothequeHistoire',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [
                'id'                => ['type' => Type::id(), 'description' => ''],
                'bibliotheque'      => ['type' => GraphQL::type('Bibliotheque')],
                'histoire'          => ['type' => GraphQL::type('Histoire')],
            ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    // protected function resolveEmailField($root, array $args)
    // {
    //     return strtolower($root->email);
    // }
}