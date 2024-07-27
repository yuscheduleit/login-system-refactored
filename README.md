# Simple PHP Login System

This is a PHP login system demonstrating basic authentication functionality.

## Project Structure

- `config/`: Configuration files for database and session
- `includes/`: Helper functions organized by feature
- `public/`: Publicly accessible files
- `actions/`: Files that handle form submissions and other actions
- `README.md`: This file

## Current Features

- User registration
- User login
- Basic session management
- Simple password hashing
- Input sanitization
- Use of prepared statements for database queries

## Setup

1. Clone the repository
2. Set up your web server to point to the `public/` directory
3. Import the database schema (to be added)
4. Update database configuration in `config/database.php`
5. Access the application through your web browser

## Improvement Plan

To enhance this project , the following are room for improvement:

1. Implement CSRF Protection
    - Generate unique tokens for each session
    - Include tokens in all forms
    - Validate tokens on form submission
    - This will protect against cross-site request forgery attacks

2. Enhance Authentication Security
    - Implement email verification for new registrations
    - Add "Forgot Password" functionality with secure reset process
    - Introduce "Remember Me" feature with secure, long-term tokens
    - Implement two-factor authentication (2FA) as an optional feature

3. Improve User Management
    - Create user profiles with editable information
    - Implement file upload for profile pictures
    - Add account lockout mechanism after failed login attempts

4. Enhance Error Handling and Logging
    - Implement comprehensive error handling throughout the application
    - Set up a robust logging system for errors and important events
    - This will aid in debugging and monitoring application health

5. Refactor and Optimize Code
    - Improve code organization and structure
    - Implement PHP best practices and design patterns
    - Optimize database queries for better performance

6. Improve User Interface
    - Enhance the frontend with CSS for better user experience
    - Make the design responsive for various devices
    - Possibly integrate a CSS framework like Bootstrap

7. Add Advanced Features
    - Implement role-based access control
    - Add a user dashboard with meaningful functionality
    - Integrate with third-party APIs for additional features

8. Implement Testing
    - Write unit tests for critical functions
    - Implement integration tests for key user flows
    - Set up automated testing pipeline

9. Documentation and Code Comments
    - Improve inline code documentation
    - Create comprehensive API documentation
    - Write tutorials on key concepts implemented in the project

...

## Explanations on Key Concepts

### 1. Secure Password Hashing in PHP

Password security is crucial in any authentication system. In this project, we use PHP's `password_hash()` and `password_verify()` functions to securely hash and verify passwords.

#### How it works:

1. When a user registers, we hash their password before storing it:

```php
function create_user($pdo, $username, $password)
{
    $query = "INSERT INTO users (username, password) VALUES (:username, :password);";
    $stmt = $pdo->prepare($query);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $hashedPassword);

    $stmt->execute();
}
```

2. When a user logs in, we verify the entered password against the stored hash:

```php
function is_password_correct($password, $hashedPassword)
{
    return password_verify($password, $hashedPassword);
}
```

#### Why this is secure:

- `password_hash()` uses a strong, adaptive hashing algorithm (currently bcrypt).
- It automatically handles salt generation and algorithm tuning.
- `password_verify()` is timing-attack safe.

#### Best practices:

- Never store passwords in plain text.
- Use `PASSWORD_DEFAULT` to always use the latest recommended algorithm.

### 2. Preventing SQL Injection with Prepared Statements

SQL Injection is a common web application vulnerability. We prevent it by using PDO with prepared statements.

#### How it works:

1. We prepare a statement with placeholders:

```php
function get_user($pdo, $username)
{
    $query = "SELECT * FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}
```

2. PDO safely handles the data insertion, preventing SQL injection.

#### Why this is secure:

- The SQL structure and data are sent to the database separately.
- The database treats the bound parameters as literal values, not as part of the SQL.

#### Best practices:

- Always use prepared statements for dynamic queries.
- Never directly interpolate variables into SQL strings.
- Use type-specific bind methods when possible (e.g., `bindValue(1, $value, PDO::PARAM_INT)` for integers).

### 3. Secure Session Management

Proper session management is crucial for maintaining user state securely across requests.

#### How it works:

1. We configure session settings for security in `config/session.php`:

```php
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 1800,
    'domain' => 'localhost',
    'path' => '/',
    'secure' => true,
    'httponly' => true
]);

session_start();

if (!isset($_SESSION["last_regeneration"])) {
    regenerate_session_id();
} else {
    $interval = 60 * 30;
    if (time() - $_SESSION["last_regeneration"] >= $interval) {
        regenerate_session_id();
    }
}
```

2. We regenerate the session ID periodically:

```php
function regenerate_session_id()
{
    session_regenerate_id(true);
    $_SESSION["last_regeneration"] = time();
}
```

#### Why this is secure:

- Using only cookies for session handling prevents session ID leakage through URLs.
- Strict mode prevents attacks using uninitialized session IDs.
- Setting secure and httponly flags protects the session cookie.
- Periodic regeneration of session IDs helps prevent session fixation attacks.

