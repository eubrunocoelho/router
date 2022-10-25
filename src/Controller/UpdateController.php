<?php

namespace Src\Controller;

class UpdateController
{
    public function update($params = [])
    {
        echo 'estou na "update/' . $params[0] . '"';
    }
}
