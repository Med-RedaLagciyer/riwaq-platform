# Riwaq

## Services

| Service  | URL                        | Credentials                                    |
|----------|----------------------------|------------------------------------------------|
| Backend  | http://localhost           | -                                              |
| Frontend | http://localhost:5173      | -                                              |
| Mailpit  | http://localhost:8025      | -                                              |
| MinIO    | http://localhost:9001      | user: riwaq_user / password: riwaq_pass        |
| Postgres | localhost:5432             | user: riwaq_user / password: riwaq_pass        |
| Redis    | localhost:6379             | -                                              |

## Commands

### Build docker
docker compose build

### Start docker
docker compose up -d

### Stop everything
docker compose down

### Rebuild a container
docker compose build [container_name]
docker compose up -d

### View logs
docker compose logs -f                     # all services
docker compose logs -f [service_name]      # specific service

### Open a shell inside a container
docker compose exec php bash
docker compose exec postgres psql -U root -d riwaq_db
```
