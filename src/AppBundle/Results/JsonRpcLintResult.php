<?php

namespace AppBundle\Results;

class JsonRpcLintResult
{
    protected $valid;

    public function setValid($valid)
    {
        if (!is_bool($valid)) {
            throw new \TypeError();
        }
        $this->valid = $valid;
    }

    public function getValid()
    {
        return $this->valid;
    }
}
