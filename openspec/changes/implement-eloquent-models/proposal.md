## Why

The TimeBank database schema is fully defined via migrations (skills, service_offers, service_requests, service_matches, transactions, reviews, pivot tables) but only the User model exists. Without Eloquent models and relationships, the application cannot interact with these entities — no CRUD, no domain logic, no API endpoints can be built. Models are the foundational layer required before any controllers, routes, or business logic can be implemented.

## What Changes

- Create Eloquent models: `Skill`, `ServiceOffer`, `ServiceRequest`, `ServiceMatch`, `Transaction`, `Review`
- Create a pivot model for `user_skill` (custom pivot with extra attributes)
- Update `User` model with missing fillable fields (`bio`, `niveau`, `disponiblites`) and all relationships
- Define all model relationships matching the foreign keys in migrations:
  - User ↔ Skill (many-to-many via user_skill)
  - User → ServiceOffer (hasMany)
  - User → ServiceRequest (hasMany)
  - User → ServiceMatch (as helper, requester, and proposed_by)
  - User → Transaction (as from_user and to_user)
  - User → Review (as reviewer and reviewed)
  - Skill → ServiceOffer (hasMany)
  - Skill → ServiceRequest (hasMany)
  - ServiceOffer → ServiceMatch (hasMany)
  - ServiceRequest → ServiceMatch (hasMany)
  - ServiceMatch → Transaction (hasMany)
  - ServiceMatch → Review (hasMany)
- Add missing `bio`, `niveau`, `disponiblites` to User `$fillable`
- Create model factories for all new models
- Add `$casts` and `$hidden` attributes where appropriate

## Capabilities

### New Capabilities
- `user-management`: User model updates — fillable fields (`bio`, `niveau`, `disponiblites`) and all relationships to other entities
- `skill-management`: Skill model with many-to-many relationship to users via custom pivot
- `service-offers`: ServiceOffer model with relationships to user, skill, and service matches
- `service-requests`: ServiceRequest model with relationships to user, skill, and service matches
- `service-matching`: ServiceMatch model linking offers to requests with helper/requester/proposed_by user relationships, durations, and status lifecycle
- `transaction-management`: Transaction model recording hour credits/debits between users per service match
- `review-management`: Review model for rating users after completed service matches

### Modified Capabilities
*(none — all capabilities are new)*

## Impact

- **Models**: 6 new Eloquent models + 1 custom pivot model created
- **User model**: Updated with fillable additions and relationship methods
- **Factories**: New factory classes for each model to support seeding and testing
- **No controllers or routes** are created — this is purely the model layer
- **No migrations** are created — all tables already exist in the schema
