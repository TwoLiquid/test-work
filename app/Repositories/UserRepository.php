<?php

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return User::query()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @param User $user
     * @param array|null $params
     * @return Collection|null
     */
    public function getWithFilters(
        User $user,
        ?array $params
    ) : ?Collection
    {
        $user = $user->newQuery();

        if (isset($params['age'])) {
            if (isset($params['age']['from'])) {
                $birthDate = Carbon::now()->addYears(-$params['age']['from']);
                $user->where('data->date_of_birth', '<=', $birthDate->toDateString());
            }

            if (isset($params['age']['to'])) {
                $birthDate = Carbon::now()->addYears(-$params['age']['to']);
                $user->where('data->date_of_birth', '>=', $birthDate->toDateString());
            }
        }

        if (isset($params['gender'])) {
            $user->whereJsonContains('data->gender', $params['gender']);
        }

        if (isset($params['hobby'])) {
            $user->whereJsonContains('data->hobby', $params['hobby']);
        }

        return $user->get();
    }
}
