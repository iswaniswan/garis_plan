const SETTINGS = {
    production: false,
    debug: true,
    HOST: 'http://assetsmanagement.lan',
    PATH_JS: 'http://assetsmanagement.lan/assets/js',
    PATH_COMPONENTS : 'http://assetsmanagement.lan/assets/js/components',
    PATH_LIB : 'http://assetsmanagement.lan/assets/js/lib',
    PATH_VENDOR: 'http://assetsmanagement.lan/assets/vendor'
};

export const HOST = SETTINGS.HOST;
export const BRANCH = ['bandung', 'jakarta', 'pasuruan', 'purwakarta'];
export const TYPE_EVENT = ['Private', 'Group', 'Branch', 'Global'];
export default SETTINGS;