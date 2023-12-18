

## Getting Started


1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up --pull always -d --wait` to start the project
4. RUN `npm install` to install the project dependencies
5. Execute `npm run dev` to run the project in development mode.
6. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
7. Run `php bin/console app:download-districts`or `docker exec -it districts_information-php-1 bin/console app:download-districts` to download districts from Gdansk and Krakow
8. Run `docker compose down --remove-orphans` to stop the Docker containers.


Project is using Symfony Docker from https://github.com/dunglas/symfony-docker
