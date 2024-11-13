"use strict";

import createRoleForm from "@/pages/user/partials/form.js";
import {formValidTypes} from "@/utiles/isayalcintr.js";
import $ from "jquery";
import Swal from "sweetalert2";
import {getUriWithRouteName} from "@/utiles/config.js";
const KTUserCreatePage = function () {
    const cardEl = document.querySelector("#user_create_card");
    const submitButtonEl = cardEl.querySelector('[data-kt-user-create-submit-button="true"]');
    const formSelector = "#user_create_form";
    const userForm = createRoleForm({formSelector: formSelector, type: formValidTypes.create});

    const handleSubmitButtonClick =  (e) => {
        submitButtonEl.addEventListener('click', async (e) => {
            e.preventDefault();
            await userForm.store();
        });
    }

    const handleEmitterEvents = () => {
        userForm.emitter.on('store_loading', function (status) {
            if (status){
                $(submitButtonEl).attr('disabled', '');
                cardEl.classList.add("spinner-active");
            }
            else {
                $(submitButtonEl).removeAttr('disabled');
                cardEl.classList.remove("spinner-active");
            }
        });

        userForm.emitter.on('store_error', async (error) => {
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

        userForm.emitter.on('store_success', async (response) => {
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
                window.location.href = getUriWithRouteName({name: 'user.index'});
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
    KTUserCreatePage.init();
});
