<div class="modal fade border-0" id="import_from_csv">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form action="{{ route('backend.playlists.import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="csv">Select File:</label>
                            <input id="csv" type="file" name="csv"
                                   class="form-control @error('name') is-invalid @enderror">
                            @include('includes.partials.error', ['field' => 'csv'])
                        </div>
                    </div>
                    <div class="float-right">
                        <button type="submit" class="btn btn-sm btn-success">Import</button>
                        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
