(function () {
    var container = document.getElementById('newar-members-table-root');
    if (!container) return;

    var rawData = container.getAttribute('data-members');
    if (!rawData) return;

    var members = JSON.parse(rawData);
    var sortKey = 'sn';
    var sortAsc = true;
    var searchTerm = '';
    var page = 1;
    var perPage = 25;

    var thead = container.querySelector('.newar-members-table thead');
    var tbody = container.querySelector('.newar-members-table tbody');
    var info = container.querySelector('.newar-members-info');
    var pagination = container.querySelector('.newar-members-pagination');

    function sortData(data) {
        var sorted = data.slice();
        if (sortKey === 'sn') {
            sorted.sort(function (a, b) { return a._sn - b._sn; });
        } else if (sortKey === 'name') {
            sorted.sort(function (a, b) {
                var x = (a.name || '').toLowerCase();
                var y = (b.name || '').toLowerCase();
                if (x < y) return sortAsc ? -1 : 1;
                if (x > y) return sortAsc ? 1 : -1;
                return 0;
            });
        } else if (sortKey === 'address') {
            sorted.sort(function (a, b) {
                var x = (a.address || '').toLowerCase();
                var y = (b.address || '').toLowerCase();
                if (x < y) return sortAsc ? -1 : 1;
                if (x > y) return sortAsc ? 1 : -1;
                return 0;
            });
        }
        return sorted;
    }

    function filterData(data) {
        if (!searchTerm) return data;
        var t = searchTerm.toLowerCase();
        return data.filter(function (m) {
            return (m.name || '').toLowerCase().indexOf(t) !== -1 ||
                   (m.address || '').toLowerCase().indexOf(t) !== -1;
        });
    }

    function render() {
        var filtered = filterData(members);
        var sorted = sortData(filtered);
        var total = sorted.length;
        var totalPages = Math.ceil(total / perPage) || 1;
        if (page > totalPages) page = totalPages;
        var start = (page - 1) * perPage;
        var pageData = sorted.slice(start, start + perPage);

        var sn = start;
        var rows = '';
        for (var i = 0; i < pageData.length; i++) {
            sn++;
            var m = pageData[i];
            var nameHtml = m.url
                ? '<a href="' + m.url + '">' + m.name + '</a>'
                : m.name;
            var addrHtml = m.address ? m.address : '\u2014';
            rows += '<tr>'
                + '<td class="newar-members-table__sn">' + sn + '</td>'
                + '<td class="newar-members-table__photo">' + (m.avatar_small || m.avatar) + '</td>'
                + '<td class="newar-members-table__name">' + nameHtml + '</td>'
                + '<td class="newar-members-table__address">' + addrHtml + '</td>'
                + '</tr>';
        }

        tbody.innerHTML = rows;

        var showingStart = total === 0 ? 0 : start + 1;
        var showingEnd = Math.min(start + perPage, total);
        var i18n = window.newarMembersI18n || {};
var infoText = (i18n.showing || 'Showing') + ' ' + showingStart + '\u2013' + showingEnd + ' ' + (i18n.of || 'of') + ' ' + total + ' ' + (i18n.members || 'members');
        info.textContent = infoText;

        var prevDisabled = page <= 1 ? ' disabled' : '';
        var nextDisabled = page >= totalPages ? ' disabled' : '';
        pagination.innerHTML =
            '<button class="newar-page-btn" data-page="prev"' + prevDisabled + '>\u25C0 ' + (i18n.prev || 'Previous') + '</button>'
            + '<span class="newar-page-info">' + (i18n.page || 'Page') + ' ' + page + ' ' + (i18n.of || 'of') + ' ' + totalPages + '</span>'
            + '<button class="newar-page-btn" data-page="next"' + nextDisabled + '>' + (i18n.next || 'Next') + ' \u25B6</button>';

        updateSortIndicators();
    }

    function updateSortIndicators() {
        var ths = thead.querySelectorAll('th[data-sort]');
        for (var i = 0; i < ths.length; i++) {
            var th = ths[i];
            var arrow = '';
            if (th.getAttribute('data-sort') === sortKey) {
                arrow = sortAsc ? ' \u25B2' : ' \u25BC';
            }
            th.innerHTML = th.getAttribute('data-label') + arrow;
        }
    }

    if (thead) {
        thead.addEventListener('click', function (e) {
            var th = e.target.closest('th[data-sort]');
            if (!th) return;
            var key = th.getAttribute('data-sort');
            if (sortKey === key) {
                sortAsc = !sortAsc;
            } else {
                sortKey = key;
                sortAsc = true;
            }
            page = 1;
            render();
        });
    }

    if (pagination) {
        pagination.addEventListener('click', function (e) {
            var btn = e.target.closest('.newar-page-btn');
            if (!btn || btn.disabled) return;
            var dir = btn.getAttribute('data-page');
            if (dir === 'prev') page--;
            else if (dir === 'next') page++;
            render();
        });
    }

    var searchInput = container.querySelector('.newar-table-search');
    if (searchInput) {
        var debounce;
        searchInput.addEventListener('input', function () {
            clearTimeout(debounce);
            debounce = setTimeout(function () {
                searchTerm = searchInput.value.trim();
                page = 1;
                render();
            }, 200);
        });
    }

    render();
})();
