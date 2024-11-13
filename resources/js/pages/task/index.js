"use strict";

import DataTable from "datatables.net";
import {dataTableTRLang, domLayout} from "@/utiles/datatables.js";
import {findEnumWithValue, getUriWithRouteName} from "@/utiles/config.js";
import {EM, RM} from "@/utiles/isayalcintr.js";
import $ from "jquery";
import createModalTaskEdit from "@/partials/modals/task/modal-edit.js";
import KTDom from "../../../metronic/core/helpers/dom";
import {formatDate} from "@/utiles/format.js";
import {taskCreateModal} from "@/utiles/globalModals.js";

const KTTaskPage = function () {
    const tableEl = document.querySelector("#task_table");
    let dataTable = null;
    let createModal = taskCreateModal;
    let editModal = createModalTaskEdit();

    const initDatatable = () => {
        dataTable = new DataTable(tableEl, {
            responsive: false,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: 'task/list-with-datatable',
                method: 'GET',
                data: function ( data ) {
                    data.search = $('[data-kt-task-table-filter="search"]').val().trim();
                }
            },
            columns:[
                {data:'code', orderable: true},//0
                {data:'customer.title', orderable: true},//1
                {data:'subject', orderable: true},//2
                {data:'start_date', orderable: true},//3
                {data:'end_date', orderable: true},//4
                {data:'category.title', orderable: true},//5
                {data:'incumbent_by', orderable: true},//6
                {data:'special_group1.title', orderable: true},//7
                {data:'special_group2.title', orderable: true},//8
                {data:'special_group3.title', orderable: true},//9
                {data:'special_group4.title', orderable: true},//10
                {data:'priority', orderable: true},//11
                {data:'status', orderable: true},//12
                {data:'created_at', orderable: true},//13
                {data:null, orderable: false},//14
                {data:null, orderable: false}//15
            ],
            columnDefs: [
                {
                    targets: [0,2,5],
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
                    targets: 6,
                    render: function (data, sss, row) {
                        return `<span class="fw-bolder">${data ? row.incumbent.name + ' ' + row.incumbent.surname : '-'}</span>`;
                    }
                },
                {
                    targets: [7,8,9,10],
                    visible: false,
                    render : function (data){
                        return `<span class="fw-bolder">${data ? data : '-'}</span>`;
                    }
                },
                {
                    targets: 11,
                    render: function (data) {
                        const en = findEnumWithValue("TaskPriority", parseInt(data))
                        return en?.badge;
                    }
                },
                {
                    targets: 12,
                    render: function (data) {
                        const en = findEnumWithValue("TaskStatus", parseInt(data))
                        return en?.badge;
                    }
                },
                {
                    targets: [3,4,13],
                    render: (data, sss, row) => {
                        return `<span class="fw-bolder">${data ? formatDate(data, "DD.MM.YYYY") : '-'}</span>`;
                    }
                },
                {
                    targets: 14,
                    render: (data, sss, row) => {
                        return `<a class="btn btn-sm btn-icon btn-clear btn-light"
                                    href="javascript:void(0);"
                                    data-kt-edit-task-button="true"
                                    data-kt-edit-task="${row.id}"
                                    >
                                  <i class="ki-duotone ki-notepad-edit">
                                  </i>
                                 </a>`
                    }
                },
                {
                    targets: 15,
                    render: (data, sss, row) => {
                        return `<a class="btn btn-sm btn-icon btn-clear btn-light" href="javascript:void(0);"
                                                    data-kt-destroy-record-button="true"
                                                    data-kt-destroy-record-uri="${getUriWithRouteName({name: 'task.destroy', params: {task:row.id}})}"
                                                    data-kt-record-manager-parent-el="#task_table"
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
        EM.on(tableEl, '[data-kt-edit-task-button="true"]', 'click', async (e) => {
            e.preventDefault();
            const editButton = e.target.closest('[data-kt-edit-task-button="true"]');
            const task = editButton.getAttribute('data-kt-edit-task');
            if (!task || parseInt(task) < 1) {
                console.error("Invalid task!");
                alert("Task is invalid!")
                return;
            }
            try {
                await editModal.form.edit(parseInt(task));
                editModal.setTask(parseInt(task));
                editModal.modal.show();
            } catch (error) {
                console.error("Error editing task:", error);
                alert("An error occurred while editing the task.");
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
            if (e.parentElement === "#task_table"){
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
    KTTaskPage.init();
});

