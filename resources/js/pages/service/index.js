"use strict";

import DataTable from "datatables.net";
import {dataTableTRLang, domLayout} from "@/utiles/datatables.js";
import {findEnumWithValue, getUriWithRouteName} from "@/utiles/config.js";
import {EM, RM} from "@/utiles/isayalcintr.js";
import $ from "jquery";
import KTDom from "../../../metronic/core/helpers/dom";
import {formatCurrency, formatDate} from "@/utiles/format.js";

const KTServicePage = function () {
    const tableEl = document.querySelector("#service_table");
    let dataTable = null;

    const initDatatable = () => {
        dataTable = new DataTable(tableEl, {
            responsive: false,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: 'service/list-with-datatable',
                method: 'GET',
                data: function ( data ) {
                    data.search = $('[data-kt-service-table-filter="search"]').val().trim();
                }
            },
            columns:[
                {data:'code', orderable: true},//0
                {data:'customer.title', orderable: true},//1
                {data:'created_by', orderable: true},//2
                {data:'sub_total', orderable: true},//3
                {data:'vat_total', orderable: true},//4
                {data:'total', orderable: true},//5
                {data:'start_date', orderable: true},//6
                {data:'end_date', orderable: true},//7
                {data:'special_group1.title', orderable: true},//8
                {data:'special_group2.title', orderable: true},//9
                {data:'special_group3.title', orderable: true},//10
                {data:'special_group4.title', orderable: true},//11
                {data:'status', orderable: true},//12
                {data:'created_at', orderable: true},//13
                {data:null, orderable: false},//14
                {data:null, orderable: false}//15
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
                    targets: [6,7],
                    render: (data, sss, row) => {
                        return `<span class="fw-bolder">${data ? formatDate(data) : '-'}</span>`;
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
                        const en = findEnumWithValue("ServiceStatus", parseInt(data))
                        return en?.badge;
                    }
                },
                {
                    targets: 13,
                    render: (data, sss, row) => {
                        return `<span class="fw-bolder">${data ? formatDate(data, "DD.MM.YYYY") : '-'}</span>`;
                    }
                },
                {
                    targets: 14,
                    render: (data, sss, row) => {
                        return `<a class="btn btn-sm btn-icon btn-clear btn-light" href="${getUriWithRouteName({name: 'service.edit', params: {service:row.id}})}">
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
                                                    data-kt-destroy-record-uri="${getUriWithRouteName({name: 'service.destroy', params: {service:row.id}})}"
                                                    data-kt-record-manager-parent-el="#service_table"
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
            if (e.parentElement === "#service_table"){
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
    KTServicePage.init();
});

