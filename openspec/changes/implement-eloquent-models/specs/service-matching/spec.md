## ADDED Requirements

### Requirement: ServiceMatch model maps to service_matches table
The ServiceMatch model SHALL map to the `service_matches` database table. Fillable attributes SHALL include all columns: `offer_id`, `request_id`, `helper_id`, `requester_id`, `proposed_by`, `message`, `statut`, `scheduled_at`, `session_link`, `platform`, `estimated_duration`, `helper_declared_duration`, `requester_declared_duration`, `actual_duration`, `helper_confirmed_at`, `requester_confirmed_at`.

#### Scenario: ServiceMatch can be created
- **WHEN** creating a ServiceMatch with valid attributes
- **THEN** the record SHALL be persisted to the `service_matches` table

### Requirement: ServiceMatch belongs to a ServiceOffer
The ServiceMatch model SHALL define a `offer()` belongsTo relationship to the ServiceOffer model via `offer_id`.

#### Scenario: ServiceMatch offer can be accessed
- **WHEN** calling `$match->offer`
- **THEN** the associated ServiceOffer model SHALL be returned

### Requirement: ServiceMatch belongs to a ServiceRequest
The ServiceMatch model SHALL define a `request()` belongsTo relationship to the ServiceRequest model via `request_id`.

#### Scenario: ServiceMatch request can be accessed
- **WHEN** calling `$match->request`
- **THEN** the associated ServiceRequest model SHALL be returned

### Requirement: ServiceMatch belongs to a User as helper
The ServiceMatch model SHALL define a `helper()` belongsTo relationship to the User model via `helper_id`.

#### Scenario: ServiceMatch helper can be accessed
- **WHEN** calling `$match->helper`
- **THEN** the helper User model SHALL be returned

### Requirement: ServiceMatch belongs to a User as requester
The ServiceMatch model SHALL define a `requester()` belongsTo relationship to the User model via `requester_id`.

#### Scenario: ServiceMatch requester can be accessed
- **WHEN** calling `$match->requester`
- **THEN** the requester User model SHALL be returned

### Requirement: ServiceMatch belongs to a User as proposed_by
The ServiceMatch model SHALL define a `proposedBy()` belongsTo relationship to the User model via `proposed_by`.

#### Scenario: ServiceMatch proposer can be accessed
- **WHEN** calling `$match->proposedBy`
- **THEN** the proposing User model SHALL be returned

### Requirement: ServiceMatch has many Transactions
The ServiceMatch model SHALL define a `transactions()` hasMany relationship to the Transaction model via `service_match_id`.

#### Scenario: ServiceMatch transactions can be accessed
- **WHEN** calling `$match->transactions`
- **THEN** a Collection of Transaction models for this match SHALL be returned

### Requirement: ServiceMatch has many Reviews
The ServiceMatch model SHALL define a `reviews()` hasMany relationship to the Review model via `service_match_id`.

#### Scenario: ServiceMatch reviews can be accessed
- **WHEN** calling `$match->reviews`
- **THEN** a Collection of Review models for this match SHALL be returned
