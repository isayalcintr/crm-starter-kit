import {axios, formValidTypes} from "@/utiles/isayalcintr.js";
import createProductForm from "@/pages/product/partials/form.js";
import $ from "jquery";
import Swal from "sweetalert2";
import {KTModal} from "@/bootstrap.js";

const createModalProductCreate = () => {
    const modalEl = document.querySelector('#modal_product_create');
    const modal = KTModal.getInstance(modalEl);
    const submitButtonEl = modalEl.querySelector('[data-kt-modal-product-create-submit-button="true"]');
    const productForm = createProductForm({formSelector: "#modal_product_create_form", type: formValidTypes.create});
    let parentElement;
    const init = () => {
        handleSubmitButtonClick();
        handleEmitterEvents();
        handleHide();
    };

    const handleHide = (e) => {
        modal.on('hide', (detail) => {
            parentElement = undefined;
            productForm.setFormData({});
        });
    }

    const handleSubmitButtonClick =  (e) => {
        submitButtonEl.addEventListener('click', async (e) => {
            e.preventDefault();
            await productForm.store();
        });
    }

    const handleEmitterEvents = () => {
        productForm.emitter.on('store_loading', function (status) {
            if (status){
                $(submitButtonEl).attr('disabled', '');
                modalEl.querySelector(".modal-content").classList.add("spinner-active");
            }
            else {
                $(submitButtonEl).removeAttr('disabled');
                modalEl.querySelector(".modal-content").classList.remove("spinner-active");
            }
        });
        productForm.emitter.on('store_error', async (error) => {
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
        productForm.emitter.on('store_success', async (response) => {
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
        form: productForm,
        init: init,
        parentElement: parentElement,
        setParentElement: (_parentElement) => {parentElement = _parentElement},
    }
}
export default createModalProductCreate;
