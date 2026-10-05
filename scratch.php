<?php
$users = App\Models\User::factory()->count(10)->create();
foreach($users as $user) {
    Database\Factories\TeamFactory::new()->create(['user_id' => $user->id]);
}
echo "10 users and teams created successfully.\n";
