<!-- Parent: ../CLAUDE.md -->
<!-- Generated: 2026-02-24 00:00 | Updated: 2026-02-24 00:00 -->
# db

## Purpose
Vendored SleekDB library -- a serverless, file-based NoSQL database that stores data as JSON files. Provides document store, query builder, caching, and CRUD operations. Data is stored in `logs/` directory organized by store name (whiteclicks, blackclicks, leads, lpctr).

## Key Files
| File | Purpose / Responsibility |
|------|--------------------------|
| `SleekDB.php` | Legacy static API facade (deprecated in favor of `Store`) |
| `Store.php` | Primary API: document CRUD, `findBy()`, `findOneBy()`, `insert()`, `update()`, `deleteBy()` |
| `QueryBuilder.php` | Fluent query builder: `where()`, `orderBy()`, `limit()`, `skip()`, `select()` |
| `Query.php` | Query execution engine; runs built queries against the file store |
| `Cache.php` | Query result caching system |

## Subdirectories
| Directory | Purpose |
|-----------|---------|
| `Classes/` | Internal implementation: `IoHelper` (file I/O), `ConditionsHandler` (query conditions), `DocumentFinder`/`DocumentReducer`/`DocumentUpdater` (CRUD ops), `CacheHandler`, `NestedHelper` |
| `Exceptions/` | Exception types: `IOException`, `JsonException`, `IdNotAllowedException`, `InvalidArgumentException`, `InvalidConfigurationException`, `InvalidPropertyAccessException` |

## Claude-specific Guidance

### When Editing Files Here
- This is a vendored library (SleekDB namespace v2.x); avoid modifications
- The application uses `Store` directly, not the legacy `SleekDB` static class
- Data directory is `__DIR__/logs` (relative to YellowCloaker root)
- Each "store" (whiteclicks, blackclicks, leads, lpctr) creates a subdirectory in `logs/`
- Documents are JSON files named by auto-incrementing integer IDs
- No schema enforcement -- documents are schemaless arrays
- Queries use array-based conditions: `[["field", "operator", "value"]]`

### Performance Notes
- SleekDB reads all documents from disk for queries; not suitable for high-traffic production use
- No indexing support -- all queries are full scans
- Consider the `Cache` class for repeated identical queries

<!-- MANUAL SECTION -- preserve on regeneration -->
