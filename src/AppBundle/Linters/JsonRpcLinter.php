<?php

namespace AppBundle\Linters;

use AppBundle\Results\JsonRpcLintResult;

class JsonRpcLinter
{
   static public function getResult($json)
   {
      $jsonRpcLintResult = new JsonRpcLintResult();

      $versionValid = ('2.0' === $json['jsonrpc']);

      $valid = $versionValid;

      $jsonRpcLintResult->setValid($valid);

      return $jsonRpcLintResult;
   }
}