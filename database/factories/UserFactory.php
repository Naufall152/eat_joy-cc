<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password = null;

    public function definition(): array
    {
        // bikin nickname & username yang "aman" (tanpa spasi/dll)
        $nickname = $this->faker->name();

        $base = Str::of($nickname)
            ->lower()
            ->replace(' ', '')
            ->replace('.', '')
            ->replace('-', '')
            ->toString();

        if ($base === '') {
            $base = 'user';
        }

        // tambahin angka biar unik
        $username = $base . $this->faker->unique()->numberBetween(10, 99999);

        return [
            // ✅ sesuai kolom tabel users kamu
            'nickname' => $nickname,
            'username' => $username,

            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),

            // password default laravel factory style
            'password' => static::$password ??= Hash::make('password123'),
            'remember_token' => Str::random(10),

            // ✅ kolom tambahan yang kamu pakai
            'current_weight' => $this->faker->numberBetween(45, 110),
            'target_weight' => $this->faker->numberBetween(40, 100),

            // kalau kamu punya google_id/avatar, biarin null
            'google_id' => null,
            'avatar' => null,

            // subscription
            'subscription_plan' => $this->faker->randomElement(['free', 'starter', 'starter_plus']),
            'subscription_ends_at' => null,

            // admin flag
            'is_admin' => false,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Opsional: state khusus untuk admin (kalau suatu saat mau factory admin)
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_admin' => true,
            'subscription_plan' => 'starter_plus',
        ]);
    }
}
