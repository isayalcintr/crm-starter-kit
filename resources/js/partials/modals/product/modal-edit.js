import {axios, formValidTypes} from "@/utiles/isayalcintr.js";
import createProductForm from "@/pages/product/partials/form.js";
import $ from "jquery";
import Swal from "sweetalert2";
import {KTModal} from "@/bootstrap.js";

const createModalProductEdit = () => {
    const modalEl = document.querySelector('#modal_product_edit');
    const modal = KTModal.getInstance(modalEl);
    const submitButtonEl = modalEl.querySelector('[data-kt-modal-product-edit-submit-button="true"]');
    const productForm = createProductForm({formSelector: "#modal_product_edit_form", type: formValidTypes.edit});
    let product = 0, parentElement;
    const init = () => {
        handleSubmitButtonClick();
        handleEmitterEvents();
        handleHide();
    };

    const handleSubmitButtonClick =  (e) => {
        submitButtonEl.addEventListener('click', async (e) => {
            e.preventDefault();
            await productForm.update(product);
        });
    }

    const handleHide = (e) => {
        modal.on('hide', (detail) => {
            product = 0;
            parentElement = undefined;
            productForm.setFormData({});
        });
    }

    const handleEmitterEvents = () => {
        productForm.emitter.on('update_loading', function (status) {
            if (status){
                $(submitButtonEl).attr('disabled', '');
                modalEl.querySelector(".modal-content").classList.add("spinner-active");
            }
            else {
                $(submitButtonEl).removeAttr('disabled');
                modalEl.querySelector(".modal-content").classList.remove("spinner-active");
            }
        });
        productForm.emitter.on('update_error', async (error) => {
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
        productForm.emitter.on('update_success', async (response) => {
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
        form: productForm,
        init: init,
        product: product,
        parentElement: parentElement,
        setParentElement: (_parentElement) => {parentElement = _parentElement},
        setProduct: (_product) => {product = _product}
    }
}
export default createModalProductEdit;
