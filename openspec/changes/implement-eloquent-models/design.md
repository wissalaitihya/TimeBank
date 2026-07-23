## Context

The TimeBank application has a complete database schema defined across 10 migrations covering users, skills, service offers/requests, matches, transactions, and reviews. Currently only the `User` model exists with no relationships. The rest of the entities have no Eloquent models at all — this is the foundational data access layer needed before any business logic or API can be built.

The database uses MySQL. All foreign keys use `cascadeOnDelete`. The `user_skill` table is a many-to-many pivot with extra attributes (`niveau`, `source`, `confidence_score`). Several tables use soft deletes (`service_offers`, `service_requests`), JSON columns (`disponibilities`, `ai_suggestion`, `tags`), and Laravel enums.

## Goals / Non-Goals

**Goals:**
- Create Eloquent models for: Skill, ServiceOffer, ServiceRequest, ServiceMatch, Transaction, Review
- Create a custom pivot model for `user_skill` with extra attributes
- Update User model: add `bio`, `niveau`, `disponiblites` to `$fillable`; define all relationships
- Define all foreign key relationships as Eloquent relationship methods
- Add proper `$casts`, `$hidden`, and `$guarded` to each model
- Create model factories for all new models for testing and seeding
- Match the exact table/column names from existing migrations

**Non-Goals:**
- No controllers, routes, or API endpoints
- No business logic beyond relationship definitions
- No migration changes (schema is already correct)
- No view or frontend work
- No authentication/authorization logic

## Decisions

### 1. Custom Pivot Model for `user_skill`
- **Decision**: Use `BelongsToMany` with `->using(UserSkill::class)` and `->withPivot(['niveau', 'source', 'confidence_score'])`
- **Rationale**: The pivot table has 3 extra attributes beyond `user_id`/`skill_id`. A custom pivot model allows type casting and direct querying of these fields. The `HasFactory` trait can be added to the pivot for test data.
- **Alternative considered**: Simple `belongsToMany` with `->withPivot()` — rejected because it lacks type casting and factory support for the pivot.

### 2. ServiceMatch User Relationships
- **Decision**: Define 3 separate `belongsTo` relationships on ServiceMatch: `helper()`, `requester()`, `proposedBy()` — each with explicit foreign key and local key.
- **Rationale**: The `service_matches` table has 3 FKs referencing `users` (helper_id, requester_id, proposed_by). Each serves a distinct semantic role. Using descriptive method names ensures clarity in domain logic.

### 3. JSON Column Casts
- **Decision**: Cast JSON columns to `'array'` or `'collection'` in their respective models:
  - `ServiceOffer.disponibilities` → `array`
  - `ServiceRequest.ai_suggestion` → `array`
  - `Review.tags` → `array`
- **Rationale**: These columns store semi-structured data that should be accessed as PHP arrays, not raw strings. Array casting is the standard Laravel approach.

### 4. Enum Casts
- **Decision**: Use native PHP enums or string casts for enum columns depending on complexity. Given the app is early-stage, start with string casts for simplicity and add dedicated enums later if enum logic grows.
- **Rationale**: Laravel's native enum casting requires defining PHP enums for each column. This adds ceremony with no current business logic to put inside the enums. String casts keep things simple during initial development.

### 5. Soft Deletes
- **Decision**: Import `SoftDeletes` trait on ServiceOffer and ServiceRequest models. Include `deleted_at` in casts.
- **Rationale**: Both tables already have `softDeletes()` in their migrations. The trait enables proper soft-delete query scoping.

### 6. Factory per Model
- **Decision**: Create a dedicated Factory class for each new model.
- **Rationale**: Enables rapid prototyping, seeding, and testing. Laravel's factory system integrates with `HasFactory` trait on models.

### 7. Relations on User Model
- **Decision**: Add all relationship methods directly on the User model rather than using traits or a separate relations file.
- **Rationale**: Standard Laravel convention. The number of relationships (~10) is manageable without needing extraction.

## Risks / Trade-offs

| Risk | Mitigation |
|------|------------|
| **Migration typo**: `2026_07_20_104737_create_service_requests_table.php` uses `constained()` instead of `constrained()` | Fix the migration now: rename to `constrained()`. This migration has not been run in production. |
| **Naming collisions**: `disponiblites` (French) and other French column names may cause confusion for English-speaking developers | Accept as-is to match the existing schema. Document in the design and model comments. |
| **Circular references**: ServiceMatch references User, which references ServiceMatch — but these are all eagerly/lazy loaded on demand, not cyclical at the schema level | No circular dependency at the FK level. Standard Laravel relationship loading handles this. |
| **Missing columns in User factory**: `bio`, `niveau`, `disponiblites` not generated | Update UserFactory to include these columns with fake data. |
