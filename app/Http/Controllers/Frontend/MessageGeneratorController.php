<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\Template;
use Illuminate\Http\Request;

class MessageGeneratorController extends Controller
{
    public function index(Playlist $playlist)
    {
        if (!$playlist->isUnlocked()){
            abort(404);
        }
        $template = user()->subscription()->plan->templates()->inRandomOrder()->first();

        $template->body = $this->parse($template->body, $playlist);
        $template->subject =$this->parse($template->subject, $playlist);

        return view('frontend.message_generator', compact('playlist', 'template'));
    }

    public function changeTemplate(Request $request, Playlist $playlist)
    {
        if (!$playlist->isUnlocked()){
            abort(404);
        }

        $template = user()->subscription()->plan->templates()->inRandomOrder()->first();

        return response()->json([
            'message' => $this->parse($template->body, $playlist),
            'subject' => $this->parse($template->subject, $playlist)
        ]);
    }

    private function parse($field, $playlist)
    {
        $replace_data = [
            '%%playlistOwner%%' => $playlist->owner,
            '%%playlistName%%' => $playlist->name,
            '%%userFullName%%' => user()->name,
            '%%playlistURL%%' => "<a href='open.spotify.com/playlist/$playlist->id'>open.spotify.com/playlist/$playlist->id</a>",
            '%trackLink%' => ''
        ];

        return strtr($field, $replace_data);
    }
}
