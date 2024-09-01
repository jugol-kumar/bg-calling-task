#Instruction


#### Project Setup Instructions:

- Clone this repository form this url

```bash
git clone  https://github.com/jugol-kumar/bg-calling-task.git
```
- Setup your project with composer requirement.
```bash
composer install
```
- copy .env.example to .env file
```bash
cp .env.example .env
```
- Setup a database with your preferred name.
- Run php artisan migrate:fresh --seed command after setup Database.
```bash
php artisan migrate:fresh --seed
```

- Setup node packages with required requirement.
```bash
npm install
```

- Setup node packages with required requirement.
```bash
npm run dev
```

- add frontend url in laravel .env file as FRONTEND_URL