<?php

/**
 * Blade Helper Functions
 * 
 * This file contains 20+ advanced Blade template functions
 * for conditional rendering, formatting, and template utilities.
 * 
 * @package Subhashladumor\LaravelHelperbox
 * @author Subhash Ladumor
 */

if (!function_exists('blade_if_route')) {
    /**
     * Check if current route matches given route name
     * 
     * @param string|array $route Route name or array of route names
     * @return bool True if current route matches
     */
    function blade_if_route($route): bool
    {
        $currentRoute = request()->route()?->getName();
        
        if (is_array($route)) {
            return in_array($currentRoute, $route);
        }
        
        return $currentRoute === $route;
    }
}

if (!function_exists('blade_if_controller')) {
    /**
     * Check if current controller matches given controller
     * 
     * @param string|array $controller Controller name or array of controller names
     * @return bool True if current controller matches
     */
    function blade_if_controller($controller): bool
    {
        $currentController = request()->route()?->getController();
        $controllerName = $currentController ? class_basename($currentController) : null;
        
        if (is_array($controller)) {
            return in_array($controllerName, $controller);
        }
        
        return $controllerName === $controller;
    }
}

if (!function_exists('blade_if_action')) {
    /**
     * Check if current action matches given action
     * 
     * @param string|array $action Action name or array of action names
     * @return bool True if current action matches
     */
    function blade_if_action($action): bool
    {
        $currentAction = request()->route()?->getActionName();
        
        if (is_array($action)) {
            return in_array($currentAction, $action);
        }
        
        return $currentAction === $action;
    }
}

if (!function_exists('blade_if_role')) {
    /**
     * Check if current user has given role
     * 
     * @param string|array $role Role name or array of role names
     * @return bool True if user has role
     */
    function blade_if_role($role): bool
    {
        $user = auth()->user();
        
        if (!$user) {
            return false;
        }
        
        if (method_exists($user, 'hasRole')) {
            if (is_array($role)) {
                return $user->hasAnyRole($role);
            }
            return $user->hasRole($role);
        }
        
        // Fallback for basic role checking
        if (is_array($role)) {
            return in_array($user->role ?? null, $role);
        }
        
        return ($user->role ?? null) === $role;
    }
}

if (!function_exists('blade_if_permission')) {
    /**
     * Check if current user has given permission
     * 
     * @param string|array $permission Permission name or array of permission names
     * @return bool True if user has permission
     */
    function blade_if_permission($permission): bool
    {
        $user = auth()->user();
        
        if (!$user) {
            return false;
        }
        
        if (method_exists($user, 'can')) {
            if (is_array($permission)) {
                return $user->hasAnyPermission($permission);
            }
            return $user->can($permission);
        }
        
        return false;
    }
}

if (!function_exists('blade_format_date')) {
    /**
     * Format date for Blade templates
     * 
     * @param mixed $date Date to format
     * @param string $format Date format
     * @return string Formatted date
     */
    function blade_format_date($date, string $format = 'Y-m-d H:i:s'): string
    {
        if (!$date) {
            return '';
        }
        
        if (is_string($date)) {
            $date = new DateTime($date);
        }
        
        if ($date instanceof DateTime) {
            return $date->format($format);
        }
        
        return date($format, is_numeric($date) ? $date : strtotime($date));
    }
}

if (!function_exists('blade_asset_version')) {
    /**
     * Append file version hash to asset URL
     * 
     * @param string $file Asset file path
     * @return string Asset URL with version
     */
    function blade_asset_version(string $file): string
    {
        $path = public_path($file);
        
        if (!file_exists($path)) {
            return asset($file);
        }
        
        $version = filemtime($path);
        return asset($file . '?v=' . $version);
    }
}

if (!function_exists('blade_inline_svg')) {
    /**
     * Inline SVG content from file
     * 
     * @param string $path SVG file path
     * @param array $attributes Additional attributes
     * @return string Inline SVG content
     */
    function blade_inline_svg(string $path, array $attributes = []): string
    {
        $fullPath = public_path($path);
        
        if (!file_exists($fullPath)) {
            return '';
        }
        
        $svg = file_get_contents($fullPath);
        
        // Add attributes to SVG
        if (!empty($attributes)) {
            $attributeString = '';
            foreach ($attributes as $key => $value) {
                $attributeString .= " {$key}=\"{$value}\"";
            }
            
            $svg = preg_replace('/<svg/', '<svg' . $attributeString, $svg, 1);
        }
        
        return $svg;
    }
}

if (!function_exists('blade_component_exists')) {
    /**
     * Check if Blade component exists
     * 
     * @param string $name Component name
     * @return bool True if component exists
     */
    function blade_component_exists(string $name): bool
    {
        return view()->exists("components.{$name}") || 
               view()->exists("components.{$name}.index");
    }
}

if (!function_exists('blade_render_markdown')) {
    /**
     * Render Markdown to HTML
     * 
     * @param string $text Markdown text
     * @return string HTML content
     */
    function blade_render_markdown(string $text): string
    {
        // Simple markdown parser (you might want to use a proper markdown library)
        $text = htmlspecialchars($text);
        
        // Headers
        $text = preg_replace('/^### (.*$)/m', '<h3>$1</h3>', $text);
        $text = preg_replace('/^## (.*$)/m', '<h2>$1</h2>', $text);
        $text = preg_replace('/^# (.*$)/m', '<h1>$1</h1>', $text);
        
        // Bold and italic
        $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);
        $text = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $text);
        
        // Links
        $text = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', '<a href="$2">$1</a>', $text);
        
        // Line breaks
        $text = nl2br($text);
        
        return $text;
    }
}

