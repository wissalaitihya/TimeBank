## ADDED Requirements

### Requirement: Skill model maps to skills table
The Skill model SHALL map to the `skills` database table with fillable attributes: `nom`, `categorie`.

#### Scenario: Skill can be created
- **WHEN** creating a Skill with `nom` and `categorie`
- **THEN** the record SHALL be persisted to the `skills` table

### Requirement: Skill has many-to-many relationship with Users
The Skill model SHALL define a `users()` relationship returning a `BelongsToMany` through the `user_skill` pivot table.

#### Scenario: Skill users can be accessed via relationship
- **WHEN** calling `$skill->users`
- **THEN** a Collection of User models SHALL be returned with pivot data

### Requirement: Skill has many ServiceOffers
The Skill model SHALL define a `serviceOffers()` hasMany relationship to the ServiceOffer model via `skill_id`.

#### Scenario: Skill service offers can be accessed
- **WHEN** calling `$skill->serviceOffers`
- **THEN** a Collection of ServiceOffer models for that skill SHALL be returned

### Requirement: Skill has many ServiceRequests
The Skill model SHALL define a `serviceRequests()` hasMany relationship to the ServiceRequest model via `skill_id`.

#### Scenario: Skill service requests can be accessed
- **WHEN** calling `$skill->serviceRequests`
- **THEN** a Collection of ServiceRequest models for that skill SHALL be returned
