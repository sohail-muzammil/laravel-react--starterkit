# Laravel 12 React Starter Kit with Social Authentication

This project is a Laravel 12 application integrated with React.js using the new React Starter Kit. It includes social authentication using the Laravel Socialite package, allowing users to log in or sign up with various social providers. Users can also manage their connected social accounts from the dashboard settings.

## Features

- **Social Authentication**: Login and sign up using social providers (e.g., Google, Facebook, GitHub, etc.).
- **Dashboard Settings**: Users can connect or disconnect social accounts from their profile settings.
- **Laravel 12**: Built with the latest version of Laravel.
- **React Starter Kit**: Integrated with React.js for a modern frontend experience.
- **Laravel Socialite**: Simplifies OAuth authentication with social providers.
- **Admin Dashboard**: URL to Access Admin Dashboard is /admin/login

## Installation

Follow these steps to set up the project locally:

1. **Clone the repository**:

   ```bash
   git clone https://github.com/sohail-muzammil/laravel-react--starterkit.git
   cd laravel-react--starterkit
   ```

2. **Install dependencies**:

   ```bash
   composer install
   npm install
   ```

3. **Set up the environment file**:

   - Copy `.env.example` to `.env`:

     ```bash
     cp .env.example .env
     ```

   - Generate an application key:

     ```bash
     php artisan key:generate
     ```

   - Update the `.env` file with your database credentials and social provider credentials (e.g., Google, Facebook, etc.).

4. **Run migrations**:

   ```bash
   php artisan migrate 
   ```

5. **Compile assets**:

   ```bash
   npm run dev
   ```

6. **Start the development server**:

   ```bash
   php artisan serve
   ```

7. **Access the application**:
   Open your browser and go to `http://127.0.0.1:8000`.

### Supported Providers

- Facebook
- Twitter
- Linkedin
- Google
- Github
- Gitlab
- Bitbucket
- Slack

## Managing Social Accounts

Users can manage their connected social accounts from the dashboard settings:

1. Log in to the application.
2. Go to the **Settings** page in the dashboard.
3. Under **Social Accounts**, users can:
   - Connect new social accounts.
   - Disconnect existing social accounts.

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bugfix.
3. Commit your changes.
4. Push your branch and submit a pull request.

## License

This project is open-source and available under the [MIT License](LICENSE).

## Acknowledgments

- [Laravel](https://laravel.com/)
- [React.js](https://reactjs.org/)
- [Laravel Socialite](https://laravel.com/docs/socialite)

---

**Happy Coding!** 🚀