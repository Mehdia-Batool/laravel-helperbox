### BladeHelpers

Blade-friendly conditionals, formatting helpers, directives support, and UI attributes.

#### Function Index

- blade_if_route(string|array $route): bool
- blade_if_controller(string|array $controller): bool
- blade_if_action(string|array $action): bool
- blade_if_role(string|array $role): bool
- blade_if_permission(string|array $permission): bool
- blade_format_date(mixed $date, string $format = 'Y-m-d H:i:s'): string
- blade_asset_version(string $file): string
- blade_inline_svg(string $path, array $attributes = []): string
- blade_component_exists(string $name): bool
- blade_render_markdown(string $text): string
- blade_loop_index(): int
- blade_include_if_exists(string $view, array $data = []): string
- blade_old_value(string $key, mixed $default = null)
- blade_error_message(string $field): string
- blade_has_error(string $field): bool
- blade_csrf_token(): string
- blade_method_field(string $method): string
- blade_route_url(string $name, array $parameters = []): string
- blade_active_class(string|array $route, string $class = 'active'): string
- blade_checked(mixed $value, mixed $checked): string
- blade_selected(mixed $value, mixed $selected): string
- blade_disabled(bool $condition): string
- blade_readonly(bool $condition): string
- blade_required(bool $condition): string
- blade_placeholder(string $field, string $default = ''): string
- blade_help_text(string $field, string $default = ''): string

#### Examples

```blade
<li class="{{ blade_active_class('dashboard') }}">...</li>
@if(blade_if_role('admin')) ... @endif
{!! blade_inline_svg('icons/logo.svg', ['class' => 'h-6']) !!}
```


