## ADDED Requirements

### Requirement: ServiceOffer model maps to service_offers table
The ServiceOffer model SHALL map to the `service_offers` database table with fillable attributes: `user_id`, `skill_id`, `titre`, `description`, `duree_estimee`, `disponibilities`, `statut`. It SHALL use the `SoftDeletes` trait.

#### Scenario: ServiceOffer can be created
- **WHEN** creating a ServiceOffer with valid attributes
- **THEN** the record SHALL be persisted to the `service_offers` table

### Requirement: ServiceOffer belongs to a User
The ServiceOffer model SHALL define a `user()` belongsTo relationship to the User model via `user_id`.

#### Scenario: ServiceOffer user can be accessed
- **WHEN** calling `$serviceOffer->user`
- **THEN** the owning User model SHALL be returned

### Requirement: ServiceOffer belongs to a Skill
The ServiceOffer model SHALL define a `skill()` belongsTo relationship to the Skill model via `skill_id`.

#### Scenario: ServiceOffer skill can be accessed
- **WHEN** calling `$serviceOffer->skill`
- **THEN** the associated Skill model SHALL be returned

### Requirement: ServiceOffer has many ServiceMatches
The ServiceOffer model SHALL define a `serviceMatches()` hasMany relationship to the ServiceMatch model via `offer_id`.

#### Scenario: ServiceOffer matches can be accessed
- **WHEN** calling `$serviceOffer->serviceMatches`
- **THEN** a Collection of ServiceMatch models for this offer SHALL be returned

### Requirement: ServiceOffer disponibilities cast to array
The `disponibilities` attribute SHALL be cast to `array` for automatic JSON serialization/deserialization.

#### Scenario: Disponibilities accessed as array
- **WHEN** accessing `$serviceOffer->disponibilities`
- **THEN** the value SHALL be a PHP array
