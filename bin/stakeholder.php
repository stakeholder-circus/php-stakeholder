#!/usr/bin/env php
<?php
declare(strict_types=1);

$classicSix = ['code_analyzer', 'data_processing', 'jargon', 'metrics', 'network_activity', 'system_monitoring'];
$modernCore = ['agent_workflows', 'platform_engineering', 'observability_ai_runtime', 'delivery_preview_ops', 'supply_chain_security'];
$aiGovernance = ['ai_inference_ops', 'evaluation_and_guardrails', 'knowledge_retrieval', 'edge_client_runtime', 'identity_and_trust', 'aibom_provenance', 'agent_boundary_security', 'embedded_agentic_pipeline', 'data_governance_compliance', 'finops_capacity'];
$securityBlockchain = ['blockchain_protocol_ops', 'cross_chain_interop', 'proof_and_sequencer_ops'];
$overlayQuantum = ['hybrid_runtime_ops', 'capacity_cost_controller', 'batch_execution_tuner', 'compiler_maintainer', 'interop_adapter_engineer', 'preflight_capacity_planner', 'simulator_performance_engineer'];
$healthProtocol = ['fhir_profile_generator', 'smart_launch_oauth', 'bulk_fhir_population_ops', 'hl7v2_feed_ops', 'clinical_workflow_events', 'dicomweb_imaging_ops', 'openehr_semantic_record_ops', 'device_telemetry_clinical', 'emr_vendor_adapter', 'ocpp_chargepoint_ops', 'ocpi_roaming_ops', 'mcp_a2a_ops', 'streaming_bus_ops', 'service_mesh_rpc_ops'];
$allFamilies = array_merge($classicSix, $modernCore, $aiGovernance, $securityBlockchain, $overlayQuantum, $healthProtocol);

function registry_id(string $family): string
{
    return str_replace('_', '-', $family);
}

/** @param list<string> $allFamilies */
function normalize_family(?string $value, array $allFamilies): ?string
{
    if ($value === null || trim($value) === '') {
        return null;
    }
    $normalized = str_replace('-', '_', strtolower(trim($value)));
    return in_array($normalized, $allFamilies, true) ? $normalized : null;
}

/**
 * @param list<string> $aiGovernance
 * @param list<string> $securityBlockchain
 * @param list<string> $overlayQuantum
 */
function fallback_group(string $family, array $aiGovernance, array $securityBlockchain, array $overlayQuantum): string
{
    if (in_array($family, $aiGovernance, true)) {
        return 'ai_governance';
    }
    if (in_array($family, $securityBlockchain, true)) {
        return 'security_blockchain';
    }
    if (in_array($family, $overlayQuantum, true)) {
        return 'overlay_quantum';
    }
    return 'health_protocol';
}

/**
 * @param list<string> $aiGovernance
 * @param list<string> $securityBlockchain
 * @param list<string> $overlayQuantum
 * @return array{rendererKey: string, tranche: string, contextKey: string, contextValue: string}
 */
function metadata_for(string $family, array $aiGovernance, array $securityBlockchain, array $overlayQuantum): array
{
    /** @var array<string, array{string, string, string, string}> $dedicated */
    $dedicated = [
        'code_analyzer' => ['classic-six.code_analyzer', 'classic-six', 'analysisFocus', 'php-contract-audit'],
        'data_processing' => ['classic-six.data_processing', 'classic-six', 'dataWindow', 'array-stream-reconciliation'],
        'jargon' => ['classic-six.jargon', 'classic-six', 'languagePolicy', 'php-ecosystem-glossary'],
        'metrics' => ['classic-six.metrics', 'classic-six', 'signalBlend', 'latency-error-throughput'],
        'network_activity' => ['classic-six.network_activity', 'classic-six', 'transportMix', 'http-sse-worker'],
        'system_monitoring' => ['classic-six.system_monitoring', 'classic-six', 'telemetryScope', 'runtime-worker-host'],
        'agent_workflows' => ['modern-core.agent_workflows', 'modern-core', 'coordinationMode', 'web-worker-handoff'],
        'platform_engineering' => ['modern-core.platform_engineering', 'modern-core', 'platformSurface', 'php-release-lane'],
        'observability_ai_runtime' => ['modern-core.observability_ai_runtime', 'modern-core', 'runtimeSignals', 'logs-metrics-traces'],
        'delivery_preview_ops' => ['modern-core.delivery_preview_ops', 'modern-core', 'deliveryGuardrail', 'preview-deploy-checkpoints'],
        'supply_chain_security' => ['modern-core.supply_chain_security', 'modern-core', 'supplyChainPosture', 'composer-package-attestation'],
    ];
    if (array_key_exists($family, $dedicated)) {
        [$renderer, $tranche, $key, $value] = $dedicated[$family];
        return ['rendererKey' => $renderer, 'tranche' => $tranche, 'contextKey' => $key, 'contextValue' => $value];
    }
    $group = fallback_group($family, $aiGovernance, $securityBlockchain, $overlayQuantum);
    return ['rendererKey' => "fallback.$group", 'tranche' => "fallback-$group", 'contextKey' => 'fallbackFamily', 'contextValue' => $group];
}

function deterministic_hash(string $value): int
{
    $hash = 2166136261;
    $bytes = unpack('C*', $value);
    if ($bytes === false) {
        throw new RuntimeException('failed to encode deterministic hash input');
    }
    foreach ($bytes as $byte) {
        $hash ^= $byte;
        $hash = ($hash * 16777619) & 0xffffffff;
    }
    return $hash;
}

function timestamp_for(int $hash): string
{
    $seconds = $hash % 86400;
    return sprintf('2026-01-01T%02d:%02d:%02dZ', intdiv($seconds, 3600), intdiv($seconds % 3600, 60), $seconds % 60);
}

