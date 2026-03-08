<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\EventImage;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $wedding = Event::create([
            'title' => 'Weddings',
            'description' => 'Celebrate your big day with elegance and style.',
        ]);

        EventImage::create(['event_id' => $wedding->id, 'image' => 'events/weddings/wedding1.jpg']);
        EventImage::create(['event_id' => $wedding->id, 'image' => 'events/weddings/wedding2.jpg']);
        EventImage::create(['event_id' => $wedding->id, 'image' => 'events/weddings/wedding3.jpg']);
        EventImage::create(['event_id' => $wedding->id, 'image' => 'events/weddings/wedding4.jpg']);
        EventImage::create(['event_id' => $wedding->id, 'image' => 'events/weddings/wedding5.jpg']);
        EventImage::create(['event_id' => $wedding->id, 'image' => 'events/weddings/wedding6.jpg']);

        $birthday = Event::create([
            'title' => 'Birthdays',
            'description' => 'Make your birthdays unforgettable with us.',
        ]);

        EventImage::create(['event_id' => $birthday->id, 'image' => 'events/birthdays/bday1.jpg']);
        EventImage::create(['event_id' => $birthday->id, 'image' => 'events/birthdays/bday2.jpg']);

        $debut = Event::create([
            'title' => 'Debuts',
            'description' => 'A magical celebration for your special day.',
        ]);

        EventImage::create(['event_id' => $debut->id, 'image' => 'events/debuts/debut1.jpg']);
        EventImage::create(['event_id' => $debut->id, 'image' => 'events/debuts/debut2.jpg']);

        $meeting = Event::create([
            'title' => 'Meetings & Seminars',
            'description' => 'Professional spaces for your business needs.',
        ]);

        EventImage::create(['event_id' => $meeting->id, 'image' => 'events/meetings/meeting1.jpg']);

        $convention = Event::create([
            'title' => 'Conventions',
            'description' => 'Spacious venues for conventions and large gatherings.',
        ]);

        EventImage::create(['event_id' => $convention->id, 'image' => 'events/conventions/convention1.jpg']);

        $retreat = Event::create([
            'title' => 'Retreats',
            'description' => 'Peaceful environment for personal and spiritual retreats.',
        ]);

        EventImage::create(['event_id' => $retreat->id, 'image' => 'events/retreats/retreat1.jpg']);
    }
}
