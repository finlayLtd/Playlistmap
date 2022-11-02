@php($playlist = isset($playlist) ? $playlist : null)

<div class="form-row">
    <div class="form-group col-6">
        <label for="playlist_id">Playlist ID:</label>
        <input id="playlist_id" type="text" name="playlist_id"
               class="form-control @error('playlist_id') is-invalid @enderror"
               value="{{ old('playlist_id', $playlist ? $playlist->playlist_id : '') }}">
        @include('includes.partials.error', ['field' => 'playlist_id'])
    </div>
    <div class="form-group col-6">
        <label for="user_id">User ID:</label>
        <input id="user_id" type="text" name="user_id"
               class="form-control @error('user_id') is-invalid @enderror"
               value="{{ old('user_id', $playlist ? $playlist->user_id : '') }}">
        @include('includes.partials.error', ['field' => 'user_id'])
    </div>
</div>

<div class="form-row">
    <div class="form-group col-6">
        <label for="name">Name:</label>
        <input id="name" type="text" name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $playlist ? $playlist->name : '') }}">
        @include('includes.partials.error', ['field' => 'name'])
    </div>
    <div class="form-group col-6">
        <label for="number_of_tracks">Number of Tracks:</label>
        <input id="number_of_tracks" type="text" name="number_of_tracks"
               class="form-control @error('number_of_tracks') is-invalid @enderror"
               value="{{ old('number_of_tracks', $playlist ? $playlist->number_of_tracks : '') }}">
        @include('includes.partials.error', ['field' => 'number_of_tracks'])
    </div>
</div>

<div class="form-row">
    <div class="form-group col-4">
        <label for="owner">Owner:</label>
        <input id="owner" type="text" name="owner"
               class="form-control @error('owner') is-invalid @enderror"
               value="{{ old('owner', $playlist ? $playlist->owner : '') }}">
        @include('includes.partials.error', ['field' => 'owner'])
    </div>
    <div class="form-group col-4">
        <label for="contact_email">Contact Email:</label>
        <input id="contact_email" type="text" name="contact_email"
               class="form-control @error('contact_email') is-invalid @enderror"
               value="{{ old('contact_email', $playlist ? $playlist->contact_email : '') }}">
        @include('includes.partials.error', ['field' => 'contact_email'])
    </div>
    <div class="form-group col-4">
        <label for="followers">Followers:</label>
        <input id="followers" type="text" name="followers"
               class="form-control @error('followers') is-invalid @enderror"
               value="{{ old('followers', $playlist ? $playlist->followers : '') }}">
        @include('includes.partials.error', ['field' => 'followers'])
    </div>
</div>
<div class="form-row">
    <div class="form-group col-6">
        <label for="instagram">Instagram:</label>
        <input id="instagram" type="text" name="instagram"
               class="form-control @error('instagram') is-invalid @enderror"
               value="{{ old('instagram', $playlist ? $playlist->instagram : '') }}">
        @include('includes.partials.error', ['field' => 'instagram'])
    </div>
    <div class="form-group col-6">
        <label for="website">Website:</label>
        <input id="website" type="text" name="website"
               class="form-control @error('website') is-invalid @enderror"
               value="{{ old('website', $playlist ? $playlist->website : '') }}">
        @include('includes.partials.error', ['field' => 'website'])
    </div>
</div>
<div class="form-row">
    <div class="form-group col-12">
        <label for="artists">Artists:</label>
        <select id="artists" type="text" name="artists[]" data-role="tagsinput" multiple
                class="form-control @error('artists') is-invalid @enderror">
            @foreach(old('artists', $playlist ? $playlist->artists : array()) as $artist)
                <option value="{{ $artist }}">{{ $artist }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-12">
        <label for="genres">Genres:</label>
        <select id="genres" type="text" name="genres[]" data-role="tagsinput" multiple
                class="form-control @error('genres') is-invalid @enderror">
            @foreach(old('genres', $playlist ? $playlist->genres : array()) as $genre)
                <option value="{{ $genre }}">{{ $genre }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-row mb-3">
    <h6 class="mx-1 mb-1">Moodiness</h6>
    <div class="border p-1 pt-3 pl-0 rounded row mx-1">
        @foreach(\App\Models\Playlist::$moods as $mood => $color)
            <div class="form-group col-4">
                <label for="moodiness_{{$mood}}">{{ ucfirst($mood) }}:</label>
                <input id="moodiness_{{$mood}}" type="text" name="moodiness[{{$mood}}]"
                       class="form-control @error('moodiness.'.$mood) is-invalid @enderror"
                       value="{{ old("moodiness.$mood", $playlist ? $playlist->moodiness[$mood] : '') }}">
                @include('includes.partials.error', ['field' => "moodiness.$mood"])
            </div>
        @endforeach
    </div>
</div>

<div class="form-group">
    <label>Description</label>
    <textarea name="description" class="js-summernote">{{ old('description', $playlist ? $playlist->description : '') }}</textarea>
</div>
