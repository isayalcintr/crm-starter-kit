"use strict";

import DataTable from "datatables.net";
import {dataTableTRLang, domLayout} from "@/utiles/datatables.js";
import {findEnumWithValue, getUriWithRouteName} from "@/utiles/config.js";
import {EM, RM} from "@/utiles/isayalcintr.js";
import $ from "jquery";
import KTDom from "../../../metronic/core/helpers/dom";
import {formatDate} from "@/utiles/format.js";
import {customerCreateModal, customerEditModal} from "@/utiles/globalModals.js";

const KTCustomerPage = function () {
    const tableEl = document.querySelector("#customer_table");
    let dataTable = null;
    let createModal = customerCreateModal;
    let editModal = customerEditModal;

    const initDatatable = () => {
        dataTable = new DataTable(tableEl, {
            responsive: false,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: 'customer/list-with-datatable',
                method: 'GET',
                data: function ( data ) {
                    data.search = $('[data-kt-customer-table-filter="search"]').val().trim();
                }
            },
            columns:[
                {data:'code', orderable: true}, //0
                {data:'title', orderable: true},//1
                {data:'phone1', orderable: true},//2
                {data:'type', orderable: true},//3
                {data:'city', orderable: true},//4
                {data:'tax_number', orderable: true},//5
                {data:'tax_office', orderable: true},//6
                {data:'special_group1', orderable: true},//7
                {data:'special_group2', orderable: true},//8
                {data:'special_group3', orderable: true},//9
                {data:'special_group4', orderable: true},//10
                {data:'special_group5', orderable: true},//11
                {data:'created_at', orderable: true},//12
                {data:null, orderable: false},//13
                {data:null, orderable: false}//14
            ],
            columnDefs: [
                {
                    targets: [0,1,5,6,7,8,9,10,11],
                    render : function (data){
                        return `<span class="fw-bolder">${data ? data : '-'}</span>`;
                    }
                },
                {
                    targets: 2,
                    render: function (data,sss,row){
                        return `<span class="fw-bolder">${row.phone1 ? row.phone1 : '-'} / ${row.phone2 ? row.phone2 : '-'}</span>`;
                    }
                },
                {
                    targets: 3,
                    render: function (data,sss,row){
                        const en = findEnumWithValue("CustomerType", parseInt(data))
                        return en.badge;
                    }
                },
                {
                    targets: 12,
                    render: (data, sss, row) => {
                        return `<span class="fw-bolder">${data ? formatDate(data) : '-'}</span>`;
                    }
                },
                {
                    targets: 13,
                    render: (data, sss, row) => {
                        return `<a class="btn btn-sm btn-icon btn-clear btn-light"
                                    href="javascript:void(0);"
                                    data-kt-edit-customer-button="true"
                                    data-kt-edit-customer="${row.id}"
                                    >
                                  <i class="ki-duotone ki-notepad-edit">
                                  </i>
                                 </a>`
                    }
                },
                {
                    targets: 14,
                    render: (data, sss, row) => {
                        return `<a class="btn btn-sm btn-icon btn-clear btn-light" href="javascript:void(0);"
                                                    data-kt-destroy-record-button="true"
                                                    data-kt-destroy-record-uri="${getUriWithRouteName({name: 'customer.destroy', params: {customer:row.id}})}"
                                                    data-kt-record-manager-parent-el="#customer_table"
                                                    data-kt-record-manager-response-data="${row.id}" >
                                  <i class="ki-duotone ki-trash">
                                  </i>
                                 </a>`
                    }
                }
            ],
            language: dataTableTRLang,
            dom: domLayout,
        });
    }

    const handleEditShowModal = () => {
        EM.on(tableEl, '[data-kt-edit-customer-button="true"]', 'click', async (e) => {
            e.preventDefault();
            const editButton = e.target.closest('[data-kt-edit-customer-button="true"]');
            const customer = editButton.getAttribute('data-kt-edit-customer');
            if (!customer || parseInt(customer) < 1) {
                console.error("Invalid customer!");
                alert("Group is invalid!")
                return;
            }
            try {
                await editModal.form.edit(parseInt(customer));
                editModal.setCustomer(parseInt(customer));
                editModal.modal.show();
            } catch (error) {
                console.error("Error editing customer:", error);
                alert("An error occurred while editing the customer.");
            }
        });
    };

    const handleStore = () => {
        createModal.form.emitter.on('store_success', (e) => {
            dataTable.ajax.reload();
        });
    }


    const handleUpdate = () => {
        editModal.form.emitter.on('update_success', (e) => {
            dataTable.ajax.reload();
        });
    }

    const handleDestroy = () => {
        RM.emitter.on('rm_destroy', (e) => {
            if (e.parentElement === "#customer_table"){
                dataTable.ajax.reload();
            }
        });
    }

    return {
        init: () => {
            initDatatable();
            handleDestroy();
            handleStore();
            handleEditShowModal();
            handleUpdate();
        }
    }
}();

KTDom.ready(() => {
    KTCustomerPage.init();
});

