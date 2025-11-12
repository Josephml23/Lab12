<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Nota;
use App\Models\Recordatorio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users
        $user1 = User::create([
            'name' => 'Alice Smith',
            'email' => 'alice@example.com',
            'password' => Hash::make('password'),
        ]);
        $user2 = User::create([
            'name' => 'Bob Johnson',
            'email' => 'bob@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create notes with reminders
        $note1 = Nota::create([
            'user_id' => $user1->id,
            'titulo' => 'Meeting Notes',
            'contenido' => 'Prepare for project meeting.',
        ]);
        $note1->recordatorio()->create([
            'fecha_vencimiento' => Carbon::now()->addDays(2),
        ]);

        $note2 = Nota::create([
            'user_id' => $user1->id,
            'titulo' => 'Grocery List',
            'contenido' => 'Buy milk and eggs.',
        ]);
        $note2->recordatorio()->create([
            'fecha_vencimiento' => Carbon::now()->addHours(5),
        ]);

        // Esta nota no aparecerá debido al global scope
        $note3 = Nota::create([
            'user_id' => $user2->id,
            'titulo' => 'Study Plan',
            'contenido' => 'Review Laravel Eloquent.',
        ]);
        $note3->recordatorio()->create([
            'fecha_vencimiento' => Carbon::now()->subDay(),
            'completado' => true,
        ]);
    }
}