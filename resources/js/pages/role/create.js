"use strict";

import createRoleForm from "@/pages/role/partials/form.js";
import {formValidTypes} from "@/utiles/isayalcintr.js";
import $ from "jquery";
import Swal from "sweetalert2";
import {getUriWithRouteName} from "@/utiles/config.js";
const KTRoleCreatePage = function () {
    const cardEl = document.querySelector("#role_create_card");
    const submitButtonEl = cardEl.querySelector('[data-kt-role-create-submit-button="true"]');
    const formSelector = "#role_create_form";
    const roleForm = createRoleForm({formSelector: formSelector, type: formValidTypes.create});

    const handleSubmitButtonClick =  (e) => {
        submitButtonEl.addEventListener('click', async (e) => {
            e.preventDefault();
            await roleForm.store();
        });
    }

    const handleEmitterEvents = () => {
        roleForm.emitter.on('store_loading', function (status) {
            if (status){
                $(submitButtonEl).attr('disabled', '');
                cardEl.classList.add("spinner-active");
            }
            else {
                $(submitButtonEl).removeAttr('disabled');
                cardEl.classList.remove("spinner-active");
            }
        });

        roleForm.emitter.on('store_error', async (error) => {
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

        roleForm.emitter.on('store_success', async (response) => {
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
                window.location.href = getUriWithRouteName({name: 'role.index'});
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
    KTRoleCreatePage.init();
});
