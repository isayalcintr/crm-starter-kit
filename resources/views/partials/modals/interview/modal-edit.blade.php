<div class="modal" data-modal="true" id="modal_interview_edit">
    <div class="use-spinner modal-content modal-center max-w-[600px]">
        <x-spinner.default />
        <div class="modal-header">
            <h3 class="modal-title">
                Görüşme Düzenle
            </h3>
            <button class="btn btn-xs btn-icon btn-light" data-modal-dismiss="true">
                <i class="ki-outline ki-cross">
                </i>
            </button>
        </div>
        <div class="modal-body">
            @include("partials.modals.interview.partials.form", ["id" => "modal_interview_edit_form"])
        </div>
        <div class="modal-footer justify-end">
            <div class="flex gap-4">
                <button class="btn btn-sm btn-clear btn-danger" data-modal-dismiss="true">
                    İptal
                </button>
                <button class="btn btn-sm btn-primary" data-kt-modal-interview-edit-submit-button="true">
                    Kaydet
                </button>
            </div>
        </div>
    </div>
</div>
