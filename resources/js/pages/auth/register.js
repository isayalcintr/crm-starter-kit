"use strict";
import {axios} from "@/utiles/isayalcintr.js";
import JustValidate from "just-validate";
import Swal from 'sweetalert2';

const KTRegisterPage = function () {
    const formEl = document.querySelector('#register_form');
    let validator = null;

    const handleSubmitForm = () => {
        formEl.addEventListener("submit", async (e) => {
            e.preventDefault();
            const isValid = await validator.validate();

            if (isValid){
                await axios
                    .post('register', (new FormData(formEl)))
                    .then(function (response) {
                        Swal.fire({
                            title: 'Giriş başarılı!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Tamam'
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
            }
            else{
                Swal.fire({
                    title: 'Hata!',
                    text: 'Alanları kontrol edip tekrar deneyiniz!',
                    icon: 'error',
                    confirmButtonText: 'Tamam'
                });
            }
        });
    }


    const initFormValidator = () => {
        validator = (new JustValidate(formEl))
            .addField('input[name="name"]', [
                {
                    rule: 'required',
                    errorMessage: 'Name girilmesi zorunludur!',
                },
                {
                    rule: 'minLength',
                    value: 2,
                    errorMessage: 'Name en az 8 hane olmalıdır!'
                },
            ])
            .addField('input[name="email"]', [
                {
                    rule: 'required',
                    errorMessage: 'Email girilmesi zorunludur!',
                },
                {
                    rule: 'email',
                    errorMessage: 'Email geçerli bir email olmalıdır!',
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
            ])
            .addField('input[name="password_confirmation"]', [
                {
                    rule: 'required',
                    errorMessage: 'Şifre tekrarı girilmesi zorunludur!'
                },
                {
                    rule: 'minLength',
                    value: 8,
                    errorMessage: 'Şifre tekrarı en az 8 hane olmalıdır!'
                },
                {
                    validator: (value, fields) => {
                        if (
                            fields['input[name="password"]'] &&
                            fields['input[name="password"]'].elem
                        ) {
                            const repeatPasswordValue =
                                fields['input[name="password"]'].elem.value;

                            return value === repeatPasswordValue;
                        }
                        return true;
                    },
                    errorMessage: 'Şifreler uyuşmuyor!'
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
    KTRegisterPage().init();
});
