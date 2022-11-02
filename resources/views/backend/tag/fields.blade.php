@php($tag = isset($tag) ? $tag : null)

<div class="form-row">
    <div class="form-group col-12">
        <label for="subject">Subject:</label>
        <input id="subject" type="text" name="subject"
               class="form-control @error('subject') is-invalid @enderror"
               value="{{ old('subject', $tag ? $tag->subject : '') }}">
        @include('includes.partials.error', ['field' => 'subject'])
    </div>
</div>

<div class="form-group">
    <label>Body</label>
    <h6 class="mb-1">
        Available Placeholders:
        <span class="font-size-sm text-muted font-weight-normal">
            Click on the placeholder to insert in the message builder
        </span>
    </h6>
    <p class="mt-0">
        @foreach(config('constants.tag_placeholders') as $placeholder)
            <span class="badge badge-info px-2 placeholder" style="cursor: pointer">{{ $placeholder }}</span>
        @endforeach
    </p>
    <textarea name="body" class="js-summernote" id="summernote">{{ old('body', $tag ? $tag->body : '') }}</textarea>
    <br>

</div>
