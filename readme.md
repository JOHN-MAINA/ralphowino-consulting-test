### ralphowino-consulting-test

### How do I get set up? ###

1. Cron the repository form
    ` https://github.com/JOHN-MAINA/ralphowino-consulting-test.git `
1. Copy `.env.example` to `.env` under the root directory
        `e.g. cp .env.example .env`
1. Install required packages using composer package manager via the following command
        ` composer install`
1. Generate the application key 
        ` php artisan key:generate`
1. Set stream api and secret in the env file
        `STREAM_API_KEY=your_key`
        `STREAM_API_SECRET=your_secret`
1. Create the encryption keys needed to generate secure access tokens
        `php artisan passport:install`
