<?php
namespace Textura;

class DBManager implements Singleton {

  private $adapter;

  private static $instance = null;

  private function __construct() {
    $this->adapter =
      $this->getAdapterInstance(
        Current::application()->getConfigurationOption('database.adapter'),
        Current::application()->getConfigurationOption('database.params')
      );
  }

  public static function getInstance() {
    if (is_null(self::$instance)) self::$instance = new self;
    return self::$instance;
  }

  public function getFields($table) {
    return $this->adapter->getFields($table);
  }

  public function insertRow($table, array $values) {
    return $this->adapter->insertRow($table, $values);
  }

  public function updateRow($table, $primary_key_value, $values) {
    return $this->adapter->updateRow($table, $primary_key_value, $values);
  }

  /**
   * Returns a new adapter instance
   *
   * @param string $adapter
   * @param array $params
   * @return mixed
   * @throws LogicException     If the adapter cannot be found
   */
  private function getAdapterInstance($adapter, $params) {
    switch (strtolower($adapter)) {
      case 'sqlite':
      case 'sqlite3':
        $class = '\Textura\SQLiteDBAdapter';
        break;
      default:
        throw new \LogicException("Unknown database adapter $adapter");
    }
    $reflecttion_class =new \ReflectionClass($class);
    return $reflecttion_class->newInstance($params);
  }

}
?>