<?php

namespace AppBundle\Exception;

/**
 * Class BadRequestDataException has purpose to pass the error message through FOSRest bundle to the client.
 * It should be used for error caused by client's bad input.
 *
 * @package AppBundle\Exception
 */
class BadRequestDataException extends \Exception {
   
    /**
   * Makes response from given exception.
   *
   * @param \Exception $exception
   * @throws BadRequestDataException
   */
  protected function throwFosrestSupportedException(\Exception $exception) {
    throw new BadRequestDataException($exception->getMessage());
  }
}