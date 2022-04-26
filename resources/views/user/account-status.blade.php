<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Estado de cuenta') }}
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
                dataSource: @json($documents['documents']),
                keyExpr: "NUMERO_DOCUMENTO",
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
                    const worksheet = workbook.addWorksheet('Account_Status');
        
                    DevExpress.excelExporter.exportDataGrid({
                        component: e.component,
                        worksheet: worksheet
                    }).then(function() {
                        workbook.xlsx.writeBuffer().then(function(buffer) {
                            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'account-status.xlsx');
                        });
                    });
                    e.cancel = true;
                },
                
                // summary: {
                //     totalItems: [{
                //         column: "TOTAL_FACTURA",
                //         summaryType: "sum"
                //     }]
                // },
                // columns: [
                //     {
                //         type: 'buttons',
                //         width: 110,
                //         buttons: ['edit', {
                //                 hint: 'Imprimir',
                //                 icon: 'print',
                //                 onClick(e) {
                //                     // console.log(e.row.data.SEQ_COMPTE)
                //                     //print factura
                //                     const form = document.createElement('form')
                //                     const inputSeqCompte = document.createElement('input');
                //                     const inputToken = document.createElement('input');
                                    
                //                     form.method = 'POST';
                //                     form.action = "/user/print/invoice"
                //                     form.target = "_blank"
                                    
                //                     inputSeqCompte.type = 'hidden'
                //                     inputSeqCompte.name = "id"
                //                     inputSeqCompte.value = e.row.data.SEQ_COMPTE

                //                     inputToken.type = 'hidden'
                //                     inputToken.name = "_token"
                //                     inputToken.value = $('meta[name="csrf-token"]').attr("content")
                                    
                //                     form.appendChild(inputSeqCompte)
                //                     form.appendChild(inputToken)
                                    
                //                     document.body.appendChild(form);
                //                     form.submit();
                //                 },
                //             }
                //         ],
                //     },
                //     {
                //         dataField: "FECHA_EMISION", 
                //         dataType: "date",
                //     },
                //     'NUMERO_FACTURA',
                //     'CLIENTE',
                //     'NOMBRE',
                //     'TOTAL_FACTURA'
                // ],

            });
        });
    </script>
</x-app-layout>
