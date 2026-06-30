# Authorization

By default, AI Pulse is accessible only in the `local` environment. In production, you must explicitly authorize access.

## Default Behavior

Out of the box, AI Pulse defines a Gate that allows access only when `APP_ENV=local`:

```php
Gate::define('viewAiPulse', function ($user = null) {
    return app()->environment('local');
});
```

This means on production servers, visiting `/ai-pulse` will result in a `403 Forbidden` response until you configure authorization.

## Authorization Methods

### Method 1: Gate (Recommended)

Define a custom Gate in your `AuthServiceProvider` or `AppServiceProvider`:

```php
use Illuminate\Support\Facades\Gate;

public function boot(): void
{
    Gate::define('viewAiPulse', function ($user) {
        return $user->isAdmin();
    });
}
```

The Gate receives the authenticated user (or `null` if not authenticated) and should return `true` to grant access.

**Common patterns:**

```php
// Admin-only access
Gate::define('viewAiPulse', function ($user) {
    return $user->hasRole('admin');
});

// Multiple roles
Gate::define('viewAiPulse', function ($user) {
    return in_array($user->role, ['admin', 'developer', 'ai-engineer']);
});

// Email domain restriction
Gate::define('viewAiPulse', function ($user) {
    return str_ends_with($user->email, '@yourcompany.com');
});

// Environment-based (default behavior)
Gate::define('viewAiPulse', function ($user = null) {
    return app()->environment('local', 'staging');
});
```

### Method 2: Middleware

Require authentication via the middleware stack:

```php
// config/ai-pulse.php
'middleware' => ['web', 'auth'],
```

This ensures only authenticated users can reach the Gate check. You can combine this with the Gate for role-based access:

```php
// config/ai-pulse.php
'middleware' => ['web', 'auth', 'can:viewAiPulse'],
```

### Method 3: Custom Guard

If your application uses multiple authentication guards:

```php
// config/ai-pulse.php
'auth_guard' => 'admin',
```

AI Pulse will use the `admin` guard when resolving the authenticated user for the Gate check.

### Method 4: IP Whitelist (Custom Middleware)

For additional security, wrap AI Pulse routes with IP-based middleware:

```php
// config/ai-pulse.php
'middleware' => ['web', 'auth', 'ip.whitelist'],
```

## Authorization Middleware

AI Pulse ships with an `Authorize` middleware that is automatically appended to all routes. This middleware:

1. Resolves the user via the configured guard
2. Checks the `viewAiPulse` Gate
3. Returns `403 Forbidden` if unauthorized

You don't need to register this middleware manually — it's applied automatically.

## Security Best Practices

1. **Always configure authorization before deploying to production**
2. **Use the Gate for fine-grained control** — middleware alone only checks authentication, not authorization
3. **Consider IP restrictions** for additional layers of security
4. **Review audit logs** regularly — AI Pulse logs all dashboard access attempts
5. **Enable HTTPS** — AI Pulse does not enforce HTTPS, but you should at the server or middleware level

## Troubleshooting

### "403 Forbidden" on local environment

Check that your `APP_ENV` is set to `local`:

```env
APP_ENV=local
```

Or explicitly define the Gate to allow local access:

```php
Gate::define('viewAiPulse', function ($user = null) {
    return app()->environment('local');
});
```

### "403 Forbidden" in production

This is expected. Define a Gate that matches your authorization logic:

```php
Gate::define('viewAiPulse', function ($user) {
    return $user->email === 'admin@example.com';
});
```

### Authentication not working

Ensure your middleware stack includes the appropriate auth middleware:

```php
// config/ai-pulse.php
'middleware' => ['web', 'auth'],
```
