"use strict";

import DataTable from "datatables.net";
import {dataTableTRLang, domLayout} from "@/utiles/datatables.js";
import {getUriWithRouteName} from "@/utiles/config.js";
import {RM} from "@/utiles/isayalcintr.js";
import $ from "jquery";
import KTDom from "../../../metronic/core/helpers/dom";

const KTRolePage = function () {
    const tableEl = document.querySelector("#role_table");
    let dataTable = null;

    const initDatatable = () => {
        dataTable = new DataTable(tableEl, {
            responsive: false,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: 'role/list-with-datatable',
                method: 'GET',
                data: function ( data ) {
                    data.search = $('[data-kt-role-table-filter="search"]').val().trim();
                }
            },
            columns:[
                {data:'name', orderable: true},
                {data:'user_count', orderable: true},
                {data:null, orderable: false},
                {data:null, orderable: false}
            ],
            columnDefs: [
                {
                    targets: [0,1],
                    render: (data,sss,row) => {
                        return `<span class="font-normal text-2sm">${data}</span>`
                    }
                },
                {
                    targets: 2,
                    render: (data, sss, row) => {
                        return `<a class="btn btn-sm btn-icon btn-clear btn-light" href="${getUriWithRouteName({name: 'role.edit', params: {role:row.id}})}">
                                  <i class="ki-duotone ki-notepad-edit">
                                  </i>
                                 </a>`
                    }
                },
                {
                    targets: 3,
                    render: (data, sss, row) => {
                        return `<a class="btn btn-sm btn-icon btn-clear btn-light" href="javascript:void(0);"
                                                    data-kt-destroy-record-button="true"
                                                    data-kt-destroy-record-uri="${getUriWithRouteName({name: 'role.destroy', params: {role:row.id}})}"
                                                    data-kt-record-manager-parent-el="#role_table"
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
            if (e.parentElement === "#role_table"){
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
    KTRolePage.init();
});

