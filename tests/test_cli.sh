#!/usr/bin/env bash
set -euo pipefail

PHP_BIN="${PHP_BIN:-php bin/stakeholder.php}"
TMPDIR="${TMPDIR:-/tmp}"

$PHP_BIN --list-values >"$TMPDIR/php-list.json"
grep -q '"id": "code_analyzer"' "$TMPDIR/php-list.json"
grep -q '"rendererKey": "modern-core.platform_engineering"' "$TMPDIR/php-list.json"
grep -q '"registryId": "knowledge-retrieval"' "$TMPDIR/php-list.json"

$PHP_BIN --output-format json --focus-family code_analyzer --seed 123 >"$TMPDIR/php-code.json"
grep -q '"family": "code_analyzer"' "$TMPDIR/php-code.json"
grep -q '"rendererKey": "classic-six.code_analyzer"' "$TMPDIR/php-code.json"

$PHP_BIN --output-format json --focus-family platform-engineering --seed 456 >"$TMPDIR/php-platform-a.json"
$PHP_BIN --output-format json --focus-family platform_engineering --seed 456 >"$TMPDIR/php-platform-b.json"
diff -u "$TMPDIR/php-platform-a.json" "$TMPDIR/php-platform-b.json"

$PHP_BIN --output-format json --focus-family ai_inference_ops --seed 7 >"$TMPDIR/php-fallback.json"
grep -q '"rendererKey": "fallback.ai_governance"' "$TMPDIR/php-fallback.json"

if $PHP_BIN --experimental-provider local-demo >"$TMPDIR/php-exp.out" 2>"$TMPDIR/php-exp.err"; then
  echo "expected experimental-provider fail-fast" >&2
  exit 1
fi
grep -qi 'experimental provider' "$TMPDIR/php-exp.err"
