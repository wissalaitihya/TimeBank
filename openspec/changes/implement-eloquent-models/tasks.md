## 1. Fix Migration Typo

- [ ] 1.1 Fix `constained()` → `constrained()` in `2026_07_20_104737_create_service_requests_table.php`

## 2. Update User Model

- [ ] 2.1 Add `bio`, `niveau`, `disponiblites` to User `$fillable`
- [ ] 2.2 Define User relationships: `skills()` (BelongsToMany via user_skill), `serviceOffers()`, `serviceRequests()`, `helperMatches()`, `requesterMatches()`, `proposedMatches()`, `sentTransactions()`, `receivedTransactions()`, `givenReviews()`, `receivedReviews()`

## 3. Create UserSkill Pivot Model

- [ ] 3.1 Create `App\Models\UserSkill` extending `Pivot` with `HasFactory`
- [ ] 3.2 Add fillable: `user_id`, `skill_id`, `niveau`, `source`, `confidence_score`
- [ ] 3.3 Add casts for `confidence_score` (decimal)

## 4. Create Skill Model

- [ ] 4.1 Create `App\Models\Skill` with `HasFactory`
- [ ] 4.2 Add fillable: `nom`, `categorie`
- [ ] 4.3 Define relationships: `users()` (BelongsToMany via user_skill using UserSkill pivot), `serviceOffers()`, `serviceRequests()`

## 5. Create ServiceOffer Model

- [ ] 5.1 Create `App\Models\ServiceOffer` with `HasFactory` and `SoftDeletes`
- [ ] 5.2 Add fillable: `user_id`, `skill_id`, `titre`, `description`, `duree_estimee`, `disponibilities`, `statut`
- [ ] 5.3 Add casts: `disponibilities` → `array`, `duree_estimee` → `decimal:2`
- [ ] 5.4 Define relationships: `user()`, `skill()`, `serviceMatches()`

## 6. Create ServiceRequest Model

- [ ] 6.1 Create `App\Models\ServiceRequest` with `HasFactory` and `SoftDeletes`
- [ ] 6.2 Add fillable: `user_id`, `skill_id`, `titre`, `duree_estimee`, `urgence`, `statut`, `ai_status`, `ai_suggestion`
- [ ] 6.3 Add casts: `ai_suggestion` → `array`, `duree_estimee` → `decimal:2`
- [ ] 6.4 Define relationships: `user()`, `skill()`, `serviceMatches()`

## 7. Create ServiceMatch Model

- [ ] 7.1 Create `App\Models\ServiceMatch` with `HasFactory`
- [ ] 7.2 Add fillable: `offer_id`, `request_id`, `helper_id`, `requester_id`, `proposed_by`, `message`, `statut`, `scheduled_at`, `session_link`, `platform`, `estimated_duration`, `helper_declared_duration`, `requester_declared_duration`, `actual_duration`, `helper_confirmed_at`, `requester_confirmed_at`
- [ ] 7.3 Add casts for all duration/decimal fields
- [ ] 7.4 Define relationships: `offer()`, `request()`, `helper()`, `requester()`, `proposedBy()`, `transactions()`, `reviews()`

## 8. Create Transaction Model

- [ ] 8.1 Create `App\Models\Transaction` with `HasFactory`
- [ ] 8.2 Add fillable: `service_match_id`, `from_user_id`, `to_user_id`, `heures`, `type`, `description`
- [ ] 8.3 Add casts: `heures` → `decimal:2`
- [ ] 8.4 Define relationships: `serviceMatch()`, `sender()`, `receiver()`

## 9. Create Review Model

- [ ] 9.1 Create `App\Models\Review` with `HasFactory`
- [ ] 9.2 Add fillable: `service_match_id`, `reviewer_id`, `reviewed_id`, `note`, `commentaire`, `tags`
- [ ] 9.3 Add casts: `tags` → `array`, `note` → `integer`
- [ ] 9.4 Define relationships: `serviceMatch()`, `reviewer()`, `reviewed()`

## 10. Create Model Factories

- [ ] 10.1 Create `SkillFactory` with `nom` and `categorie` definitions
- [ ] 10.2 Create `ServiceOfferFactory` with full attribute definitions
- [ ] 10.3 Create `ServiceRequestFactory` with full attribute definitions
- [ ] 10.4 Create `ServiceMatchFactory` with full attribute definitions
- [ ] 10.5 Create `TransactionFactory` with full attribute definitions
- [ ] 10.6 Create `ReviewFactory` with full attribute definitions
- [ ] 10.7 Update `UserFactory` to include `bio`, `niveau`, `disponiblites`
- [ ] 10.8 Update `DatabaseSeeder` to seed skills, service offers, and related data

## 11. Verify Implementation

- [ ] 11.1 Run `php artisan migrate:fresh` to verify schema matches models
- [ ] 11.2 Run `php artisan tinker` and test all relationships with factory data
- [ ] 11.3 Run `php artisan test` to ensure no regressions
