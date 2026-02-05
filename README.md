## postiz-wp-integration-guide
A minimal, practical example showing how to connect Postiz with WordPress REST API to publish posts from Postiz.
Reference docs: https://docs.postiz.com/public-api/providers/wordpress

## Get Your Postiz API Key
- The Postiz API key is created inside the Postiz dashboard (not in WordPress).
- Log in to Postiz Dashboard
- Open Settings → API Keys
- Click Create API Key
- Copy the generated key
- You will use this key in every request:
    `Authorization: YOUR_POSTIZ_API_KEY`
- Without this key the endpoint https://api.postiz.com/public/v1/posts will return `401 Unauthorized`.

## WordPress Preparation
A. Permalinks
 - WordPress REST requires pretty permalinks:
    `Admin → Settings → Permalinks → "Post name"`

B. Authentication Options
 - Option 1 - Application Password (Recommended & simplest)
    `Users → Profile`
    `Application Passwords`
    `Create "Postiz"`
    `Copy credentials (username application-password)`

 - Option 2 - JWT (more secure than using application password)
    `Install plugin: JWT Authentication for WP REST API`
    `Add the following to wp-config`
    ```php
    define('JWT_AUTH_SECRET_KEY', 'your-secret-key');
    ```

    `Generate token`
    `POST https://your-site.com/wp-json/jwt-auth/v1/token`
    `Body`
    ```
    {
        "username": "wp-user",
        "password": "wp-password"
    }
    ```

    `Response`
    ```
    {
        "token": "eyJ...",
        "user_email": "..."
    }
    ```

    `Use this token in requests to WordPress.`

## Verify WordPress Side
    `curl https://your-site.com/wp-json/wp/v2/posts \ -u username:app-password`
- This should return a JSON list of posts.

## How Flow Works
- Create API key in Postiz dashboard
- Create WordPress Integration in Postiz
- Postiz stores WP credentials
- Your application (script/dashboard) calls Postiz with the Postiz API key
- Postiz calls:
    `/wp-json/wp/v2/posts`
    `/wp-json/wp/v2/media`
- WordPress creates content

## Image handling
- The payload must contain the original public image URL.
- Postiz downloads this file, uploads it to WordPress Media, receives a media ID, and uses that ID internally when creating the post.
- The image URL must be publicly accessible by Postiz servers
- If no image is required, send an empty array:
    ```
    "image": []
    ```

## Security Notes
- Hard‑coding API keys, usernames, or passwords in source code is not recommended
- Use any of the following instead:
    `Environment variables`
    `Store in options table from customizer or theme settings (custom)`
- Rotate Postiz API keys periodically
- Use JWT instead of app passwords when possible
- Restrict WordPress user role to minimum capabilities
- Example using environment variable in PHP
    ```php
    $apiKey = getenv('POSTIZ_API_KEY');
    ```

## Troubleshooting
- `401 from Postiz` - Missing Postiz API key
- `401 from WP` - Wrong app password/JWT
- `404 wp-json` - Permalinks disabled
- `Images fail` - Media endpoint blocked
- `CORS` - Firewall/host

## Contributing & Discussion
- This repo is intentionally open for improvements.
- Ideas welcome:
    `Better media upload examples`
    `Custom post type support`
    `Category/tag mapping`
    `OAuth/JWT hardening`
    `Multisite testing`
- Feel free to:
    `Open an issue with your scenario`
    `Submit a PR with improvements`
    `Add alternative language examples (JS/Node)`

## Disclaimer
- This repository is a community guide based on the official Postiz documentation and general WordPress REST behavior.
- I do not currently have a Postiz account to perform end-to-end testing.
- The examples illustrate the expected flow but may require adjustments depending on:
    - Postiz account configuration
    - authentication method (App Password / JWT)
    - WordPress hosting restrictions
    - Postiz API changes
- PRs from users with real Postiz setups are very welcome 🙏