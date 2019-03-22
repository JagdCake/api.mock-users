### Docker files for a Symfony 4 application
#### Based on https://github.com/coloso/symfony-docker

##### Uses:
- Alpine images for small container size and resource efficiency
- automated nginx proxy — https://github.com/jwilder/nginx-proxy
- automated Let's Encrypt SSL certificates — https://github.com/JrCs/docker-letsencrypt-nginx-proxy-companion
- PostgreSQL 10.6 with a BASH script which creates an encrypted database the first time the container starts
- optional BASH script to transfer tables between the local filesystem and a container

All environment variables in [docker-compose.yml](./docker-compose.yml) and [nginx/default.conf](./nginx/default.conf) have to be set. `APP_ENV`, `APP_DEBUG` and `APP_SECRET` from both files should match.

On line 10 of the [nginx/Dockerfile](./nginx/Dockerfile) - `RUN echo "upstream php-upstream { server api:8000; }" > /etc/nginx/conf.d/upstream.conf`, `api` corresponds to the name of the project service.
