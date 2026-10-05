<?php

namespace Database\Factories;

use App\Models\team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<team>
 */
class TeamFactory extends Factory
{
    protected $model = team::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $events = ['野球', 'サッカー', 'バスケットボール', 'バレーボール', 'テニス', '卓球', 'バドミントン', 'フットサル'];

        return [
            'team_name' => $this->faker->city() . ' ' . $this->faker->randomElement(['クラブ', 'FC', 'ユナイテッド', 'イーグルス', 'スパルタンズ', 'ライオンズ']),
            'event' => $this->faker->randomElement($events),
            'latitude' => $this->faker->latitude(30, 45), // 日本周辺の緯度
            'longitude' => $this->faker->longitude(130, 145), // 日本周辺の経度
            'contact' => $this->faker->phoneNumber(),
        ];
    }
}
