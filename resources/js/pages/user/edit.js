"use strict";

import createUserForm from "@/pages/user/partials/form.js";
import {formValidTypes} from "@/utiles/isayalcintr.js";
import $ from "jquery";
import Swal from "sweetalert2";
import {getUriWithRouteName, PageData} from "@/utiles/config.js";
const KTUserEditPage = function () {
    const cardEl = document.querySelector("#user_edit_card");
    const submitButtonEl = cardEl.querySelector('[data-kt-user-edit-submit-button="true"]');
    const formSelector = "#user_edit_form";
    const userForm = createUserForm({formSelector: formSelector, type: formValidTypes.edit});

    const handleSubmitButtonClick =  (e) => {
        submitButtonEl.addEventListener('click', async (e) => {
            e.preventDefault();
            await userForm.update(PageData.user.id);
        });
    }

    const handleEmitterEvents = () => {
        userForm.emitter.on('update_loading', function (status) {
            if (status){
                $(submitButtonEl).attr('disabled', '');
                cardEl.classList.add("spinner-active");
            }
            else {
                $(submitButtonEl).removeAttr('disabled');
                cardEl.classList.remove("spinner-active");
            }
        });
        userForm.emitter.on('update_error', async (error) => {
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
        userForm.emitter.on('update_success', async (response) => {
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
    KTUserEditPage.init();
});
