<?php
namespace Textura;

class Installer extends Controller {

  public function index() {
    ViewHelper::renderTemplate(
      $this->getInstallerFilePath('index.haml'),
      $this,
      $this->response
    );
  }

  public function style() {
    $this->response->setHeader('Content-Type', 'text/css');
    $this->response->appendToBody(file_get_contents($this->getInstallerFilePath('textura.css')));
  }

  private function getInstallerFilePath($filename) {
    return PathBuilder::buildPath(dirname(__FILE__), 'installer', $filename);
  }

}
?>