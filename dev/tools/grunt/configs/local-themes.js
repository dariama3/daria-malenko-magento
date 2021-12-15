/**
 * Magento/luma - en_US
 * grunt exec:luma && grunt less:luma
 * grunt exec:luma && grunt less:luma && grunt watch
 *
 * Dariam/luma - uk_UA
 * grunt exec:dariam_luma_uk_ua && grunt less:dariam_luma_uk_ua
 * grunt exec:dariam_luma_uk_ua && grunt less:dariam_luma_uk_ua && grunt watch:dariam_luma_uk_ua
 */
module.exports = {
    luma: {
        area: 'frontend',
        name: 'Magento/luma',
        locale: 'en_US',
        files: [
            'css/styles-m',
            'css/styles-l'
        ],
        dsl: 'less'
    },
    dariam_luma_uk_ua: {
        area: 'frontend',
        name: 'Dariam/luma',
        locale: 'uk_UA',
        files: [
            'css/styles-m',
            'css/styles-l'
        ],
        dsl: 'less'
    }
};
