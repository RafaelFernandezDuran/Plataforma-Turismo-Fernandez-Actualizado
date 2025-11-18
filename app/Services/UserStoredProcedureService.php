<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class UserStoredProcedureService
{
    /**
     * Create a user via stored procedure and return the hydrated model.
     *
     * @param  array<string, mixed>  $payload
     */
    public function create(array $payload): User
    {
        $result = DB::select('CALL sp_create_user(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $payload['name'] ?? null,
            $payload['email'] ?? null,
            $payload['password'] ?? null,
            $payload['phone'] ?? null,
            $payload['birth_date'] ?? null,
            $payload['nationality'] ?? null,
            $payload['document_type'] ?? null,
            $payload['document_number'] ?? null,
            $payload['user_type'] ?? null,
            $payload['preferences'] ?? null,
            $payload['opt_out_recommendations'] ?? null,
            $payload['avatar'] ?? null,
            $payload['language'] ?? null,
            $payload['newsletter_subscription'] ?? null,
        ]);

        return $this->hydrateSingleResult($result);
    }

    public function find(int $userId): ?User
    {
        $result = DB::select('CALL sp_get_user(?)', [$userId]);

        return empty($result) ? null : $this->hydrateSingleResult($result);
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public function update(int $userId, array $payload): User
    {
        $result = DB::select('CALL sp_update_user(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $userId,
            $payload['name'] ?? null,
            $payload['email'] ?? null,
            $payload['password'] ?? null,
            $payload['phone'] ?? null,
            $payload['birth_date'] ?? null,
            $payload['nationality'] ?? null,
            $payload['document_type'] ?? null,
            $payload['document_number'] ?? null,
            $payload['user_type'] ?? null,
            $payload['preferences'] ?? null,
            $payload['opt_out_recommendations'] ?? null,
            $payload['avatar'] ?? null,
            $payload['language'] ?? null,
            $payload['newsletter_subscription'] ?? null,
        ]);

        return $this->hydrateSingleResult($result);
    }

    public function delete(int $userId): bool
    {
        $result = DB::select('CALL sp_delete_user(?)', [$userId]);

        if (empty($result)) {
            return false;
        }

        $row = (array) $result[0];

        return (int) ($row['affected_rows'] ?? 0) > 0;
    }

    /**
     * @param  array<int, object>  $result
     */
    private function hydrateSingleResult(array $result): User
    {
        if (empty($result)) {
            throw new RuntimeException('La operación no devolvió información del usuario.');
        }

        return $this->mapRowToModel($result[0]);
    }

    private function mapRowToModel(object $row): User
    {
        $attributes = (array) $row;

        if (array_key_exists('preferences', $attributes) && is_string($attributes['preferences'])) {
            $decoded = json_decode($attributes['preferences'], true);
            $attributes['preferences'] = $decoded ?? $attributes['preferences'];
        }

        $user = new User();
        $user->setRawAttributes($attributes, true);
        $user->exists = true;

        return $user;
    }
}
