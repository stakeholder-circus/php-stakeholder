  # PHP Toolchain

  - State: scaffold-only next-20 prep
  - Toolchain source: `repair-brew`

  ## Planned commands after promotion
    - `brew reinstall php`
- `brew linkage --test php`
- `php --version`

  ## Scaffold-time checks
  - `python3 scripts/validate_scaffold.py`
  - `/nix/var/nix/profiles/default/bin/nix --extra-experimental-features 'nix-command flakes' flake lock`

  ## Current limitation
  - Current PHP is broken on host; if repair fails in one attempt, replace this repo with objective-c-stakeholder.
