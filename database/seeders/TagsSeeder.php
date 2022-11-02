<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            "HIP HOP", "R&B", "NATION", "CHILLED", "HOUSE", "LOFI", "LAZY", "RELAXING", "SLEEP", "RAVE", "CHILLS", "TOP", "TRAPICANA", "BASS", "BEST", "FOLK", "2021", "90S", "SELECTS", "CLASSICAL", "KIDS", "EDM", "DEEP", "AESTHETIC", "FELLING", "EDITION", "MINDSET", "BEATS", "DISCO", "MORNING", "ONE HIT", "THROWBACK", "ANALOG", "SUMMER", "WINTER", "CLUB", "JAZZ", "TRANCE", "DREAM", "VIBES", "VIBE", "NEW", "DEEP CUTS", "INDIETRONICA", "RIVER", "RIDE", "LATE", "NIGHTS", "SAD", "HAPPY", "DREAMY", "BEACH", "FROM 1990", "DRINKING", "RAP", "FELLINGS", "URBAN", "MIAMI", "JAPAN", "MIDNIGHT", "AFTER", "VEGAS", "CHILL", "TRAP", "HIPSTER", "POOL", "NEON", "WORKOUT", "TRIPPY", "GUYS", "FESTIVAL", "FUZZ", "DARK", "POP", "LATIN", "UK", "BRAZIL", "HIPHOP", "RANDB", "MIX", "JANUARY", "EVERYDAY", "NIGHT", "AMSTERDAM", "TOMORROWLAND", "UPSTATE", "FEEL", "THROWBACKS", "DISTORTING", "DREAMERS", "BREAK UP", "VIBEZ", "BOUTIQUE", "TURNTABLE", "ALTERNATIVE", "TOP TRACKS", "ELECTRO BEATS", "PSYCHEDELIC", "PIANO", "LOST", "HIGHSCHOOL", "AMERICA", "DAYS", "PERFECT", "GIRL", "ROCKSTAR", "DIRTY", "HAPPINESS", "STUDY", "FELL", "UPBEAT", "GOOD MORNING", "DIGITAL", "UNDERGROUND",
        ];

        foreach ($tags as $tag)
        {
            Tag::create([
                'name' => strtolower($tag)
            ]);
        }
    }
}
