import moment from "moment";

const formatDate = (date, format = "DD.MM.YYYY HH:mm") => {
    return moment(date).format(format)
};
const formatCurrency = (price, digits, currency = "TRY", format = navigator.language || navigator.userLanguage) => {
    if (['TL','TL2','tl','tl2'].includes(currency)){
        currency = 'TRY';
    }
    const formatter = new Intl.NumberFormat(format, {
        style: 'currency',
        currency: currency,
        minimumFractionDigits: digits,
        maximumFractionDigits: digits,
        currencyDisplay: 'narrowSymbol',
    });
    return formatter.format(parseFloat(price));
}
const formatQuantity = (quantity, digits = 2) => {
    return parseFloat(quantity).toFixed(digits);
}
export {formatDate, formatCurrency, formatQuantity};
