<?php
namespace App\GraphQL\Type;

use App\Models\Paragraphe;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ParagrapheType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Paragraphe',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [
                'id'                       => ['type' => Type::id(), 'description' => ''],
                'corps'                    => ['type' => Type::string()],
                'chapitre_id'              => ['type' => Type::int()],
                'chapitre'                 => ['type' => GraphQL::type('Chapitre')],
            ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    // protected function resolveEmailField($root, array $args)
    // {
    //     return strtolower($root->email);
    // }
}