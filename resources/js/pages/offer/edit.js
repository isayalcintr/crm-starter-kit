"use strict";

import createRoleForm from "@/pages/offer/partials/form.js";
import {formValidTypes} from "@/utiles/isayalcintr.js";
import $ from "jquery";
import Swal from "sweetalert2";
import {getUriWithRouteName, PageData} from "@/utiles/config.js";
const KTOfferEditPage = function () {
    const cardEl = document.querySelector("#offer_edit_card");
    const submitButtonEl = cardEl.querySelector('[data-kt-offer-edit-submit-button="true"]');
    const formSelector = "#offer_edit_form";
    const offerForm = createRoleForm({formSelector: formSelector, type: formValidTypes.edit});

    const handleSubmitButtonClick =  (e) => {
        submitButtonEl.addEventListener('click', async (e) => {
            e.preventDefault();
            await offerForm.update(PageData.offer.id);
        });
    }

    const handleEmitterEvents = () => {
        offerForm.emitter.on('update_loading', function (status) {
            if (status){
                $(submitButtonEl).attr('disabled', '');
                cardEl.classList.add("spinner-active");
            }
            else {
                $(submitButtonEl).removeAttr('disabled');
                cardEl.classList.remove("spinner-active");
            }
        });
        offerForm.emitter.on('update_error', async (error) => {
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
        offerForm.emitter.on('update_success', async (response) => {
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
        init: async () => {
            handleSubmitButtonClick();
            handleEmitterEvents();

            const [offer, items] = [PageData.offer, PageData.items];
            const offerData = {
                customer_id: offer.customer_id,
                date: offer.start_date,
                validity_date: offer.validity_date,
                description: offer.description,
                special_group1_id: offer.special_group1_id,
                special_group2_id: offer.special_group2_id,
                special_group3_id: offer.special_group3_id,
                special_group4_id: offer.special_group4_id,
                special_group5_id: offer.special_group5_id,
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
                        discount1: item.discount1,
                        discount2: item.discount2,
                        discount3: item.discount3,
                        discount4: item.discount4,
                        discount5: item.discount5,
                        discount1_price: item.discount1_price,
                        discount2_price: item.discount2_price,
                        discount3_price: item.discount3_price,
                        discount4_price: item.discount4_price,
                        discount5_price: item.discount5_price,
                        order: item.order
                    }
                })
            };
            offerForm.setFormData(offerData);
        }
    };
}();


KTDom.ready(() => {
    KTOfferEditPage.init();
});
