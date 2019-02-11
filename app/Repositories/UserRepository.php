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

            if (isset($params['age']['from']) && isset($params['age']['to'])) {
                if ($params['age']['from'] == $params['age']['to']) {
                    $startFrom = Carbon::now()->addYears(-$params['age']['to'] - 1)->toDateString();
                    $endTo = Carbon::now()->addYears(-$params['age']['to'])->toDateString();

                    $user->where('data->date_of_birth', '>=', $startFrom)
                        ->where('data->date_of_birth', '<=', $endTo);
                } else {
                    $birthDateFrom = Carbon::now()->addYears(-$params['age']['from']);
                    $birthDateTo = Carbon::now()->addYears(-$params['age']['to']);

                    $user->where('data->date_of_birth', '<=', $birthDateFrom->format('Y-m-d'))
                        ->where('data->date_of_birth', '>=', $birthDateTo->format('Y-m-d'));
                }
            } else {
                if (isset($params['age']['from'])) {
                    $birthDate = Carbon::now()->addYears(-$params['age']['from']);
                    $user->where('data->date_of_birth', '<=', $birthDate->format('Y-m-d'));
                }

                if (isset($params['age']['to'])) {
                    $birthDate = Carbon::now()->addYears(-$params['age']['to']);
                    $user->where('data->date_of_birth', '>=', $birthDate->format('Y-m-d'));
                }
            }
        }

        if (isset($params['gender'])) {
            $user->whereJsonContains('data->gender', $params['gender']);
        }

        if (isset($params['hobby'])) {
            $user->where(function ($query) use ($params) {
                foreach ($params['hobby'] as $hobby) {
                    $query->orWhereJsonContains('data->hobby', $hobby);
                }
            });
        }

        return $user->get();
    }
}
