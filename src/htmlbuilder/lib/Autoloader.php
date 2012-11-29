<?php
/**
 * Simple autoloader
 * 
 * PHP version 5
 * 
 * @example   simple.php How to use
 * @filesource
 * @category  Main
 * @package   Main
 * @author    Jens Peters <jens@history-archive.net>
 * @copyright 2011 Jens Peters
 * @license   http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @version   1.0
 * @link      http://launchpad.net/htmlbuilder
 */
namespace HTMLBuilder;

/**
 * Simple autoloader
 * 
 * @category Main
 * @example  simple.php How to use
 * @package  Main
 * @author   Jens Peters <jens@history-archiv.net>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU LGPL v3
 * @link     http://launchpad.net/htmlbuilder
 */

use HTMLBuilder\Elements\Form\Select;

use HTMLBuilder\Exceptions\Exception;

class Autoloader
{

    /**
     * Namespace prefix
     * @var string
     */
    const NS_PREFIX = "HTMLBuilder";

    /**
     * Path to core files
     * @var string
     */
    protected static $path = "";

    /**
     * Path to custom extensions
     * @var string
     */
    protected static $extensionsPath = "";

    /**
     * Core classes
     * @var array
     */
    protected static $classes = array ();

    /**
     * Custom extended classes
     * @var array
     */
    protected static $extensionsClasses = array ();

    /**
     * Cache classes in file
     * @var boolean
     */
    public static $cache = false;

    /**
     * Exclude file list
     * @var array
     */
    protected static $excludedFiles = array (
                                            ".", 
                                            "..", 
                                            "README", 
                                            "CHANGELOG"
    );

    /**
     * Main autoloader method. Includes the class file if exists
     * 
     * @param string $name The name of the loading class
     * 
     * @return boolean 
     */
    public static function autoload($name)
    {

        $classname = str_replace(self::NS_PREFIX . "\\", "", $name);
        $classname = str_replace("\\", "/", $classname) . ".php";
        
        if (isset(self::$classes[$classname])) {
            
            $path = self::$path . $classname;
            include_once $path;
            return true;
        }
        
        $classname = str_replace("ext/", "", $classname);
        if (isset(self::$extensionsClasses[$classname])) {
            
            $path = self::$extensionsPath . $classname;
            include_once $path;
            return true;
        }
        
        return false;
    }

    /**
     * Helper function to read in the files in the system
     * 
     * @param string $directory The diretory to read in
     * @param bool 	 $extension Is the directory base or extension
     * 
     * @return void
     */
    private static function readFilesRecursivly($directory, $extension = false)
    {

        $handle = opendir($directory);
        
        while ($file = readdir($handle)) {
            
            if (!in_array($file, self::$excludedFiles)) {
                
                if (is_dir($directory . $file)) {
                    
                    self::readFilesRecursivly($directory . $file . '/', $extension);
                } else {
                    
                    if ($extension === false) {
                        
                        $tmp = str_replace(self::$path, "", $directory) . $file;
                        self::$classes[$tmp] = $file;
                    } else {
                        
                        $tmp = str_replace(self::$extensionsPath, "", $directory) . $file;
                        self::$extensionsClasses[$tmp] = $file;
                    }
                }
            }
        }
        closedir($handle);
    }

    /**
     * Setting cache files
     * @throws Exception
     */
    private static function setCacheFiles()
    {

        list($lib, $ext) = self::getCacheFileNames();
        
        $written1 = file_put_contents($lib, serialize(self::$classes));
        $written2 = file_put_contents($ext, serialize(self::$extensionsClasses));
        
        if ($written1 === false || $written2 === false) {
            trigger_error("Error setting cache files");
        }
    }

    /**
     * Loading cache file
     * 
     * @return boolean Sucess     
     */
    private static function loadFromCacheFiles()
    {

        if (self::$cache === true) {
            
            list($lib, $ext) = self::getCacheFileNames();
            
            if (file_exists($lib) && file_exists($ext)) {
                
                self::$classes = unserialize(file_get_contents($lib));
                self::$extensionsClasses = unserialize(file_get_contents($ext));              
            }
            
        }
    }

    private static function getCacheFileNames()
    {

        $lib = sys_get_temp_dir() . "/" . self::NS_PREFIX . "_" . md5(self::NS_PREFIX) . "_lib";
        $ext = sys_get_temp_dir() . "/" . self::NS_PREFIX . "_" . md5(self::NS_PREFIX) . "_ext";
        
        return array (
                    $lib, 
                    $ext
        );
    }

    /**
     * Registers the autoloader for a defined path
     * 
     * @param string $path       The path to the html builder library 
     * @param string $extensions Optional: path for own extensions
     * 
     * @return void
     */
    public static function register($path, $extensions = null)
    {

        self::$path = $path;
        self::$extensionsPath = $extensions;        
        
        // realpath is used because relative paths causes warnigs when using in phar context
        if (preg_match("/^phar:\/\//is", __DIR__)) {
            self::$extensionsPath = realpath(self::$extensionsPath);
        }
        
        if (!preg_match("@/$@", self::$path)) {
            self::$path .= "/";
        }
        
        if (!preg_match("@/$@", self::$extensionsPath)) {
            self::$extensionsPath .= "/";
        }
        
        self::loadFromCacheFiles();
        
        if (count(self::$classes) == 0) {
            
            self::readFilesRecursivly(self::$path);
            
            if (isset($extensions)) {
                self::readFilesRecursivly(self::$extensionsPath, true);
            }
            
            if (self::$cache === true) {
                self::setCacheFiles();
            }
            
        }
        
        spl_autoload_register(__CLASS__ . "::autoload");
    }
}