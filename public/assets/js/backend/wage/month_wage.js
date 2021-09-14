define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'wage/month_wage/index' + location.search,
                    add_url: 'wage/month_wage/add',
                    edit_url: 'wage/month_wage/edit',
                    del_url: 'wage/month_wage/del',
                    multi_url: 'wage/month_wage/multi',
                    import_url: 'wage/month_wage/import',
                    table: 'employees_month_wage',
                }
            });
            //绑定事件
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var panel = $($(this).attr("href"));
                if (panel.size() > 0) {
                    Controller.table[panel.attr("id")].call(this);
                    $(this).on('click', function (e) {
                        $($(this).attr("href")).find(".btn-refresh").trigger("click");
                    });
                }
                //移除绑定的事件
                $(this).unbind('shown.bs.tab');
            });
            
            //必须默认触发shown.bs.tab事件
            $('ul.nav-tabs li.active a[data-toggle="tab"]').trigger("shown.bs.tab");
            /* var table = $("#table");
            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'), operate: false},
                        {field: 'employees_id', title: __('Employees_id'), visible: false,searchList:$.getJSON("employees/employees/userList")},
                        {field: 'years', title: __('Years'),searchList: $.getJSON('wage/employees_process/years')},
                        {field: 'month', title: __('Month'),searchList: $.getJSON('wage/employees_process/month')},
                        {field: 'employees.code_number', title: __('Employees.code_number'), operate: 'LIKE', operate: false},
                        {field: 'employees.name', title: __('Employees.name'), operate: 'LIKE', operate: false},
                        {field: 'employees_process_wage', title: __('Employees_process_wage'), operate:'BETWEEN', operate: false},
                        {field: 'employees_basis_wage', title: __('Employees_basis_wage'), operate:'BETWEEN', operate: false},
                        {field: 'month_fill', title: __('Month_fill'), operate: false},
                        {field: 'json', title: __('Json'), operate: false},
                        {field: 'five_insurance', title: __('Five_insurance'), operate: false},
                        {field: 'total_amount', title: __('Total_amount'), operate:'BETWEEN', operate: false},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime, operate: false},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime, operate: false},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table); */
        },
        table: {
            first: function () {
                // 表格1
                var table1 = $("#table1");
                table1.bootstrapTable({
                    url: $.fn.bootstrapTable.defaults.extend.index_url,
                    pk: 'id',
                    sortName: 'id',
                    toolbar: '#toolbar1',
                    columns: [
                        [
                            {checkbox: true},
                            {field: 'id', title: __('Id'), operate: false},
                            {field: 'employees_id', title: __('Employees_id'), visible: false,searchList:$.getJSON("employees/employees/userList")},
                            {field: 'years', title: __('Years'),searchList: $.getJSON('wage/employees_process/years')},
                            {field: 'month', title: __('Month'),searchList: $.getJSON('wage/employees_process/month')},
                            {field: 'employees.code_number', title: __('Employees.code_number'), operate: 'LIKE', operate: false},
                            {field: 'employees.name', title: __('Employees.name'), operate: 'LIKE', operate: false},
                            {field: 'employees_process_wage', title: __('Employees_process_wage'), operate:'BETWEEN', operate: false},
                            {field: 'employees_basis_wage', title: __('Employees_basis_wage'), operate:'BETWEEN', operate: false},
                            {field: 'month_fill', title: __('Month_fill'), operate: false},
                            {field: 'json', title: __('Json'), operate: false},
                            {field: 'five_insurance', title: __('Five_insurance'), operate: false},
                            {field: 'total_amount', title: __('Total_amount'), operate:'BETWEEN', operate: false},
                            {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime, operate: false},
                            {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime, operate: false},
                            {field: 'operate', title: __('Operate'), table: table1, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                        ]
                    ]
                });

                // 为表格1绑定事件
                Table.api.bindevent(table1);
            },
            second: function () {
                // 表格2
                var table2 = $("#table2");
                table2.bootstrapTable({
                    url: $.fn.bootstrapTable.defaults.extend.index_url,
                    pk: 'id',
                    sortName: 'id',
                    toolbar: '#toolbar2',
                    columns: [
                        [
                            {checkbox: true},
                            {field: 'id', title: __('Id'), operate: false},
                            {field: 'employees_id', title: __('Employees_id'), visible: false,searchList:$.getJSON("employees/employees/userList")},
                            {field: 'years', title: __('Years'),searchList: $.getJSON('wage/employees_process/years')},
                            {field: 'month', title: __('Month'),searchList: $.getJSON('wage/employees_process/month')},
                            {field: 'employees.code_number', title: __('Employees.code_number'), operate: 'LIKE', operate: false},
                            {field: 'employees.name', title: __('Employees.name'), operate: 'LIKE', operate: false},
                            {field: 'employees_process_wage', title: __('Employees_process_wage'), operate:'BETWEEN', operate: false},
                            {field: 'employees_basis_wage', title: __('Employees_basis_wage'), operate:'BETWEEN', operate: false},
                            {field: 'month_fill', title: __('Month_fill'), operate: false},
                            {field: 'json', title: __('Json'), operate: false},
                            {field: 'five_insurance', title: __('Five_insurance'), operate: false},
                            // {field: 'total_amount', title: __('Total_amount'), operate:'BETWEEN', operate: false},
                            {field: 'all_total_amount', title: __('All_total_amount'), operate:'BETWEEN', operate: false},
                            {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime, operate: false},
                            {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime, operate: false},
                            {field: 'operate', title: __('Operate'), table: table2, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                        ]
                    ]
                });

                // 为表格2绑定事件
                Table.api.bindevent(table2);
            }
        },
        recyclebin: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    'dragsort_url': ''
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: 'wage/month_wage/recyclebin' + location.search,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {
                            field: 'deletetime',
                            title: __('Deletetime'),
                            operate: 'RANGE',
                            addclass: 'datetimerange',
                            formatter: Table.api.formatter.datetime
                        },
                        {
                            field: 'operate',
                            width: '130px',
                            title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            buttons: [
                                {
                                    name: 'Restore',
                                    text: __('Restore'),
                                    classname: 'btn btn-xs btn-info btn-ajax btn-restoreit',
                                    icon: 'fa fa-rotate-left',
                                    url: 'wage/month_wage/restore',
                                    refresh: true
                                },
                                {
                                    name: 'Destroy',
                                    text: __('Destroy'),
                                    classname: 'btn btn-xs btn-danger btn-ajax btn-destroyit',
                                    icon: 'fa fa-times',
                                    url: 'wage/month_wage/destroy',
                                    refresh: true
                                }
                            ],
                            formatter: Table.api.formatter.operate
                        }
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },

        add: function () {
            Controller.api.bindevent();

            $(document).on("change", "#c-employees_id", function () {
                var em_id = $("#c-employees_id").val();
                $.ajax({
                    url:'employees/employees/userInfo',
                    data:{id:em_id},
                    success:function(data,ret){
                        var json = data.data;
                        if(data.code ==1){
                            $("#c-employees_basis_wage").val(json.wage);
                            $("#c-five_insurance").val(data.f_i);
                            $("#tishi").html(`<span role="alert" class="msg-wrap n-error">*<span class="n-msg">(1-`+data.five_insurance+`/100)x`+json.wage_base+`</span></span>`);
                        }
                        console.log(json);
                    },
                    error:function(){
                        layer.close(index);
                    }
                });
            });

        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});