if (!function_exists('blade_loop_index')) {
    /**
     * Get current loop index in Blade templates
     * 
     * @return int Current loop index
     */
    function blade_loop_index(): int
    {
        $loop = app('view')->getShared()['loop'] ?? null;
        return $loop ? $loop->index : 0;
    }
}

if (!function_exists('blade_include_if_exists')) {
    /**
     * Include Blade view only if it exists
     * 
     * @param string $view View name
     * @param array $data Data to pass to view
     * @return string Rendered view or empty string
     */
    function blade_include_if_exists(string $view, array $data = []): string
    {
        if (!view()->exists($view)) {
            return '';
        }
        
        return view($view, $data)->render();
    }
}

if (!function_exists('blade_old_value')) {
    /**
     * Get old input value with fallback
     * 
     * @param string $key Input key
     * @param mixed $default Default value
     * @return mixed Old value or default
     */
    function blade_old_value(string $key, $default = null)
    {
        return old($key, $default);
    }
}

if (!function_exists('blade_error_message')) {
    /**
     * Get error message for field
     * 
     * @param string $field Field name
     * @return string Error message or empty string
     */
    function blade_error_message(string $field): string
    {
        $errors = session('errors');
        
        if (!$errors || !$errors->has($field)) {
            return '';
        }
        
        return $errors->first($field);
    }
}

if (!function_exists('blade_has_error')) {
    /**
     * Check if field has error
     * 
     * @param string $field Field name
     * @return bool True if field has error
     */
    function blade_has_error(string $field): bool
    {
        $errors = session('errors');
        
        return $errors && $errors->has($field);
    }
}

if (!function_exists('blade_csrf_token')) {
    /**
     * Get CSRF token for forms
     * 
     * @return string CSRF token
     */
    function blade_csrf_token(): string
    {
        return csrf_token();
    }
}

if (!function_exists('blade_method_field')) {
    /**
     * Generate hidden method field for forms
     * 
     * @param string $method HTTP method
     * @return string Hidden input field
     */
    function blade_method_field(string $method): string
    {
        return '<input type="hidden" name="_method" value="' . strtoupper($method) . '">';
    }
}

if (!function_exists('blade_route_url')) {
    /**
     * Generate route URL with parameters
     * 
     * @param string $name Route name
     * @param array $parameters Route parameters
     * @return string Route URL
     */
    function blade_route_url(string $name, array $parameters = []): string
    {
        try {
            return route($name, $parameters);
        } catch (Exception $e) {
            return '#';
        }
    }
}

if (!function_exists('blade_active_class')) {
    /**
     * Generate active class based on current route
     * 
     * @param string|array $route Route name or array of route names
     * @param string $class Active class name
     * @return string Class name or empty string
     */
    function blade_active_class($route, string $class = 'active'): string
    {
        return blade_if_route($route) ? $class : '';
    }
}

if (!function_exists('blade_checked')) {
    /**
     * Generate checked attribute for checkboxes
     * 
     * @param mixed $value Current value
     * @param mixed $checked Value to check against
     * @return string Checked attribute or empty string
     */
    function blade_checked($value, $checked): string
    {
        if (is_array($checked)) {
            return in_array($value, $checked) ? 'checked' : '';
        }
        
        return $value == $checked ? 'checked' : '';
    }
}

if (!function_exists('blade_selected')) {
    /**
     * Generate selected attribute for select options
     * 
     * @param mixed $value Current value
     * @param mixed $selected Value to select
     * @return string Selected attribute or empty string
     */
    function blade_selected($value, $selected): string
    {
        if (is_array($selected)) {
            return in_array($value, $selected) ? 'selected' : '';
        }
        
        return $value == $selected ? 'selected' : '';
    }
}

if (!function_exists('blade_disabled')) {
    /**
     * Generate disabled attribute based on condition
     * 
     * @param bool $condition Condition to check
     * @return string Disabled attribute or empty string
     */
    function blade_disabled(bool $condition): string
    {
        return $condition ? 'disabled' : '';
    }
}

if (!function_exists('blade_readonly')) {
    /**
     * Generate readonly attribute based on condition
     * 
     * @param bool $condition Condition to check
     * @return string Readonly attribute or empty string
     */
    function blade_readonly(bool $condition): string
    {
        return $condition ? 'readonly' : '';
    }
}

if (!function_exists('blade_required')) {
    /**
     * Generate required attribute based on condition
     * 
     * @param bool $condition Condition to check
     * @return string Required attribute or empty string
     */
    function blade_required(bool $condition): string
    {
        return $condition ? 'required' : '';
    }
}

if (!function_exists('blade_placeholder')) {
    /**
     * Generate placeholder text
     * 
     * @param string $field Field name
     * @param string $default Default placeholder
     * @return string Placeholder text
     */
    function blade_placeholder(string $field, string $default = ''): string
    {
        $placeholders = [
            'name' => 'Enter your name',
            'email' => 'Enter your email',
            'password' => 'Enter your password',
            'phone' => 'Enter your phone number',
            'address' => 'Enter your address',
            'message' => 'Enter your message',
        ];
        
        return $placeholders[$field] ?? $default;
    }
}

if (!function_exists('blade_help_text')) {
    /**
     * Generate help text for form fields
     * 
     * @param string $field Field name
     * @param string $default Default help text
     * @return string Help text
     */
    function blade_help_text(string $field, string $default = ''): string
    {
        $helpTexts = [
            'email' => 'We\'ll never share your email with anyone else.',
            'password' => 'Must be at least 8 characters long.',
            'phone' => 'Include country code if international.',
            'file' => 'Maximum file size: 2MB',
        ];
        
        return $helpTexts[$field] ?? $default;
    }
}
