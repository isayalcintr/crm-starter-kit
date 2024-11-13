"use strict";

import DataTable from "datatables.net";
import {dataTableTRLang, domLayout} from "@/utiles/datatables.js";
import {getUriWithRouteName} from "@/utiles/config.js";
import {EM, RM} from "@/utiles/isayalcintr.js";
import $ from "jquery";
import createModalInterviewEdit from "@/partials/modals/interview/modal-edit.js";
import KTDom from "../../../metronic/core/helpers/dom";
import {formatDate} from "@/utiles/format.js";
import {interviewCreateModal} from "@/utiles/globalModals.js";

const KTIInterviewPage = function () {
    const tableEl = document.querySelector("#interview_table");
    let dataTable = null;
    let createModal = interviewCreateModal;
    let editModal = createModalInterviewEdit();

    const initDatatable = () => {
        dataTable = new DataTable(tableEl, {
            responsive: false,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: 'interview/list-with-datatable',
                method: 'GET',
                data: function ( data ) {
                    data.search = $('[data-kt-interview-table-filter="search"]').val().trim();
                }
            },
            columns:[
                {data:'code', orderable: true},//0
                {data:'customer.title', orderable: true},//1
                {data:'subject', orderable: true},//2
                {data:'category.title', orderable: true},//3
                {data:'type.title', orderable: true},//4
                {data:'creator', orderable: true},//5
                {data:'special_group1.title', orderable: true},//6
                {data:'special_group2.title', orderable: true},//7
                {data:'special_group3.title', orderable: true},//8
                {data:'special_group4.title', orderable: true},//9
                {data:'created_at', orderable: true},//10
                {data:null, orderable: false},//11
                {data:null, orderable: false}//12
            ],
            columnDefs: [
                {
                    targets: [0,2,3,4,6,7,8,9],
                    render : function (data){
                        return `<span class="fw-bolder">${data ? data : '-'}</span>`;
                    }
                },
                {
                    targets: 1,
                    render: function (data, sss, row) {
                        return `<span class="fw-bolder">${data ? data.code + '-' + data.title : '-'}</span>`;
                    }
                },
                {
                    targets: 5,
                    render: function (data) {
                        return `<span class="fw-bolder">${data ? data.name + ' ' + data.surname : '-'}</span>`;
                    }
                },
                {
                    targets: 10,
                    render: (data, sss, row) => {
                        return `<span class="fw-bolder">${data ? formatDate(data) : '-'}</span>`;
                    }
                },
                {
                    targets: 11,
                    render: (data, sss, row) => {
                        return `<a class="btn btn-sm btn-icon btn-clear btn-light"
                                    href="javascript:void(0);"
                                    data-kt-edit-interview-button="true"
                                    data-kt-edit-interview="${row.id}"
                                    >
                                  <i class="ki-duotone ki-notepad-edit">
                                  </i>
                                 </a>`
                    }
                },
                {
                    targets: 12,
                    render: (data, sss, row) => {
                        return `<a class="btn btn-sm btn-icon btn-clear btn-light" href="javascript:void(0);"
                                                    data-kt-destroy-record-button="true"
                                                    data-kt-destroy-record-uri="${getUriWithRouteName({name: 'interview.destroy', params: {interview:row.id}})}"
                                                    data-kt-record-manager-parent-el="#interview_table"
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
        EM.on(tableEl, '[data-kt-edit-interview-button="true"]', 'click', async (e) => {
            e.preventDefault();
            const editButton = e.target.closest('[data-kt-edit-interview-button="true"]');
            const interview = editButton.getAttribute('data-kt-edit-interview');
            if (!interview || parseInt(interview) < 1) {
                console.error("Invalid interview!");
                alert("Interview is invalid!")
                return;
            }
            try {
                await editModal.form.edit(parseInt(interview));
                editModal.setInterview(parseInt(interview));
                editModal.modal.show();
            } catch (error) {
                console.error("Error editing interview:", error);
                alert("An error occurred while editing the interview.");
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
            if (e.parentElement === "#interview_table"){
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
    KTIInterviewPage.init();
});

