<?php
namespace App\GraphQL\Type;

use App\Models\{Histoire,Outil};
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class HistoireType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Histoire',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [
                'id'                         => ['type' => Type::id(), 'description' => ''],
                'titre'                      => ['type' => Type::string()],
                'genre'                      => ['type' => Type::string()],
                'resume'                     => ['type' => Type::string()],

                'user_id'                    => ['type' => Type::int()],
                'user'                       => ['type' => GraphQL::type('User')],
                'famille_histoire_id'        => ['type' => Type::int()],
                'famille_histoires'          => ['type' => GraphQL::type('FamilleHistoire')],
                'chapitres'                  => ['type' => Type::listOf(GraphQL::type('Chapitre')), 'description' => ''],
            ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    // protected function resolveEmailField($root, array $args)
    // {
    //     return strtolower($root->email);
    // }
}