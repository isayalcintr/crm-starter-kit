import {formValidTypes, checkValidFormType, axios, setGroupSelectValue} from "@/utiles/isayalcintr.js";
import {getUriWithRouteName, SystemData} from "@/utiles/config.js";
import EventEmitter from "eventemitter3";
import * as Yup from 'yup';
import createYupForm from "@/utiles/yupForm.js";
import $ from "jquery";
const createProductForm = ({ formSelector, type = formValidTypes.other }) => {
    const formEl = document.querySelector(formSelector);
    const yupForm = createYupForm({formEl: formEl});
    const emitter = new EventEmitter();
    const validationSchema = Yup.object().shape({
        code: Yup.string().required('Kod gerekli'),
        name: Yup.string().required('İsim gerekli').max(255, 'İsim en fazla 255 karakter olmalı'),
        unit_id: Yup.number().required('Birim ID gerekli').integer('Birim ID bir tamsayı olmalı'),
        purchase_vat_rate: Yup
            .number()
            .typeError("5,2 hassasiyetle ondalıklı sayı olmalı")
            .required('Alış KDV oranı gerekli')
            .test('decimal', 'En fazla 5,2 hassasiyetle ondalıklı sayı olmalı', (value) => /^\d+(\.\d{1,2})?$/.test(value)),
        purchase_price: Yup
            .number()
            .typeError("18,6 hassasiyetle ondalıklı sayı olmalı")
            .required('Alış fiyatı gerekli')
            .test('decimal', 'En fazla 18,6 hassasiyetle ondalıklı sayı olmalı', (value) => /^\d+(\.\d{1,6})?$/.test(value)),
        sell_vat_rate: Yup
            .number()
            .typeError("5,2 hassasiyetle ondalıklı sayı olmalı")
            .required('Satış KDV oranı gerekli')
            .test('decimal', 'En fazla 5,2 hassasiyetle ondalıklı sayı olmalı', (value) => /^\d+(\.\d{1,2})?$/.test(value)),
        sell_price: Yup
            .number()
            .typeError("18,6 hassasiyetle ondalıklı sayı olmalı")
            .required('Satış fiyatı gerekli')
            .test('decimal', 'En fazla 18,6 hassasiyetle ondalıklı sayı olmalı', (value) => /^\d+(\.\d{1,6})?$/.test(value)),
        quantity: Yup
            .number()
            .typeError("18,6 hassasiyetle ondalıklı sayı olmalı")
            .required('Miktar gerekli')
            .test('decimal', 'En fazla 18,6 hassasiyetle ondalıklı sayı olmalı', (value) => /^\d+(\.\d{1,6})?$/.test(value)),
        special_group1: Yup.number().nullable(),
        special_group2: Yup.number().nullable(),
        special_group3: Yup.number().nullable(),
        special_group4: Yup.number().nullable(),
        special_group5: Yup.number().nullable(),
        type: Yup.number().required('Tip gerekli') // Enum değerleri burada ayarlanabilir
    });

    const initForm = () => {
        if (!checkValidFormType(type)) throw new Error("Type is not valid!");
        if (!formEl) throw new Error("Form element not found!");
        handleSubmit();
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

    const store = async () => {
        const formData = new FormData(formEl);
        const data = Object.fromEntries(formData.entries());
        yupForm.clearErrorMessages();
        try {
            await validationSchema.validate(data, { abortEarly: false });
            emitter.emit('store_loading', true);
            await axios.post(getUriWithRouteName({ name: 'product.store' }), formData)
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
        $(formEl.querySelector('input[name="code"]')).val(data?.code).trigger('change');
        $(formEl.querySelector('input[name="name"]')).val(data?.name).trigger('change');
        $(formEl.querySelector('input[name="quantity"]')).val(data?.quantity).trigger('change');
        $(formEl.querySelector('input[name="purchase_vat_rate"]')).val(data?.purchase_vat_rate).trigger('change');
        $(formEl.querySelector('input[name="purchase_price"]')).val(data?.purchase_price).trigger('change');
        $(formEl.querySelector('input[name="sell_vat_rate"]')).val(data?.sell_vat_rate).trigger('change');
        $(formEl.querySelector('input[name="sell_price"]')).val(data?.sell_price).trigger('change');
        $(formEl.querySelector('select[name="type"]')).val(data?.type).trigger('change');
        $(formEl.querySelector('select[name="unit_id"]')).val(data?.unit_id).trigger('change');

        setGroupSelectValue(formEl.querySelector('select[name="special_group1_id"]'), data?.special_group1_id);
        setGroupSelectValue(formEl.querySelector('select[name="special_group2_id"]'), data?.special_group2_id);
        setGroupSelectValue(formEl.querySelector('select[name="special_group3_id"]'), data?.special_group3_id);
        setGroupSelectValue(formEl.querySelector('select[name="special_group4_id"]'), data?.special_group4_id);
    }

    const edit = async (product) => {
        await axios.get(getUriWithRouteName({ name: 'product.show', params: {product: product} }))
            .then(response => {
                setFormData(response.data.data);
                return response;
            })
            .catch(error => {
                setFormData({});
                throw new Error(error);
            });
    }

    const update = async (product) => {
        const formData = new FormData(formEl);
        const data = Object.fromEntries(formData.entries());
        yupForm.clearErrorMessages();
        try {
            await validationSchema.validate(data, { abortEarly: false });
            emitter.emit('update_loading', true);
            await axios.put(getUriWithRouteName({ name: 'product.update', params: {product: product} }), data)
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
        edit: edit,
        update: update,
        emitter: emitter,
        setFormData: setFormData,
    }
}
export default createProductForm;
