var translations = [];
function t(msg, translation, locale) {
    if (translations[locale] == undefined) translations[locale] = [];
    translations[locale][msg] = translation;
}

function _(msg, locale) {
    if (locale == undefined) locale = 'ru';
    if (translations[locale][msg] == undefined) return msg;
    return translations[locale][msg];
}
