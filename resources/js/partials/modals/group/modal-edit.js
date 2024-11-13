import {axios, formValidTypes} from "@/utiles/isayalcintr.js";
import createGroupForm from "@/pages/group/partials/form.js";
import $ from "jquery";
import Swal from "sweetalert2";
import {KTModal} from "@/bootstrap.js";

const createModalGroupEdit = () => {
    const modalEl = document.querySelector('#modal_group_edit');
    const modal = KTModal.getInstance(modalEl);
    const submitButtonEl = modalEl.querySelector('[data-kt-modal-group-edit-submit-button="true"]');
    const groupForm = createGroupForm({formSelector: "#modal_group_edit_form", type: formValidTypes.edit});
    let group = 0, parentElement;
    const init = () => {
        handleSubmitButtonClick();
        handleEmitterEvents();
        handleHide();
    };

    const handleSubmitButtonClick =  (e) => {
        submitButtonEl.addEventListener('click', async (e) => {
            e.preventDefault();
            await groupForm.update(group);
        });
    }

    const handleHide = (e) => {
        modal.on('hide', (detail) => {
            group = 0;
            parentElement = undefined;
            groupForm.setFormData({});
        });
    }

    const handleEmitterEvents = () => {
        groupForm.emitter.on('update_loading', function (status) {
            if (status){
                $(submitButtonEl).attr('disabled', '');
                modalEl.querySelector(".modal-content").classList.add("spinner-active");
            }
            else {
                $(submitButtonEl).removeAttr('disabled');
                modalEl.querySelector(".modal-content").classList.remove("spinner-active");
            }
        });
        groupForm.emitter.on('update_error', async (error) => {
            await Swal.fire({
                title: 'Kayıt Eklenemedi!',
                text: error.response && error.response.data?.message ? error.response.data?.message : "Sorry, looks like there are some errors detected, please try again.",
                icon: "error",
                confirmButtonText: 'Tamam!',
                showCancelButton: false,
                customClass: {
                    icon: "rotate-y",
                    confirmButton: "btn-danger"
                },
            });
        });
        groupForm.emitter.on('update_success', async (response) => {
            await Swal.fire({
                title: 'Kayıt Eklendi!',
                text: response.message || 'İşlem başarılı!',
                icon: "success",
                confirmButtonText: 'Tamam!',
                showCancelButton: false,
                customClass: {
                    icon: "rotate-y",
                    confirmButton: "btn-success"
                },
            });
        });
    }

    init();

    return {
        modal: modal,
        modalEl: modalEl,
        form: groupForm,
        init: init,
        group: group,
        parentElement: parentElement,
        setParentElement: (_parentElement) => {parentElement = _parentElement},
        setGroup: (_group) => {group = _group}
    }
}
export default createModalGroupEdit;
