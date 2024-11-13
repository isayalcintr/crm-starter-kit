import {
    formValidTypes,
    checkValidFormType,
    axios,
    setGroupSelectValue,
    setCustomerSelectValue
} from "@/utiles/isayalcintr.js";
import {getUriWithRouteName, SystemData} from "@/utiles/config.js";
import EventEmitter from "eventemitter3";
import * as Yup from 'yup';
import createYupForm from "@/utiles/yupForm.js";
import $ from "jquery";
const createInterviewForm = ({ formSelector, type = formValidTypes.other }) => {
    const formEl = document.querySelector(formSelector);
    const yupForm = createYupForm({formEl: formEl});
    const emitter = new EventEmitter();
    const validationSchema = Yup.object().shape({
        customer_id: Yup.number().required('Müşteri seçimi gerekli!'),
        subject: Yup.string().required('Konu gerekli'),
        description: Yup.string().required('Açıklama gerekli').max(500, 'İsim en fazla 255 karakter olmalı'),
        category_id: Yup.number().nullable(),
        type_id: Yup.number().nullable(),
        special_group1: Yup.number().nullable(),
        special_group2: Yup.number().nullable(),
        special_group3: Yup.number().nullable(),
        special_group4: Yup.number().nullable(),
        special_group5: Yup.number().nullable(),
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
            await axios.post(getUriWithRouteName({ name: 'interview.store' }), formData)
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
        $(formEl.querySelector('input[name="subject"]')).val(data?.subject).trigger('subject');
        $(formEl.querySelector('input[name="description"]')).val(data?.description).trigger('change');
        setCustomerSelectValue(formEl.querySelector('select[name="customer_id"]'), data?.customer_id);
        setGroupSelectValue(formEl.querySelector('select[name="type_id"]'), data?.type_id);
        setGroupSelectValue(formEl.querySelector('select[name="category_id"]'), data?.category_id);
        setGroupSelectValue(formEl.querySelector('select[name="special_group1_id"]'), data?.special_group1_id);
        setGroupSelectValue(formEl.querySelector('select[name="special_group2_id"]'), data?.special_group2_id);
        setGroupSelectValue(formEl.querySelector('select[name="special_group3_id"]'), data?.special_group3_id);
        setGroupSelectValue(formEl.querySelector('select[name="special_group4_id"]'), data?.special_group4_id);
    }

    const edit = async (interview) => {
        await axios.get(getUriWithRouteName({ name: 'interview.show', params: {interview: interview} }))
            .then(response => {
                setFormData(response.data.data);
                return response;
            })
            .catch(error => {
                setFormData({});
                throw new Error(error);
            });
    }

    const update = async (interview) => {
        const formData = new FormData(formEl);
        const data = Object.fromEntries(formData.entries());
        yupForm.clearErrorMessages();
        try {
            await validationSchema.validate(data, { abortEarly: false });
            emitter.emit('update_loading', true);
            await axios.put(getUriWithRouteName({ name: 'interview.update', params: {interview: interview} }), data)
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
export default createInterviewForm;
