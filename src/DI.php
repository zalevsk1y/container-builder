<?php

namespace ContainerBuilder;

use ContainerBuilder\Interfaces\ContainerInterface;
use ContainerBuilder\Exception\MyException;
use ContainerBuilder\Message\Errors;

/**
 *
 * This class provides an implementation of the Container Interface, allowing to handle dependencies and create instances of classes with their dependencies.
 * 
 * PHP version 7.4
 *
 * @package ContainerBuilder
 * @author Evgeniy S.Zalevskiy 2600@ukr.net
 * @license MIT
 *
 */


class DI implements ContainerInterface
{
    /**
     * @var array Holds the definition array for dependency injection.
     */
    protected array $defenitionArray;
    /**
     * @var array Holds the instances of objects created through dependency injection.
     */
    protected array $instancesArray = [];
    public function __construct(){
        $this->instancesArray[DI::class]=$this;
    }
    /**
     * Adds definitions from a specified file.
     *
     * @param string $pathToDefinitionFile The path to the definition file.
     *
     * @throws MyException Throws an exception if the definition file does not exist.
     */

    public function addDefinitions($pathToDefenitionFile)
    {
        if (!file_exists($pathToDefenitionFile)) {
            throw new MyException(Errors::text('NO_DI_DEFINITION_FILE'), Errors::code('NO_DI_DEFINITION_FILE'));
        }
        $defenitionArray = require $pathToDefenitionFile;
        $this->defenitionArray = $defenitionArray;
    }
    /**
     * Retrieves an instance of a specified class with its dependencies.
     *
     * @param string $instanceName The name of the class instance.
     *
     * @return object The created instance of the class.
     *
     * @throws MyException Throws an exception if the specified instance has missing dependencies.
     */
    
    public function get($instance_name)
    {
        if (array_key_exists($instance_name, $this->instancesArray)) return $this->instancesArray[$instance_name];
        $this->hasDefenition($instance_name);
        return $this->createInstance($instance_name, $this->defenitionArray[$instance_name]);
    }
    /**
     * Sets a specific instance of a class.
     *
     * @param object $instance The instance of the class.
     *
     * @return bool Returns true if the instance is set successfully.
     *
     * @throws MyException Throws an exception if the provided instance is not an object.
     */

    public function set($instance){
        if(!is_object($instance)){
            throw new MyException(Errors::text('INVALID_INSTANCE'), Errors::code('INVALID_INSTANCE'));
        }
        $instance_name=get_class($instance);
        $this->instancesArray[$instance_name] = $instance;
        return true;
    }
    /**
     * Calls a specified method on an instance with the given arguments.
     *
     * @param array $instanceArr An array containing the instance name and the method name.
     * @param array $args The arguments to be passed to the method.
     *
     * @return mixed The result of the method call.
     *
     * @throws MyException Throws an exception if the argument format or method does not exist.
     */

    public function call($instance_arr, $args)
    {
        $instance_name = $instance_arr[0];
        $method_name = $instance_arr[1];
        if (!is_array($instance_arr) || !is_array($args)) {
            throw new MyException(Errors::text('WRONG_ARGUMENT_FORMAT'), Errors::code('WRONG_ARGUMENT_FORMAT'));
        }
        if (count($instance_arr) != 2) {
            throw new MyException(Errors::text('WRONG_ARGUMENT_FORMAT'), Errors::code('WRONG_ARGUMENT_FORMAT'));
        }
        $instance = $this->get($instance_name);
        if (!method_exists($instance, $method_name)) {
            throw new MyException(Errors::text('INSTANCE_DOESNT_HAVE_METHOD'), Errors::code('INSTANCE_DOESNT_HAVE_METHOD'));
        }
        return $instance->$method_name(...$args);
    }
    /**
     * Creates an instance of a class with its dependencies.
     *
     * @param string $instanceName The name of the class instance.
     * @param array $dependencies The dependencies of the class instance.
     *
     * @return object The created instance of the class.
     */

    protected function createInstance($instance_name, $dependences)
    {
        if (count($dependences) == 0) {
            $new_instance = new $instance_name();
            $this->instancesArray[$instance_name] = $new_instance;
            return $new_instance;
        }
        $dep_args = [];
        foreach ($dependences as $dep_item) {
            if ((is_string($dep_item)||is_int($dep_item))&&array_key_exists($dep_item, $this->instancesArray)) {
                array_push($dep_args, $this->instancesArray[$dep_item]);
            } else if ($this->isInstanceableDependece($dep_item)) {
                array_push($dep_args, $this->get($dep_item));
            } else {
                array_push($dep_args, $dep_item);
            }
        }
        $this->instancesArray[$instance_name] = new $instance_name(...$dep_args);
        return $this->instancesArray[$instance_name];
    }
    /**
     * Checks if a dependency is an instanceable class.
     *
     * @param mixed $dependency The dependency to check.
     * @return bool Returns true if the dependency is an instanceable class, false otherwise.
     */

    protected function isInstanceableDependece($dep_item)
    {
        if(is_string($dep_item)){
            return class_exists($dep_item);
        } else {
            return false;
        }
    }
    /**
     * Checks if a defenition of instanse exists in the definition array.
     *
     * @param string $instance_name The dependency to check.
     * @throws MyException Throws an exception if the dependency does not exist.
     */

    protected function hasDefenition($instance_name)
    {
        if (!array_key_exists($instance_name, $this->defenitionArray)) {
            throw new MyException(Errors::text('NO_NEEDED_DEPENDENCY_IN_DEFINITION'), Errors::code('NO_NEEDED_DEPENDENCY_IN_DEFINITION'));
        }
    }
   
}
