<?php
/*
 * tappleby
 * Date: 2013-05-11
 * Time: 9:14 PM
 */

namespace Arh\AuthToken;


use Illuminate\Support\Manager;

class AuthTokenManager extends Manager {

  protected function createDatabaseDriver() {
    $provider = $this->createDatabaseProvider();
    $users = $this->app['auth']->user()->driver()->getProvider();

    return new AuthTokenDriver($provider, $users);
  }

  protected function createDatabaseProvider() {
    $connection = $this->app['db']->connection();
    $encrypter = $this->app['encrypter'];
    $hasher = new HashProvider($this->app['config']['app.key']);

    return new DatabaseAuthTokenProvider($connection, 'arh_auth_tokens', $encrypter, $hasher);
  }

  public function getDefaultDriver() {
    return 'database';
  }
}
