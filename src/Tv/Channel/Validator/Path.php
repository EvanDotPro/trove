<?php
namespace Tv\Channel\Validator;

use Respect\Validation\Validator as v;

class Path
{
    public static function validator()
    {
        return v::alnum('-_')->noWhitespace()->length(3, 15);
    }
}
