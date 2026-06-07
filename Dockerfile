FROM php:8.5-cli-alpine
RUN apk add --no-cache bash
WORKDIR /app
COPY bin ./bin
COPY tests ./tests
RUN php -l bin/stakeholder.php && bash tests/test_cli.sh
ENTRYPOINT ["php", "/app/bin/stakeholder.php"]
