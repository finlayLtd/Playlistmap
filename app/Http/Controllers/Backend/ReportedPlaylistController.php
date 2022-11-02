<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ReportedPlaylist;
use Illuminate\Http\Request;

class ReportedPlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reportedPlaylists = ReportedPlaylist::paginate(25);
        return view('backend.playlist.reported_playlists', compact('reportedPlaylists'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportedPlaylist  $reportedPlaylist
     * @return \Illuminate\Http\Response
     */
    public function show(ReportedPlaylist $reportedPlaylist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReportedPlaylist $reportedPlaylist
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(ReportedPlaylist $reportedPlaylist)
    {
        $reportedPlaylist->delete();
        return redirect()->back()->with('success', 'Report Deleted Successfully!');
    }
}
