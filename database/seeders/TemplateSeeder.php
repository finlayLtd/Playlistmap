<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templates = array(
            [
                'subject' => 'I Like your Playlist %%playlistName%%',
                'body' => "<p>Hey %%playlistOwner%%,</p><p>Hope you're well. I just discovered your playlist %%UserFullName%% and I'm a huge fan!.</p><p>After listening to a few tracks on your playlist, I felt like my latest track could be a perfect fit for it and I'll appreciate it if you'll give it a listen and hopefully a chance to get into your playlist.!</p><p>It sounds similar to artists who you've also featured on your playlist.</p><p><b>You can listen here:&nbsp;</b>%%trackLink%%&nbsp;</p><p>I'd love to hear your thought about this one!</p><p>Kind regards,&nbsp;</p><p>%%UserFullName%%&nbsp;</p>"
            ],
            [
                'subject' => 'A quick question About your Playlist %%playlistName%%',
                'body' => '<p><font color="#000000" face="Arial"><span style="font-size: 14.6667px; white-space: pre-wrap;">Hey, Nice to meet you My name is %%UserFullName%% </span></font></p><p><font color="#000000" face="Arial"><span style="font-size: 14.6667px; white-space: pre-wrap;">I came across your playlist %%playlistName%%  and i really like the vibes of the songs, i wanted to ask if you are adding new music?</span></font></p><p><font color="#000000" face="Arial"><span style="font-size: 14.6667px; white-space: pre-wrap;">If you\'re updating the playlist, I \'d happy if you will listen to my latest track, and if you like it you hopefully add it to your playlist</span></font></p><p><font color="#000000" face="Arial"><span style="font-size: 14.6667px; white-space: pre-wrap;">here is a link to my lates track :</span></font></p><p><font color="#000000" face="Arial"><span style="font-size: 14.6667px; white-space: pre-wrap;">%%trackLink%%</span></font></p><p><font color="#000000" face="Arial"><span style="font-size: 14.6667px; white-space: pre-wrap;">I really appreciate your time!</span></font></p><p><font color="#000000" face="Arial"><span style="font-size: 14.6667px; white-space: pre-wrap;">Kind regards,</span></font></p><p><font color="#000000" face="Arial"><span style="font-size: 14.6667px; white-space: pre-wrap;">%%UserFullName%%</span></font>&nbsp;<br></p>'
            ]
        );

        foreach ($templates as $template) {
            Template::create($template);
        }
    }
}
