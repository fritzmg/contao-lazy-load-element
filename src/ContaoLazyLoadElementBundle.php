<?php

namespace InspiredMinds\ContaoLazyLoadElement;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ContaoLazyLoadElementBundle extends Bundle
{
    public function getPath()
    {
        return \dirname(__DIR__);
    }
}
