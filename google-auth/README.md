# Google Auth Plugin Documentation

## Plugin Description

The Google Auth plugin allows users to create accounts on a WordPress website using their Google accounts. When enabled, the plugin adds a "Google Auth" menu to the WordPress admin dashboard. Admins can configure the plugin by providing Google API credentials. The plugin also registers a shortcode `[google_auth_link]`, which can be used to display a "Login using Google Account" link on any page. Upon clicking this link, users are redirected to Google for authentication. If they are already logged in to Google, they will be asked to confirm registration. The plugin then retrieves user information and either creates a new account on the website or logs in the user if they are already registered.

## User Documentation and Usage

### Admin Settings

1. **Accessing the Settings:**
   - After activating the plugin, go to the WordPress dashboard.
   - Click on the "Google Auth" menu item under the "Settings" section.

2. **Setting Up Google API Credentials:**
   - Go to the [Google Developer Console](https://console.developers.google.com/).
   - Create a new project or select an existing project.
   - Enable the "Google+ API" and "Google People API".
   - Navigate to "Credentials" and create OAuth 2.0 Client IDs.
   - Copy the generated `Client ID` and `Client Secret`.
   - Paste these values into the corresponding fields in the plugin's settings page.

3. **Saving the Settings:**
   - Ensure the "Authorized redirect URIs" field in the Google Developer Console includes the provided URL (`https://your-website/ytaha-google-oauth-callback`).
   - Click "Save Settings" in the plugin settings page.

### Adding the Shortcode

1. **Using the Shortcode:**
   - Add the shortcode `[google_auth_link]` to any page or post where you want to display the "Login using Google Account" link.

2. **User Experience:**
   - When a user clicks the "Login using Google Account" link, they are redirected to Google for authentication.
   - If the user is not already registered on the website, a new account is created using their Google information, and they are logged in.
   - If the user is already registered, they are logged in and redirected to the homepage.

## Technical Documentation

### Implementation Overview

The plugin is structured into various components, including endpoints, admin pages, user pages, shortcodes, templates, assets, core classes, and tests. Below is a detailed description of these components:

1. **Endpoints:**
   - `class-auth-confirm.php`: Handles the confirmation of Google authentication.
   - `class-auth-settings.php`: Manages the authentication settings.

2. **Admin Pages:**
   - `class-abstract-admin-page.php`: Abstract class for admin pages.
   - `class-google-auth-settings.php`: Admin page for Google Auth settings.

3. **User Pages:**
   - `class-abstract-user-page.php`: Abstract class for user pages.
   - `class-google-auth-confirm.php`: User page for Google Auth confirmation.

4. **Shortcodes:**
   - `class-confirm-shortcode.php`: Registers the `[google_auth_link]` shortcode.

5. **Templates:**
   - `auth-confirm.php`: Template for the authentication confirmation page.

6. **Assets:**
   - Contains CSS and JS files for styling and functionality.

7. **Core Classes:**
   - `class-base.php`: Base class for the plugin.
   - `class-endpoint.php`: Manages API endpoints.
   - `class-loader.php`: Loads the plugin.
   - `class-singleton.php`: Implements the singleton pattern.
   - `class-auth.php`: Core authentication logic.

8. **Languages:**
   - `ytaha-google-auth.pot`: Translation template file.

9. **Tests:**
   - `bootstrap.php`: Bootstrap file for tests.
   - `test-api-auth.php`: Tests for the API authentication.
   - `test-sample.php`: Sample tests.

### React.js Implementation

The `src` directory contains React.js implementations for the admin dashboard page and the Google confirmation page. These components enhance the user experience with a modern, dynamic interface.

#### Admin Dashboard Page

- **File:** `src/pages/confirm-google-auth`
  - Implements the settings page using React.
  - Fetches and displays current settings.
  - Provides forms for updating the Client ID and Client Secret.

#### Google Confirmation Page

- **File:** `src/pages/google-auth-settings.jsx`
  - Manages the Google authentication confirmation process.
  - Displays user information retrieved from Google.
  - Handles user registration and login.

### Detailed File Descriptions

#### Endpoints

- **class-auth-confirm.php:**
  - Handles the confirmation process of the Google authentication.
  - Validates the authentication token and retrieves user information.

- **class-auth-settings.php:**
  - Manages the settings for the Google authentication.
  - Provides methods to save and retrieve the API credentials.

#### Admin Pages

- **class-abstract-admin-page.php:**
  - Abstract class that provides common functionality for admin pages.
  - Includes methods for rendering settings forms and saving options.

- **class-google-auth-settings.php:**
  - Extends the abstract admin page class.
  - Implements the settings page specific to Google Auth.
  - Handles saving and retrieving the Client ID and Client Secret.

#### User Pages

- **class-abstract-user-page.php:**
  - Abstract class that provides common functionality for user pages.
  - Includes methods for rendering user-facing forms and handling submissions.

- **class-google-auth-confirm.php:**
  - Extends the abstract user page class.
  - Implements the confirmation page for Google Auth.
  - Handles the logic for user registration and login based on Google authentication.

#### Shortcodes

- **class-confirm-shortcode.php:**
  - Registers the `[google_auth_link]` shortcode.
  - Renders a link that initiates the Google authentication process.

#### Templates

- **auth-confirm.php:**
  - Template file for the authentication confirmation page.
  - Displays the confirmation message and handles user redirection.

#### Core Classes

- **class-base.php:**
  - Base class for the plugin.
  - Provides common methods and properties used throughout the plugin.

- **class-endpoint.php:**
  - Manages API endpoints.
  - Registers and handles custom API routes.

- **class-loader.php:**
  - Loads the plugin's components.
  - Ensures that all necessary files and classes are included.

- **class-singleton.php:**
  - Implements the singleton pattern to ensure a single instance of a class.
  - Used for classes that should only have one instance throughout the plugin.

- **class-auth.php:**
  - Core class for handling authentication logic.
  - Manages the OAuth flow and retrieves user information from Google.

#### Languages

- **ytaha-google-auth.pot:**
  - Translation template file.
  - Contains translatable strings for localization.

#### Tests

- **bootstrap.php:**
  - Bootstrap file for setting up the test environment.
  - Includes necessary files and initializes the testing framework.

- **test-api-auth.php:**
  - Tests for the API authentication endpoints.
  - Verifies that the endpoints return the expected results.

### Technologies Used

- **PHP:** Core language used for developing the WordPress plugin.
- **JavaScript:** Used for client-side scripting and enhancing user interactions.
- **React.js:** Utilized for implementing the admin dashboard and Google confirmation pages.
- **WordPress APIs:** Used for integrating with WordPress's functionality and ensuring compatibility.
- **Google OAuth 2.0:** Authentication protocol used for logging in users via their Google accounts.
- **CSS:** Styling language used for designing the plugin's user interface.
- **HTML:** Markup language used for structuring the plugin's admin and user pages.

---
### Installation

## Composer
Install composer packages
`composer install`

## Build Tasks (npm)
Everything should be handled by npm.

Install npm packages
`npm install`

| Command              | Action                                                |
|----------------------|-------------------------------------------------------|
| `npm run watch`      | Compiles and watch for changes.                       |
| `npm run compile`    | Compile production ready assets.                      |
| `npm run build`      | Compile development assets.                           |
