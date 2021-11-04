# Pet project (Test task): User payments
This project contains simple crud amd small coinbase commerce integration.

You also can see some screenshots [here](/screenshots)

## Development
First you need is to clone repository:  
`git clone https://github.com/reenekt/pet-project-user-payments-coinbase.git`

For running this project locally you need to have installed Homestead (recommended) or Docker. Also, you need to have installed nodejs (version >= 12) and npm.


### Backend
Copy `.env.example` file from project root to `.env`.

If you have installed homestead you need to add project (folder, sitemap and database) to Homestead.yaml and run `vagrant reload --provision` from homestead root. 
See Homestead [documentation](https://laravel.com/docs/8.x/homestead) for details

If you use Docker, you need to setup project following Sail [documentation](https://laravel.com/docs/8.x/sail)

After setting up the project you need to set APP_KEY (for this pet project this step is optional) by running `php artisan key:generate`.

From project root run `php artisan migrate --seed`. Admin credentials are `admin@test.test`/`secret`.

After adding project to homestead / running with sail you need to know URL of project (for `.env` files, see below).

### Frontend
All project's frontend located in `frontend` folder. 

Copy `.env.example` file from **frontend** root to `.env`.

It is a nuxt project, so you need nodejs to build and run it (recommended running it on your host machine for better performance).

Before start, you need to change `API_URL` in frontend `.env`. **Note**: this URL should be API base path of backend (backend base URL + `/api`).

For running frontend just run `npm run dev` and open link from CLI (typically it is http://localhost:3000).

### Coinbase Commerce integration setup

> **NOTE**: this part is not fully implemented

1. Sign in Coinbase Commerce
2. Create some test checkout
3. Get checkout link (from checkout details modal)
4. Paste link in `TEST_CHECKOUT_ID` variable of **frontend** `.env`
5. (Optional) restart `npm run dev` if frontend is running
6. Open settings page of Coinbase Commerce, scroll to "Webhooks". Copy "Shared secret" (and then paste it to `COINBASE_COMMERCE_WEBHOOKS_SECRET` variable of **backend** `.env`) and add project's webhook endpoint (backend base URL + `/coinbase/webhooks/charge`)

After this, you have ready-to-use project (project is not fully working. See `\App\Http\Controllers\CoinbaseController`)
