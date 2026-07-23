## ADDED Requirements

### Requirement: Transaction model maps to transactions table
The Transaction model SHALL map to the `transactions` database table with fillable attributes: `service_match_id`, `from_user_id`, `to_user_id`, `heures`, `type`, `description`.

#### Scenario: Transaction can be created
- **WHEN** creating a Transaction with valid attributes
- **THEN** the record SHALL be persisted to the `transactions` table

### Requirement: Transaction belongs to a ServiceMatch
The Transaction model SHALL define a `serviceMatch()` belongsTo relationship to the ServiceMatch model via `service_match_id`.

#### Scenario: Transaction service match can be accessed
- **WHEN** calling `$transaction->serviceMatch`
- **THEN** the associated ServiceMatch model SHALL be returned

### Requirement: Transaction belongs to a User as sender
The Transaction model SHALL define a `sender()` belongsTo relationship to the User model via `from_user_id`.

#### Scenario: Transaction sender can be accessed
- **WHEN** calling `$transaction->sender`
- **THEN** the sender User model SHALL be returned

### Requirement: Transaction belongs to a User as receiver
The Transaction model SHALL define a `receiver()` belongsTo relationship to the User model via `to_user_id`.

#### Scenario: Transaction receiver can be accessed
- **WHEN** calling `$transaction->receiver`
- **THEN** the receiver User model SHALL be returned
