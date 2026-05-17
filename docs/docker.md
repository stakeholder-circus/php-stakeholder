# PHP Docker

## Build and test
- `docker build -t php-stakeholder .`
- `docker run --rm php-stakeholder --list-values`
- `docker run --rm php-stakeholder --output-format json --focus-family platform_engineering --seed 123`

## Rationale
- The image syntax-checks and contract-tests the PHP deterministic runtime before exposing the CLI entrypoint.
- Docker is the reproducible Linux gate; host and CI matrices still cover native PHP CLI behavior.
- The first tranche remains provider-free, so provider flags must fail fast inside the image as they do natively.
