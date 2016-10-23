<?php

namespace AppBundle\Linters;

use AppBundle\Results\JsonRpcLintResult;

class JsonRpcLinter
{
   static public function getResult()
   {
      return new JsonRpcLintResult();
   }
}