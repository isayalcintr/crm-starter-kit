"use strict";

import createRoleForm from "@/pages/service/partials/form.js";
import {formValidTypes} from "@/utiles/isayalcintr.js";
import $ from "jquery";
import Swal from "sweetalert2";
import {getUriWithRouteName, PageData} from "@/utiles/config.js";
const KTServiceEditPage = function () {
    const cardEl = document.querySelector("#service_edit_card");
    const submitButtonEl = cardEl.querySelector('[data-kt-service-edit-submit-button="true"]');
    const formSelector = "#service_edit_form";
    const serviceForm = createRoleForm({formSelector: formSelector, type: formValidTypes.edit});

    const handleSubmitButtonClick =  (e) => {
        submitButtonEl.addEventListener('click', async (e) => {
            e.preventDefault();
            await serviceForm.update(PageData.service.id);
        });
    }

    const handleEmitterEvents = () => {
        serviceForm.emitter.on('update_loading', function (status) {
            if (status){
                $(submitButtonEl).attr('disabled', '');
                cardEl.classList.add("spinner-active");
            }
            else {
                $(submitButtonEl).removeAttr('disabled');
                cardEl.classList.remove("spinner-active");
            }
        });
        serviceForm.emitter.on('update_error', async (error) => {
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
        serviceForm.emitter.on('update_success', async (response) => {
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
                window.location.href = getUriWithRouteName({name: 'service.index'});
            });
        });
    }


    return {
        init: async () => {
            handleSubmitButtonClick();
            handleEmitterEvents();

            const [service, items] = [PageData.service, PageData.items];
            const serviceData = {
                customer_id: service.customer_id,
                start_date: service.start_date,
                end_date: service.end_date,
                status: service.status,
                description: service.description,
                special_group1_id: service.special_group1_id,
                special_group2_id: service.special_group2_id,
                special_group3_id: service.special_group3_id,
                special_group4_id: service.special_group4_id,
                special_group5_id: service.special_group5_id,
                items: items.map(item => {
                    return {
                        id: item.id,
                        product_id: item.product_id,
                        code: item.product.code,
                        name: item.product_name,
                        type: item.product_type,
                        quantity: item.quantity,
                        unit_id: item.unit_id,
                        vat_rate: item.vat_rate,
                        price: item.price,
                        order: item.order
                    }
                })
            };
            serviceForm.setFormData(serviceData);
        }
    };
}();


KTDom.ready(() => {
    KTServiceEditPage.init();
});
