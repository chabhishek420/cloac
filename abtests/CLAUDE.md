<!-- Parent: ../CLAUDE.md -->
<!-- Generated: 2026-02-24 00:00 | Updated: 2026-02-24 00:00 -->
# abtests

## Purpose
A/B testing engine implementing multi-armed bandit strategies for optimizing traffic distribution across landing page variants. Tracks variant performance and adjusts allocation using epsilon-greedy or epsilon-first exploration/exploitation algorithms.

## Key Files
| File | Purpose / Responsibility |
|------|--------------------------|
| `Machine.php` | Main `Machine` class; manages an array of `Lever` objects (variants), runs the selected strategy to pick a winner |
| `Lever.php` | `Lever` value object representing a single A/B test variant with reward tracking |
| `StrategyInterface.php` | Interface for bandit strategy implementations |

## Subdirectories
| Directory | Purpose |
|-----------|---------|
| `Calculator/` | `SplitTestAnalyzer.php` (statistical significance calculator), `Variation.php` (variation stats model) |
| `Strategies/` | Bandit algorithms: `EpsilonGreedy.php` (explore/exploit), `EpsilonFirst.php` (pure explore then exploit) |
| `Math/` | `MersenneTwister.php` (PRNG), `RandomNumberGeneratorInterface.php` |
| `Exceptions/` | `RuntimeException.php` |

## Claude-specific Guidance

### When Editing Files Here
- The A/B test system is used by `abtest.php` in the root to select which landing/prelanding to show
- `Machine` is instantiated with levers (one per variant) and a strategy
- The epsilon-greedy strategy balances exploration (random selection) vs exploitation (best-performing variant)
- `SplitTestAnalyzer` provides Z-test based statistical significance calculations
- This is a self-contained library with no external dependencies

<!-- MANUAL SECTION -- preserve on regeneration -->