#### Best practices:

- Always use HTTPS to encrypt all traffic, including session cookies.
- Regenerate session IDs after privilege level changes (e.g., login).
- Implement proper session destruction on logout.

### 4. Input Sanitization and Validation

Properly handling user input is essential for preventing various types of attacks and ensuring data integrity.

#### How it works:

1. We sanitize input using the `sanitize_input` function in `includes/utils/validation.php`:

```php
function sanitize_input($input)
{
    return htmlspecialchars(strip_tags(trim($input)));
}
```

2. We validate input using specific validation functions:

```php
function validate_username($username)
{
    return strlen($username) >= 3 && strlen($username) <= 20 && ctype_alnum($username);
}

function validate_password($password)
{
    return strlen($password) >= 8;
}
```

3. We use these functions when processing form submissions, like in `actions/signup.php`:

```php
$username = sanitize_input($_POST["username"]);
// ...
if (!validate_username($username)) {
    $errors[] = "Username must be 3-20 characters long and contain only letters and numbers.";
}
```

#### Why this is secure:

- Sanitization helps prevent XSS (Cross-Site Scripting) attacks by encoding special characters.
- Validation ensures that the input meets specific criteria, reducing the risk of malformed data entering the system.

#### Best practices:

- Always sanitize data before outputting it to prevent XSS.
- Validate input on both the client-side (for user experience) and server-side (for security).
- Use type hinting and strict type checking when possible to prevent type juggling vulnerabilities.

### 5. Database Connection with PDO

Establishing a secure and efficient database connection is crucial for any web application. This project uses PHP Data Objects (PDO) for database interactions.

#### How it works:

In `config/database.php`, we establish a PDO connection:

```php
$host = "localhost";
$dbName = "vtt";
$dbUsername = "root";
$dbPassword = "";
$db_charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$dbName;charset=$db_charset";

try {
    $pdo = new PDO($dsn, $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}
```

#### Why this is beneficial:

- PDO provides a consistent interface for accessing databases, making it easier to switch between different database systems if needed.
- It supports prepared statements, which we use to prevent SQL injection.
- Setting the error mode to `ERRMODE_EXCEPTION` allows for better error handling and debugging.

#### Best practices:

- Always use try-catch blocks when establishing a database connection to handle potential errors gracefully.
- Store database credentials securely, ideally in environment variables rather than directly in the code.
- Use UTF-8 character encoding (utf8mb4 in MySQL) to support a wide range of characters.

### 6. Error Handling and User Feedback

Proper error handling and user feedback are essential for both security and user experience.

#### How it works:

1. We collect errors in an array, as seen in `actions/signup.php`:

```php
$errors = [];

if (is_input_empty($username, $password) || empty($confirm_password)) {
    $errors[] = "All fields are required.";
}

if (!validate_username($username)) {
    $errors[] = "Username must be 3-20 characters long and contain only letters and numbers.";
}

// ... more validations ...

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: ../signup.php");
    exit();
}
```

2. We display errors to the user using the `display_error_messages` function in `includes/views/view_functions.php`:

```php
function display_error_messages($errors)
{
    if (!empty($errors)) {
        echo "<ul class='error-messages'>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
}
```

#### Why this is important:

- Collecting errors before processing allows for comprehensive validation.
- Storing errors in the session allows for maintaining them across redirects.
- Displaying specific error messages helps users understand and correct their input.

#### Best practices:

- Be cautious about the information revealed in error messages to prevent potential security leaks.
- Always validate and sanitize user input before processing or storing it.
- Use clear and friendly language in error messages to guide users.

### 7. Separation of Concerns

The project structure demonstrates a basic separation of concerns, which is a fundamental principle in software design.

#### How it works:

The project is organized into different directories and files based on their responsibilities:

- `config/`: Configuration files (database, session)
- `includes/`: Helper functions and utilities
- `public/`: Publicly accessible files
- `actions/`: Form processing scripts

For example, authentication logic is separated from display logic:

- Authentication logic in `includes/auth/login_functions.php`:
```php
function is_username_wrong($result)
{
    return !$result;
}

function is_password_wrong($password, $hashedPassword)
{
    return !password_verify($password, $hashedPassword);
}
```

- Display logic in `includes/views/view_functions.php`:
```php
function display_login_form()
{
    // HTML for login form
}
```

#### Why this is beneficial:

- Improves code organization and readability
- Makes the codebase easier to maintain and extend
- Facilitates teamwork by allowing different team members to work on different components

#### Best practices:

- Keep files focused on a single responsibility
- Use consistent naming conventions for files and functions
- Consider using autoloading for more efficient file inclusion

## Contributing

While this is primarily a personal development project, contributions, suggestions, and discussions are welcome. Feel free to fork the project and submit pull requests with improvements or open issues for discussions.

