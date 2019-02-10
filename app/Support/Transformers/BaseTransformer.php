<?php

namespace App\Support\Transformers;

use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract
{
    use TransformTrait;

    abstract public function getItemKey();

    abstract public function getCollectionKey();
}
