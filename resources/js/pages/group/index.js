"use strict";

import DataTable from "datatables.net";
import {dataTableTRLang, domLayout} from "@/utiles/datatables.js";
import {getUriWithRouteName} from "@/utiles/config.js";
import {EM, RM} from "@/utiles/isayalcintr.js";
import $ from "jquery";
import createModalGroupCreate from "@/partials/modals/group/modal-create.js";
import createModalGroupEdit from "@/partials/modals/group/modal-edit.js";
import KTDom from "../../../metronic/core/helpers/dom";
import {formatDate} from "@/utiles/format.js";

const KTGroupPage = function () {
    const tableEl = document.querySelector("#group_table");
    let dataTable = null;
    let createModal = createModalGroupCreate();
    let editModal = createModalGroupEdit();

    const initDatatable = () => {
        dataTable = new DataTable(tableEl, {
            responsive: false,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: 'group/list-with-datatable',
                method: 'GET',
                data: function ( data ) {
                    data.search = $('[data-kt-group-table-filter="search"]').val().trim();
                }
            },
            columns:[
                {data:'title', orderable: true},
                {data:'section_title', orderable: true},
                {data:'type_title', orderable: true},
                {data:'order', orderable: true},
                {data:'created_at', orderable: true},
                {data:null, orderable: false},
                {data:null, orderable: false}
            ],
            columnDefs: [
                {
                    targets: [0],
                    render : function (data){
                        return `<span class="fw-bolder">${data ? data : '-'}</span>`;
                    }
                },
                {
                    targets: [1 , 2, 3],
                    className: 'mw-150px w-150px min-w-150px',
                    render : function (data){
                        return `<span class="fw-bolder">${data ? data : '-'}</span>`;
                    }
                },
                {
                    targets: 4,
                    render: (data, sss, row) => {
                        return `<span class="fw-bolder">${data ? formatDate(data) : '-'}</span>`;
                    }
                },
                {
                    targets: 5,
                    render: (data, sss, row) => {
                        return `<a class="btn btn-sm btn-icon btn-clear btn-light"
                                    href="javascript:void(0);"
                                    data-kt-edit-group-button="true"
                                    data-kt-edit-group="${row.id}"
                                    >
                                  <i class="ki-duotone ki-notepad-edit">
                                  </i>
                                 </a>`
                    }
                },
                {
                    targets: 6,
                    render: (data, sss, row) => {
                        return `<a class="btn btn-sm btn-icon btn-clear btn-light" href="javascript:void(0);"
                                                    data-kt-destroy-record-button="true"
                                                    data-kt-destroy-record-uri="${getUriWithRouteName({name: 'group.destroy', params: {group:row.id}})}"
                                                    data-kt-record-manager-parent-el="#group_table"
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
        EM.on(tableEl, '[data-kt-edit-group-button="true"]', 'click', async (e) => {
            e.preventDefault();
            const editButton = e.target.closest('[data-kt-edit-group-button="true"]');
            const group = editButton.getAttribute('data-kt-edit-group');
            if (!group || parseInt(group) < 1) {
                console.error("Invalid group!");
                alert("Group is invalid!")
                return;
            }
            try {
                await editModal.form.edit(parseInt(group));
                editModal.setGroup(parseInt(group));
                editModal.modal.show();
            } catch (error) {
                console.error("Error editing group:", error);
                alert("An error occurred while editing the group.");
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
            if (e.parentElement === "#group_table"){
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
    KTGroupPage.init();
});

