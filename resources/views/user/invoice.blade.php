<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Facturas') }}
        </h2>
    </x-slot>
    
    <div class="max-w-7xl mt-8 py-8 mx-auto sm:px-6 lg:px-8 bg-white">
        <div class="overflow-y-auto" id="dataGrid"></div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.0.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
    <script>
        $(function() {
            $("#dataGrid").dxDataGrid({
                dataSource: @json($invoices['invoices']),
                keyExpr: "NUMERO_FACTURA",
                allowColumnResizing: true,
                allowColumnReordering: true,
                columnAutoWidth: true,
                filterRow: { visible: true },
                searchPanel: { visible: true },
                export: {
                    enabled: true
                },
                onExporting: function(e) {
                    const workbook = new ExcelJS.Workbook();
                    const worksheet = workbook.addWorksheet('Invoices');
        
                    DevExpress.excelExporter.exportDataGrid({
                        component: e.component,
                        worksheet: worksheet
                    }).then(function() {
                        workbook.xlsx.writeBuffer().then(function(buffer) {
                            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Invoices.xlsx');
                        });
                    });
                    e.cancel = true;
                },
                
                summary: {
                    totalItems: [{
                        column: "TOTAL_FACTURA",
                        summaryType: "sum"
                    }]
                },
                columns: [
                    {
                        type: 'buttons',
                        width: 110,
                        buttons: ['edit', {
                                hint: 'Imprimir',
                                icon: 'print',
                                onClick(e) {
                                    // console.log(e.row.data.SEQ_COMPTE)
                                    //print factura
                                    const form = document.createElement('form')
                                    const inputSeqCompte = document.createElement('input');
                                    const inputToken = document.createElement('input');
                                    
                                    form.method = 'POST';
                                    form.action = "/user/print/invoice"
                                    form.target = "_blank"
                                    
                                    inputSeqCompte.type = 'hidden'
                                    inputSeqCompte.name = "id"
                                    inputSeqCompte.value = e.row.data.SEQ_COMPTE

                                    inputToken.type = 'hidden'
                                    inputToken.name = "_token"
                                    inputToken.value = $('meta[name="csrf-token"]').attr("content")
                                    
                                    form.appendChild(inputSeqCompte)
                                    form.appendChild(inputToken)
                                    
                                    document.body.appendChild(form);
                                    form.submit();
                                },
                            }
                        ],
                    },
                    {
                        dataField: "FECHA_EMISION", 
                        dataType: "date",
                    },
                    'NUMERO_FACTURA',
                    'CLIENTE',
                    'NOMBRE',
                    'TOTAL_FACTURA'
                ],

            });
        });
        // $(function() {
        //     $("#dataGrid").dxDataGrid({
        //         dataSource: employees,
        //         keyExpr: "EmployeeID",
        //         allowColumnResizing: true,
        //         columnAutoWidth: true,
        //         columnFixing: {
        //             enabled: true
        //         },
        //         allowColumnReordering: true,
        //         columnChooser: { enabled: true },
        //         columns: [{
        //             dataField: "FullName",
        //             validationRules: [{
        //                 type: "required"
        //             }],
        //             fixed: true
        //         }, {
        //             dataField: "Position",
        //             validationRules: [{
        //                 type: "required"
        //             }]
        //         }, {
        //             dataField: "BirthDate", 
        //             dataType: "date",
        //             width: 100,
        //             validationRules: [{
        //                 type: "required"
        //             }]
        //         }, {
        //             dataField: "HireDate", 
        //             dataType: "date",
        //             width: 100,
        //             validationRules: [{
        //                 type: "required"
        //             }]
        //         }, "City", {
        //             dataField: "Country",
        //             groupIndex: 0,
        //             sortOrder: "asc",
        //             validationRules: [{
        //                 type: "required"
        //             }]
        //         },
        //         "Address",
        //         "HomePhone", {
        //             dataField: "PostalCode",
        //             visible: false
        //         }],
        //         filterRow: { visible: true },
        //         searchPanel: { visible: true },
        //         groupPanel: { visible: true },
        //         selection: { mode: "single" },
        //         onSelectionChanged: function(e) {
        //             e.component.byKey(e.currentSelectedRowKeys[0]).done(employee => {
        //                 if(employee) {
        //                     $("#selected-employee").text(`Selected employee: ${employee.FullName}`);
        //                 }
        //             });
        //         },
        //         summary: {
        //             groupItems: [{
        //                 summaryType: "count"
        //             }]
        //         },
        //         editing: {
        //             mode: "popup",
        //             allowUpdating: true,
        //             allowDeleting: true,
        //             allowAdding: true
        //         },
        //         masterDetail: {
        //             enabled: true,
        //             template: function (_, options) {
        //                 const employee = options.data;
        //                 const photo = $("<img>")
        //                     .addClass("employee-photo")
        //                     .attr("src", employee.Photo);
        //                 const notes = $("<p>")
        //                     .addClass("employee-notes")
        //                     .text(employee.Notes);
        //                 return $("<div>").append(photo, notes);
        //             }
        //         },
        //         export: {
        //             enabled: true
        //         },
        //         onExporting: function(e) { 
        //             const workbook = new ExcelJS.Workbook(); 
        //             const worksheet = workbook.addWorksheet("Main sheet"); 
        //             DevExpress.excelExporter.exportDataGrid({ 
        //                 worksheet: worksheet, 
        //                 component: e.component,
        //             }).then(function() {
        //                 workbook.xlsx.writeBuffer().then(function(buffer) { 
        //                     saveAs(new Blob([buffer], { type: "application/octet-stream" }), "DataGrid.xlsx"); 
        //                 }); 
        //             }); 
        //             e.cancel = true; 
        //         }
        //     });
        // });
    </script>
</x-app-layout>
