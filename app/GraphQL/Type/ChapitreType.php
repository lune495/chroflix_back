<?php
namespace App\GraphQL\Type;

use App\Models\Chapitre;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ChapitreType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Chapitre',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [
                'id'                        => ['type' => Type::id(), 'description' => ''],
                'titre'                     => ['type' => Type::string()],
                'histoire_id'               => ['type' => Type::int()],
                'histoire'                  => ['type' => GraphQL::type('Histoire')],
                'paragraphes'               => ['type' => Type::listOf(GraphQL::type('Paragraphe')), 'description' => ''],

            ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    // protected function resolveEmailField($root, array $args)
    // {
    //     return strtolower($root->email);
    // }
}