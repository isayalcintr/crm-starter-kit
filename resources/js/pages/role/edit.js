"use strict";

import createRoleForm from "@/pages/role/partials/form.js";
import {formValidTypes} from "@/utiles/isayalcintr.js";
import $ from "jquery";
import Swal from "sweetalert2";
import {getUriWithRouteName, PageData} from "@/utiles/config.js";
const KTRoleEditPage = function () {
    const cardEl = document.querySelector("#role_edit_card");
    const submitButtonEl = cardEl.querySelector('[data-kt-role-edit-submit-button="true"]');
    const formSelector = "#role_edit_form";
    const roleForm = createRoleForm({formSelector: formSelector, type: formValidTypes.edit});

    const handleSubmitButtonClick =  (e) => {
        submitButtonEl.addEventListener('click', async (e) => {
            e.preventDefault();
            await roleForm.update(PageData.role.id);
        });
    }

    const handleEmitterEvents = () => {
        roleForm.emitter.on('update_loading', function (status) {
            if (status){
                $(submitButtonEl).attr('disabled', '');
                cardEl.classList.add("spinner-active");
            }
            else {
                $(submitButtonEl).removeAttr('disabled');
                cardEl.classList.remove("spinner-active");
            }
        });

        roleForm.emitter.on('update_error', async (error) => {
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

        roleForm.emitter.on('update_success', async (response) => {
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
    KTRoleEditPage.init();
});
