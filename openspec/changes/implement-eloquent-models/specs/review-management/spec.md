## ADDED Requirements

### Requirement: Review model maps to reviews table
The Review model SHALL map to the `reviews` database table with fillable attributes: `service_match_id`, `reviewer_id`, `reviewed_id`, `note`, `commentaire`, `tags`.

#### Scenario: Review can be created
- **WHEN** creating a Review with valid attributes
- **THEN** the record SHALL be persisted to the `reviews` table

### Requirement: Review belongs to a ServiceMatch
The Review model SHALL define a `serviceMatch()` belongsTo relationship to the ServiceMatch model via `service_match_id`.

#### Scenario: Review service match can be accessed
- **WHEN** calling `$review->serviceMatch`
- **THEN** the associated ServiceMatch model SHALL be returned

### Requirement: Review belongs to a User as reviewer
The Review model SHALL define a `reviewer()` belongsTo relationship to the User model via `reviewer_id`.

#### Scenario: Review reviewer can be accessed
- **WHEN** calling `$review->reviewer`
- **THEN** the reviewer User model SHALL be returned

### Requirement: Review belongs to a User as reviewed
The Review model SHALL define a `reviewed()` belongsTo relationship to the User model via `reviewed_id`.

#### Scenario: Review reviewed user can be accessed
- **WHEN** calling `$review->reviewed`
- **THEN** the reviewed User model SHALL be returned

### Requirement: Review tags cast to array
The `tags` attribute SHALL be cast to `array` for automatic JSON serialization/deserialization.

#### Scenario: Tags accessed as array
- **WHEN** accessing `$review->tags`
- **THEN** the value SHALL be a PHP array
