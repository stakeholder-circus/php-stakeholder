# PHP Toolchain

- State: deterministic-first local validation complete
- Toolchain source: `brew`

## Native commands
- `brew reinstall php`
- `brew linkage --test php`
- `php --version`
- `python3 scripts/validate_scaffold.py`
- `php -l bin/stakeholder.php`
- `bash tests/test_cli.sh`
- `php bin/stakeholder.php --list-values`

## Docker commands
- `docker build -t php-stakeholder .`
- `docker run --rm php-stakeholder --list-values`
- `docker run --rm php-stakeholder --output-format json --focus-family platform_engineering --seed 123`

## Nix
- `/nix/var/nix/profiles/default/bin/nix --extra-experimental-features 'nix-command flakes' flake lock`
- `/nix/var/nix/profiles/default/bin/nix --extra-experimental-features 'nix-command flakes' flake show`

## Current limitation
- Full live-provider/runtime support is deferred. The deterministic runtime fails fast for provider flags.
