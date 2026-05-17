# PHP Edge Cases

- Seeded JSON runs must remain deterministic and byte-stable for a given `--focus-family` and `--seed`.
- Family names accept hyphenated registry IDs and underscore IDs, normalizing both to the same JSON payload.
- Unknown families, unknown flags, and invalid output formats fail fast with a non-zero exit.
- Later families are intentionally grouped through fallback renderers until dedicated second-pass implementations land.
- Experimental live-provider concepts must not affect default deterministic output and currently fail fast through `--experimental-provider`.
