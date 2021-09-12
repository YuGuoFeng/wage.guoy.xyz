define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'wage/employees_process/index' + location.search,
                    add_url: 'wage/employees_process/add',
                    edit_url: 'wage/employees_process/edit',
                    del_url: 'wage/employees_process/del',
                    multi_url: 'wage/employees_process/multi',
                    import_url: 'wage/employees_process/import',
                    table: 'employees_process',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'dates', title: __('Dates'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'employees_id', title: __('Employees_id')},
                        {field: 'product_id', title: __('Product_id')},
                        {field: 'process_id', title: __('Process_id')},
                        {field: 'process_price', title: __('Process_price'), operate:'BETWEEN'},
                        {field: 'process_num', title: __('Process_num')},
                        {field: 'total_amount', title: __('Total_amount'), operate:'BETWEEN'},
                        {field: 'text', title: __('Text'), operate: 'LIKE'},
                        {field: 'years', title: __('Years')},
                        {field: 'month', title: __('Month')},
                        {field: 'day', title: __('Day')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'employees.code_number', title: __('Employees.code_number'), operate: 'LIKE'},
                        {field: 'employees.name', title: __('Employees.name'), operate: 'LIKE'},
                        {field: 'product.name', title: __('Product.name'), operate: 'LIKE'},
                        {field: 'process.code_number', title: __('Process.code_number'), operate: 'LIKE'},
                        {field: 'process.describe', title: __('Process.describe'), operate: 'LIKE'},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
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
                url: 'wage/employees_process/recyclebin' + location.search,
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
                                    url: 'wage/employees_process/restore',
                                    refresh: true
                                },
                                {
                                    name: 'Destroy',
                                    text: __('Destroy'),
                                    classname: 'btn btn-xs btn-danger btn-ajax btn-destroyit',
                                    icon: 'fa fa-times',
                                    url: 'wage/employees_process/destroy',
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