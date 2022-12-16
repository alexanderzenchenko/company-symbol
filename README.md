## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Fill in the next variables in .env or create .env.local
   - X_RAPID_API_KEY
   - X_RAPID_API_HOST
   - MAILER_DSN (e.q. gmail://you@gmail.com:pass@default?verify_peer=0)
3. Run `docker compose build --pull --no-cache` to build fresh images
4. Run `docker compose up` (the logs will be displayed in the current shell)
5. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
6. Run `docker compose down --remove-orphans` to stop the Docker containers.
