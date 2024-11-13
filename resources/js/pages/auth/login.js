"use strict";
import {axios} from "@/utiles/isayalcintr.js";
import JustValidate from "just-validate";
import Swal from 'sweetalert2';

const KTLoginPage = function () {
    const formEl = document.querySelector('#login_form');
    let validator = null;

    const handleSubmitForm = () => {
        formEl.addEventListener("submit", async (e) => {
            e.preventDefault();
            await axios
                .post('login', (new FormData(formEl)))
                .then(function (response) {
                    Swal.fire({
                        title: 'Giriş başarılı!',
                        text: 'Başarılı şekilde giriş yapıldı!',
                        icon: 'success',
                        confirmButtonText: 'Tamam'
                    }).then(() => {
                        window.location.href = "/";
                    });

                })
                .catch(function (error) {
                    Swal.fire({
                        title: 'Hata!',
                        text: error.response?.data?.message || 'Bir hata oluştu!',
                        icon: 'error',
                        confirmButtonText: 'Tamam'
                    });
                });
        });
    }


    const initFormValidator = () => {
        validator = (new JustValidate(formEl))
            .addField('input[name="email"]', [
                {
                    rule: 'required',
                    errorMessage: 'e-Posta girilmesi zorunludur!',
                },
                {
                    rule: 'email',
                    errorMessage: 'e-Posta geçerli bir email olmalıdır!',
                },
            ])
            .addField('input[name="password"]', [
                {
                    rule: 'required',
                    errorMessage: 'Şifre girilmesi zorunludur!'
                },
                {
                    rule: 'minLength',
                    value: 8,
                    errorMessage: 'Şifre en az 8 hane olmalıdır!'
                },
            ]);
    }

    return {
        init: function () {
            initFormValidator();
            handleSubmitForm();
        }
    }
}

KTDom.ready(() => {
    KTLoginPage().init();
});
