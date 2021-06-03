_ = (el) => document.querySelector(el);
_evt = (el, evt, fn) => el.addEventListener(evt, fn);

_('.nav .dashboard_btn').classList.add('active');

_evt(window, 'load', () => {
    loadReportsCount();
    setTimeout(() => {
        loadReportsChart()
    }, 1000); 
})

function loadReportsCount(){
    fetch('API/Crimes/getCrimeRecordsCount')
    .then(res => res.json())
    .then(data => {
        _('.crime_record .count').innerHTML = data
    })
    .catch(e => console.log(e))

    fetch('API/LostItems/getLostItemRecordCount')
    .then(res => res.json())
    .then(data => {
        _('.lost_item_record .count').innerHTML = data
    })
    .catch(e => console.log(e))

    fetch('API/MissingPersons/getMissingPersonRecordCount')
    .then(res => res.json())
    .then(data => {
        _('.missing_person_record .count').innerHTML = data
    })
    .catch(e => console.log(e))
}

const crimes = getCrimeData()
const lost_items = getLostItemData()
const missing_persons = getMissingPersonData()


async function loadReportsChart(){
    var ctx = document.getElementById('myChart');
    
    var crime_data = {
        label: 'Crimes',
        data: crimes,
        lineTension: 0.4,
        fill: false,
        borderColor: 'blue',
        backgroundColor: 'blue'
    }

    var lost_item_data = {
        label: 'Lost Items',
        data: lost_items,
        lineTension: 0.4,
        fill: false,
        borderColor: 'red',
        backgroundColor: 'red'
    }

    var missing_person_data = {
        label: 'Missing Persons',
        data: missing_persons,
        lineTension: 0.4,
        fill: false,
        borderColor: 'green',
        backgroundColor: 'green',
    }

    var datasets = {
        labels: getDays(),
        datasets: [crime_data, lost_item_data, missing_person_data]
    }
    
    var myChart = new Chart(ctx, {
        type: 'line',
        data: datasets,
        options: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    boxWidth: 80,
                    fontColor: 'black'
                }
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        tickMarkLength: false,
                    },
                }]
            }
        }
    });
}

function getDays(){
    const date = new Date();
    const dates = new Array();

    for (let i = 1; i <= date.getDate(); i++){
        dates.push(i);
    }

    return dates;
}

function getDates(){
    const date = new Date();
    const dates = new Array();
    const month = date.getMonth() < 10+1? `0${date.getMonth()+1}`: date.getMonth()+1;
    const year = date.getFullYear();

    for (let i = 1; i <= date.getDate(); i++){
        const day = i < 10? `0${i}`: i;

        dates.push(`${year}-${month}-${day}`);
    }

    return dates;
}

function getCrimeData(){
    const crime_data = new Array();

    fetch('API/Crimes/getCrimesCountRecordByDates')
    .then(res => res.json())
    .then(data => {

        getDates().forEach(date => {
            const crime_count = parseInt(data[date]?data[date]:0);
            
            crime_data.push(crime_count);
        })
    })
    .catch(e => console.log(e))

    return crime_data
}

function getLostItemData(){
    const lost_item_data = new Array;

    fetch('API/LostItems/getLostItemsCountRecordByDates')
    .then(res => res.json())
    .then(data => {
        getDates().forEach(date => {
            const lost_item_count = parseInt(data[date]?data[date]:0);
            
            lost_item_data.push(lost_item_count);
        })
    })
    .catch(e => console.log(e))

    return lost_item_data;
}

function getMissingPersonData(){
    const missing_person_data = new Array;

    fetch('API/MissingPersons/getMissingPersonRecordsCountByDates')
    .then(res => res.json())
    .then(data => {
        getDates().forEach(date => {
            const missing_person_count = parseInt(data[date]?data[date]:0);
            
            missing_person_data.push(missing_person_count);
        })
    })
    .catch(e => console.log(e))

    return missing_person_data;
}