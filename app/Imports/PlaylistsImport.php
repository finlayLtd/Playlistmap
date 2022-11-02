<?php

namespace App\Imports;

use App\Models\Playlist;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rules\RequiredIf;

class PlaylistsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithCustomCsvSettings {

    use SkipsFailures;

    /**
     * @param array $row
     *
     * @return Playlist
     */
    public function model(array $row) {
        $moodiness = array_merge(...(json_decode($row['moodiness'], true)));

        return new Playlist([
            'playlist_id' => $row['playlist_id'],
            'name' => $row['playlist_name'],
            'description' => $row['playlist_description'],
            'user_id' => $row['user_id'],
            'number_of_tracks' => $row['number_of_tracks'],
            'owner' => $row['owner'],
            'contacts' => json_decode($row['contact'], true),
            'artists' => json_decode($row['artists'], true),
            'followers' => $row['followers'],
            'last_updated_on' => $row['added_date'] ?? null,
            'top_artists' => json_decode($row['top_artists'], true),
            'genres' => array_unique(json_decode($row['genres'], true)),
            'moodiness' => $moodiness,
        ]);
    }

    public function getCsvSettings(): array {
        return [
            'escape_character' => '',
        ];
    }

    public function rules(): array {
        return [
            'playlist_id' => Rule::unique('playlists', 'playlist_id'),
//            'artists' => new RequiredIf($this->row->number_of_tracks == 0),
//            'artists' => 'required|array',
//            'number_of_tracks' => 'required_if:number_of_tracks,==,0|gt:0',
        ];
    }

}
