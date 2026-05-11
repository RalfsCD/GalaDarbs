<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstNames = ['Anna', 'Alise', 'Janis', 'Eva', 'Martins', 'Laura', 'Markus', 'Elina', 'Roberts', 'Krista'];
        $lastNames = ['Berzins', 'Ozols', 'Kalnins', 'Lacis', 'Ziedins', 'Krumins', 'Petersone', 'Bergs', 'Vitolins', 'Dumbrava'];
        $domains = ['example.com', 'test.lv', 'mail.test', 'demo.local'];
        $name = $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];

        return [
            'name' => $name,
            'email' => Str::lower(Str::slug($name, '.')) . '+' . Str::random(5) . '@' . $domains[array_rand($domains)],
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
