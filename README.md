# ContainerBuilder
## Introduction
The ContainerBuilder is a Dependency Injection (DI) tool that allows you to handle dependencies and create instances of classes with their dependencies. The tool provides an implementation of the Container Interface, providing a simple and effective way to manage dependencies and resolve them.

Every class that is created using the definition file or the set method is saved in the container and will be returned by the get method as a singleton instance. This means that subsequent calls to get the same class will return the previously created instance.

## New Feature: Manual Object Addition
Now, you can manually add objects to the DI container using the set method. This allows you to set a specific instance of a class, providing more control over the objects stored in the container.

```
use ContainerBuilder\DI;

$container = new DI();
$container->addDefinitions(__DIR__ . '/config.php');

$instance = $container->set(new ClassName($some_deps));
$instance = $container->get(ClassName::class);

```
## API
The API of the ContainerBuilder is simple and straightforward, allowing you to:

- Add definitions using the addDefinitions method
- Get an instance of a class using the get method
- Call a method of an instance using the call method
- Set a specific instance of a class using the set method


## Configuration File Format
The configuration file is an array of definitions where each key represents a class and its value is an array of dependencies. The format of the configuration file is as follows:

```
return array(
    ClassName1::class=>[Dependency1, Dependency2, ...],
    ClassName2::class=>[Dependency3, Dependency4, ...],
    ...
)
```
Here, ClassName1 and ClassName2 are classes that have dependencies Dependency1, Dependency2, Dependency3, and Dependency4, respectively.

## Example
Here is an example of how you can use the ContainerBuilder:

```
use ContainerBuilder\DI;

$container = new DI();
$container->addDefinitions(__DIR__ . '/config.php');

$instance = $container->get(ClassName::class);
$result = $container->call([$instance, 'methodName'], [$arg1, $arg2, ...]);
```

In this example, config.php is the configuration file that contains the definitions of the classes and their dependencies. The addDefinitions method is used to load the definitions, and the get method is used to get an instance of the ClassName class. The call method is used to call the methodName method of the ClassName instance and pass the arguments $arg1, $arg2, etc.


Thank you 🙏 for support - [Atlant Web Agency](https://www.atlant-web.com/).

