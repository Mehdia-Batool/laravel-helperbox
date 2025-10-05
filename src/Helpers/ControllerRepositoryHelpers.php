<?php

/**
 * Controller & Repository Helper Functions
 * 
 * This file contains 20+ advanced controller and repository utility functions
 * for reflection, middleware management, and controller operations.
 * 
 * @package Subhashladumor\LaravelHelperbox
 * @author Subhash Ladumor
 */

if (!function_exists('controller_action_name')) {
    /**
     * Get current controller@method name
     * 
     * @return string Controller@method name
     */
    function controller_action_name(): string
    {
        $route = request()->route();
        
        if (!$route) {
            return '';
        }
        
        $action = $route->getActionName();
        
        if ($action === 'Closure') {
            return 'Closure';
        }
        
        return $action;
    }
}

if (!function_exists('controller_class_name')) {
    /**
     * Get current controller class name
     * 
     * @return string Controller class name
     */
    function controller_class_name(): string
    {
        $action = controller_action_name();
        
        if ($action === 'Closure' || strpos($action, '@') === false) {
            return '';
        }
        
        return explode('@', $action)[0];
    }
}

if (!function_exists('controller_method_name')) {
    /**
     * Get current controller method name
     * 
     * @return string Method name
     */
    function controller_method_name(): string
    {
        $action = controller_action_name();
        
        if ($action === 'Closure' || strpos($action, '@') === false) {
            return '';
        }
        
        return explode('@', $action)[1];
    }
}

if (!function_exists('repository_find_by')) {
    /**
     * Find model by field and value
     * 
     * @param string $model Model class name
     * @param string $field Field name
     * @param mixed $value Field value
     * @return mixed Model instance or null
     */
    function repository_find_by(string $model, string $field, $value)
    {
        try {
            return $model::where($field, $value)->first();
        } catch (Exception $e) {
            return null;
        }
    }
}

