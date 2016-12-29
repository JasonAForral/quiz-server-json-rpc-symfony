<?php

namespace AppBundle\Linters;

use AppBundle\Results\JsonRpcLintResult;

class JsonRpcLinter
{
   static public function getResult($json)
   {
      $jsonRpcLintResult = new JsonRpcLintResult();

      if (!array_key_exists('jsonrpc', $json)) {
          $versionValid = false;
      } else {
          $versionValid = ('2.0' === $json['jsonrpc']);
      }

      if (!array_key_exists('id', $json)) {
          $idValid = false;
      } else {
          $id = $json['id'];
          $idValid = (is_int($id) || is_string($id)) && !is_null($id);
      }

      

      $methodValid = array_key_exists('method', $json);
      $resultValid = array_key_exists('result', $json);
      $errorValid = array_key_exists('error', $json);

      $responseValid = $resultValid || $errorValid;

      $valid = $versionValid && $idValid && ($methodValid || $responseValid);

      $jsonRpcLintResult->setValid($valid);

      return $jsonRpcLintResult;
   }
}
