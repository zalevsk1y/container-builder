<?php

namespace ContainerBuilder\Message;

/**
 * Class error message storage
 *
 *
 * @package  Message
 * @author   Evgeniy S.Zalevskiy <2600@ukr.net>
 * @license  MIT
 */
class Errors
{

    public static function text($slug)
    {
        switch ($slug) {
            case 'NO_DI_DEFINITION_FILE':
                return "File with class defenitions for DI container could not be found. Check file path.";
            case 'INVALID_INSTANCE':
                    return "Invalid instance provided. Expected an object.";
            case 'WRONG_ARGUMENT_FORMATE':
                return "In dependency defenition file wrong depandency oreder.Dependencies should be placed earlier in array";
            case 'INSTANCE_DOESNT_HAVE_METHOD':
                return "You are trying to call a method that doesn't exist on the object.";
            case 'NO_NEEDED_DEPENDENCY_IN_DEFINITION':
                return "You are trying to create an instance of an object that has a specified dependency, but the definition array does not have an entry for that dependency. This error indicates that the definition array is not properly set up, and the required dependencies for the object being instantiated are not defined in the array.";
            case 'WRONG_DEFINITION_FILE_FORMAT':
                return "The definition file should be an array, but if it's not.";
        }
    }
    public static function code($slug)
    {
        switch ($slug) {
            case 'NO_DI_DEFINITION_FILE':
                return 1;
            case 'INVALID_INSTANCE':
                return 2;
            case 'WRONG_ARGUMENT_FORMAT':
                return 3;
            case 'INSTANCE_DOESNT_HAVE_METHOD':
                return 4;
            case 'NO_NEEDED_DEPENDENCY_IN_DEFINITION':
                return 5;
            case 'WRONG_DEFINITION_FILE_FORMAT':
                return 6;
            default:
                return 0;
        }
    }

}
