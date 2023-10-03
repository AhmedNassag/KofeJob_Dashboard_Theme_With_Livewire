<!-- Start Modal -->
<div wire:ignore.self class="modal fade custom-modal" id="editModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">{{ trans('main.Edit') }} {{ trans('main.Category') }}</h4>
                <button wire:click="closeModal" type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <form wire:submit.prevent="updateData" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <!-- name -->
                    <div class="form-group">
                        <label>{{ trans('main.Name') }}</label>
                        <input type="text" class="form-control" wire:model="name" value="{{ old('name') }}" placeholder="{{ trans('main.Name') }}" >
                        @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <!-- photo -->
                    <div class="form-group">
                        <label>{{ trans('main.Photo') }}</label>
                        <input type="file" class="form-control" wire:model="photo" placeholder="{{ trans('main.Photo') }}">
                        @error('photo')<span class="text-danger">{{ $message }}</span>@enderror
                        @if($photo_name)
                            <div class="row">
                                <div class="col-12">
                                    <img class="img-thumbnail m-1" src="{{ asset('attachments/category/'.$photo_name) }}" alt="{{ $photo_name }}" height="100" width="100">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-block">{{ trans('main.Confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
