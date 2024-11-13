const SystemConfig = _systemConfig,
    SystemData = _systemData,
    PageData = _pageData;
export {SystemConfig, SystemData, PageData}

const getRoutes = () => SystemConfig.Routes || [];

const findRouteWithName = (name) => {
    return getRoutes().find(route => route.name === name);
}

const getUriWithRouteName = ({name, params = {}}) => {
    const route = findRouteWithName(name);
    if (!route)
        throw new Error(name + ' routu bulunamadı!');

    // URI içindeki dinamik parametreleri params objesindeki değerlerle değiştir
    return SystemConfig.BaseUri + '/' + route.uri.replace(/{(\w+)}/g, (match, p1) => {
        // Parametre anahtarını 'params' objesinde bul, varsa değerini al, yoksa match'i döndür
        return params[p1] !== undefined ? params[p1] : match;
    });
}
export {getRoutes, findRouteWithName, getUriWithRouteName}


const getEnums = (name) => {
    return SystemData["Enums"];
}
const getEnum = (name) => {
    return getEnums()[name];
}
const findEnumWithValue = (name, value) => {
    const en = getEnum(name);
    return en.find(item => item.value === value);
}
const findEnumWithName = (name, value) => {
    const en = getEnum(name);
    return en.find(item => item.name === value);
}
export {getEnums, getEnum, findEnumWithValue, findEnumWithName}


