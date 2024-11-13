"use strict";

import DataTable from "datatables.net";
import {dataTableTRLang, domLayout} from "@/utiles/datatables.js";
import {findEnumWithName, findEnumWithValue, getUriWithRouteName} from "@/utiles/config.js";
import {axios, EM, RM} from "@/utiles/isayalcintr.js";
import $ from "jquery";
import KTDom from "../../../metronic/core/helpers/dom";
import {formatCurrency, formatDate} from "@/utiles/format.js";
import Swal from "sweetalert2";

const KTOfferPage = function () {
    const tableEl = document.querySelector("#offer_table");
    let dataTable = null;

    const initDatatable = () => {
        dataTable = new DataTable(tableEl, {
            responsive: false,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: 'offer/list-with-datatable',
                method: 'GET',
                data: function ( data ) {
                    data.search = $('[data-kt-offer-table-filter="search"]').val().trim();
                }
            },
            columns:[
                {data:'code', orderable: true},//0
                {data:'customer.title', orderable: true},//1
                {data:'created_by', orderable: true},//2
                {data:'sub_total', orderable: true},//3
                {data:'vat_total', orderable: true},//4
                {data:'total', orderable: true},//5
                {data:'date', orderable: true},//6
                {data:'validity_date', orderable: true},//7
                {data:'special_group1.title', orderable: true},//8
                {data:'special_group2.title', orderable: true},//9
                {data:'special_group3.title', orderable: true},//10
                {data:'special_group4.title', orderable: true},//11
                {data:'stage', orderable: true},//12
                {data:'status', orderable: true},//13
                {data:'created_at', orderable: true},//14
                {data:null, orderable: false},//15
                {data:null, orderable: false},//16
            ],
            columnDefs: [
                {
                    targets: 0,
                    render : function (data){
                        return `<span class="fw-bolder">${data ? data : '-'}</span>`;
                    }
                },
                {
                    targets: 1,
                    render: function (data, sss, row) {
                        console.log(row);
                        return `<span class="fw-bolder">${data ? row.customer.code + '-' + row.customer.title : '-'}</span>`;
                    }
                },
                {
                    targets: 2,
                    render: function (data, sss, row) {
                        return `<span class="fw-bolder">${data ? row.creator?.name + ' ' + row.creator?.surname : '-'}</span>`;
                    }
                },
                {
                    targets: [3, 4, 5],
                    className: 'text-end',
                    render: (data) => {
                        return `<span class="fw-bolder">${formatCurrency(data || 0, 2)}</span>`;
                    }
                },
                {
                    targets: [6,7,14],
                    render: (data, sss, row) => {
                        return `<span class="fw-bolder">${data ? formatDate(data, "DD.MM.YYYY") : '-'}</span>`;
                    }
                },
                {
                    targets: [8,9,10,11],
                    visible: false,
                    render : function (data){
                        return `<span class="fw-bolder">${data ? data : '-'}</span>`;
                    }
                },
                {
                    targets: 12,
                    render: function (data) {
                        const en = findEnumWithValue("OfferStage", parseInt(data))
                        return en?.badge;
                    }
                },
                {
                    targets: 13,
                    render: function (data) {
                        const en = findEnumWithValue("OfferStatus", parseInt(data))
                        return en?.badge;
                    }
                },
                {
                    targets: 15,
                    render: (data, sss, row) => {
                        return `<div class="dropdown" data-dropdown="true" data-dropdown-placement="left-start" data-dropdown-trigger="click">
                                 <button class="dropdown-toggle btn btn-sm btn-icon btn-clear btn-light">
                                  <i class="ki-duotone ki-eye text-primary">
                                  </i>
                                 </button>
                                 <div class="dropdown-content w-full max-w-56 py-2">
                                  <div class="menu menu-default flex flex-col w-full">
                                   <div class="menu-item">
                                    <a class="menu-link" href="#">
                                     <span class="menu-icon">
                                      <i class="ki-duotone ki-eye text-primary">
                                      </i>
                                     </span>
                                     <span class="menu-title">
                                      Görüntüle
                                     </span>
                                    </a>
                                   </div>
                                   <div class="menu-item">
                                    <a class="menu-link" href="#">
                                     <span class="menu-icon">
                                      <i class="ki-outline ki-cloud-download text-warning">
                                      </i>
                                     </span>
                                     <span class="menu-title">
                                      PDF
                                     </span>
                                    </a>
                                   </div><div class="menu-item">
                                    <a class="menu-link" href="#">
                                     <span class="menu-icon">
                                      <i class="ki-outline ki-cloud-download text-warning">
                                      </i>
                                     </span>
                                     <span class="menu-title">
                                      Ön İzle PDF
                                     </span>
                                    </a>
                                   </div>
                                  </div>
                                 </div>
                                </div>`
                    }
                },
                {
                    targets: 16,
                    render: (data, sss, row) => {
                        const statusEn = findEnumWithValue("OfferStatus", parseInt(row.status))
                        const stageEn = findEnumWithValue("OfferStage", parseInt(row.stage))

                        let stageLinks = "";
                        if (stageEn.name === "OFFER"){
                            stageLinks += `
                            <div class="menu-item"  data-kt-offer-change-stage-button="true"
                                                    data-kt-stage="${row.stage}"
                                                    data-kt-target-stage="${findEnumWithName("OfferStage", "APPROVAL").value}"
                                                    data-kt-offer-id="${row.id}">
                                    <a class="menu-link" href="javascript:void(0);"
                                                    >
                                     <span class="menu-icon">
                                      <i class="ki-duotone ki-black-right text-primary">
                                      </i>
                                     </span>
                                     <span class="menu-title">
                                      Onaya Aktar
                                     </span>
                                    </a>
                                   </div>
                            `;
                        }
                        else {
                            stageLinks += `
                            <div class="menu-item">
                                    <a class="menu-link" href="javascript:void(0);"
                                                    data-kt-offer-change-stage-button="true"
                                                    data-kt-stage="${row.stage}"
                                                    data-kt-target-stage="${findEnumWithName("OfferStage", "OFFER").value}"
                                                    data-kt-offer-id="${row.id}">
                                     <span class="menu-icon">
                                      <i class="ki-duotone ki-black-left text-warning">
                                      </i>
                                     </span>
                                     <span class="menu-title">
                                      Teklife Aktar
                                     </span>
                                    </a>
                                   </div>`;
                            if (stageEn.name === "APPROVAL"){
                                stageLinks += `
                                <div class="menu-item">
                                    <a class="menu-link" href="javascript:void(0);"
                                                    data-kt-offer-change-stage-button="true"
                                                    data-kt-stage="${row.stage}"
                                                    data-kt-target-stage="${findEnumWithName("OfferStage", "CUSTOMER_APPROVAL").value}"
                                                    data-kt-offer-id="${row.id}">
                                     <span class="menu-icon">
                                      <i class="ki-duotone ki-black-right text-primary">
                                      </i>
                                     </span>
                                     <span class="menu-title">
                                      M. Onaya Aktar
                                     </span>
                                    </a>
                                   </div>`;
                            }
                            else if (stageEn.name === "CUSTOMER_APPROVAL"){
                                stageLinks += `
                                <div class="menu-item">
                                    <a class="menu-link" href="javascript:void(0);"
                                                    data-kt-offer-change-stage-button="true"
                                                    data-kt-stage="${row.stage}"
                                                    data-kt-target-stage="${findEnumWithName("OfferStage", "ORDER").value}"
                                                    data-kt-offer-id="${row.id}">
                                     <span class="menu-icon">
                                      <i class="ki-duotone ki-check-circle text-success">
                                      </i>
                                     </span>
                                     <span class="menu-title">
                                      Siparişe Aktar
                                     </span>
                                    </a>
                                   </div>`;
                            }
                        }
                        return `<div class="dropdown" data-dropdown="true" data-dropdown-placement="left-start" data-dropdown-trigger="click">
                                 <button class="dropdown-toggle btn btn-sm btn-icon btn-clear btn-light">
                                  <i class="ki-duotone ki-setting-2 text-danger">
                                  </i>
                                 </button>
                                 <div class="dropdown-content w-full max-w-56 py-2">
                                  <div class="menu menu-default flex flex-col w-full">
                                   ${
                                        statusEn.name === "PROCESSING" ? `
                                        ${stageLinks}
                                        <div class="menu-item">
                                            <a class="menu-link" href="javascript:void(0);"
                                                    data-kt-offer-cancel-button="true"
                                                    data-kt-offer-id="${row.id}">
                                             <span class="menu-icon">
                                              <i class="ki-duotone ki-cross-circle text-danger">
                                              </i>
                                             </span>
                                             <span class="menu-title">
                                              İptal Et
                                             </span>
                                            </a>
                                           </div>
                                        `: ''
                                    }
                                   ${
                                        stageEn.name === "OFFER" && statusEn.name === "PROCESSING" ? `
                                        <div class="menu-item">
                                            <a class="menu-link" href="${getUriWithRouteName({name: 'offer.edit', params: {offer:row.id}})}">
                                             <span class="menu-icon">
                                              <i class="ki-duotone ki-notepad-edit text-primary">
                                              </i>
                                             </span>
                                             <span class="menu-title">
                                              Düzenle
                                             </span>
                                            </a>
                                           </div>
                                        `: ''
                                    }
                                   <div class="menu-item">
                                    <a class="menu-link" href="javascript:void(0);"
                                                    data-kt-destroy-record-button="true"
                                                    data-kt-destroy-record-uri="${getUriWithRouteName({name: 'offer.destroy', params: {offer:row.id}})}"
                                                    data-kt-record-manager-parent-el="#offer_table"
                                                    data-kt-record-manager-response-data="${row.id}" >
                                     <span class="menu-icon">
                                      <i class="ki-duotone ki-trash text-danger">
                                      </i>
                                     </span>
                                     <span class="menu-title">
                                      Sil
                                     </span>
                                    </a>
                                   </div>
                                  </div>
                                 </div>
                                </div>`
                    }
                }
            ],
            language: dataTableTRLang,
            dom: domLayout,
        });
    }

    const handleDestroy = () => {
        RM.emitter.on('rm_destroy', (e) => {
            if (e.parentElement === "#offer_table"){
                dataTable.ajax.reload();
            }
        });
    }

    const handleChangeStage = () => {
        //Offer Change Stage Button
        EM.on(tableEl, '[data-kt-offer-change-stage-button="true"]', 'click', async (e) => {
            e.preventDefault();
            const button = e.target.closest('[data-kt-offer-change-stage-button="true"]');
            if (button){
                const offerId = button.getAttribute('data-kt-offer-id') || 0;
                const currentStage = button.getAttribute('data-kt-stage');
                const targetStage = button.getAttribute('data-kt-target-stage');

                const currentStageEn = findEnumWithValue("OfferStage", parseInt(currentStage)),
                    targetStageEn = findEnumWithValue("OfferStage", parseInt(targetStage))

                if (!currentStageEn || !targetStageEn){
                    console.warn("Geçersiz stage!");
                    return;
                }

                await Swal.fire({
                    title: "Teklif Aşama Değiştir",
                    html: "Teklif aşaması, "+currentStageEn.badge+" aşamasından "+targetStageEn.badge+" aşamasına geçirilecek. Emin misiniz? Bu işlemin geri dönüşü olmayabilir!",
                    icon: "warning",
                    confirmButtonText: "Devam Et!",
                    cancelButtonText: "İptal!",
                    showCancelButton: true,
                    customClass: {
                        icon: "rotate-y",
                        confirmButton: "btn-danger",
                    },
                }).then(result => {
                    if (result.isDismissed) {
                        console.log("İşlem iptal edildi.");
                    }
                    else {
                        return axios.put(getUriWithRouteName({ name: 'offer.change.stage', params: {offer: offerId} }), {stage: parseInt(targetStage)})
                            .then(response => {
                                Swal.fire({
                                    title: 'Teklif Aşaması Değiştirildi!',
                                    text: 'İşlem başaralı',
                                    icon: "success",
                                    confirmButtonText: "Tamam!",
                                    showCancelButton: false,
                                    customClass: {
                                        icon: "rotate-y",
                                        confirmButton: "btn-success",
                                    },
                                }).then(() => {
                                    dataTable.ajax.reload();
                                });
                            })
                            .catch(error => {
                                Swal.fire({
                                    title: 'Teklif Aşaması Değiştirilemedi!',
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
                    }
                });
            }
        });
    }

    const handleCancel = () => {
        //Offer Change Stage Button
        EM.on(tableEl, '[data-kt-offer-cancel-button="true"]', 'click', async (e) => {
            e.preventDefault();
            const button = e.target.closest('[data-kt-offer-cancel-button="true"]');
            if (button){
                const offerId = button.getAttribute('data-kt-offer-id') || 0;

                await Swal.fire({
                    title: "Teklif İptal Et",
                    text: "Teklif iptal edilecek. Emin misiniz? Bu işlemin geri dönüşü yoktur!",
                    icon: "warning",
                    confirmButtonText: "Devam Et!",
                    cancelButtonText: "İptal!",
                    showCancelButton: true,
                    customClass: {
                        icon: "rotate-y",
                        confirmButton: "btn-danger",
                    },
                }).then(result => {
                    if (result.isDismissed) {
                        console.log("İşlem iptal edildi.");
                    }
                    else {
                        return axios.patch(getUriWithRouteName({ name: 'offer.cancel', params: {offer: offerId} }))
                            .then(response => {
                                Swal.fire({
                                    title: 'Teklif İptal Edildi!',
                                    text: 'İşlem başaralı',
                                    icon: "success",
                                    confirmButtonText: "Tamam!",
                                    showCancelButton: false,
                                    customClass: {
                                        icon: "rotate-y",
                                        confirmButton: "btn-success",
                                    },
                                }).then(() => {
                                    dataTable.ajax.reload();
                                });
                            })
                            .catch(error => {
                                Swal.fire({
                                    title: 'Teklif İptal Edilemedi!',
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
                    }
                });
            }
        });
    }

    return {
        init: () => {
            initDatatable();
            handleDestroy();
            handleChangeStage();
            handleCancel();
        }
    }
}();

KTDom.ready(() => {
    KTOfferPage.init();
});

