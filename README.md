# Hexagonal Architecture with Laravel

This project demonstrates the implementation of Hexagonal Architecture (also known as Ports and Adapters) within a Laravel framework. The goal is to achieve a decoupled, testable, and maintainable application by separating core business logic (Domain) from external concerns (Infrastructure, UI).

## Why Hexagonal Architecture?

Hexagonal Architecture focuses on isolating the domain logic from external technologies like databases, web frameworks, and external APIs. This provides:

-   **Decoupling**: The core business logic doesn't depend on specific infrastructure details.
-   **Testability**: The domain can be tested independently of the UI and database.
-   **Maintainability**: Changes in external technologies have minimal impact on the core.
-   **Flexibility**: Easily swap out implementations (e.g., switch from Eloquent to another ORM or a different database).

## Architecture Diagram (Conceptual)

```
+-------------------------------------------------------------+
|               User Interface / API (Controllers)            |
|                                                             |
|   +-----------------------------------------------------+   |
|   |         Application Layer (Use Cases)             |   |
|   |                                                     |   |
|   |   +---------------------------------------------+   |   |
|   |   |         Domain Layer (Entities, Repositories)   |   |
|   |   |                                               |   |   |
|   |   |      (Ports - Interfaces defined here)        |   |   |
|   |   +---------------------------------------------+   |   |
|   |                                                     |   |
|   +-----------------------------------------------------+   |
|                                                             |
|   +-----------------------------------------------------+   |
|   |        Infrastructure Layer (Adapters)            |   |
|   |                                                     |   |
|   |     (Adapters - Implementations of Domain Ports)    |   |
|   |                                                     |   |
|   +-----------------------------------------------------+   |
|                                                             |
|               External Services (Database, APIs)            |
+-------------------------------------------------------------+
```

### Explanation of Layers:

-   **Domain Layer (`app/Domain`)**: Contains the core business logic, entities, and interfaces (ports) for interacting with external systems (e.g., `CustomerRepository`). This is the heart of the application and has no dependencies on the `Infrastructure` layer.
-   **Application Layer (`app/Domain/UseCases`)**: Orchestrates the domain objects to perform specific application features. Each use case represents a distinct action (e.g., `CreateCustomer`, `GetCustomer`).
-   **User Interface / API Layer (`app/Http/Controllers`)**: Handles incoming requests, translates them into calls to the application layer (use cases), and formats the output.
-   **Infrastructure Layer (`app/Infrastructure`)**: Provides the concrete implementations (adapters) for the ports defined in the domain. This includes persistence (e.g., `EloquentCustomerRepository`), external services, and frameworks.

## Folder Structure

The key directories reflecting the hexagonal architecture are found within the `app/` folder:

```
app/
├── Domain/
│   ├── Customer/
│   │   ├── Entities/             # Core business objects (e.g., Customer.php)
│   │   ├── Repositories/         # Interfaces (ports) for data access (e.g., CustomerRepository.php)
│   │   └── UseCases/             # Application-specific logic (e.g., CreateCustomer.php, CetCustomer.php)
│   ├── Order/
│   └── Producte/
├── Helper/
│   └── ApiResource.php           # Custom API response helper
├── Http/
│   ├── Controllers/              # Laravel controllers (adapters for the web)
│   ├── Requests/                 # Form requests for validation
│   └── Resources/                # API resources for data transformation
├── Infrastructure/
│   ├── Persistence/              # Adapters implementing domain repository interfaces (e.g., EloquentCustomerRepository.php)
│   └── Providers/                # Service providers for dependency injection (e.g., RepositoryServiceProvider.php)
├── Models/                       # Eloquent models (used by Infrastructure layer)
│   ├── Customer.php
│   └── User.php
└── Providers/
    └── AppServiceProvider.php
```

## Example Flow: Creating a Customer

1.  **Request**: An API request hits `CustomerController@store`.
2.  **Controller (`app/Http/Controllers/CustomerController.php`)**:
    -   Receives the `CustomerRequest` (validated input).
    -   Invokes the `CreateCustomer` Use Case (`App\Domain\Customer\UseCases\CreateCustomer`).
3.  **Use Case (`App\Domain\Customer\UseCases/CreateCustomer.php`)**:
    -   Depends on `App\Domain\Customer\Repositories\CustomerRepository` (the port/interface).
    -   Creates a `Customer` entity (`App\Domain\Customer\Entities\Customer.php`).
    -   Calls `save()` on the `CustomerRepository` interface.
4.  **Dependency Injection (`App\Infrastructure\Providers\RepositoryServiceProvider.php`)**:
    -   Laravel's service container, configured via `RepositoryServiceProvider`, resolves `CustomerRepository` to `App\Infrastructure\Persistence\EloquentCustomerRepository` (the adapter).
5.  **Adapter (`App\Infrastructure\Persistence\EloquentCustomerRepository.php`)**:
    -   Implements the `CustomerRepository` interface.
    -   Uses the Eloquent ORM (`App\Models\Customer.php`) to persist the customer data to the database.
6.  **Response**: The controller receives the result from the use case and uses `ApiResource` to return a `201 Created` HTTP response.

## Commands

These are common commands for setting up and running the Laravel project:

-   **Install PHP Dependencies**:

    ```bash
    composer install
    ```

-   **Copy Environment File**:

    ```bash
    cp .env.example .env
    ```

-   **Generate Application Key**:

    ```bash
    php artisan key:generate
    ```

-   **Run Database Migrations**:

    ```bash
    php artisan migrate
    ```

-   **Start Local Development Server**:

    ```bash
    php artisan serve
    ```

-   **Clear Configuration Cache (if issues occur after changes)**:
    ```bash
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    ```

## How to Run Tests

The project uses PHPUnit for testing.

-   **Run All Tests**:

    ```bash
    php artisan test
    ```

-   **Run Tests in a Specific File**:

    ```bash
    php artisan test --filter=<path_to_test_file>
    # Example: php artisan test --filter=tests/Unit/ExampleTest.php
    ```

-   **Run a Specific Test Method**:
    ```bash
    php artisan test --filter=<TestClassName>::<testMethodName>
    # Example: php artisan test --filter=ExampleTest::test_that_true_is_true
    ```

## Development Notes (Derived from commits and architectural choices)

-   **Initial Setup**: Project initialized with Laravel, focusing on a clean separation of concerns.
-   **Domain-Driven Structure**: Emphasis on defining domain entities and repositories first.
-   **Use Cases**: Introduction of dedicated use cases to encapsulate specific application logic.
-   **Repository Pattern**: Implementation of the repository pattern to abstract data persistence.
-   **Dependency Injection**: Extensive use of Laravel's service container for managing dependencies, especially for binding interfaces to concrete implementations.
-   **API Design**: Use of `ApiResource` helper for consistent API responses.
-   **Testing Strategy**: Facilitating unit testing of domain and use case layers independently.

---

**Author**: MahmoudRedaShaban
**Branch**: `hexagonalArchTest/mahmoudreda`
