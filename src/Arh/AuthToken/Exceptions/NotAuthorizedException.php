<?php
/*
 * tappleby
 * Date: 2013-05-12
 * Time: 12:17 AM
 */

namespace Arh\AuthToken\Exceptions;


class NotAuthorizedException extends \Exception {
  public function __construct($message = "Not Authorized", $code = 401, Exception $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }
}
