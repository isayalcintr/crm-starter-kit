"use strict";
import createServiceForm from "@/pages/offer/partials/form.js";
import {formValidTypes} from "@/utiles/isayalcintr.js";
import $ from "jquery";
import Swal from "sweetalert2";
import {getUriWithRouteName} from "@/utiles/config.js";
const KTOfferCreatePage = function () {
    const formEl = document.querySelector("#offer_create_form");
    const submitButtonEl = document.querySelector('[data-kt-offer-create-submit-button="true"]');
    const formSelector = "#offer_create_form";
    const offerForm = createServiceForm({formSelector: formSelector, type: formValidTypes.create});

    const handleSubmitButtonClick =  (e) => {
        submitButtonEl.addEventListener('click', async (e) => {
            e.preventDefault();
            await offerForm.store();
        });
    }

    const handleEmitterEvents = () => {
        offerForm.emitter.on('store_loading', function (status) {
            if (status){
                $(submitButtonEl).attr('disabled', '');
                formEl.classList.add("spinner-active");
            }
            else {
                $(submitButtonEl).removeAttr('disabled');
                formEl.classList.remove("spinner-active");
            }
        });

        offerForm.emitter.on('store_error', async (error) => {
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

        offerForm.emitter.on('store_success', async (response) => {
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
            }).then(() => {
                window.location.href = getUriWithRouteName({name: 'offer.index'});
            });
        });
    }



    return {
        init: () => {
            handleSubmitButtonClick();
            handleEmitterEvents();
        }
    };
}();

KTDom.ready(() => {
    KTOfferCreatePage.init();
});
