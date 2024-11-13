import {
    formValidTypes,
    checkValidFormType,
    axios,
    setGroupSelectValue,
    setCustomerSelectValue
} from "@/utiles/isayalcintr.js";
import {findEnumWithValue, getUriWithRouteName, SystemData} from "@/utiles/config.js";
import EventEmitter from "eventemitter3";
import * as Yup from 'yup';
import createYupForm from "@/utiles/yupForm.js";
import DataTable from "datatables.net";
import $ from "jquery";
import {dataTableTRLang, domLayout} from "@/utiles/datatables.js";
import Choices from "choices.js";
import { v4 as uuidv4 } from 'uuid';
import {formatCurrency} from "@/utiles/format.js";
import moment from "moment";

const createServiceForm = ({ formSelector, type = formValidTypes.other }) => {
    const formEl = document.querySelector(formSelector);
    const itemsTableEl = formEl.querySelector("table");
    let itemsDataTable, productChoice;
    const yupForm = createYupForm({formEl: formEl});
    const emitter = new EventEmitter();
    const validationSchema = Yup.object().shape({
        // customer_id: Yup.number().required('Müşteri seçimi gerekli!'),
        // description: Yup.string().required('Açıklama girilmesi zorunludur!'),
        // status: Yup.number().required('Durum seçimi gerekli!'),
        // start_date: Yup.date()
        //     .required('Başlangıç tarihi zorunludur!')
        //     .test('valid-timezone', 'Başlangıç tarihi geçerli bir zaman diliminde olmalı!', (value) => {
        //         return moment(value).isValid() && moment(value).isSameOrAfter(moment().startOf('day'));
        //     })
        //     .test('before-end-date', 'Başlangıç tarihi bitiş tarihinden sonra olamaz!', function (value) {
        //         const { end_date } = this.parent;
        //         if (end_date) {
        //             return moment(value).isBefore(moment(end_date));
        //         }
        //         return true;
        //     }),
        // end_date: Yup.date()
        //     .required('Bitiş tarihi zorunludur!')
        //     .test('valid-timezone', 'Bitiş tarihi geçerli bir zaman diliminde olmalı!', (value) => {
        //         return moment(value).isValid() && moment(value).isSameOrAfter(moment().startOf('day'));
        //     })
        //     .test('after-start-date', 'Bitiş tarihi başlangıç tarihinden önce olamaz!', function (value) {
        //         const { start_date } = this.parent;
        //         if (start_date) {
        //             return moment(value).isAfter(moment(start_date));
        //         }
        //         return true;
        //     }),
        // items: Yup.array()
        //     .of(
        //         Yup.object().shape({
        //             quantity: Yup.number()
        //                 .min(1, 'Miktar en az 1 olmalı!')
        //                 .required('Miktar zorunludur!'),
        //             price: Yup.number()
        //                 .min(0, 'Fiyat 0 veya daha büyük olmalı!')
        //                 .required('Fiyat zorunludur!'),
        //             unit_id: Yup.number()
        //                 .required('Birim ID zorunludur!')
        //                 .typeError('Birim ID sayısal olmalı!'), // unit_id sayısal olmalı
        //             vat_rate: Yup.number()
        //                 .min(0, 'KDV oranı 0 veya daha büyük olmalı!')
        //                 .required('KDV oranı zorunludur!'),
        //         })
        //     )
        //     .min(1, 'En az bir adet item gerekli!')
        //     .required('Itemlar zorunludur!')
    });
    const itemFnc = {
        subTotal: function(item){
            try {
                return item.price * item.quantity;
            } catch (error) {
                return 0;
            }
        },
        vatTotal: function(item){
            try {
                return this.subTotal(item) / 100 * item.vat_rate;
            } catch (error) {
                return 0;
            }
        },
        total: function(item){
            try {
                return this.subTotal(item) + this.vatTotal(item);
            } catch (error) {
                return 0;
            }
        }
    };

    const initForm = () => {
        if (!checkValidFormType(type)) throw new Error("Type is not valid!");
        if (!formEl) throw new Error("Form element not found!");
        initItemsTable();
        initProductSelect();
        handleAddProduct();
        handleItemsTableEvents();
        handleSubmit();
    }

    const initItemsTable = () => {
        itemsDataTable = new DataTable(itemsTableEl, {
            responsive: false,
            searchDelay: 500,
            processing: true,
            serverSide: false,
            stateSave: false,
            info: false,
            paging: false,
            searching: false,
            columns: [
                {data: 'order', orderable: true},//0
                {data: 'type', orderable: false},//1
                {data: 'code', orderable: false},//2
                {data: 'quantity', orderable: false},//3
                {data: 'unit_id', orderable: false},//4
                {data: 'price', orderable: false},//5
                {data: 'vat_rate', orderable: false},//6
                {data: null, orderable: false},//7
                {data: null, orderable: false},//8
                {data: null, orderable: false},//9
                {data: 'key', orderable: false},//10
            ],
            columnDefs: [
                {
                    targets: 0,
                    type:"html-num" ,
                    render: (data, sss, row) => {
                        return `<input name="items[${row.order - 1}][order]" data-kt-item-input="order" class="input input-sm"  type="number" value="${data}" />`
                    }
                },
                {
                    targets: 1,
                    render: (data, sss, row) => {
                        const en = findEnumWithValue("ProductType", parseInt(data))
                        return `
                            <input type="hidden" name="items[${row.order - 1}][product_id]" value="${row.product_id}">
                            <input type="hidden" name="items[${row.order - 1}][product_name]" value="${row.name}">
                            ${en?.badge}`
                    }
                },
                {
                    targets: 2,
                    render: (data, sss, row) => {
                        return `<span class="fw-bolder">${row.code + ' - ' + row.name}</span>`
                    }
                },
                {
                    targets: 3,
                    render: (data, sss, row) => {
                        return `<input name="items[${row.order - 1}][quantity]" data-kt-item-input="quantity" class="input input-sm" value="${row.quantity}">`
                    }
                },
                {
                    targets: 4,
                    render: (data, sss, row) => {
                        let unitOptions = '';
                        SystemData.Units.forEach(unit => {
                            unitOptions += `<option value="${unit.id}" ${unit.id === row.unit_id ? 'selected' : ''}>${unit.name}</option>`
                        })
                        return `<select name="items[${row.order - 1}][unit_id]" data-kt-item-input="unit_id" class="select select-sm">
                                                ${unitOptions}
                                            </select>`
                    }
                },
                {
                  targets: 5,
                  render: (data, sss, row) => {
                      return `<input name="items[${row.order - 1}][price]" data-kt-item-input="price" class="input input-sm" value="${row.price}">`;
                  }
                },
                {
                  targets: 6,
                  render: (data, sss, row) => {
                      return `<input name="items[${row.order - 1}][vat_rate]" data-kt-item-input="vat_rate" class="input input-sm" value="${row.vat_rate}">`;
                  }
                },
                {
                    targets: 7,
                    className: "fw-bolder text-end",
                    render: (data, sss, row) => {
                        return formatCurrency(itemFnc.subTotal(row), 2)
                    }
                },
                {
                    targets: 8,
                    className: "fw-bolder text-end",
                    render: (data, sss, row) => {
                        return formatCurrency(itemFnc.vatTotal(row), 2)
                    }
                },
                {
                    targets: 9,
                    className: "fw-bolder text-end",
                    render: (data, sss, row) => {
                        return formatCurrency(itemFnc.total(row), 2)
                    }
                },
                {
                    targets: 10,
                    render: (data, sss, row) => {
                        return `<a class="btn btn-sm btn-icon btn-clear btn-light" href="javascript:void(0);" data-kt-service-form-items-destroy="true">
                                  <i class="ki-duotone ki-trash">
                                  </i>
                                 </a>`
                    }
                }
            ],
            language: dataTableTRLang,
            // dom: domLayout,
        });
        itemsDataTable.on('draw', function () {
            refreshTotals();
        });
    }

    const initProductSelect = () => {
        const productSelect = formEl.querySelector('select[name="product"]');

        productChoice = new Choices(productSelect, {
            searchEnabled: true,
            placeholder: true,
            placeholderValue: 'Bir ürün seçin...',
            shouldSort: false,
        });

        async function fetchProductData(query) {
            try {
                const response = await axios.get(getUriWithRouteName({ name: 'product.select' }) + `?search=${query}&limit=100`);
                return response.data.data;
            } catch (error) {
                console.error('Veri alınamadı:', error);
                return [];
            }
        }

        productSelect.addEventListener('search', async function (event) {
            const query = event.detail.value;
            if (query.length >= 2) {
                const results = await fetchProductData(query);
                productChoice.clearChoices();
                productChoice.setChoices(results.map(item => ({
                    value: item.id,
                    label: item.text,
                    customProperties: {
                        id: item.id,
                        code: item.code,
                        name: item.name,
                        type: item.type,
                        unit_id: item.unit_id,
                        sell_vat_rate: item.sell_vat_rate,
                        sell_price: item.sell_price,
                        purchase_vat_rate: item.purchase_vat_rate,
                        purchase_price: item.purchase_price,
                    }
                })), 'value', 'label', true);
            } else {
                productChoice.clearChoices();
            }
        });
    }

    const itemsDataTableAddItem = function ({
                                                id,
                                                product_id,
                                                code,
                                                name,
                                                type,
                                                quantity,
                                                unit_id,
                                                vat_rate,
                                                price,
                                                order,
                                            }) {

        itemsDataTable.row.add({
            key: uuidv4(),
            id: id,
            product_id: product_id,
            code: code,
            name: name,
            type: parseInt(type),
            quantity: parseFloat(quantity),
            unit_id: parseInt(unit_id),
            vat_rate: parseFloat(vat_rate),
            price: parseFloat(price),
            order: parseInt(order || itemsDataTable.data().count()+1),
        }).draw();
    }

    const handleAddProduct = () => {
        formEl.querySelector('[data-kt-service-add-product-button="true"]').addEventListener('click', function () {
            const selectedOption = productChoice.getValue();
            if (selectedOption) {
                const item = selectedOption.customProperties;
                itemsDataTableAddItem({
                    id: null,
                    product_id: item.id,
                    code: item.code,
                    name: item.name,
                    type: item.type,
                    quantity: 1,
                    unit_id: item.unit_id,
                    vat_rate: item.sell_vat_rate,
                    price: item.sell_price,
                })
            }
        })
    }

    const handleItemsTableEvents = () => {
        itemsTableEl.addEventListener('change', function (e) {
            const parentEl = e.target.closest('tbody tr');
            const item = itemsDataTable.row($(parentEl)).data();
            if (!item)
                return;
            if (e.target.hasAttribute('data-kt-item-input') && e.target.getAttribute("data-kt-item-input") === "order"){
                item.order = parseInt(e.target.value);
            }
            else if (e.target.hasAttribute('data-kt-item-input') && e.target.getAttribute("data-kt-item-input") === "vat_rate"){
                item.vat_rate = parseInt(e.target.value);
            }
            else if (e.target.hasAttribute('data-kt-item-input') && e.target.getAttribute("data-kt-item-input") === "price"){
                item.price = parseFloat(e.target.value);
            }
            else if (e.target.hasAttribute('data-kt-item-input') && e.target.getAttribute("data-kt-item-input") === "unit_id"){
                item.unit_id = parseInt(e.target.value);
            }
            else if (e.target.hasAttribute('data-kt-item-input') && e.target.getAttribute("data-kt-item-input") === "quantity"){
                item.quantity = parseInt(e.target.value);
            }
            itemsDataTable.row($(parentEl)).data(item).draw();
        });
        itemsTableEl.addEventListener('click', async function (e) {
            e.preventDefault();
            const parentEl = e.target.closest('tbody tr');
            const item = itemsDataTable.row($(parentEl)).data();
            if (!item)
                return;
            const check = (el) => {
                return el
                    && (
                        el === e.target
                        || el.contains(e.target)
                    );
            }
            if (check(e.target.closest('.btn[data-kt-service-form-items-destroy="true"]'))) {
                await itemsDataTable.row($(parentEl)).remove().draw();
            }
        });
    }

    const handleSubmit = () => {
        formEl.addEventListener('submit', async e => {
            e.preventDefault();
            switch (type) {
                case formValidTypes.create:
                    await store();
                    break;
                case formValidTypes.edit:
                    await update();
                    break;
                default:
                    console.warn("Unknown form type!");
            }
        });
    }

    const refreshTotals = () => {
        let vatTotal = 0, subTotal = 0, stockTotal = 0, serviceTotal = 0, total = 0;
        const items = itemsDataTable.rows().data().toArray();
        items?.forEach(item => {
           let _total =  itemFnc.total(item);
           if (item.type === 1){
               stockTotal += _total;
           }
           if (item.type === 2){
               serviceTotal += _total;
           }
           subTotal += itemFnc.subTotal(item);
           vatTotal += itemFnc.vatTotal(item);
           total += _total;
        });
        formEl.querySelector('[data-kt-service-total="service_total"]').innerHTML = formatCurrency(serviceTotal, 2)
        formEl.querySelector('[data-kt-service-total="stock_total"]').innerHTML = formatCurrency(stockTotal, 2)
        formEl.querySelector('[data-kt-service-total="sub_total"]').innerHTML = formatCurrency(subTotal, 2)
        formEl.querySelector('[data-kt-service-total="vat_total"]').innerHTML = formatCurrency(vatTotal, 2)
        formEl.querySelector('[data-kt-service-total="total"]').innerHTML = formatCurrency(total, 2)
    }

    const getFormData = () => {
        const formData = new FormData(formEl);
        formData.delete("product");
        return formData;
    }

    const store = async () => {
        const formData = getFormData();
        const data = Object.fromEntries(formData.entries());
        yupForm.clearErrorMessages();
        try {
            await validationSchema.validate(data, { abortEarly: false });
            emitter.emit('store_loading', true);
            await axios.post(getUriWithRouteName({ name: 'service.store' }), formData)
                .then(response => {
                    emitter.emit('store_success', response);
                })
                .catch(error => {
                    emitter.emit('store_error', error);
                })
                .finally(() => {
                    emitter.emit('store_loading', false);
                });
        } catch (err) {
            yupForm.displayErrors(err);
            emitter.emit('validation_failed', err);
        }
    }

    const setFormData = (data) => {
        $(formEl.querySelector('input[name="start_date"]')).val(data?.start_date).trigger('change');
        $(formEl.querySelector('input[name="end_date"]')).val(data?.end_date).trigger('change');
        $(formEl.querySelector('input[name="status"]')).val(data?.status).trigger('change');
        formEl.querySelector('textarea[name="description"]').innerHTML = data?.description;
        data.items.forEach(item => {
            itemsDataTableAddItem(item);
        });
        // setCustomerSelectValue(formEl.querySelector('select[name="customer_id"]'), data?.customer_id);
        // setGroupSelectValue(formEl.querySelector('select[name="special_group1_id"]'), data?.special_group1_id);
        // setGroupSelectValue(formEl.querySelector('select[name="special_group2_id"]'), data?.special_group2_id);
        // setGroupSelectValue(formEl.querySelector('select[name="special_group3_id"]'), data?.special_group3_id);
        // setGroupSelectValue(formEl.querySelector('select[name="special_group4_id"]'), data?.special_group4_id);
    }

    const update = async (service) => {
        const formData = getFormData();
        const data = Object.fromEntries(formData.entries());
        const items = [];
        for (let i = 0; i < itemsDataTable.data().count(); i++) {
            items.push({
                order: formData.get(`items[${i}][order]`),
                product_id: formData.get(`items[${i}][product_id]`),
                product_name: formData.get(`items[${i}][product_name]`),
                quantity: formData.get(`items[${i}][quantity]`),
                unit_id: formData.get(`items[${i}][unit_id]`),
                price: formData.get(`items[${i}][price]`),
                vat_rate: formData.get(`items[${i}][vat_rate]`)
            });
        }
        data.items = items;
        yupForm.clearErrorMessages();
        try {
            await validationSchema.validate(data, { abortEarly: false });
            emitter.emit('update_loading', true);
            await axios.put(getUriWithRouteName({ name: 'service.update', params: {service: service} }), data)
                .then(response => {
                    emitter.emit('update_success', response);
                })
                .catch(error => {
                    emitter.emit('update_error', error);
                })
                .finally(() => {
                    emitter.emit('update_loading', false);
                });
        } catch (err) {
            yupForm.displayErrors(err);
            emitter.emit('validation_failed', err);
        }
    }
    initForm();
    return {
        formEl: formEl,
        store: store,
        update: update,
        emitter: emitter,
        setFormData: setFormData,
    }
}
export default createServiceForm;
