"use strict";

import DataTable from "datatables.net";
import {dataTableTRLang, domLayout} from "@/utiles/datatables.js";
import {findEnumWithValue, getUriWithRouteName} from "@/utiles/config.js";
import {EM, RM} from "@/utiles/isayalcintr.js";
import $ from "jquery";
import createModalProductCreate from "@/partials/modals/product/modal-create.js";
import createModalProductEdit from "@/partials/modals/product/modal-edit.js";
import KTDom from "../../../metronic/core/helpers/dom";
import {formatCurrency, formatDate, formatQuantity} from "@/utiles/format.js";

const KTProductPage = function () {
    const tableEl = document.querySelector("#product_table");
    let dataTable = null;
    let createModal = createModalProductCreate();
    let editModal = createModalProductEdit();
    const initDatatable = () => {
        dataTable = new DataTable(tableEl, {
            responsive: false,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: 'product/list-with-datatable',
                method: 'GET',
                data: function ( data ) {
                    data.search = $('[data-kt-product-table-filter="search"]').val().trim();
                }
            },
            columns:[
                {data:'code', orderable: true},//0
                {data:'name', orderable: true},//1
                {data:'type', orderable: true},//2
                {data:'sell_price', orderable: true},//3
                {data:'purchase_price', orderable: true},//4
                {data:'quantity', orderable: true},//5
                {data:'unit_id', orderable: true},//6
                {data:'special_group1', orderable: true},//7
                {data:'special_group2', orderable: true},//8
                {data:'special_group3', orderable: true},//9
                {data:'special_group4', orderable: true},//10
                {data:'created_at', orderable: true},//11
                {data:null, orderable: false},//12
                {data:null, orderable: false}//13
            ],
            columnDefs: [
                {
                    targets: [0,1],
                    render: (data,sss,row) => {
                        return `<span class="fw-bolder">${data ? data : '-'}</span>`;
                    }
                },
                {
                    targets: 2,
                    render: (data, sss, row) => {
                        const en = findEnumWithValue("ProductType", parseInt(data))
                        return en?.badge;
                    }
                },
                {
                    targets: [3,4],
                    render: (data, sss, row) => {
                        return `<span class="fw-bolder">${data ? formatCurrency(data) : formatCurrency(0)}</span>`;
                    }
                },
                {
                    targets: 5,
                    render: (data, sss, row) => {
                        return `<span class="fw-bolder">${formatQuantity(data, 2)}</span>`
                    }
                },
                {
                    targets: 6,
                    render: (data, sss, row) => {
                        return `<span class="fw-bolder">${data ? row.unit.name : '-'}</span>`;
                    }
                },
                {
                    targets: [7,8,9,10],
                    render: (data, sss, row) => {
                        return `<span class="fw-bolder">${data ? data.title : '-'}</span>`
                    }
                },
                {
                    targets: 11,
                    render: (data, sss, row) => {
                        return `<span class="fw-bolder">${data ? formatDate(data) : '-'}</span>`;
                    }
                },
                {
                    targets: 12,
                    render: (data, sss, row) => {
                        return `<a class="btn btn-sm btn-icon btn-clear btn-light"
                                    href="javascript:void(0);"
                                    data-kt-edit-product-button="true"
                                    data-kt-edit-product="${row.id}"
                                    >
                                  <i class="ki-duotone ki-notepad-edit">
                                  </i>
                                 </a>`
                    }
                },
                {
                    targets: 13,
                    render: (data, sss, row) => {
                        return `<a class="btn btn-sm btn-icon btn-clear btn-light" href="javascript:void(0);"
                                                    data-kt-destroy-record-button="true"
                                                    data-kt-destroy-record-uri="${getUriWithRouteName({name: 'product.destroy', params: {product:row.id}})}"
                                                    data-kt-record-manager-parent-el="#product_table"
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
        EM.on(tableEl, '[data-kt-edit-product-button="true"]', 'click', async (e) => {
            e.preventDefault();
            const editButton = e.target.closest('[data-kt-edit-product-button="true"]');
            const product = editButton.getAttribute('data-kt-edit-product');
            if (!product || parseInt(product) < 1) {
                console.error("Invalid product!");
                alert("Product is invalid!")
                return;
            }
            try {
                await editModal.form.edit(parseInt(product));
                editModal.setProduct(parseInt(product));
                editModal.modal.show();
            } catch (error) {
                console.error("Error editing product:", error);
                alert("An error occurred while editing the product.");
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
            if (e.parentElement === "#product_table"){
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
    KTProductPage.init();
});

