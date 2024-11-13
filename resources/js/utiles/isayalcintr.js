import axios from "axios";
import RecordManager from "@/utiles/RecordManager.js";
import EventManager from "@/utiles/EventManager.js";
import {getUriWithRouteName, SystemData} from "@/utiles/config.js";
import Choices from 'choices.js';
import 'choices.js/public/assets/styles/choices.css';
import $ from "jquery";
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
export { axios };

const formValidTypes = {
    create: 1,
    edit: 2,
    other: 3,
};
const checkValidFormType = (type) => {
    return !(!type || -1 === Object.values(formValidTypes).includes(type));
}
export {formValidTypes, checkValidFormType};

const EM = new EventManager();
const RM = new RecordManager(document);
export {EM,RM};

const uniqueCode = (limit = 8) => {
    return parseInt((Math.random() * Date.now()).toString(16), 16)
        .toString(36)
        .substr(0, limit);
}
export {uniqueCode};

const groupSelectCIList = [];
const initGroupSelect = async (main = document) => {
    const data = {};
    const selectItems = main.querySelectorAll('[data-kt-group-select="true"]');
    const getGroupData = async (section, type) => {
        const uri = getUriWithRouteName({ name: 'group.select' }) + '?' + (new URLSearchParams({ section: section, type: type })).toString();
        return await axios.get(uri);
    };

    const fetchData = async () => {
        const fetchPromises = [];

        for (const selectItem of selectItems) {
            const section = parseInt(selectItem.getAttribute('data-kt-section'));
            const type = parseInt(selectItem.getAttribute('data-kt-type'));

            if (!data['s' + section + '-t' + type]) {
                fetchPromises.push(getGroupData(section, type).then(res => {
                    data['s' + section + '-t' + type] = res.data.data;
                }).catch(() => {
                    data['s' + section + '-t' + type] = [];
                }));
            }
        }

        return Promise.all(fetchPromises);
    };

    await fetchData().then(() => {
        selectItems.forEach(selectItem => {
            const section = parseInt(selectItem.getAttribute('data-kt-section'));
            const type = parseInt(selectItem.getAttribute('data-kt-type'));
            const key = selectItem.getAttribute('data-kt-key') || uniqueCode();
            const value = selectItem.getAttribute('data-kt-value') || null;
            const selects = data['s' + section + '-t' + type] || [];
            const choicesInstance = new Choices(selectItem, {
                removeItemButton: true,
                placeholder: true,
                searchEnabled: true,
                itemSelectText: '',
                placeholderValue: selectItem.getAttribute('placeholder') || 'Seçiniz..',
                choices: selects.map(item => ({
                    value: item.id,
                    label: item.text,
                    selected: parseInt(item.id) === parseInt(value)
                })),
            });
            groupSelectCIList.push({
                key:  key,
                instance: choicesInstance
            });
        });
    });
};
const setGroupSelectValue = (element, value) => {
    const key = element.getAttribute('data-kt-key');
    if (!key)
        return;
    const instance = groupSelectCIList.find(item => item.key === key);
    if (!instance)
        return;
    instance.instance.setChoiceByValue(value);
}
export {initGroupSelect, setGroupSelectValue};

const citySelectCIList = [];
const initCitySelect = (main = document) => {
    const selectItems = main.querySelectorAll('[data-kt-city-select="true"]');
    const data = SystemData.Location.Cities;
    selectItems.forEach(selectItem => {
        const key = selectItem.getAttribute('data-kt-key') || uniqueCode();
        const valueKey = selectItem.getAttribute('data-kt-value-key') || 'name';
        const value = selectItem.getAttribute('data-kt-value') || null;
        const choicesInstance = new Choices(selectItem, {
            removeItemButton: true,
            placeholder: true,
            searchEnabled: true,
            itemSelectText: '',
            placeholderValue: selectItem.getAttribute('placeholder') || 'Seçiniz..',
            choices: data.map(item => ({
                value: item[valueKey],
                label: item.name,
                selected: item[valueKey] == value,
            })),
        });
        citySelectCIList.push({
            key:  key,
            instance: choicesInstance
        });
    });
}
const setCitySelectValue = (element, value) => {
    const key = element.getAttribute('data-kt-key');
    if (!key)
        return;
    const instance = citySelectCIList.find(item => item.key === key);
    if (!instance)
        return;
    instance.instance.setChoiceByValue(value);
}
export {initCitySelect, setCitySelectValue}

