### ControllerRepositoryHelpers

Controller reflection and simple repository-like utilities for common patterns.

#### Function Index

- controller_action_name(): string
- controller_class_name(): string
- controller_method_name(): string
- repository_find_by(string $model, string $field, mixed $value)
- repository_update_by(string $model, string $field, mixed $value, array $data): bool
- repository_delete_by(string $model, string $field, mixed $value): bool
- repository_exists(string $model, string $field, mixed $value): bool
- controller_middleware_list(string $controller): array
- controller_has_middleware(string $controller, string $middleware): bool
- controller_namespace(): string
- controller_methods(string $controller): array
- controller_has_method(string $controller, string $method): bool
- controller_properties(string $controller): array
- controller_has_property(string $controller, string $property): bool
- controller_parent_class(string $controller): ?string
- controller_implements_interface(string $controller, string $interface): bool
- controller_uses_trait(string $controller, string $trait): bool
- controller_get_traits(string $controller): array
- controller_get_interfaces(string $controller): array
- controller_is_abstract(string $controller): bool
- controller_is_final(string $controller): bool
- controller_get_doc_comment(string $controller): string
- controller_get_method_doc_comment(string $controller, string $method): string
- controller_get_parameters(string $controller, string $method): array
- controller_get_return_type(string $controller, string $method): ?string
- controller_is_public_method(string $controller, string $method): bool
- controller_is_protected_method(string $controller, string $method): bool
- controller_is_private_method(string $controller, string $method): bool
- controller_is_static_method(string $controller, string $method): bool
- controller_get_attributes(string $controller): array
- controller_has_attribute(string $controller, string $attribute): bool


