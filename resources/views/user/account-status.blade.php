<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Estado de cuenta') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mt-8 py-8 mx-auto sm:px-6 lg:px-8 bg-white">
        <div class="flex justify-between items-center mb-7">
            <div class="w-full flex gap-x-2">
                <div class="col-span-3">
                    <label for="fechaInicio" class="block text-xs font-medium text-gray-700">Inicio</label>
                    <input value="{{date('Y-m-d', strtotime('01/01/2021'))}}" type="date" id="fechaInicio" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm 
                                            focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-xs">
                </div>
                <div class="col-span-3">
                    <label for="fechaFin" class="block text-xs font-medium text-gray-700">Fin</label>
                    <input value="{{date('Y-m-d', strtotime(\Carbon\Carbon::now()))}}" type="date" id="fechaFin" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm 
                                            focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-xs">
                </div>
            </div>
            <div class="">
                <button class="inline-flex justify-center w-28 py-2 px-4 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    type="button" id="search">
                    Buscar
                </button>
            </div>
        </div>

        <div class="overflow-y-auto" id="dataGrid"></div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.0.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
    <script>
        const initializeGrid = (data) => {
            $("#dataGrid").dxDataGrid({
                dataSource: data,
                keyExpr: "NUMERO_DOCUMENTO",
                loadPanel: { enabled: true },
                allowColumnResizing: true,
                allowColumnReordering: true,
                columnAutoWidth: true,
                filterRow: { visible: true },
                searchPanel: { visible: true },
                grouping: { contextMenuEnabled: true },
                groupPanel: { visible: true },
                headerFilter: { visible: true },
                filterPanel: { visible: true },
                // wordWrapEnabled: true,
                scrolling: {
                    rowRenderingMode: 'virtual',
                },
                paging: {
                    pageSize: 10,
                },
                pager: {
                    visible: true,
                    allowedPageSizes: [5, 10, 'all'],
                    showPageSizeSelector: true,
                    showInfo: true,
                    showNavigationButtons: true,
                },
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
                
                summary: {
                    totalItems: [
                        {
                            column: "VALOR_SALDO",
                            summaryType: "sum",
                            valueFormat: {
                                type: "currency",
                                precision: 2
                            }
                        },
                        {
                            column: "VALOR_COMPROBANTE",
                            summaryType: "sum",
                            valueFormat: {
                                type: "currency",
                                precision: 2
                            }
                        },
                        {
                            column: "VALOR_ABONO",
                            summaryType: "sum",
                            valueFormat: {
                                type: "currency",
                                precision: 2
                            }
                        }
                    ]
                },
                columns: [
                    'NUMERO_DOCUMENTO',
                    'TIPO_DOC',
                    {
                        dataField: "VALOR_COMPROBANTE", 
                        format: {
                            type: "currency",
                            precision: 2
                        }
                        // format: "currency",
                        // editorOptions: {
                        //     format: "$ #,##0.##"
                        // }
                    },
                    {
                        dataField: "VALOR_ABONO", 
                        format: {
                            type: "currency",
                            precision: 2
                        }
                        // format: "currency",
                        // editorOptions: {
                        //     format: "$ #,##0.##"
                        // }
                    },
                    {
                        dataField: "VALOR_SALDO", 
                        format: {
                            type: "currency",
                            precision: 2
                        }
                    },
                    {
                        dataField: "FECHAEMISION", 
                        dataType: "date",
                    },
                    'CLIENTE',
                    'NOMBRE_CLIENTE',
                    'NOM_VENDEDOR'
                ],

            });
        }

        initializeGrid(@json($documents['documents']))

        document.getElementById('search').addEventListener('click', async () => {
            const url = '/user/fetch/account/status'
            const formData = new FormData()
    
            formData.append('fechaInicio' ,  document.getElementById("fechaInicio").value)
            formData.append('fechaFin' ,  document.getElementById("fechaFin").value)
            formData.append('_token' ,  $('meta[name="csrf-token"]').attr("content"))
    
            const response = await fetch((url), {
                                        method: 'POST',
                                        body:  formData,
                                    }).then(response => response.json())
                                    .catch(err => alert(`Ha ocurrido un error: ${err}`))
                                    .then(response => {
                                        initializeGrid(response)
                                    })
        })
    </script>
</x-app-layout>
