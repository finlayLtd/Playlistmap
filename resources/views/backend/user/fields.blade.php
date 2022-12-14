@php($user = isset($user) ? $user : null)
<div class="form-row">
    <div class="form-group col-12">
        <label for="name">Name:</label>
        <input id="name" type="text" name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $user ? $user->name : '') }}">
        @include('backend.includes.partials.error', ['field' => 'name'])
    </div>
</div>

<div class="form-row">
    <div class="form-group col-6">
        <label for="email">Email:</label>
        <input id="email" type="email" name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $user ? $user->email : '') }}">
        @include('backend.includes.partials.error', ['field' => 'email'])
    </div>
    <div class="form-group col-6">
        <label for="status">Status:</label>
        <select name="status" id="status" class="form-control">
            @foreach(config('constants.user_statuses') as $key => $status)
                <option value="{{ $key }}" {{ $key == old('status', $user ? $user->status : '') ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
        </select>
        @include('backend.includes.partials.error', ['field' => 'status'])
    </div>
</div>
<div class="form-group">
    <label for="password">New Password:</label>
    <input id="password" type="text" name="password"
           class="form-control @error('password') is-invalid @enderror"
           value="{{ old('password')}}">
    @include('backend.includes.partials.error', ['field' => 'password'])
</div>


<div class="form-row">
    <div class="form-group col-12">
        <label>Profile Image:</label>
        <input type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar">
        @include('backend.includes.partials.error', ['field' => 'avatar'])
        @if($user)
            <div class="my-2">
                <img alt="" class="img-avatar img-avatar128 rounded" src="{{ $user->avatar_url }}" >
            </div>
        @endif
    </div>
</div>
