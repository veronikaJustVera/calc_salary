//require('./bootstrap');
var _TOKEN;
var film_id = null;
function setToken(token) {
    _TOKEN = token;
}
console.log('kkkk');
$(document).ready(function(){
    console.log('ready');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    setTimeout(() => {    console.log('setTimeout');
        if(document.querySelector('select[name="employee_ids[]"] + .dropdown-toggle')) {
            bindClickToDropdown('employee_ids[]', 'employeeSelect');
        }
        else if(document.querySelector('select[name="film_id"] + .dropdown-toggle')) {    console.log('film_id');
            console.log('roleGet');
            bindClickToDropdown('film_id', 'roleGet');
        }
    }, 1500);
});
// window.addEventListener('DOMContentLoaded', () => {

// });
// set dynamic date options by selected employees
var dates = [];
function multiDimensionalUnique(arr) {
    var uniques = [];
    var itemsFound = {};
    for(var i = 0, l = arr.length; i < l; i++) {
        var stringified = JSON.stringify(arr[i]);
        if(itemsFound[stringified]) { continue; }
        uniques.push(arr[i]);
        itemsFound[stringified] = true;
    }
    return uniques;
}
function removeOptions(selectElement) {
    var i, L = selectElement.options.length - 1;
    for(i = L; i >= 0; i--) {
        selectElement.remove(i);
    }
}
function bindClickToDropdown(name, methodName) {
    var _toggler = document.querySelector('select[name="' + name +'"] + .dropdown-toggle');console.log(_toggler);
        _toggler.addEventListener('click', () => {
            var _options = document.querySelectorAll('select[name="' + name +'"] + .dropdown-toggle + .dropdown-menu div.inner ul li');
            _options.forEach((option, key) => {
                option.addEventListener('click', () => {
                    var e = document.querySelectorAll('select[name="' + name +'"] option');
                    var o = e[key];
                    if(name == 'film_id') film_id = o.value;
                    methods[methodName](o.value);
                });
            });
        });
}
var methods = {
    employeeSelect: function(id) {
        $.ajax({
            url: '/employee/select',
            type: 'POST',
            dataType: "json",
            data: {
                "_token": _TOKEN,
                "id": id
            },
            success: function(data){
                var selectDates = document.querySelector('select[name="dates[]"]');
                var newDates = Object.entries(data);
                dates = dates.concat(newDates);
                dates = multiDimensionalUnique(dates);
                removeOptions(selectDates);
                dates.forEach(date => {
                    var opt = document.createElement('option');
                    opt.value = date[1];
                    opt.innerHTML = date[1];
                    selectDates.appendChild(opt);
                });
                $('.selectpicker').selectpicker('refresh');
            },
            error: function(data){
                console.log(data);
            }
        });
    },
    roleGet: function(id) {
        $.ajax({
            url: '/role/get_for_film',
            type: 'POST',
            dataType: "json",
            data: {
                "_token": _TOKEN,
                "id": id
            },
            success: function(data){
                document.querySelector('#role_select_block').style.display = 'block';

                var selectRoles = document.querySelector('select[name="role_id"]');
                data.forEach(item => {
                    var opt = document.createElement('option');
                    opt.value = item.id;
                    opt.innerHTML = item.title;
                    selectRoles.appendChild(opt);
                });
                bindClickToDropdown('role_id', 'getSalary');
                $('.selectpicker').selectpicker('refresh');

            },
            error: function(data){
                console.log(data);
            }
        });
    },
    getSalary: function(id) {
        $.ajax({
            url: '/role/get_salary',
            type: 'POST',
            dataType: "json",
            data: {
                "_token": _TOKEN,
                "role_id": id,
                "film_id": film_id
            },
            success: function(data){
                document.querySelector('#salary_select_block').style.display = 'block';
                document.querySelector('input[name="salary"]').value = data[0].month_salary;
            },
            error: function(data){
                console.log(data);
            }
        });
    }
}
