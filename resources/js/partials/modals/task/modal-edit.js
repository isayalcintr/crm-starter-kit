import {axios, formValidTypes} from "@/utiles/isayalcintr.js";
import createTaskForm from "@/pages/task/partials/form.js";
import $ from "jquery";
import Swal from "sweetalert2";
import {KTModal} from "@/bootstrap.js";

const createModalTaskEdit = () => {
    const modalEl = document.querySelector('#modal_task_edit');
    const modal = KTModal.getInstance(modalEl);
    const submitButtonEl = modalEl.querySelector('[data-kt-modal-task-edit-submit-button="true"]');
    const taskForm = createTaskForm({formSelector: "#modal_task_edit_form", type: formValidTypes.edit});
    let task = 0, parentElement;
    const init = () => {
        handleSubmitButtonClick();
        handleEmitterEvents();
        handleHide();
    };

    const handleSubmitButtonClick =  (e) => {
        submitButtonEl.addEventListener('click', async (e) => {
            e.preventDefault();
            await taskForm.update(task);
        });
    }

    const handleHide = (e) => {
        modal.on('hide', (detail) => {
            task = 0;
            parentElement = undefined;
            taskForm.setFormData({});
        });
    }

    const handleEmitterEvents = () => {
        taskForm.emitter.on('update_loading', function (status) {
            if (status){
                $(submitButtonEl).attr('disabled', '');
                modalEl.querySelector(".modal-content").classList.add("spinner-active");
            }
            else {
                $(submitButtonEl).removeAttr('disabled');
                modalEl.querySelector(".modal-content").classList.remove("spinner-active");
            }
        });
        taskForm.emitter.on('update_error', async (error) => {
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
        taskForm.emitter.on('update_success', async (response) => {
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
        form: taskForm,
        init: init,
        task: task,
        parentElement: parentElement,
        setParentElement: (_parentElement) => {parentElement = _parentElement},
        setTask: (_task) => {task = _task}
    }
}
export default createModalTaskEdit;
