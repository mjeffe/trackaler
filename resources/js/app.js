require('./bootstrap');

require('alpinejs');

window.localDateStr = function (msdate) {
    const d = new Date(msdate);
    /*
    const options = {
        year: 'numeric', month: 'numeric', day: 'numeric',
        hour: 'numeric', minute: 'numeric', second: 'numeric',
        hour12: false,
        //timeZone: 'America/Los_Angeles'
    };
    const formatter = new Intl.DateTimeFormat('default' , options);
    return formatter.format(d);
     */
    return new Intl.DateTimeFormat().format(d);
}