const districtSelectCIList = [];
const initDistrictSelect = (main = document) => {
    const selectItems = main.querySelectorAll('[data-kt-district-select="true"]');

    const getDistrictData = async (cityId) => {
        const uri = getUriWithRouteName({ name: 'location.select.districts', params: {cityId: cityId} });
        return await axios.get(uri);
    };

    selectItems.forEach(async selectItem => {
        const key = selectItem.getAttribute('data-kt-key') || uniqueCode();
        const valueKey = selectItem.getAttribute('data-kt-value-key') || 'text';
        const citySelector = selectItem.getAttribute('data-kt-city-select-selector') || '';
        if (!citySelector) return;

        const citySelectItem = main.querySelector(citySelector);
        if (!citySelectItem) return;

        let cityId = 0;
        let choicesInstance;

        // Başlangıçta cityId'yi belirleme
        const initCityId = () => {
            SystemData.Location.Cities.forEach(item => {
                const selectedCity = citySelectItem.value || 0;
                const cityValueKey = citySelectItem.getAttribute('data-kt-value-key') || 'name';

                if (item[cityValueKey] === selectedCity) cityId = item.id;
            });
        };

        initCityId(); // İlk yüklemede cityId'yi belirle

        const loadDistrictData = async () => {
            const res = await getDistrictData(cityId);
            const data = res.data.data;

            if (!choicesInstance) {
                choicesInstance = new Choices(selectItem, {
                    removeItemButton: true,
                    placeholder: true,
                    searchEnabled: true,
                    itemSelectText: '',
                    placeholderValue: selectItem.getAttribute('placeholder') || 'Seçiniz..',
                });
                districtSelectCIList.push({ key: key, instance: choicesInstance });
            } else {
                choicesInstance.removeActiveItems();
                choicesInstance.clearChoices();
            }

            choicesInstance.setChoices(data.map(item => ({
                value: item[valueKey],
                label: item.name,
            })), 'value', 'label', true);
        };

        await loadDistrictData();

        citySelectItem.addEventListener('change', async () => {
            initCityId();
            await loadDistrictData();
        });
    });
};
const setDistrictSelectValue = (element, value) => {
    const key = element.getAttribute('data-kt-key');
    if (!key)
        return;
    const instance = districtSelectCIList.find(item => item.key === key);
    if (!instance)
        return;
    instance.instance.setChoiceByValue(value);
}
export { initDistrictSelect, setDistrictSelectValue };

const customerSelectCIList = [];
let customerData = [];
const initCustomerSelect = async (main = document) => {
    const selectItems = main.querySelectorAll('[data-kt-customer-select="true"]');
    const getCustomerData = async () => {
        const uri = getUriWithRouteName({ name: 'customer.select'});
        await axios.get(uri).then(res => customerData = res.data.data);
    }
    await getCustomerData();
    selectItems.forEach(selectItem => {
        const key = selectItem.getAttribute('data-kt-key') || uniqueCode();
        const value = selectItem.getAttribute('data-kt-value') || null;
        const choicesInstance = new Choices(selectItem, {
            removeItemButton: true,
            placeholder: true,
            searchEnabled: true,
            itemSelectText: '',
            placeholderValue: selectItem.getAttribute('placeholder') || 'Seçiniz..',
            choices: customerData.map(item => (
                {
                    value: item.id,
                    label: item.text,
                    selected: parseInt(item.id) === parseInt(value)
                }
            )),
        });
        customerSelectCIList.push({
            key:  key,
            instance: choicesInstance
        });
    });
}
const setCustomerSelectValue = (element, value) => {
    const key = element.getAttribute('data-kt-key');
    if (!key)
        return;
    const instance = customerSelectCIList.find(item => item.key === key);
    if (!instance){
        return;
    }
    instance.instance.setChoiceByValue(value);
}
const addNewCustomerToSelects = ({id, text}, selected = true) => {
    customerData.push({id: id, text: text});
    customerSelectCIList.forEach(item => {
        const instance = item.instance;
        instance._addChoice({
            value: id,
            label: text,
            selected: selected,
            disabled: false,
        });
    });
};
export { initCustomerSelect, setCustomerSelectValue, addNewCustomerToSelects };
