<?php

namespace BackBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BackBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
