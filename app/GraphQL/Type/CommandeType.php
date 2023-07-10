<?php
namespace App\GraphQL\Type;

use App\Models\Commande;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CommandeType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Commande',
        'description'   => ''
    ];

    public function fields(): array
    {
       return
            [
                'id'                        => ['type' => Type::id(), 'description' => ''],
                'ref_commande'              => ['type' => Type::string()],
                'nom_commande'              => ['type' => Type::string()],
                'env'                       => ['type' => Type::int()],
                'devise'                    => ['type' => Type::int()],
                'status'                    => ['type' => Type::int()],
                'histoire'                  => ['type' => GraphQL::type('Histoire')],
                'user'                      => ['type' => GraphQL::type('User')]

            ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
    // protected function resolveEmailField($root, array $args)
    // {
    //     return strtolower($root->email);
    // }
}