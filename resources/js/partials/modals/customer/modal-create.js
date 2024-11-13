import {axios, formValidTypes} from "@/utiles/isayalcintr.js";
import createCustomerForm from "@/pages/customer/partials/form.js";
import $ from "jquery";
import Swal from "sweetalert2";
import {KTModal} from "@/bootstrap.js";

const createModalCustomerCreate = () => {
    const modalEl = document.querySelector('#modal_customer_create');
    const modal = KTModal.getInstance(modalEl);
    const submitButtonEl = modalEl.querySelector('[data-kt-modal-customer-create-submit-button="true"]');
    const customerForm = createCustomerForm({formSelector: "#modal_customer_create_form", type: formValidTypes.create});
    let parentElement;
    const init = () => {
        handleSubmitButtonClick();
        handleEmitterEvents();
        handleHide();
    };

    const handleHide = (e) => {
        modal.on('hide', (detail) => {
            parentElement = undefined;
            customerForm.setFormData({});
        });
    }

    const handleSubmitButtonClick =  (e) => {
        submitButtonEl.addEventListener('click', async (e) => {
            e.preventDefault();
            await customerForm.store();
        });
    }

    const handleEmitterEvents = () => {
        customerForm.emitter.on('store_loading', function (status) {
            if (status){
                $(submitButtonEl).attr('disabled', '');
                modalEl.querySelector(".modal-content").classList.add("spinner-active");
            }
            else {
                $(submitButtonEl).removeAttr('disabled');
                modalEl.querySelector(".modal-content").classList.remove("spinner-active");
            }
        });
        customerForm.emitter.on('store_error', async (error) => {
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
        customerForm.emitter.on('store_success', async (response) => {
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
        modalEl: modalEl,
        form: customerForm,
        init: init,
        parentElement: parentElement,
        setParentElement: (_parentElement) => {parentElement = _parentElement},
    }
}
export default createModalCustomerCreate;