if (!function_exists('repository_update_by')) {
    /**
     * Update model record by field and value
     * 
     * @param string $model Model class name
     * @param string $field Field name
     * @param mixed $value Field value
     * @param array $data Data to update
     * @return bool True if updated
     */
    function repository_update_by(string $model, string $field, $value, array $data): bool
    {
        try {
            return $model::where($field, $value)->update($data) > 0;
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('repository_delete_by')) {
    /**
     * Delete model record by field and value
     * 
     * @param string $model Model class name
     * @param string $field Field name
     * @param mixed $value Field value
     * @return bool True if deleted
     */
    function repository_delete_by(string $model, string $field, $value): bool
    {
        try {
            return $model::where($field, $value)->delete() > 0;
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('repository_exists')) {
    /**
     * Check if model record exists by field and value
     * 
     * @param string $model Model class name
     * @param string $field Field name
     * @param mixed $value Field value
     * @return bool True if exists
     */
    function repository_exists(string $model, string $field, $value): bool
    {
        try {
            return $model::where($field, $value)->exists();
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('controller_middleware_list')) {
    /**
     * Get list of middleware applied to controller
     * 
     * @param string $controller Controller class name
     * @return array Array of middleware names
     */
    function controller_middleware_list(string $controller): array
    {
        try {
            $reflection = new ReflectionClass($controller);
            $middleware = [];
            
            // Get middleware from class
            if ($reflection->hasProperty('middleware')) {
                $property = $reflection->getProperty('middleware');
                $property->setAccessible(true);
                $middleware = array_merge($middleware, $property->getValue());
            }
            
            // Get middleware from methods
            $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
            foreach ($methods as $method) {
                if ($method->hasAttribute('middleware')) {
                    $attributes = $method->getAttributes('middleware');
                    foreach ($attributes as $attribute) {
                        $middleware = array_merge($middleware, $attribute->getArguments());
                    }
                }
            }
            
            return array_unique($middleware);
        } catch (Exception $e) {
            return [];
        }
    }
}

if (!function_exists('controller_has_middleware')) {
    /**
     * Check if controller has specific middleware
     * 
     * @param string $controller Controller class name
     * @param string $middleware Middleware name
     * @return bool True if has middleware
     */
    function controller_has_middleware(string $controller, string $middleware): bool
    {
        $middlewareList = controller_middleware_list($controller);
        return in_array($middleware, $middlewareList);
    }
}

if (!function_exists('controller_namespace')) {
    /**
     * Get current controller namespace
     * 
     * @return string Controller namespace
     */
    function controller_namespace(): string
    {
        $controller = controller_class_name();
        
        if (empty($controller)) {
            return '';
        }
        
        $reflection = new ReflectionClass($controller);
        return $reflection->getNamespaceName();
    }
}

if (!function_exists('controller_methods')) {
    /**
     * Get all public methods of controller
     * 
     * @param string $controller Controller class name
     * @return array Array of method names
     */
    function controller_methods(string $controller): array
    {
        try {
            $reflection = new ReflectionClass($controller);
            $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
            
            return array_map(function($method) {
                return $method->getName();
            }, $methods);
        } catch (Exception $e) {
            return [];
        }
    }
}

if (!function_exists('controller_has_method')) {
    /**
     * Check if controller has specific method
     * 
     * @param string $controller Controller class name
     * @param string $method Method name
     * @return bool True if has method
     */
    function controller_has_method(string $controller, string $method): bool
    {
        try {
            $reflection = new ReflectionClass($controller);
            return $reflection->hasMethod($method);
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('controller_properties')) {
    /**
     * Get all properties of controller
     * 
     * @param string $controller Controller class name
     * @return array Array of property names
     */
    function controller_properties(string $controller): array
    {
        try {
            $reflection = new ReflectionClass($controller);
            $properties = $reflection->getProperties();
            
            return array_map(function($property) {
                return $property->getName();
            }, $properties);
        } catch (Exception $e) {
            return [];
        }
    }
}

if (!function_exists('controller_has_property')) {
    /**
     * Check if controller has specific property
     * 
     * @param string $controller Controller class name
     * @param string $property Property name
     * @return bool True if has property
     */
    function controller_has_property(string $controller, string $property): bool
    {
        try {
            $reflection = new ReflectionClass($controller);
            return $reflection->hasProperty($property);
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('controller_parent_class')) {
    /**
     * Get parent class of controller
     * 
     * @param string $controller Controller class name
     * @return string|null Parent class name or null
     */
    function controller_parent_class(string $controller): ?string
    {
        try {
            $reflection = new ReflectionClass($controller);
            $parent = $reflection->getParentClass();
            
            return $parent ? $parent->getName() : null;
        } catch (Exception $e) {
            return null;
        }
    }
}

if (!function_exists('controller_implements_interface')) {
    /**
     * Check if controller implements interface
     * 
     * @param string $controller Controller class name
     * @param string $interface Interface name
     * @return bool True if implements interface
     */
    function controller_implements_interface(string $controller, string $interface): bool
    {
        try {
            $reflection = new ReflectionClass($controller);
            return $reflection->implementsInterface($interface);
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('controller_uses_trait')) {
    /**
     * Check if controller uses trait
     * 
     * @param string $controller Controller class name
     * @param string $trait Trait name
     * @return bool True if uses trait
     */
    function controller_uses_trait(string $controller, string $trait): bool
    {
        try {
            $reflection = new ReflectionClass($controller);
            return in_array($trait, $reflection->getTraitNames());
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('controller_get_traits')) {
    /**
     * Get all traits used by controller
     * 
     * @param string $controller Controller class name
     * @return array Array of trait names
     */
    function controller_get_traits(string $controller): array
    {
        try {
            $reflection = new ReflectionClass($controller);
            return $reflection->getTraitNames();
        } catch (Exception $e) {
            return [];
        }
    }
}

if (!function_exists('controller_get_interfaces')) {
    /**
     * Get all interfaces implemented by controller
     * 
     * @param string $controller Controller class name
     * @return array Array of interface names
     */
    function controller_get_interfaces(string $controller): array
    {
        try {
            $reflection = new ReflectionClass($controller);
            return $reflection->getInterfaceNames();
        } catch (Exception $e) {
            return [];
        }
    }
}

if (!function_exists('controller_is_abstract')) {
    /**
     * Check if controller is abstract
     * 
     * @param string $controller Controller class name
     * @return bool True if abstract
     */
    function controller_is_abstract(string $controller): bool
    {
        try {
            $reflection = new ReflectionClass($controller);
            return $reflection->isAbstract();
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('controller_is_final')) {
    /**
     * Check if controller is final
     * 
     * @param string $controller Controller class name
     * @return bool True if final
     */
    function controller_is_final(string $controller): bool
    {
        try {
            $reflection = new ReflectionClass($controller);
            return $reflection->isFinal();
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('controller_get_doc_comment')) {
    /**
     * Get controller doc comment
     * 
     * @param string $controller Controller class name
     * @return string Doc comment
     */
    function controller_get_doc_comment(string $controller): string
    {
        try {
            $reflection = new ReflectionClass($controller);
            return $reflection->getDocComment() ?: '';
        } catch (Exception $e) {
            return '';
        }
    }
}

if (!function_exists('controller_get_method_doc_comment')) {
    /**
     * Get method doc comment
     * 
     * @param string $controller Controller class name
     * @param string $method Method name
     * @return string Doc comment
     */
    function controller_get_method_doc_comment(string $controller, string $method): string
    {
        try {
            $reflection = new ReflectionClass($controller);
            $methodReflection = $reflection->getMethod($method);
            return $methodReflection->getDocComment() ?: '';
        } catch (Exception $e) {
            return '';
        }
    }
}

if (!function_exists('controller_get_parameters')) {
    /**
     * Get method parameters
     * 
     * @param string $controller Controller class name
     * @param string $method Method name
     * @return array Array of parameter information
     */
    function controller_get_parameters(string $controller, string $method): array
    {
        try {
            $reflection = new ReflectionClass($controller);
            $methodReflection = $reflection->getMethod($method);
            $parameters = $methodReflection->getParameters();
            
            return array_map(function($param) {
                return [
                    'name' => $param->getName(),
                    'type' => $param->getType() ? $param->getType()->getName() : null,
                    'optional' => $param->isOptional(),
                    'default' => $param->isOptional() ? $param->getDefaultValue() : null
                ];
            }, $parameters);
        } catch (Exception $e) {
            return [];
        }
    }
}

if (!function_exists('controller_get_return_type')) {
    /**
     * Get method return type
     * 
     * @param string $controller Controller class name
     * @param string $method Method name
     * @return string|null Return type or null
     */
    function controller_get_return_type(string $controller, string $method): ?string
    {
        try {
            $reflection = new ReflectionClass($controller);
            $methodReflection = $reflection->getMethod($method);
            $returnType = $methodReflection->getReturnType();
            
            return $returnType ? $returnType->getName() : null;
        } catch (Exception $e) {
            return null;
        }
    }
}

if (!function_exists('controller_is_public_method')) {
    /**
     * Check if method is public
     * 
     * @param string $controller Controller class name
     * @param string $method Method name
     * @return bool True if public
     */
    function controller_is_public_method(string $controller, string $method): bool
    {
        try {
            $reflection = new ReflectionClass($controller);
            $methodReflection = $reflection->getMethod($method);
            return $methodReflection->isPublic();
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('controller_is_protected_method')) {
    /**
     * Check if method is protected
     * 
     * @param string $controller Controller class name
     * @param string $method Method name
     * @return bool True if protected
     */
    function controller_is_protected_method(string $controller, string $method): bool
    {
        try {
            $reflection = new ReflectionClass($controller);
            $methodReflection = $reflection->getMethod($method);
            return $methodReflection->isProtected();
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('controller_is_private_method')) {
    /**
     * Check if method is private
     * 
     * @param string $controller Controller class name
     * @param string $method Method name
     * @return bool True if private
     */
    function controller_is_private_method(string $controller, string $method): bool
    {
        try {
            $reflection = new ReflectionClass($controller);
            $methodReflection = $reflection->getMethod($method);
            return $methodReflection->isPrivate();
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('controller_is_static_method')) {
    /**
     * Check if method is static
     * 
     * @param string $controller Controller class name
     * @param string $method Method name
     * @return bool True if static
     */
    function controller_is_static_method(string $controller, string $method): bool
    {
        try {
            $reflection = new ReflectionClass($controller);
            $methodReflection = $reflection->getMethod($method);
            return $methodReflection->isStatic();
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('controller_get_attributes')) {
    /**
     * Get all attributes of controller
     * 
     * @param string $controller Controller class name
     * @return array Array of attributes
     */
    function controller_get_attributes(string $controller): array
    {
        try {
            $reflection = new ReflectionClass($controller);
            $attributes = $reflection->getAttributes();
            
            return array_map(function($attribute) {
                return [
                    'name' => $attribute->getName(),
                    'arguments' => $attribute->getArguments()
                ];
            }, $attributes);
        } catch (Exception $e) {
            return [];
        }
    }
}

if (!function_exists('controller_has_attribute')) {
    /**
     * Check if controller has specific attribute
     * 
     * @param string $controller Controller class name
     * @param string $attribute Attribute name
     * @return bool True if has attribute
     */
    function controller_has_attribute(string $controller, string $attribute): bool
    {
        try {
            $reflection = new ReflectionClass($controller);
            $attributes = $reflection->getAttributes($attribute);
            return !empty($attributes);
        } catch (Exception $e) {
            return false;
        }
    }
}
