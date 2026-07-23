## ADDED Requirements

### Requirement: ServiceRequest model maps to service_requests table
The ServiceRequest model SHALL map to the `service_requests` database table with fillable attributes: `user_id`, `skill_id`, `titre`, `duree_estimee`, `urgence`, `statut`, `ai_status`, `ai_suggestion`. It SHALL use the `SoftDeletes` trait.

#### Scenario: ServiceRequest can be created
- **WHEN** creating a ServiceRequest with valid attributes
- **THEN** the record SHALL be persisted to the `service_requests` table

### Requirement: ServiceRequest belongs to a User
The ServiceRequest model SHALL define a `user()` belongsTo relationship to the User model via `user_id`.

#### Scenario: ServiceRequest user can be accessed
- **WHEN** calling `$serviceRequest->user`
- **THEN** the requesting User model SHALL be returned

### Requirement: ServiceRequest belongs to a Skill
The ServiceRequest model SHALL define a `skill()` belongsTo relationship to the Skill model via `skill_id`.

#### Scenario: ServiceRequest skill can be accessed
- **WHEN** calling `$serviceRequest->skill`
- **THEN** the associated Skill model SHALL be returned

### Requirement: ServiceRequest has many ServiceMatches
The ServiceRequest model SHALL define a `serviceMatches()` hasMany relationship to the ServiceMatch model via `request_id`.

#### Scenario: ServiceRequest matches can be accessed
- **WHEN** calling `$serviceRequest->serviceMatches`
- **THEN** a Collection of ServiceMatch models for this request SHALL be returned

### Requirement: ServiceRequest ai_suggestion cast to array
The `ai_suggestion` attribute SHALL be cast to `array` for automatic JSON serialization/deserialization.

#### Scenario: Ai_suggestion accessed as array
- **WHEN** accessing `$serviceRequest->ai_suggestion`
- **THEN** the value SHALL be a PHP array
