<!-- Start modal-->
<div wire:ignore.self class="modal custom-modal fade" id="deleteModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    {{ trans('main.Delete') }}
                </h5>
                <button wire:click="closeModal" type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-header">
                    <p>{{ trans('main.Are You Sure Of Deleting..??') }}</p>
                </div>
                <div class="modal-btn delete-action">
                    <form wire:submit.prevent="destroyData" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <button class="destroyBtn btn btn-primary continue-btn">{{ trans('main.Delete') }}</button>
                                </div>
                                <div class="col-6">
                                    <a wire:click="closeModal" href="" data-bs-dismiss="modal" class="btn btn-primary cancel-btn">{{ trans('main.Close') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End modal-->