/**
 * @param list<string> $allFamilies
 * @param list<string> $classicSix
 * @param list<string> $modernCore
 * @param list<string> $aiGovernance
 * @param list<string> $securityBlockchain
 * @param list<string> $overlayQuantum
 * @param list<string> $healthProtocol
 */
function list_values_json(array $allFamilies, array $classicSix, array $modernCore, array $aiGovernance, array $securityBlockchain, array $overlayQuantum, array $healthProtocol): string
{
    $families = [];
    foreach ($allFamilies as $family) {
        $meta = metadata_for($family, $aiGovernance, $securityBlockchain, $overlayQuantum);
        $families[] = [
            'id' => $family,
            'registryId' => registry_id($family),
            'rendererKey' => $meta['rendererKey'],
            'tranche' => $meta['tranche'],
        ];
    }
    return encode_json([
        'outputFormats' => ['text', 'json'],
        'flags' => ['list-values', 'focus-family', 'output-format', 'seed', 'experimental-provider'],
        'generatorFamilies' => $families,
        'classicSix' => array_map('registry_id', $classicSix),
        'modernCore' => array_map('registry_id', $modernCore),
        'fallbackFamilies' => array_map('registry_id', array_merge($aiGovernance, $securityBlockchain, $overlayQuantum, $healthProtocol)),
        'implementationMode' => 'family-focus-deterministic',
    ]);
}

/**
 * @param list<string> $aiGovernance
 * @param list<string> $securityBlockchain
 * @param list<string> $overlayQuantum
 * @return array{
 *   eventType: string,
 *   sequence: int,
 *   family: string,
 *   message: string,
 *   timestamp: string,
 *   context: array<string, string>,
 *   generationProvenance: array{
 *     sourceRepo: string,
 *     baseline: string,
 *     experimental: bool,
 *     adapterType: string,
 *     promptVersion: null
 *   },
 *   outputFormat: string
 * }
 */
function payload(string $family, string $seed, string $outputFormat, array $aiGovernance, array $securityBlockchain, array $overlayQuantum): array
{
    $meta = metadata_for($family, $aiGovernance, $securityBlockchain, $overlayQuantum);
    $hash = deterministic_hash("$seed::$family");
    return [
        'eventType' => 'stakeholder.generator.output',
        'sequence' => 1000 + ($hash % 9000),
        'family' => $family,
        'message' => "Deterministic php tranche for $family",
        'timestamp' => timestamp_for($hash),
        'context' => [
            'rendererKey' => $meta['rendererKey'],
            $meta['contextKey'] => $meta['contextValue'],
            'seedFingerprint' => registry_id($family) . '-' . dechex($hash),
            'tranche' => $meta['tranche'],
            'phpProfile' => 'next-20-deterministic-foundation',
        ],
        'generationProvenance' => [
            'sourceRepo' => 'php-stakeholder',
            'baseline' => 'next20-family-focus',
            'experimental' => false,
            'adapterType' => 'static-catalog',
            'promptVersion' => null,
        ],
        'outputFormat' => $outputFormat,
    ];
}

function encode_json(mixed $value): string
{
    return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR) . PHP_EOL;
}

function fail(string $message): int
{
    fwrite(STDERR, $message . PHP_EOL);
    return 2;
}

$focusFamily = null;
$seed = 'default-seed';
$outputFormat = 'text';
$listValues = false;

for ($i = 1; $i < $argc; $i++) {
    $arg = $argv[$i];
    if ($arg === '--list-values') {
        $listValues = true;
    } elseif ($arg === '--focus-family') {
        if (++$i >= $argc) {
            exit(fail('missing value for --focus-family'));
        }
        $focusFamily = normalize_family($argv[$i], $allFamilies);
        if ($focusFamily === null) {
            exit(fail("invalid --focus-family: {$argv[$i]}"));
        }
    } elseif ($arg === '--seed') {
        if (++$i >= $argc) {
            exit(fail('missing value for --seed'));
        }
        $seed = $argv[$i];
    } elseif ($arg === '--output-format') {
        if (++$i >= $argc) {
            exit(fail('missing value for --output-format'));
        }
        $outputFormat = $argv[$i];
        if (!in_array($outputFormat, ['text', 'json'], true)) {
            exit(fail("invalid --output-format: $outputFormat"));
        }
    } elseif ($arg === '--experimental-provider') {
        if (++$i >= $argc) {
            exit(fail('missing value for --experimental-provider'));
        }
        exit(fail("experimental provider '{$argv[$i]}' is not enabled in the deterministic first tranche"));
    } elseif (str_starts_with($arg, '--experimental-')) {
        exit(fail('experimental flags require --experimental-provider'));
    } else {
        exit(fail("unknown argument: $arg"));
    }
}

if ($listValues) {
    echo list_values_json($allFamilies, $classicSix, $modernCore, $aiGovernance, $securityBlockchain, $overlayQuantum, $healthProtocol);
    exit(0);
}

if ($focusFamily === null) {
    exit(fail('focus-family is required and must be a known generator family'));
}

$payload = payload($focusFamily, $seed, $outputFormat, $aiGovernance, $securityBlockchain, $overlayQuantum);
if ($outputFormat === 'json') {
    echo encode_json($payload);
    exit(0);
}

echo 'family: ' . $payload['family'] . PHP_EOL;
echo 'renderer: ' . $payload['context']['rendererKey'] . PHP_EOL;
echo 'tranche: ' . $payload['context']['tranche'] . PHP_EOL;
echo 'sequence: ' . $payload['sequence'] . PHP_EOL;
echo 'timestamp: ' . $payload['timestamp'] . PHP_EOL;
echo 'message: ' . $payload['message'] . PHP_EOL;
