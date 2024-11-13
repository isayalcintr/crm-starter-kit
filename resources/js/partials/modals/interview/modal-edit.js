import {axios, formValidTypes} from "@/utiles/isayalcintr.js";
import createInterviewForm from "@/pages/interview/partials/form.js";
import $ from "jquery";
import Swal from "sweetalert2";
import {KTModal} from "@/bootstrap.js";

const createModalInterviewEdit = () => {
    const modalEl = document.querySelector('#modal_interview_edit');
    const modal = KTModal.getInstance(modalEl);
    const submitButtonEl = modalEl.querySelector('[data-kt-modal-interview-edit-submit-button="true"]');
    const interviewForm = createInterviewForm({formSelector: "#modal_interview_edit_form", type: formValidTypes.edit});
    let interview = 0, parentElement;
    const init = () => {
        handleSubmitButtonClick();
        handleEmitterEvents();
        handleHide();
    };

    const handleSubmitButtonClick =  (e) => {
        submitButtonEl.addEventListener('click', async (e) => {
            e.preventDefault();
            await interviewForm.update(interview);
        });
    }

    const handleHide = (e) => {
        modal.on('hide', (detail) => {
            interview = 0;
            parentElement = undefined;
            interviewForm.setFormData({});
        });
    }

    const handleEmitterEvents = () => {
        interviewForm.emitter.on('update_loading', function (status) {
            if (status){
                $(submitButtonEl).attr('disabled', '');
                modalEl.querySelector(".modal-content").classList.add("spinner-active");
            }
            else {
                $(submitButtonEl).removeAttr('disabled');
                modalEl.querySelector(".modal-content").classList.remove("spinner-active");
            }
        });
        interviewForm.emitter.on('update_error', async (error) => {
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
        interviewForm.emitter.on('update_success', async (response) => {
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
        form: interviewForm,
        init: init,
        interview: interview,
        parentElement: parentElement,
        setParentElement: (_parentElement) => {parentElement = _parentElement},
        setInterview: (_interview) => {interview = _interview}
    }
}
export default createModalInterviewEdit;
