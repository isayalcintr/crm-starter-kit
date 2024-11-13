"use strict";

import DataTable from "datatables.net";
import {dataTableTRLang, domLayout} from "@/utiles/datatables.js";
import {getUriWithRouteName} from "@/utiles/config.js";
import {RM} from "@/utiles/isayalcintr.js";
import $ from "jquery";
import KTDom from "../../../metronic/core/helpers/dom";
import {formatDate} from "@/utiles/format.js";

const KTUserPage = function () {
    const tableEl = document.querySelector("#user_table");
    let dataTable = null;

    const initDatatable = () => {
        dataTable = new DataTable(tableEl, {
            responsive: false,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: 'user/list-with-datatable',
                method: 'GET',
                data: function ( data ) {
                    data.search = $('[data-kt-user-table-filter="search"]').val().trim();
                }
            },
            columns:[
                {data:'name', orderable: true},
                {data:'role.name', orderable: true},
                {data:'status', orderable: true},
                {data:'created_at', orderable: true},
                {data:null, orderable: false},
                {data:null, orderable: false}
            ],
            columnDefs: [
                {
                    targets: 0,
                    render: (data,sss,row) => {
                        return `<span class="font-normal text-2sm">${row.name + ' ' + row.surname}</span>`
                    }
                },
                {
                    targets: 1,
                    render: (data,sss,row) => {
                        return `<span class="font-normal text-2sm">${row.role?.name}</span>`
                    }
                },
                {
                    targets: 2,
                    render: (data,sss,row) => {
                        return `<span class="font-normal text-2sm">${data ? 'Aktif' : 'Pasif'}</span>`
                    }
                },
                {
                    targets: 3,
                    render: (data, sss, row) => {
                        return `<span class="fw-bolder">${data ? formatDate(data) : '-'}</span>`;
                    }
                },
                {
                    targets: 4,
                    render: (data, sss, row) => {
                        return `<a class="btn btn-sm btn-icon btn-clear btn-light" href="${getUriWithRouteName({name: 'user.edit', params: {user:row.id}})}">
                                  <i class="ki-duotone ki-notepad-edit">
                                  </i>
                                 </a>`
                    }
                },
                {
                    targets: 5,
                    render: (data, sss, row) => {
                        return `<a class="btn btn-sm btn-icon btn-clear btn-light" href="javascript:void(0);"
                                                    data-kt-destroy-record-button="true"
                                                    data-kt-destroy-record-uri="${getUriWithRouteName({name: 'user.destroy', params: {user:row.id}})}"
                                                    data-kt-record-manager-parent-el="#user_table"
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

    const handleDestroy = () => {
        RM.emitter.on('rm_destroy', (e) => {
            if (e.parentElement === "#user_table"){
                dataTable.ajax.reload();
            }
        });
    }

    return {
        init: () => {
            initDatatable();
            handleDestroy();
        }
    }
}();

KTDom.ready(() => {
    KTUserPage.init();
});

