<?php

namespace App\Exports;

use App\Models\Playlist;
use Maatwebsite\Excel\Concerns\FromCollection;

class PlaylistsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Playlist::all();
    }
}
