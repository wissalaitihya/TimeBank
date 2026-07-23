## ADDED Requirements

### Requirement: User has fillable attributes for all database columns
The User model SHALL include `bio`, `niveau`, and `disponiblites` in its `$fillable` array in addition to `name`, `email`, and `password`.

#### Scenario: User can be created with all fields
- **WHEN** creating a User with `bio`, `niveau`, and `disponiblites` via mass assignment
- **THEN** all fields SHALL be persisted to the database

### Requirement: User has many-to-many relationship with Skills
The User model SHALL define a `skills()` relationship returning a `BelongsToMany` through the `user_skill` pivot table with pivot attributes `niveau`, `source`, and `confidence_score`.

#### Scenario: User skills can be accessed via relationship
- **WHEN** calling `$user->skills`
- **THEN** a Collection of Skill models SHALL be returned with pivot data

### Requirement: User has many ServiceOffers
The User model SHALL define a `serviceOffers()` hasMany relationship to the ServiceOffer model via `user_id`.

#### Scenario: User service offers can be accessed
- **WHEN** calling `$user->serviceOffers`
- **THEN** a Collection of ServiceOffer models SHALL be returned

### Requirement: User has many ServiceRequests
The User model SHALL define a `serviceRequests()` hasMany relationship to the ServiceRequest model via `user_id`.

#### Scenario: User service requests can be accessed
- **WHEN** calling `$user->serviceRequests`
- **THEN** a Collection of ServiceRequest models SHALL be returned

### Requirement: User has many ServiceMatches as helper
The User model SHALL define a `helperMatches()` hasMany relationship to the ServiceMatch model via `helper_id`.

#### Scenario: User helper matches can be accessed
- **WHEN** calling `$user->helperMatches`
- **THEN** a Collection of ServiceMatch models where user is helper SHALL be returned

### Requirement: User has many ServiceMatches as requester
The User model SHALL define a `requesterMatches()` hasMany relationship to the ServiceMatch model via `requester_id`.

#### Scenario: User requester matches can be accessed
- **WHEN** calling `$user->requesterMatches`
- **THEN** a Collection of ServiceMatch models where user is requester SHALL be returned

### Requirement: User has many ServiceMatches as proposed by
The User model SHALL define a `proposedMatches()` hasMany relationship to the ServiceMatch model via `proposed_by`.

#### Scenario: User proposed matches can be accessed
- **WHEN** calling `$user->proposedMatches`
- **THEN** a Collection of ServiceMatch models proposed by the user SHALL be returned

### Requirement: User has many Transactions as from_user
The User model SHALL define a `sentTransactions()` hasMany relationship to the Transaction model via `from_user_id`.

#### Scenario: User sent transactions can be accessed
- **WHEN** calling `$user->sentTransactions`
- **THEN** a Collection of Transaction models where user is the sender SHALL be returned

### Requirement: User has many Transactions as to_user
The User model SHALL define a `receivedTransactions()` hasMany relationship to the Transaction model via `to_user_id`.

#### Scenario: User received transactions can be accessed
- **WHEN** calling `$user->receivedTransactions`
- **THEN** a Collection of Transaction models where user is the receiver SHALL be returned

### Requirement: User has many Reviews as reviewer
The User model SHALL define a `givenReviews()` hasMany relationship to the Review model via `reviewer_id`.

#### Scenario: User given reviews can be accessed
- **WHEN** calling `$user->givenReviews`
- **THEN** a Collection of Review models written by the user SHALL be returned

### Requirement: User has many Reviews as reviewed
The User model SHALL define a `receivedReviews()` hasMany relationship to the Review model via `reviewed_id`.

#### Scenario: User received reviews can be accessed
- **WHEN** calling `$user->receivedReviews`
- **THEN** a Collection of Review models about the user SHALL be returned
