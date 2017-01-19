<?php
/*
 * tappleby
 * Date: 2013-05-11
 * Time: 10:11 PM
 */

namespace Arh\AuthToken;


use Illuminate\Events\Dispatcher;
use Arh\AuthToken\Exceptions\NotAuthorizedException;

class AuthTokenFilter {

  /**
   * The event dispatcher instance.
   *
   * @var \Illuminate\Events\Dispatcher
   */
  protected $events;

  /**
   * @var \Arh\AuthToken\AuthTokenDriver
   */
  protected $driver;

  function __construct(AuthTokenDriver $driver, Dispatcher $events)
  {
    $this->driver = $driver;
    $this->events = $events;
  }

  function filter($route, $request) {
	  $payload = $request->header('X-Auth-Token');

	  if(empty($payload)) {
		  $payload = $request->input('auth_token');
	  }

    $user = $this->driver->validate($payload);

    if(!$user) {
      throw new NotAuthorizedException();
    }

    $this->events->fire('auth.token.valid', $user);
  }
}
