    const MONTHS = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
    const fmt = d => `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}-${String(d.getDate()).padStart(2,'0')}`;

    let year, month;
    let selectedMonday = null, selectedFriday = null;

    function getMonday(d) {
        const c = new Date(d); c.setHours(0,0,0,0);
        const day = c.getDay();
        c.setDate(c.getDate() - (day === 0 ? 6 : day - 1));
        return c;
    }

    function build() {
        document.getElementById('title').textContent = `${MONTHS[month]} ${year}`;
        const grid = document.getElementById('grid');
        grid.innerHTML = '<div class="hd">Lu</div><div class="hd">Ma</div><div class="hd">Me</div><div class="hd">Je</div><div class="hd">Ve</div><div class="hd">Sa</div><div class="hd">Di</div>';

        const today = new Date(); today.setHours(0,0,0,0);
        let cur = getMonday(new Date(year, month, 1));

        for (let r = 0; r < 6; r++) {
        const mon = new Date(cur);
        const fri = new Date(cur); fri.setDate(fri.getDate() + 4);
        if (r > 0 && cur.getMonth() > month) break;

        const row = document.createElement('div');
        row.className = 'week' + (selectedMonday && mon.toDateString() === selectedMonday.toDateString() ? ' selected' : '');
        row.style.cssText = 'display:contents;cursor:pointer';

        for (let d = 0; d < 7; d++) {
            const cell = document.createElement('div');
            cell.className = 'day' + (cur.getMonth() !== month ? ' other' : '') + (cur.toDateString() === today.toDateString() ? ' today' : '');
            cell.textContent = cur.getDate();
            row.appendChild(cell);
            cur.setDate(cur.getDate() + 1);
        }

        row.addEventListener('click', () => {
            selectedMonday = mon; selectedFriday = fri;
            build(); updateOutput();
        });
        grid.appendChild(row);
        }
    }

    function updateOutput() {
        document.getElementById('output').textContent = selectedMonday
        ? `Lundi : ${fmt(selectedMonday)}   —   Vendredi : ${fmt(selectedFriday)}`
        : 'Aucune semaine sélectionnée';
        
        // On redirige vers l'impression
        open(`imprimer/menu_hebdo.php?date_debut=${fmt(selectedMonday)}"&date_fin=${fmt(selectedFriday)}`);
    }

    document.getElementById('prev').onclick = () => { if (--month < 0) { month = 11; year--; } build(); };
    document.getElementById('next').onclick = () => { if (++month > 11) { month = 0; year++; } build(); };

    const now = new Date(); year = now.getFullYear(); month = now.getMonth();
    build();

    window.weekPicker = {
        getMonday: () => selectedMonday ? fmt(selectedMonday) : null,
        getFriday: () => selectedFriday ? fmt(selectedFriday) : null,
    };