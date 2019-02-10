<?php

namespace App\Support\Transformers\Api\V1;

use App\Models\User;
use App\Support\Transformers\BaseTransformer;

class UserTransformer extends BaseTransformer
{
    public function transform(User $user)
    {
        return [
            'id'            => $user->id,
            'name'          => $user->name,
            'data'          => $user->data,
            'created_at'    => $user->created_at,
            'updated_at'    => $user->updated_at
        ];
    }

    /**
     * @return string
     */
    public function getItemKey()
    {
        return 'user';
    }

    /**
     * @return string
     */
    public function getCollectionKey()
    {
        return 'users';
    }
}
