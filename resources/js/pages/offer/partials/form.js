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

const createOfferForm = ({ formSelector, type = formValidTypes.other }) => {
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
        discountTotal: function (item) {
            try {
                let unitPrice = item.price;
                let unitDiscount = 0;
                for (let i = 1; i <= 5; i++){
                    if (item["discount" + i] > 0){
                        item["discount" + i + "_price"] = 0;
                        const discount = unitPrice / 100 * item["discount" + i];
                        unitPrice -= discount;
                        unitDiscount += discount;
                    }
                    else if (item["discount" + i + "_price"] > 0){
                        unitPrice -= item["discount" + i + "_price"];
                        unitDiscount += item["discount" + i + "_price"];
                    }
                }
                if (unitPrice - unitDiscount === 0)
                    unitDiscount = 0;
                return unitDiscount * item.quantity;
            } catch (error) {
                return 0;
            }
        },
        subTotal: function(item){
            try {
                return (item.price * item.quantity) - this.discountTotal(item);
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
        initItemsDataTable();
        initProductSelect();
        handleAddProduct();
        handleItemsTableEvents();
        handleSubmit();
    }

    const initItemsDataTable = () => {
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
                {data: 'discount1', orderable: false, visible: false},//6
                {data: 'discount1_price', orderable: false},//7
                {data: 'discount2', orderable: false, visible: false},//8
                {data: 'discount2_price', orderable: false},//9
                {data: 'discount3', orderable: false, visible: false},//10
                {data: 'discount3_price', orderable: false, visible: false},//11
                {data: 'discount4', orderable: false, visible: false},//12
                {data: 'discount4_price', orderable: false, visible: false},//13
                {data: 'discount5', orderable: false, visible: false},//14
                {data: 'discount5_price', orderable: false, visible: false},//15
                {data: 'vat_rate', orderable: false},//16
                {data: null, orderable: false},//16
                {data: null, orderable: false},//18
                {data: null, orderable: false},//19
                {data: null, orderable: false},//20
                {data: 'key', orderable: false},//21
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
                      return `<input name="items[${row.order - 1}][discount1]" data-kt-item-input="discount1" class="input input-sm" value="${row.discount1}">`;
                  }
                },
                {
                  targets: 7,
                  render: (data, sss, row) => {
                      return `<input name="items[${row.order - 1}][discount1_price]" data-kt-item-input="discount1_price" class="input input-sm" value="${row.discount1_price}">`;
                  }
                },
                {
                  targets: 8,
                  render: (data, sss, row) => {
                      return `<input name="items[${row.order - 1}][discount2]" data-kt-item-input="discount2" class="input input-sm" value="${row.discount2}">`;
                  }
                },
                {
                  targets: 9,
                  render: (data, sss, row) => {
                      return `<input name="items[${row.order - 1}][discount2_price]" data-kt-item-input="discount2_price" class="input input-sm" value="${row.discount2_price}">`;
                  }
                },
                {
                  targets: 10,
                  render: (data, sss, row) => {
                      return `<input name="items[${row.order - 1}][discount3]" data-kt-item-input="discount3" class="input input-sm" value="${row.discount3}">`;
                  }
                },
                {
                  targets: 11,
                  render: (data, sss, row) => {
                      return `<input name="items[${row.order - 1}][discount3_price]" data-kt-item-input="discount3_price" class="input input-sm" value="${row.discount3_price}">`;
                  }
                },
                {
                  targets: 12,
                  render: (data, sss, row) => {
                      return `<input name="items[${row.order - 1}][discount4]" data-kt-item-input="discount4" class="input input-sm" value="${row.discount4}">`;
                  }
                },
                {
                  targets: 13,
                  render: (data, sss, row) => {
                      return `<input name="items[${row.order - 1}][discount4_price]" data-kt-item-input="discount4_price" class="input input-sm" value="${row.discount4_price}">`;
                  }
                },
                {
                  targets: 14,
                  render: (data, sss, row) => {
                      return `<input name="items[${row.order - 1}][discount5]" data-kt-item-input="discount5" class="input input-sm" value="${row.discount5}">`;
                  }
                },
                {
                  targets: 15,
                  render: (data, sss, row) => {
                      return `<input name="items[${row.order - 1}][discount5_price]" data-kt-item-input="discount5_price" class="input input-sm" value="${row.discount5_price}">`;
                  }
                },
                {
                  targets: 16,
                  render: (data, sss, row) => {
                      return `<input name="items[${row.order - 1}][vat_rate]" data-kt-item-input="vat_rate" class="input input-sm" value="${row.vat_rate}">`;
                  }
                },
                {
                    targets: 17,
                    className: "fw-bolder text-end",
                    render: (data, sss, row) => {
                        return formatCurrency(itemFnc.discountTotal(row), 2)
                    }
                },
                {
                    targets: 18,
                    className: "fw-bolder text-end",
                    render: (data, sss, row) => {
                        return formatCurrency(itemFnc.subTotal(row), 2)
                    }
                },
                {
                    targets: 19,
                    className: "fw-bolder text-end",
                    render: (data, sss, row) => {
                        return formatCurrency(itemFnc.vatTotal(row), 2)
                    }
                },
                {
                    targets: 20,
                    className: "fw-bolder text-end",
                    render: (data, sss, row) => {
                        return formatCurrency(itemFnc.total(row), 2)
                    }
                },
                {
                    targets: 21,
                    render: (data, sss, row) => {
                        return `<a class="btn btn-sm btn-icon btn-clear btn-light" href="javascript:void(0);" data-kt-offer-form-items-destroy="true">
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
                                                discount1 = 0,
                                                discount1_price = 0,
                                                discount2 = 0,
                                                discount2_price = 0,
                                                discount3 = 0,
                                                discount3_price = 0,
                                                discount4 = 0,
                                                discount4_price = 0,
                                                discount5 = 0,
                                                discount5_price = 0,
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
            discount1: parseFloat(discount1),
            discount1_price: parseFloat(discount1_price),
            discount2: parseFloat(discount2),
            discount2_price: parseFloat(discount2_price),
            discount3: parseFloat(discount3),
            discount3_price: parseFloat(discount3_price),
            discount4: parseFloat(discount4),
            discount4_price: parseFloat(discount4_price),
            discount5: parseFloat(discount5),
            discount5_price: parseFloat(discount5_price),
            order: parseInt(order || itemsDataTable.data().count()+1),
        }).draw();
    }

    const handleAddProduct = () => {
        formEl.querySelector('[data-kt-offer-add-product-button="true"]').addEventListener('click', function () {
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
            if (!e.target.hasAttribute('data-kt-item-input'))
                return;
            if (e.target.getAttribute("data-kt-item-input") === "order"){
                item.order = parseInt(e.target.value);
            }
            else if (e.target.getAttribute("data-kt-item-input") === "vat_rate"){
                item.vat_rate = parseInt(e.target.value);
            }
            else if (e.target.getAttribute("data-kt-item-input") === "price"){
                item.price = parseFloat(e.target.value);
            }
            else if (e.target.getAttribute("data-kt-item-input") === "unit_id"){
                item.unit_id = parseInt(e.target.value);
            }
            else if (e.target.getAttribute("data-kt-item-input") === "quantity"){
                item.quantity = parseInt(e.target.value);
            }
            else{
                for (let i = 1; i <= 5; i++){
                    if (e.target.getAttribute("data-kt-item-input") === "discount" + i || e.target.getAttribute("data-kt-item-input") === "discount" + i + "_price"){
                        let discount = Math.abs(parseFloat(e.target.value)) || 0;
                        discount = (e.target.getAttribute("data-kt-item-input") === "discount" + i ? (discount > 100 ? 0 : discount) : discount);
                        discount = (e.target.getAttribute("data-kt-item-input") === "discount" + i + "_price" ? (itemFnc.discountTotal(item) + discount > item.price ? 0 : discount) : discount);
                        if (e.target.getAttribute("data-kt-item-input") === "discount" + i){
                            item["discount" + i] = discount;
                            item["discount" + i + "_price"] = 0;
                        }
                        else if (e.target.getAttribute("data-kt-item-input") === "discount" + i + "_price") {
                            item["discount" + i] = 0;
                            item["discount" + i + "_price"] = discount;
                        }
                        if (i < 5){
                            for (let j = i+1; j <= 5; j++){
                                item["discount" + j] = 0;
                                item["discount" + j + "_price"] = 0;
                            }
                        }
                    }
                }
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
            if (check(e.target.closest('.btn[data-kt-offer-form-items-destroy="true"]'))) {
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
        let vatTotal = 0, subTotal = 0, stockTotal = 0, serviceTotal = 0, total = 0, discountTotal = 0;
        const items = itemsDataTable.rows().data().toArray();
        items?.forEach(item => {
           let _total =  itemFnc.total(item);
           if (item.type === 1){
               stockTotal += _total;
           }
           if (item.type === 2){
               serviceTotal += _total;
           }
           discountTotal += itemFnc.discountTotal(item);
           subTotal += itemFnc.subTotal(item);
           vatTotal += itemFnc.vatTotal(item);
           total += _total;
        });
        formEl.querySelector('[data-kt-offer-total="service_total"]').innerHTML = formatCurrency(serviceTotal, 2)
        formEl.querySelector('[data-kt-offer-total="stock_total"]').innerHTML = formatCurrency(stockTotal, 2)
        formEl.querySelector('[data-kt-offer-total="discount_total"]').innerHTML = formatCurrency(discountTotal, 2)
        formEl.querySelector('[data-kt-offer-total="sub_total"]').innerHTML = formatCurrency(subTotal, 2)
        formEl.querySelector('[data-kt-offer-total="vat_total"]').innerHTML = formatCurrency(vatTotal, 2)
        formEl.querySelector('[data-kt-offer-total="total"]').innerHTML = formatCurrency(total, 2)
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
            await axios.post(getUriWithRouteName({ name: 'offer.store' }), formData)
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
        $(formEl.querySelector('input[name="date"]')).val(data?.date).trigger('change');
        $(formEl.querySelector('input[name="validity_date"]')).val(data?.end_date).trigger('change');
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

    const update = async (offer) => {
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
                discount1: formData.get(`items[${i}][discount1]`),
                discount2: formData.get(`items[${i}][discount2]`),
                discount3: formData.get(`items[${i}][discount3]`),
                discount4: formData.get(`items[${i}][discount4]`),
                discount5: formData.get(`items[${i}][discount5]`),
                discount1_price: formData.get(`items[${i}][discount1_price]`),
                discount2_price: formData.get(`items[${i}][discount2_price]`),
                discount3_price: formData.get(`items[${i}][discount3_price]`),
                discount4_price: formData.get(`items[${i}][discount4_price]`),
                discount5_price: formData.get(`items[${i}][discount5_price]`),
                vat_rate: formData.get(`items[${i}][vat_rate]`)
            });
        }
        data.items = items;
        yupForm.clearErrorMessages();
        try {
            await validationSchema.validate(data, { abortEarly: false });
            emitter.emit('update_loading', true);
            await axios.put(getUriWithRouteName({ name: 'offer.update', params: {offer: offer} }), data)
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
export default createOfferForm;
