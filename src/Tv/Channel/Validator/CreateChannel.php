<?php
namespace Tv\Channel\Validator;

use Respect\Validation\Validator as v;

class CreateChannel
{
    public static function validator()
    {
        return v::key('name', Name::validator())
                ->key('path', Path::validator());
    }
}

