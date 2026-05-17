# PHP Tooling

## Commands
- `php --version`
- `python3 scripts/validate_scaffold.py`
- `php -l bin/stakeholder.php`
- `bash tests/test_cli.sh`
- `php bin/stakeholder.php --list-values`
- `docker build -t php-stakeholder .`
- `docker run --rm php-stakeholder --list-values`

## Extended local checks
- `docker run --rm php-stakeholder --output-format json --focus-family platform_engineering --seed 123`
- `/nix/var/nix/profiles/default/bin/nix --extra-experimental-features 'nix-command flakes' flake show`

## Notes
- The Docker path is the reproducible Linux baseline for this provider-free deterministic tranche.
- Native CI covers Linux and macOS PHP CLI behavior.
- Live-provider/runtime checks are deferred and must fail fast until the provider wave lands.
