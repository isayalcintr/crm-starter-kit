import {
    formValidTypes,
    checkValidFormType,
    axios,
    setGroupSelectValue,
    setCitySelectValue, setDistrictSelectValue
} from "@/utiles/isayalcintr.js";
import {getUriWithRouteName, SystemData} from "@/utiles/config.js";
import EventEmitter from "eventemitter3";
import * as Yup from 'yup';
import createYupForm from "@/utiles/yupForm.js";
import $ from "jquery";
const createCustomerForm = ({ formSelector, type = formValidTypes.other }) => {
    const formEl = document.querySelector(formSelector);
    const yupForm = createYupForm({formEl: formEl});
    const emitter = new EventEmitter();
    const validationSchema = Yup.object().shape({
        code: Yup.string().required('Kod gerekli'),
        title: Yup.string().required('Ad - Soyad / Unvan gerekli'),
        special_group1: Yup.number().nullable(),
        special_group2: Yup.number().nullable(),
        special_group3: Yup.number().nullable(),
        special_group4: Yup.number().nullable(),
        special_group5: Yup.number().nullable(),
        type: Yup.number().required('Tip gerekli')
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
            await axios.post(getUriWithRouteName({ name: 'customer.store' }), formData)
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
        $(formEl.querySelector('input[name="title"]')).val(data?.title).trigger('change');
        $(formEl.querySelector('select[name="type"]')).val(data?.type).trigger('change');
        $(formEl.querySelector('input[name="tax_number"]')).val(data?.tax_number).trigger('change');
        $(formEl.querySelector('input[name="tax_office"]')).val(data?.tax_office).trigger('change');
        $(formEl.querySelector('input[name="email"]')).val(data?.email).trigger('change');
        $(formEl.querySelector('input[name="phone1"]')).val(data?.phone1).trigger('change');
        $(formEl.querySelector('input[name="phone2"]')).val(data?.phone2).trigger('change');
        $(formEl.querySelector('input[name="address1"]')).val(data?.address1).trigger('change');
        $(formEl.querySelector('input[name="address2"]')).val(data?.address2).trigger('change');

        setCitySelectValue(formEl.querySelector('select[name="city"]'), data?.city);
        setDistrictSelectValue(formEl.querySelector('select[name="district"]'), data?.district);
        setGroupSelectValue(formEl.querySelector('select[name="special_group1_id"]'), data?.special_group1_id);
        setGroupSelectValue(formEl.querySelector('select[name="special_group2_id"]'), data?.special_group2_id);
        setGroupSelectValue(formEl.querySelector('select[name="special_group3_id"]'), data?.special_group3_id);
        setGroupSelectValue(formEl.querySelector('select[name="special_group4_id"]'), data?.special_group4_id);
    }

    const edit = async (customer) => {
        await axios.get(getUriWithRouteName({ name: 'customer.show', params: {customer: customer} }))
            .then(response => {
                setFormData(response.data.data);
                return response;
            })
            .catch(error => {
                setFormData({});
                throw new Error(error);
            });
    }

    const update = async (customer) => {
        const formData = new FormData(formEl);
        const data = Object.fromEntries(formData.entries());
        yupForm.clearErrorMessages();
        try {
            await validationSchema.validate(data, { abortEarly: false });
            emitter.emit('update_loading', true);
            await axios.put(getUriWithRouteName({ name: 'customer.update', params: {customer: customer} }), data)
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
export default createCustomerForm;
